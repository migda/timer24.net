@extends('layouts.admin')
@section('title','Categories')
@section('breadcrumbs')
<li>@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-8"><h1>@yield('title')</h1>
    </div>
    <div class="col-sm-4 text-right"><a href="{{route('admin.categories.create')}}" class="btn btn-lg btn-primary">Create new</a></div>
</div>
<div class="clearfix"></div>
<div class="row">
    @if($categories->count() > 0)
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th style="width:200px;">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{{ $category->title }}}</td>
                <td>{{{ $category->created_at }}}</td>
                <td>{{{ $category->updated_at }}}</td>
                <td>
                    <div class="col-sm-6">
                        <a href="{{route('admin.categories.edit',$category->id)}}" class="btn btn-sm btn-default">Edit</a>
                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(array('method'=>'DELETE','route' => array('admin.categories.destroy',$category->id))) !!}
                        {{Form::submit('Delete',['class'=>'btn btn-sm btn-default', 'onClick'=>'return confirm("Delete \"'.$category->title.'\"?");'])}}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No categories</p>
    @endif
</div>
<div class="row">
    {!! $categories->render() !!}
</div>
@endsection