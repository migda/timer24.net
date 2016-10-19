@extends('layouts.app')
@section('title',$user->name)
@section('breadcrumbs')
<li><a href="{{route('users')}}">Users</a></li>
<li>@yield('title')</li>
@endsection
@section('content')
<div class="row">
    <div class="jumbotron">
        <h1>@yield('title')</h1>
        <h2>Timers:</h2>
        <ul class="list-unstyled">
            @forelse($events as $event)
            <li>
                <a href="{{route('event',[$event->id,$event->slug])}}">{{$event->title}}</a>, created at {{date('j F Y', strtotime($event->created_at))}}
            </li>
            @empty
            <p>No timers.</p>
            @endforelse
        </ul>
    </div>
</div>
@endsection
@section('scripts')
@endsection