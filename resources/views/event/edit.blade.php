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
        <h1>@yield('title') <small>[<a href="{{route('events.show',[$event->id,$event->slug])}}" target="_blank">show</a>]</small></h1>
        {!! Form::model($event,array('method'=>'PUT','route' => ['events.update',$event->id])) !!}

        <div class="row">
            <div class="col-sm-7">
                {{Form::text('date',null,array('id'=>'date','class'=>'form-control','required'=>'required','placeholder'=>'YYYY-MM-DD HH:mm:ss'))}}
            </div>
            <div class="col-sm-5">
                <p id="ends">-</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                {{Form::select('timezone',[-1=>'Choose timezone'],null, array('id'=>'timezone','class'=>'form-control', 'required'=>'required'))}}
            </div>
            <div class="col-sm-5">
                {{Form::select('category',[null=>'Choose category'] +  $categories, $event->category->id, ['class' => 'form-control','required'=>'required']) }}
            </div>
        </div>
        {{Form::label('title','Title')}}
        {{Form::text('title',null,array('class'=>'form-control','required'=>'required','placeholder'=>'Title'))}}
        {{Form::label('description','Description')}}
        {{Form::textarea('description',null,array('class'=>'form-control','rows'=>2,'placeholder'=>'Description (optional)'))}}
        {{Form::label('private','Private timer')}}
        {{Form::checkbox('private',null, $event->is_private)}}

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
    <p><a href="{{route('profile.events')}}">Go Back</a></p>
</div>
@endsection
@section('scripts')
<script>
    // timezone form >> select
    var localTimezone = '{{$event->timezone}}'; // user timezone
    $.each(moment.tz.names(), function (i, item) {
        var selected = false;
        if (i == localTimezone) {
            selected = true;
        }
        $('#timezone').append($('<option>', {
            value: i,
            text: item + ' (' + moment.tz(item).format('Z') + ')',
            selected: selected
        }));
    });

    var timeUser = moment(new Date()); // user datetime
    $('#user-timezone').html(moment.tz(timezoneUser).format('Z') + ' (' + timezoneUser + ')');
    $('#user-date').html(timeUser.format('DD MMMM YYYY, HH:mm:ss'));

    var stopper = null;
</script>
<script src="{{url('js/scripts.js?0')}}"></script>
@endsection