<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Event;
use App\Http\Controllers\AdminController;
use Session;

class EventController extends AdminController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $events = \App\Event::orderBy('id', 'DESC')->paginate(10);
        return view('admin.events.index')->with('events', $events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = \App\Category::orderBy('title')->pluck('title', 'id')->toArray();
        $users = \App\User::orderBy('email')->pluck('email', 'id')->toArray();
        return view('admin.events.create')->with(array('categories' => $categories, 'users' => $users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'date' => 'required|date|date_format:"Y-m-d H:i:s',
            'category' => 'required',
            'timezone' => 'required',
        ));
        // store in the database
        $event = new Event;
        $event->title = $request->title;
        $event->date = $request->date;
        $event->category_id = $request->category;
        $event->slug = str_slug($request->title); // slug from title
        if ($request->description != '') {
            $event->description = $request->description;
        }
        if ($request->user > 0) { // check if logged in
            $event->user_id = (int) $request->user; // assing user id
        }

        $event->timezone = $request->timezone;
        if ($request->private == 'on') {
            $event->is_private = true;
        }
        $event->status = (int) $request->status;
        // redirect to the specified resource if event is saved
        if ($event->save()) {
            Session::flash('success', 'Created - ' . $event->title . '!');
        }
        // redirect
        return redirect()->route('admin.events.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $event = Event::find($id);
        if (!$event) {
            return null;
        }
        $categories = \App\Category::orderBy('title')->pluck('title', 'id')->toArray();
        $users = \App\User::orderBy('email')->pluck('email', 'id')->toArray();
        return view('admin.events.edit')->with(array('event' => $event, 'categories' => $categories, 'users' => $users));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'date' => 'required|date|date_format:"Y-m-d H:i:s',
            'category' => 'required',
            'timezone' => 'required',
        ));
        // save the data to the database
        $event = Event::find($id);
        $event->title = $request->title;
        $event->date = $request->date;
        $event->category_id = $request->category;
        $event->slug = str_slug($request->title); // slug from title
        if ($request->description != '') {
            $event->description = $request->description;
        }
        if ($request->user > 0) { // check if logged in
            $event->user_id = (int) $request->user; // assing user id
        }

        $event->timezone = $request->timezone;
        if ($request->private == 'on') {
            $event->is_private = true;
        } else {
            $event->is_private = false;
        }
        $event->status = (int) $request->status;
        // redirect to the specified resource if event is saved
        if ($event->save()) {
            Session::flash('success', 'Edited - ' . $event->title . '!');
        }
        // redirect
        return redirect()->route('admin.events.edit', $event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $event = Event::find($id);
        $event->delete();
        Session::flash('success', 'Deleted - ' . $event->title . '!');
        return redirect()->route('admin.events.index');
    }

}
