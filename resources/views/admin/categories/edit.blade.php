@extends('layouts.admin')
@section('title','Edit category: '. $category->title)
@section('breadcrumbs')
<li><a href="{{url('admin/categories')}}">Categories</a></li>
<li>@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>@yield('title')</h1>
        {!! Form::model($category,array('method'=>'PUT','route' => ['admin.categories.update',$category->id])) !!}

        {{Form::label('title','Name:')}}
        {{Form::text('title',null,array('class'=>'form-control', 'required'=>'required'))}}
        {{Form::submit('Edit category',array('class'=>'btn btn-primary btn-md btn-block','style'=>'margin-top:10px;'))}}

        {!! Form::close() !!}
    </div>
</div>
<hr />
<div class="row">
    <p><a href="{{route('admin.categories.index')}}">Go Back</a></p>
</div>
@endsection