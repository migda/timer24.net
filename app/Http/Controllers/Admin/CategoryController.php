<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use App\Http\Controllers\AdminController;
use Session;

class CategoryController extends AdminController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = \App\Category::orderBy('title')->paginate(10);
        return view('admin.categories.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.categories.create');
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
            'title' => 'required|max:255|unique:categories,slug',
        ));
        // store in the database
        $category = new Category;
        $category->title = $request->title;
        $category->slug = str_slug($request->title);
        // save and check if correct
        if ($category->save()) {
            // set flash data with success message
            Session::flash('success', 'Successfully created - ' . $category->title . '!');
        }
        // redirect
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return view('admin.categories.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $category = Category::find($id);
        if (!$category) {
            return null;
        }
        return view('admin.categories.edit')->with('category', $category);
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
            'title' => 'required|max:255|unique:categories,slug,' . $id,
        ));
        // save the data to the database
        $category = Category::find($id);
        $category->title = $request->title;
        $category->slug = str_slug($request->title);
        // save and check if correct
        if ($category->save()) {
            // set flash data with success message
            Session::flash('success', 'Successfully edited - ' . $category->title . '!');
        }
        // redirect
        return redirect()->route('categories.edit', $category->id);
    }

    /**
     * Change the specified resource status to 2 (deleted)
     * Item won't show in the list
     * Item will be in the storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $category = Category::find($id);
        if ($category->events->count() == 0) {
            $category->delete();
            Session::flash('success', 'Successfully deleted - ' . $category->title . '!');
        } else {
            Session::flash('warning', 'Delete all events belong to this category!');
        }
        return redirect()->route('categories.index');
    }

}
