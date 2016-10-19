@extends('layouts.app')
@section('title','My Profile')
@section('breadcrumbs')
<li>@yield('title')</li>
@endsection
@section('content')
<h1>@yield('title') <small>[<a href="{{route('user',$user->id)}}/" target="_blank">show public profile</a>]</small></h1>
<div class="row">
    <div class="col-md-4">
        <h2>Basic information <small>[<a href="{{route('profile.edit')}}/">edit</a>]</small></h2>
        <p>
            Name: {{$user->name}}<br>
            E-mail: {{$user->email}}<br>
        </p>
    </div>
    <div class="col-md-8">
        <h2>My events ({{$user->events->count()}})</h2>
        @if($user->events->count() > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Private</th>
                    <th>Created at</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->category->title }}</td>
                    <td>{{ ($event->is_private ? 'Yes' : 'No')}}</td>
                    <td>{{ $event->created_at }}</td>
                    <td><a href="{{route('event',[$event->id,$event->slug])}}" target="blank" class="btn btn-sm btn-default">Show</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No events</p>
        @endif
    </div>
</div>
@endsection
@section('scripts')
@endsection