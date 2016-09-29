@extends('layouts.app')
@section('title','Create your own countdown timer!')

@section('content')
<div class="container">
    <div class="jumbotron">
        <div class="col-md-6">
            <h1>Timer24.net</h1>
            <p>Create your own countdown timer!</p>
        </div>
        <div class="col-md-6">
            <h3>{{date('d F Y, H:i')}}</h3>
            <p>Timezone is: <?= date_default_timezone_get(); ?></p>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="jumbotron">
        <h2>Countdown timer will be available soon.</h2>
    </div>
</div>
<script>
    var dt = new Date();
    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
    //alert(time);
</script>
@endsection