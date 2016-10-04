<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Auth;
use Session;
use DateTime;

class HomeController extends Controller {

    /**
     * Display a home view (info & timer form)
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home.index');
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
        ));
        // store in the database
        $event = new Event;
        $offset = (int) $request->offset * (-1);
        $dat = new DateTime($request->date); // subtract offset
        $dat->modify($offset . ' hours');
        $event->date = $dat->format("Y-m-d H:i:s");
        $event->title = $request->title;
        if ($request->description != '') {
            $event->description = $request->description;
        }
        if (Auth::check()) { // check if logged in
            $event->user_id = Auth::id(); // assing user id
        }
        $event->slug = ($request->title != '' ? str_slug($request->title) : time()); // slug from title or timestamp
        $event->timezone = $request->offset;
        if ($request->private == 'on') {
            $event->is_private = true;
        }
        $event->status = 1; // status == 1 == accepted
        // redirect to the specified resource if event is saved
        if ($event->save()) {
            Session::flash('success', 'Your timer is created!');
            return redirect()->route('event', [$event->id, $event->slug]);
        }
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function event($id, $slug) {
        $event = Event::find($id);
        if ($event->slug == $slug) {
            $event->displayed++; // increment reads
            $event->save();
            return view('home.event')->with('event', $event);
        } else {
            return redirect('/');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function events() {
        $events = Event::where('status', 1) // acceopted
                ->where('is_private', 0) // not private
                ->orderBy('created_at', 'DESC')
                ->paginate(10); // 10 resource per page
        return view('home.events')->with(['events' => $events, 'category' => null]);
    }

}
