<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Event;
use Auth;
use Session;

class EventController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['only' => ['edit', 'update', 'destroy']]); // actions only for logged user
    }

    /**
     * Display a listing of events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\Illuminate\Http\Request $request) {
        $cat = null;
        $catId = null;
        $category = \App\Category::where('slug', $request->input('category'))->first(); // input category slug
        if ($request->input('category')) {
            if (!$category) {
                return redirect()->route('events'); // no category = redirect
            }
            $catId = $category->id;
            $cat = $request->input('category');
        }
        $events = Event::getEvents($catId);
        $countAllEvents = Event::getEvents($catId)->count();
        $categories = \App\Category::orderBy('title')->get(); // category list
        return view('event.index')->with(['events' => $events, 'countAllEvents' => $countAllEvents, 'currentCategory' => $category, 'categories' => $categories, 'cat' => $cat]);
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
            'date' => 'required|date|date_format:"Y-m-d H:i:s',
            'title' => 'required|max:255',
            'category' => 'required',
        ));
        // store in the database
        $event = new Event;
        $event->date = $request->date;
        $event->title = $request->title;
        if ($request->description != '') {
            $event->description = $request->description;
        }
        if (Auth::check()) { // check if logged in
            $event->user_id = Auth::id(); // assing user id
        }
        $event->slug = ($request->title != '' ? str_slug($request->title) : time()); // slug from title or timestamp
        if ($request->category > 0) {
            $event->category_id = $request->category;
        }
        $event->timezone = $request->timezone;
        if ($request->private == 'on') {
            $event->is_private = true;
        }
        $event->status = 1; // status == 1 == accepted
        // redirect to the specified resource if event is saved
        if ($event->save()) {
            Session::flash('success', 'Your timer is created!');
            return redirect()->route('events.show', [$event->id, $event->slug]);
        }
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug) {
        $event = Event::find($id);
        if ($event->status && $event->slug == $slug) {
            $event->displayed++; // increment reads
            $event->save();
            return view('event.show')->with('event', $event);
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $event = Event::find($id);
        if ($event && $event->status && $event->user_id == Auth::id()) { // check if event belgongs to this user
            $categories = \App\Category::orderBy('title')->pluck('title', 'id')->toArray();
            return view('event.edit')->with(array('event' => $event, 'categories' => $categories));
        } else {
            return redirect(route('profile.events')); // redirect to user profile
        }
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
            'date' => 'required|date|date_format:"Y-m-d H:i:s',
            'title' => 'required|max:255',
            'category' => 'required'
        ));

        // store in the database
        $event = Event::find($id);
        if ($event && $event->status && $event->user_id == Auth::id()) { // check if event belgongs to this user
            $event->date = $request->date;
            $event->title = $request->title;
            if ($request->description != '') {
                $event->description = $request->description;
            }
            if (Auth::check()) { // check if logged in
                $event->user_id = Auth::id(); // assing user id
            }
            $event->slug = ($request->title != '' ? str_slug($request->title) : time()); // slug from title or timestamp
            if ($request->category > 0) {
                $event->category_id = $request->category;
            }
            $event->timezone = $request->timezone;
            if ($request->private == 'on') {
                $event->is_private = true;
            }
            // redirect to the specified resource if event is saved
            if ($event->save()) {
                Session::flash('success', 'Edited!');
                return redirect(route('events.edit', $event->id)); // redirect to user events
            }
        }
        return redirect(route('profile.events')); // redirect to user events
    }

    /**
     * Change event status to 2 (deleted by user)
     * Item won't show in the list
     * Item will be in the storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $event = Event::find($id);
        if ($event && $event->status && $event->user_id == Auth::id()) {
            $event->status = 0;
            if ($event->save()) {
                Session::flash('success', 'Event deleted!');
            }
        }
        return redirect()->route('profile.events');
    }

}
