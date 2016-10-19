<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UserController extends Controller {

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = User::all();
        return view('user.index')->with('users', $users);
    }

    /**
     * Display specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $user = User::find($id);
        if ($user) {
            $userEvents = $user->events->where('status', 1);
            return view('user.show')->with(array('user' => $user, 'events' => $userEvents));
        } else {
            return redirect(route('users') . '/');
        }
    }

    /**
     * Display a listing of logged user events.
     *
     * @return \Illuminate\Http\Response
     */
    public function events() {
        $events = Event::where('user_id', Auth::id());
        return view('user.events')->with('events', $events);
    }

}
