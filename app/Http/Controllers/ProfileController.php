<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Auth;
use Session;

class ProfileController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = User::find(Auth::id());
        return view('profile.index')->with('user', $user);
    }

    /**
     * Display user events.
     *
     * @return \Illuminate\Http\Response
     */
    public function events() {
        $events = \App\Event::where('user_id', Auth::id())->where('status', 1)->orderBy('created_at', 'DESC')->paginate(8);
        return view('profile.events')->with('events', $events);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        $user = User::find(Auth::id());
        if (!$user) {
            return null;
        }
        return view('profile.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        // validate the data
        $this->validate($request, array(
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'min:6|confirmed',
        ));
        // save the data to the database
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        // save and check if correct
        if ($user->save()) {
            // set flash data with success message
            Session::flash('success', 'Profile edited!');
        }
        // redirect
        return redirect()->route('profile.edit');
    }

}
