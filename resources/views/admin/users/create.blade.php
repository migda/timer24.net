@extends('layouts.admin')
@section('title','Create New User')
@section('breadcrumbs')
<li><a href="{{url('admin/users')}}">Users</a></li>
<li>@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>@yield('title')</h1>
        {!! Form::open(array('route' => 'admin.users.store')) !!}

        {{Form::label('name','Name:')}}
        {{Form::text('name',null,array('class'=>'form-control', 'required'=>'required'))}}
        {{Form::label('email','E-mail:')}}
        {{Form::email('email',null,array('class'=>'form-control', 'required'=>'required'))}}
        {{Form::label('password','Password:')}}
        {{Form::password('password',array('class'=>'form-control', 'required'=>'required'))}}
        {{Form::label('password_confirmation','Confirm password:')}}
        {{Form::password('password_confirmation',array('class'=>'form-control', 'required'=>'required'))}}
        {{Form::label('role','Role:')}}
        {{Form::select('role', [null=>'Choose role'] + StaticArrays::$roles, null, ['class' => 'form-control', 'required'=>'required']) }}
        {{Form::submit('Create user',array('class'=>'btn btn-primary btn-md btn-block','style'=>'margin-top:10px;'))}}

        {!! Form::close() !!}
    </div>
</div>
<hr />
<div class="row">
    <p><a href="{{route('admin.users.index')}}">Go Back</a></p>
</div>
@endsection