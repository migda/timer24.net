@extends('layouts.app')
@section('title','Edit event: '.$event->title)
@section('breadcrumbs')
<li><a href="{{route('profile')}}">My Profile</a></li>
<li><a href="{{route('profile.events')}}">My Events</a></li>
<li>@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>@yield('title')</h1>
        {!! Form::model($event,array('method'=>'PUT','route' => ['events.update',$event->id])) !!}

        <div class="row">
            <div class="col-sm-6">
                {{Form::text('date',null,array('id'=>'date','class'=>'form-control','required'=>'required','placeholder'=>'YYYY-MM-DD HH:mm:ss'))}}
            </div>
            <div class="col-sm-6">
                <p id="ends">-</p>
            </div>
        </div>
        {{Form::text('title',null,array('class'=>'form-control','required'=>'required','placeholder'=>'Title'))}}
        {{Form::textarea('description',null,array('class'=>'form-control','rows'=>2,'placeholder'=>'Description (optional)'))}}
        {{Form::label('private','Private timer')}}
        {{Form::checkbox('private',null, $event->is_private)}}
        {{Form::select('category',[null=>'Choose category'] +  $categories, $event->category_id, ['class' => 'form-control','required'=>'required']) }}
        {{Form::hidden('offset',0,array('id'=>'offset'))}}

        <div class="row" style="margin-top:20px;">
            <div class="col-xs-8">
                {{Form::submit('Edit my event',array('class'=>'btn btn-primary btn-md btn-block'))}}
            </div>
            <div class="col-xs-4">
                {{Form::reset('Reset',array('class'=>'btn btn-primary btn-md btn-block'))}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<hr />
<div class="row">
    <p><a href="{{route('profile')}}">Go Back</a></p>
</div>
@endsection
@section('scripts')
<script>
    var dat = new Date('{{date("Y-m-d H:i:s")}}'); // get server datetime
    var userOffset = (dat.getTimezoneOffset() / 60) * (-1);  // UTC time offset
    var stopper = null;
</script>
<script src="{{url('js/scripts.js?0')}}"></script>
@endsection