@extends('layouts.app')
@section('title',($event->title ? $event->title : 'Event'))
@section('breadcrumbs')
<li><a href="{{route('events.index')}}">Events</a></li>
<li><a href="{{route('events.index',['category'=>$event->category->slug])}}">{{$event->category->title}}</a></li>
<li>{{$event->title}}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="jumbotron text-center">
            <h2>{{$event->title}}</h2>
            <h1 id="ends">-</h1>
            <h3>{!! $event->description or 'No description' !!}</h3>
        </div>
        <div class="jumbotron text-center">
            {{Form::label('url','Timer\'s URL:')}}
            {{Form::text('url',route('events.show',[$event->id,$event->slug]),array('class'=>'form-control', 'onFocus'=>'this.select()'))}}
        </div>
    </div>
    <div class="col-md-5">
        <div class="jumbotron text-center">
            <div class="row">
                Timer stops at:
                <p id="user-stop">{{date('j F Y, H:i:s',strtotime($event->date))}}</p>
                Current time:
                <p id="user-date">
                    {{date('j F Y, H:i:s')}}
                </p>
                <span>Detected timezone: </span>
                <p id="user-timezone"></p>
            </div>
        </div>
        <div class="jumbotron text-center">
            <h2>Created by {!!($event->user_id ? '<a href="'.route('user',$event->user->id).'">'.$event->user->name.'</a>' : '~guest')!!}</h2>
            Local timer stops at:
            <p id="local-stop">{{date('j F Y, H:i:s',strtotime($event->date))}}</p>
            local time:
            <p id="local-date">
                {{date('j F Y, H:i:s')}}
            </p>
            <span>Local timezone: </span>
            <p>UTC <span id="local-timezone">{{$event->timezone}}</span></p>
        </div>
    </div>
</div>
<div class="clearfix"></div>
@endsection
@section('scripts')
<script>
    var timezoneLocal = moment.tz.names()['{{$event->timezone}}']; // timezone from db
    var timezoneUser = moment.tz.guess(); // user timezone

    var timeUser = moment(new Date());
    var timeLocal = moment(new Date());
    timeLocal = timeLocal.tz(timezoneLocal);

    var stopLocal = moment.tz('{{$event->date}}', timezoneLocal); // date from db with timezone
    var stopUser = moment.tz('{{$event->date}}', timezoneLocal);
    stopUser = stopUser.tz(timezoneUser); // convert to user timezone

    $('#user-stop').html(stopUser.format('DD MMMM YYYY, HH:mm:ss'));
    $('#local-stop').html(stopLocal.format('DD MMMM YYYY, HH:mm:ss'));

    $('#user-timezone').html(moment.tz(timezoneUser).format('Z') + ' (' + timezoneUser + ')');
    $('#local-timezone').html(moment.tz(timezoneLocal).format('Z') + ' (' + timezoneLocal + ')');

    $('#user-date').html(timeUser.format('DD MMMM YYYY, HH:mm:ss'));
    $('#local-stop').html(stopLocal.format('DD MMMM YYYY, HH:mm:ss'));

    var stopper = stopUser;
    var changed = false;
</script>
<script src="{{url('js/scripts.js?0')}}"></script>
@endsection