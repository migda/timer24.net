@extends('layouts.app')
@section('title','My Events ('.$events->count().')')
@section('breadcrumbs')
<li><a href="{{route('profile')}}">My Profile</a></li>
<li>@yield('title')</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-8"><h1>@yield('title')</h1>
    </div>
    <div class="col-sm-4 text-right"><a href="{{url('')}}" class="btn btn-lg btn-primary">Create new</a></div>
</div>
@if($events->count() > 0)
<table class="table table-hover">
    <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Private</th>
            <th>End date</th>
            <th>Created at</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($events as $event)
        <tr>
            <td>{{ $event->title }}</td>
            <td>{{ $event->category->title }}</td>
            <td>{{ ($event->is_private ? 'Yes' : 'No')}}</td>
            <td>{{ date('d F Y, H:i:s',strtotime($event->date))}}</td>
            <td>{{ date('d F Y, H:i:s',strtotime($event->created_at))}}</td>
            <td>
                <ul class="list-inline">
                    <li><a href="{{route('events.show',[$event->id,$event->slug])}}" class="btn btn-sm btn-default">Show</a></li>
                    <li><a href="{{route('events.edit',[$event->id])}}" class="btn btn-sm btn-default">Edit</a></li>
                    <li>
                        {!! Form::open(array('method'=>'DELETE','route' => array('events.destroy',$event->id))) !!}
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
{!! $events->render() !!}
@endsection
@section('scripts')
@endsection