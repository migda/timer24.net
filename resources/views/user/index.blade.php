@extends('layouts.app')
@section('title','Users')
@section('breadcrumbs')
<li>@yield('title')</li>
@endsection
@section('content')
<div class="row">
    <div class="jumbotron">
        <h1>@yield('title')</h1>
        <ul class="list-unstyled">
            @foreach($users as $user)
            <li><a href="{{route('user',$user->id)}}">{{$user->name}}</a>, timers: {{$user->events()->count()}} (priv timers: {{$user->events()->where('is_private',1)->count()}})</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
@section('scripts')
@endsection