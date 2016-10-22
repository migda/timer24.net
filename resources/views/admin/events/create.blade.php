@extends('layouts.admin')
@section('title','Create New Event')
@section('breadcrumbs')
<li><a href="{{url('admin/events')}}">Events</a></li>
<li>@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>@yield('title')</h1>
        {!! Form::open(array('route' => 'admin.events.store')) !!}

        {{Form::label('title','Title:')}}
        {{Form::text('title',null,array('class'=>'form-control', 'required'=>'required'))}}
        <div class="row">
            <div class="col-md-8">
                {{Form::label('date','Date & time:')}}
                {{Form::text('date',null,array('id'=>'date','class'=>'form-control','required'=>'required','placeholder'=>'YYYY-MM-DD HH:mm:ss'))}}
            </div>
            <div class="col-md-4">
                {{Form::label('timezone','Timezone:')}}
                {{Form::select('timezone',[-1=>'Choose timezone'],null, array('class'=>'form-control', 'required'=>'required'))}}
            </div>
        </div>
        {{Form::label('category','Category:')}}
        {{Form::select('category',[null=>'Choose category'] +  $categories, null, ['class' => 'form-control','required'=>'required']) }}
        {{Form::label('description','Description:')}}
        {{Form::textarea('description',null,array('class'=>'form-control','rows'=>2))}}
        {{Form::label('user','User:')}}
        {{Form::select('user',[null=>'Choose user'] +  $users, null, ['class' => 'form-control']) }}
        {{Form::label('status','Status:')}}
        {{Form::select('status',array(0 => 'Not published', 1 => 'Published'),null, array('class'=>'form-control'))}}
        {{Form::label('private','Private timer')}}
        {{Form::checkbox('private',null,false)}}
        <br>
        {{Form::submit('Create event',array('class'=>'btn btn-primary btn-md btn-block','style'=>'margin-top:10px;'))}}

        {!! Form::close() !!}
    </div>
</div>
<hr />
<div class="row">
    <p><a href="{{route('admin.events.index')}}">Go Back</a></p>
</div>
@endsection
@section('scripts')
<script>
    // timezone form >> select
    var timezoneUser = moment.tz.names().indexOf(moment.tz.guess()); // user timezone
    $.each(moment.tz.names(), function (i, item) {
        var selected = false;
        if (i == timezoneUser) {
            selected = true;
        }
        $('#timezone').append($('<option>', {
            value: i,
            text: item + ' (' + moment.tz(item).format('Z') + ')',
            selected: selected
        }));
    });

// datetimepicker
    $(function () {
        $('#date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false,
            sideBySide: true
        });
    });
</script>
@endsection