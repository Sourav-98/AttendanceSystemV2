@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            @if (session()->get('msg'))
                @if (session()->get('feedback') >= 0)
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session()->get('msg')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif (session()->get('feedback') == 1)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{session()->get('msg')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @else
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{session()->get('msg')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            @endif
            <a href="/scanqr" role="button" class="btn btn-primary btn-lg btn-block">Scan QR Code for Attendance</a>
        </div>
        <div class="col-md-3"></div>
        </div>
        <hr>
        <h1 style="text-align:center">Attendance Status</h1>
        <div class="row">
            @foreach ($attendance_data as $attd)
            <div class="col-sm-6">
                <div class="card" style="margin-bottom: 10px">
                    <div class="card-header">
                        <h3 >{{ $attd->sub_name }}</h3>
                    </div>
                    <div class="card-body" style="padding: 6px">
                        <div class="row" >
                            <div class="col-7" style="text-align: justify">
                                Classes Attended: <b>{{$attd->attd_count}}</b><br>
                                Total Classes: <b>{{$attd->lec_count}}</b>
                            </div>
                            <div class="col-5" style="text-align: center">
                                Percentage:<br><b>@if($attd->attd_count==0) <span style="color: #D40202; font-size: 20px">0 <i class="fa fa-percent" aria-hidden="true"></i></span>
                                            @elseif( floor(($attd->attd_count/$attd->lec_count)*100) < 75) <span style="color: #D40202; font-size: 20px">{{floor(($attd->attd_count/$attd->lec_count)*100)}} <i class="fa fa-percent" aria-hidden="true"></i></span>
                                            @elseif (floor(($attd->attd_count/$attd->lec_count)*100) < 85) <span style="color: #DB8F02; font-size: 20px">{{floor(($attd->attd_count/$attd->lec_count)*100)}} <i class="fa fa-percent" aria-hidden="true"></i></span>
                                            @else <span style="color: #20AB16; font-size: 20px">{{floor(($attd->attd_count/$attd->lec_count)*100)}} <i class="fa fa-percent" aria-hidden="true"></i></span>
                                            @endif</b>
                                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection