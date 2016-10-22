@extends('layouts.app')
@section('title','Create your own countdown timer!')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="jumbotron">
            <h2>Create your timer:</h2><br>
            {!! Form::open() !!}
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
                    {{Form::select('category',[null=>'Choose category'] +  $categories, null, ['class' => 'form-control','required'=>'required']) }}
                </div>
            </div>
            {{Form::text('title',null,array('class'=>'form-control','required'=>'required','placeholder'=>'Title'))}}
            {{Form::textarea('description',null,array('class'=>'form-control','rows'=>2,'placeholder'=>'Description (optional)'))}}
            {{Form::label('private','Private timer')}}
            {{Form::checkbox('private',null,false)}}

            <div class="row" style="margin-top:20px;">
                <div class="col-xs-8">
                    {{Form::submit('Create Timer!',array('class'=>'btn btn-primary btn-md btn-block'))}}
                </div>
                <div class="col-xs-4">
                    {{Form::reset('Reset',array('class'=>'btn btn-primary btn-md btn-block'))}}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="jumbotron">
            <h1>Timer24.net</h1>
            <p id="user-date">
                {{date('d F Y, H:i:s')}}
            </p>
            <em>Detected timezone: <strong><span id="user-timezone"></span></strong></em> 
            <hr />

            <p>Create your own countdown timer for every event you want!</p>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection
@section('scripts')
<script>
    var timezoneUser = moment.tz.guess(); // user timezone
    var timeUser = moment(new Date()); // user datetime

    $('#user-timezone').html(moment.tz(timezoneUser).format('Z') + ' (' + timezoneUser + ')');
    $('#user-date').html(timeUser.format('DD MMMM YYYY, HH:mm:ss'));

    // timezone form >> select
    $.each(moment.tz.names(), function (i, item) {
        var selected = false;
        if (item === timezoneUser) {
            selected = true;
        }
        $('#timezone').append($('<option>', {
            value: i,
            text: item + ' (' + moment.tz(item).format('Z') + ')',
            selected: selected
        }));
    });

    var stopper = null;
    var changed = false;
</script>
<script src="{{url('js/scripts.js?0')}}"></script>
@endsection