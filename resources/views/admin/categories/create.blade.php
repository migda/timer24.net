@extends('layouts.admin')
@section('title','Create New Category')
@section('breadcrumbs')
<li><a href="{{url('admin/categories')}}">Categories</a></li>
<li>@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>@yield('title')</h1>
        {!! Form::open(array('route' => 'categories.store')) !!}

        {{Form::label('title','Name:')}}
        {{Form::text('title',null,array('class'=>'form-control', 'required'=>'required'))}}
        {{Form::submit('Create category',array('class'=>'btn btn-primary btn-md btn-block','style'=>'margin-top:10px;'))}}

        {!! Form::close() !!}
    </div>
</div>
<hr />
<div class="row">
    <p><a href="{{route('categories.index')}}">Go Back</a></p>
</div>
@endsection