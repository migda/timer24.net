@extends('layouts.app')
@section('title','My Profile')
@section('breadcrumbs')
<li>@yield('title')</li>
@endsection
@section('content')
<h1>@yield('title') <small>[<a href="{{route('user',$user->id)}}/" target="_blank">show public profile</a>]</small></h1>
<h2>Basic information <small>[<a href="{{route('profile.edit')}}/">edit</a>]</small></h2>
<p>
    Name: {{$user->name}}<br>
    E-mail: {{$user->email}}<br>
    Events: <a href="{{route('profile.events')}}">{{$user->events->where('status',1)->count()}}</a><br>
</p>
@endsection