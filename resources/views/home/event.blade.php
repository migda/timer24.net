@extends('layouts.app')
@section('title',($event->title ? $event->title : 'Event'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="jumbotron text-center">
                <h2>{{$event->title}}:</h2>
                <h1 id="ends">-</h1>
                <h3>{{$event->description}}</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron text-center">
                Timer stops at:
                <p id="stop">{{date('d F Y, H:i:s',strtotime($event->date))}}</p>
                <strong>Current time:</strong>
                <p id="user-date">
                    {{date('d F Y')}}, {{date('H:i:s')}}
                </p>
                <span>Your timezone:</span>
                <p><?= date_default_timezone_get(); ?><span id="user-offset"></span></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="jumbotron text-center">
            {{Form::label('url','Timer\'s URL:')}}
            {{Form::text('url',url('event/'.$event->id.'/'.$event->slug),array('class'=>'form-control'))}}
        </div>
    </div>
</div>
<div class="clearfix"></div>
@endsection
@section('scripts')
<script>
    var dat = new Date('{{date("Y-m-d H:i:s")}}'); // get server datetime
    var userOffset = (dat.getTimezoneOffset() / 60) * (-1);  // UTC time offset

    userDate = new Date(dat);
    userDate.setMinutes(dat.getMinutes() + 60 * userOffset); // user datetime based on offset and server datatime

    // datetimepicker

    $(function () {
        $('#date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false,
            sideBySide: true,
            defaultDate: userDate
        });
    });


    // user date and time info, time stop
    //stop 
    var stop = new Date('{{$event->date}}'); // get event datetime
    stop.setMinutes(stop.getMinutes() + 60 * userOffset); // add offset
    // clock
    $('#user-date').html(moment(userDate).format('DD MMMM YYYY, HH:mm:ss'));
    // offset
    if (userOffset !== 0) {
        $('#stop').html(moment(stop).format('DD MMMM YYYY, HH:mm:ss'));
        $('#user-offset').html(' ' + (userOffset > 0 ? '+' : '') + moment(userOffset).format('HH:mm'));
    }

    var now = new Date();
    function updateUserDatetime() {
        // clock
        now.setSeconds(now.getSeconds() + 1);
        $('#user-date').html(moment(now).format('DD MMMM YYYY, HH:mm:ss'));

        // ends
        var a = moment(stop); // datetime from input
        var b = moment(now); // now
        var diff = a.diff(b).valueOf(); // timestamp
        if (diff > 0) {
            $('#ends').html('');
            if (moment.duration(diff, "ms").years() > 0) {
                $('#ends').append(moment.duration(diff, "ms").years());
                $('#ends').append('Y,');
            }
            if (moment.duration(diff, "ms").months() > 0) {
                $('#ends').append(moment.duration(diff, "ms").months());
                $('#ends').append('M,');
            }
            if (moment.duration(diff, "ms").days()) {
                $('#ends').append(moment.duration(diff, "ms").days());
                $('#ends').append('D,');
            }
            if (moment.duration(diff, "ms").hours() > 0) {
                $('#ends').append(moment.duration(diff, "ms").hours());
                $('#ends').append('h,');
            }
            $('#ends').append(moment.duration(diff, "ms").minutes());
            $('#ends').append('m,');
            $('#ends').append(moment.duration(diff, "ms").seconds());
            $('#ends').append('s');
        } else {
            $('#ends').html('-');
        }
    }

    $(document).ready(function ()
    {
        setInterval('updateUserDatetime()', 1000); // update user datetime every 1 second
    });

</script>
@endsection