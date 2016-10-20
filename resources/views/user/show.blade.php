@extends('layouts.app')
@section('title',$user->name)
@section('breadcrumbs')
<li><a href="{{route('users')}}">Users</a></li>
<li>@yield('title')</li>
@endsection
@section('content')
<h1>@yield('title')</h1>
<h3>Timers ({{$count}}):</h3>
<ul class="list-unstyled">
    @forelse($events as $event)
    <li>
        <a href="{{route('events.show',[$event->id,$event->slug])}}">{{$event->title}}</a>, created at {{date('j F Y', strtotime($event->created_at))}}
    </li>
    @empty
    <p>No timers.</p>
    @endforelse
</ul>
{!! $events->render() !!}
@endsection
@section('scripts')
@endsection