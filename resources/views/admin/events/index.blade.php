@extends('layouts.admin')
@section('title','Events')
@section('breadcrumbs')
<li>@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-8"><h1>@yield('title')</h1>
    </div>
    <div class="col-sm-4 text-right"><a href="{{route('admin.events.create')}}" class="btn btn-lg btn-primary">Create new</a></div>
</div>
<div class="clearfix"></div>
<div class="row">
    @if($events->count() > 0)
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>User</th>
                <th>Category</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th style="width:200px;">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->title }}</td>
                <td>{{ ($event->user_id > 0 ? $event->user->email : '-') }}</td>
                <td>{{ $event->category->title }}</td>
                <td>{{ $event->created_at }}</td>
                <td>{{ $event->updated_at }}</td>
                <td>
                    <div class="col-sm-6">
                        <a href="{{route('admin.events.edit',$event->id)}}" class="btn btn-sm btn-default">Edit</a>
                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(array('method'=>'DELETE','route' => array('admin.events.destroy',$event->id))) !!}
                        {{Form::submit('Delete',['class'=>'btn btn-sm btn-default', 'onClick'=>'return confirm("Delete \"'.$event->title.'\"?");'])}}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No events</p>
    @endif
</div>
<div class="row">
    {!! $events->render() !!}
</div>
@endsection