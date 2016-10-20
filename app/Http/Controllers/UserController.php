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
            $userEvents = \App\Event::where('user_id', $id)->where('is_private', false)->where('status', 1);
            $count = $userEvents->count();
            $events = $userEvents->paginate(8);
            return view('user.show')->with(array('user' => $user, 'events' => $events, 'count' => $count));
        } else {
            return redirect(route('users') . '/');
        }
    }

}
