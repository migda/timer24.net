@extends('layouts.admin')
@section('title','Users')
@section('breadcrumbs')
<li>@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-8"><h1>@yield('title')</h1>
    </div>
    <div class="col-sm-4 text-right"><a href="{{route('users.create')}}" class="btn btn-lg btn-primary">Create new</a></div>
</div>
<div class="clearfix"></div>
<div class="row">
    @if($users->count() > 0)
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th style="width:200px;">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{{ $user->name }}}</td>
                <td>{{{ $user->email }}}</td>
                <td>{{{ StaticArrays::$roles[$user->role] }}}</td>
                <td>{{{ $user->created_at }}}</td>
                <td>{{{ $user->updated_at }}}</td>
                <td>
                    <div class="col-sm-6">
                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-sm btn-default">Edit</a>
                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(array('method'=>'DELETE','route' => array('users.destroy',$user->id))) !!}
                        {{Form::submit('Delete',['class'=>'btn btn-sm btn-default', 'onClick'=>'return confirm("Delete \"'.$user->name.'\"?");'])}}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No users</p>
    @endif
</div>
<div class="row">
    {!! $users->render() !!}
</div>
@endsection