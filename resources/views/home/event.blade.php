@extends('layouts.app')
@section('title',($event->title ? $event->title : 'Event'))

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="jumbotron text-center">
            <h2>{{$event->title}}:</h2>
            <h1 id="ends">-</h1>
            <h3>{!! $event->description or 'No description' !!}</h3>
        </div>
    </div>
    <div class="col-md-5">
        <div class="jumbotron text-center">
            Timer stops at:
            <p id="stop">{{date('j F Y, H:i:s',strtotime($event->date))}}</p>
            <strong>Current time:</strong>
            <p id="user-date">
                {{date('j F Y')}}, {{date('H:i:s')}}
            </p>
            <span>Your timezone:</span>
            <p><?= date_default_timezone_get(); ?><span id="user-offset"></span></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="jumbotron text-center">
        {{Form::label('url','Timer\'s URL:')}}
        {{Form::text('url',url('event/'.$event->id.'/'.$event->slug).'/',array('class'=>'form-control', 'onFocus'=>'this.select()'))}}
    </div>
</div>
<div class="clearfix"></div>
@endsection
@section('scripts')
<script>
    var dat = new Date('{{date("Y-m-d H:i:s")}}'); // get server datetime
    var userOffset = (dat.getTimezoneOffset() / 60) * (-1);  // UTC time offset
    //stop 
    var stop = new Date('{{$event->date}}'); // get event datetime
    stop.setMinutes(stop.getMinutes() + 60 * userOffset); // add offset

    var stopper = moment(stop); // datetime from input
</script>
<script src="{{url('js/scripts.js')}}"></script>
@endsection