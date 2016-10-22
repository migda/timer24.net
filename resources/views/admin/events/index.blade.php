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
                <th>Status</th>
                <th>End date</th>
                <th>Created at</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->title }}</td>
                <td>{{ ($event->user_id > 0 ? $event->user->email : '-') }}</td>
                <td>{{ $event->category->title }}</td>
                <td>{{ $event->status }}</td>
            <td>{{ date('d F Y, H:i:s',strtotime($event->date))}}</td>
            <td>{{ date('d F Y, H:i:s',strtotime($event->created_at))}}</td>

                <td>
                    <ul class="list-inline">
                        <li>
                            <a href="{{route('admin.events.edit',$event->id)}}" class="btn btn-sm btn-default">Edit</a>
                        </li>
                        <li>
                            {!! Form::open(array('method'=>'DELETE','route' => array('admin.events.destroy',$event->id))) !!}
                            {{Form::submit('Delete',['class'=>'btn btn-sm btn-default', 'onClick'=>'return confirm("Delete \"'.$event->title.'\"?");'])}}
                            {!! Form::close() !!}
                        </li>
                    </ul>
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