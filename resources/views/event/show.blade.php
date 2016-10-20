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
    </div>
    <div class="col-md-5">
        <div class="jumbotron text-center">
            <div class="row">
                Timer stops at:
                <p id="stop">{{date('j F Y, H:i:s',strtotime($event->date))}}</p>
                Current time:
                <p id="user-date">
                    {{date('j F Y, H:i:s')}}}
                </p>
                <span>Your timezone:</span>
                <p><?= date_default_timezone_get(); ?><span id="user-offset"></span></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="jumbotron text-center">
            {{Form::label('url','Timer\'s URL:')}}
            {{Form::text('url',route('events.show',[$event->id,$event->slug]),array('class'=>'form-control', 'onFocus'=>'this.select()'))}}
        </div>
    </div>
    <div class="col-md-5">
        <div class="jumbotron text-center">
            <h2>Created by {!!($event->user_id ? '<a href="'.route('user',$event->user->id).'">'.$event->user->name.'</a>' : '~guest')!!}</h2>
            <span>Local timezone: UTC {{($event->timezone > 0 ? '+'.$event->timezone : $event->timezone)}}</span>
            <p><span id="user-offset"></span></p>
            Timer stops at (local time):
            <p id="stop">{{date('j F Y, H:i:s',strtotime($event->date))}}</p>
            local time:
            <p id="local-date">
                {{date('j F Y, H:i:s',strtotime('+'.$event->timezone.' hours'))}}
            </p>
        </div>
    </div>

</div>
<div class="clearfix"></div>
@endsection
@section('scripts')
<script>
    var dat = new Date('{{date("Y-m-d H:i:s")}}'); // get server datetime
    var userOffset = (dat.getTimezoneOffset() / 60) * (-1); // UTC time offset
    var localOffset = '{{$event -> timezone}}'; // UTC time offset
    //stop 
    var stop = new Date('{{$event->date}}'); // get event datetime
    stop.setMinutes(stop.getMinutes() - 60 * localOffset); // subtract local timezone
    stop.setMinutes(stop.getMinutes() + 60 * userOffset); // add user offset

    var stopper = moment(stop); // datetime from input
</script>
<script src="{{url('js/scripts.js?0')}}"></script>
@endsection