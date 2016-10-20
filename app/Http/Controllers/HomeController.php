<?php

namespace App\Http\Controllers;

class HomeController extends Controller {

    /**
     * Display a home view (info & timer form)
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = \App\Category::orderBy('title')->pluck('title', 'id')->toArray();
        return view('home.index')->with('categories', $categories);
    }

}
