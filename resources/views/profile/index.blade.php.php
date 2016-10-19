@extends('layouts.app')
@section('title','Create your own countdown timer!')

@section('content')
<div class="col-md-6">
    <div class="jumbotron">
        <h2>Create your timer:</h2><br>
        {!! Form::open() !!}
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
        {{Form::checkbox('private',null,false)}}
        {{Form::select('category',[null=>'Choose category'] +  $categories, null, ['class' => 'form-control','required'=>'required']) }}
        {{Form::hidden('offset',0,array('id'=>'offset'))}}

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
            {{date('H:i:s')}}
            <br>{{date('d F Y')}}
        </p>
        <em>Your timezone: <strong><?= date_default_timezone_get(); ?><span id="user-offset"></span></strong></em> 
        <hr />

        <p>Create your own countdown timer for every event you want!</p>
    </div>
</div>
<div class="clearfix"></div>
@endsection
@section('scripts')
<script>
    var dat = new Date('{{date("Y-m-d H:i:s")}}'); // get server datetime
    var userOffset = (dat.getTimezoneOffset() / 60) * (-1);  // UTC time offset
    var stopper = null;
</script>
<script src="{{url('js/scripts.js?0')}}"></script>
@endsection