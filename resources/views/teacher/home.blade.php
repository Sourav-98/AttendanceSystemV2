@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      @if(session()->get('msg'))
        @if(session()->get('lec_taken') == true)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{session()->get('msg')}}</strong> Number of students attended: {{ session()->get('std_count') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @else
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{session()->get('msg')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
      @endif
      <div class = "panel-group">
        <div class = "panel panel-default">
          <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle = "collapse" data-target="#TakeAttendanceCollapse" style="background-color:#004CFF">TAKE ATTENDANCE</button>
          <div id = "TakeAttendanceCollapse" class="panel-collapse collapse">
            <ul class = "list-group">
              @foreach($sub_list as $lec)
                <li class = "list-group-item">
                  <form method="POST" action="/genqr">
                    @csrf
                    <div class="form-row">
                      <div class="col">
                        <label> 
                          <b>{{$lec->sub_name}} &nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></b>
                          <b>{{$lec->sub_dept}}, {{$lec->lec_sem}}{{$lec->lec_sec}}</b>
                        </label>
                      </div>
                      <div class="col">
                        <input type="text" name="lec_id" value="{{$lec->lec_id}}" style="display:none">
                        <div style="text-align: right"><button type="submit" class="btn btn-primary">QR CODE &nbsp;<i class="fa fa-qrcode" aria-hidden="true"></i></button></div>
                      </div>
                    </div>
                  </form>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <hr>
      <h2 style="text-align: center">Attendance Status</h2>
      <div class="accordion" id="AttdStatusAccordion">
        @foreach($sub_list as $lec)
          <div class="card">
            <div class="card-header">
              <h2 class="mb-0">
                <button class="btn collapsed btn-block" style="text-align: justify" type="button" data-toggle="collapse" data-target="#collapse{{$lec->lec_id}}" aria-expanded="false" aria-controls="collapse{{$lec->lec_id}}">
                  <b>{{$lec->sub_name}} &nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></b>
                  <b>{{$lec->sub_dept}}, {{$lec->lec_sem}}{{$lec->lec_sec}}</b>
                  <p class="float-right"> <span style="font-size: 10px">TOTAL CLASSES:</span> <span style="font-size: 17px"><b>{{$lec->lec_count}}</b></span></p>
                </button>
              </h2>
            </div>
            <div id="collapse{{$lec->lec_id}}" class="collapse" aria-labelledby="headingThree" data-parent="#AttdStatusAccordion">
              <div class="card-body">
                
                  <table class="table table-striped table-sm table-responsive">
                    <thead>
                      <tr>
                        <th>USN</th>
                        <th>Name</th>
                        <th>Classes Attended</th>
                        <th><i class="fa fa-percent" aria-hidden="true"></i></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($attd_list as $std)
                      @if($std->lec_id == $lec->lec_id)
                      <tr>
                        <td>{{$std->std_usn}}</td>
                        <td>{{$std->std_name}}</td>
                        <td>{{$std->attd_count}}</td>
                        @if($std->attd_count==0)
                        <td style="color:#D40202"> 0% </td>
                        @elseif(floor(($std->attd_count/$std->lec_count)*100)  >= 85)
                        <td style="color:#20AB16">{{ floor(($std->attd_count/$std->lec_count)*100) }}% </td>
                        @elseif(floor(($std->attd_count/$std->lec_count)*100)  >= 75)
                        <td style="color:#DB8F02" >{{ floor(($std->attd_count/$std->lec_count)*100) }}% </td>
                        @else
                        <td style="color:#D40202" >{{ floor(($std->attd_count/$std->lec_count)*100) }}% </td>
                        @endif
                      </tr>
                      @endif
                    @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection