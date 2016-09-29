@extends('layouts.app')
@section('title','Create your own countdown timer!')

@section('content')
<div class="container">
    <div class="col-md-6">
        <div class="jumbotron">
            <h1>Timer24.net</h1>
            <p id="user-date">
                {{date('H:i:s')}}
                <br>{{date('d F Y')}}
            </p>
            <em>Your timezone: <strong><?= date_default_timezone_get(); ?><span id="user-offset"></span></strong></em> 
            <hr />

            <p>Create your own countdown timer for every event you want!</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="jumbotron">
            <h2>Create your timer:</h2><br>
            {!! Form::open(array()) !!}
            <div class="row">
                <div class="col-sm-6">
                    {{Form::text('date',null,array('id'=>'date','class'=>'form-control','required'=>'required','placeholder'=>'YYYY-MM-DD HH:mm:ss'))}}
                </div>
                <div class="col-sm-6">
                    <p id="ends">-</p>
                </div>
            </div>
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>'Title (optional)'))}}
            {{Form::textarea('description',null,array('class'=>'form-control','rows'=>2,'placeholder'=>'Description (optional)'))}}
            {{Form::label('private','Private timer')}}
            {{Form::checkbox('private',null,false)}}
            {{Form::hidden('offset',0,array('id'=>'offset'))}}

            <div class="row" style="margin-top:20px;">
                <div class="col-sm-8">
                    {{Form::submit('Create Timer!',array('class'=>'btn btn-primary btn-md btn-block'))}}
                </div>
                <div class="col-sm-4">
                    {{Form::reset('Reset',array('class'=>'btn btn-primary btn-md btn-block'))}}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="clearfix"></div>
</div>
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


    // user date and time info & hidden field - offset
    // clock
    $('#user-date').html(moment(userDate).format('DD MMMM YYYY, HH:mm:ss'));
    // offset
    if (userOffset !== 0) {
        $('#user-offset').html(' ' + (userOffset > 0 ? '+' : '') + moment(userOffset).format('HH:mm'));
        $("#offset").val(userOffset); // set value of hidden field
    }

    var now = new Date();
    function updateUserDatetime() {
        //tmp = moment(tmp).add(1, 's');

        // clock
        now.setSeconds(now.getSeconds() + 1);
        $('#user-date').html(moment(now).format('DD MMMM YYYY, HH:mm:ss'));


        // ends
        var a = moment($('#date').val()); // datetime from input
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