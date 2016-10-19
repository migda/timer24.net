<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Http\Controllers\AdminController;
use Session;

class UserController extends AdminController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = \App\User::orderBy('id')->paginate(10);
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.users.create');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
        ));
        // store in the database
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = (int) $request->role;
        // save and check if correct
        if ($user->save()) {
            // set flash data with success message
            Session::flash('success', 'Created - ' . $user->name . '!');
        }
        // redirect
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::find($id);
        if (!$user) {
            return null;
        }
        return view('admin.users.edit')->with('user', $user);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'min:6|confirmed',
            'role' => 'required',
        ));
        // save the data to the database
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role = (int) $request->role;
        // save and check if correct
        if ($user->save()) {
            // set flash data with success message
            Session::flash('success', 'Edited - ' . $user->name . '!');
        }
        // redirect
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::find($id);
        if ($user->events->count() == 0) {
            $user->delete();
            Session::flash('success', 'Deleted - ' . $user->name . '!');
        } else {
            Session::flash('warning', 'Delete all events belong to this user!');
        }
        return redirect()->route('admin.users.index');
    }

}
