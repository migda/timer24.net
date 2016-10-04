@extends('layouts.app')
@section('title',('Events added by users'))

@section('content')
<div class="row">
    <div class="col-sm-3">
        Categories:
        <ul>
            <p>No categories</p>
        </ul>
    </div>
    <div class="col-sm-9">
        <div class="row">
            <h1>Events (timers) added by users:</h1>
            <ul>
                @forelse ($events as $event)
                <li><a href="{{url('event/'.$event->id.'/'.$event->slug)}}/">{{ $event->title }}</a>, <small> created {{date('j F Y', strtotime($event->created_at))}} by {{($event->user_id ? $event->user->name : '~guest')}}</small></li>
                @empty
                <p>No events</p>
                @endforelse
            </ul>
        </div>
        <div class="row">
            {!! $events->appends(['category' => $category])->render() !!}
        </div>
    </div>
</div>
@endsection