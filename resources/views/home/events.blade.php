@extends('layouts.app')
@section('title',('Events (timers)' . ($currentCategory ? ' - '.$currentCategory->title : '')))
@section('breadcrumbs')
@if($currentCategory) 
<li><a href="{{url('events')}}/">Events</a></li>
<li>{{$currentCategory->title}}</li>
@else
<li>Events</li>
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-sm-3">
        Categories:
        <ul>
            <li><a href="{{url('events')}}/">All categories</a> ({{$countAllEvents}})
                <ul>
                    @foreach ($categories as $category)
                    <li><a href="{{url('events/?category='.$category->slug)}}" {{ ($currentCategory && $currentCategory->id == $category->id  ? ' class=text-primary' : '') }}>{{ $category->title }}</a> ({{$category->events()->where('status',1)->count()}})</li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-sm-9">
        <div class="row">
            <h1>Events (timers) {{($currentCategory ? ' - '.$currentCategory->title : '')}}:</h1>
            <ul>
                @forelse ($events as $event)
                <li><a href="{{url('event/'.$event->id.'/'.$event->slug)}}/">{{ $event->title }}</a>, <small> created {{date('j F Y', strtotime($event->created_at))}} by {{($event->user_id ? $event->user->name : '~guest')}}</small></li>
                @empty
                <p>No events</p>
                @endforelse
            </ul>
        </div>
        <div class="row">
            {!! $events->appends(['category' => $cat])->render() !!}
        </div>
    </div>
</div>
@endsection