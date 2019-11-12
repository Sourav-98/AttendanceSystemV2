@extends('layouts.app')

@section('content')
  <div class="container" style="margin-top:20px">
  <div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
      <img style="width:100%" src='https://chart.googleapis.com/chart?cht=qr&chl={{urlencode($code)}}&chs=500x500&choe=UTF-8&chld=L|2' rel='nofollow' alt='qr code'><a href='https://www.qr-code-generator.com/' style='cursor:default'  rel='nofollow'></a>
      <hr>
      <form action="/done" method="POST">
        @csrf
        <input type="text" style="display:none" name="lec_id" value="{{$lec_id}}">
        <button type="submit" class="btn btn-success btn-block">Done</button>
      </form>
    </div>
    <div class="col-md-4">
    </div>
  </div>
</div>
@endsection
