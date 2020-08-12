@extends('admin.layout.app')

@section ('content')
 <div class="container-fluid">
          <div class="row">
             <div class="col-lg-12">
                @if (session()->has('success'))
               <div class="alert alert-success">
                @if(is_array(session()->get('success')))
                        <ul>
                            @foreach (session()->get('success') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                        @else
                            {{ session()->get('success') }}
                        @endif
                    </div>
                @endif
                 @if (count($errors) > 0)
                  @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                      {{$errors->first()}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                  @endif
                @endif
                </div> 
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Message/OTP Setting</h4>
                  <b>@if($smsby->status == 0 && $smsby->twilio == 0 && $smsby->msg91 == 0) OTP/SMS OFF &nbsp;<span style="height: 12px;width: 12px;background-color: red;border-radius: 50%;display: inline-block;" class="dot"></span> @endif
                  @if($smsby->status == 1 && $smsby->twilio == 1 && $smsby->msg91 == 0) Twilio is On &nbsp;<span style="height: 12px;width: 12px;background-color: green;border-radius: 50%;display: inline-block;" class="dot"></span> @endif 
                  @if($smsby->status == 1 && $smsby->twilio == 0 && $smsby->msg91 == 1) Msg91 is On &nbsp;<span style="height: 12px;width: 12px;background-color: green;border-radius: 50%;display: inline-block;" class="dot"></span> @endif</b>
                  
                 </div> 
    <script type="text/javascript">
        function ShowHideDiv() {
            var ddlPassport = document.getElementById("ddlPassport");
            var dvPassport = document.getElementById("dvPassport");
            dvPassport.style.display = ddlPassport.value == "Msg91" ? "block" : "none";
            var dv2Passport = document.getElementById("dv2Passport");
            dv2Passport.style.display = ddlPassport.value == "Twilio" ? "block" : "none";
            var dv3Passport = document.getElementById("dv3Passport");
            dv3Passport.style.display = ddlPassport.value == "off" ? "block" : "none";
        }
    </script>
    <div class="container">
     <div class="form-group">    
    <span>Select Your Message/OTP Medium</span>
    <select id="ddlPassport" class="form-control" onchange="ShowHideDiv()">
        <option disabled selected>Select Your Message/OTP Medium <i class="material_icons">setting</i></option>
        <option value="Msg91">Msg91 </option>
        <option value="Twilio">Twilio</option>
        <option value="off">OTP/Message Off</option>
    </select>
    </div>      
           <div id="dvPassport" style="display: none">
       
                  <form class="forms-sample" action="{{route('updatemsg91')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                <div class="card-body">
                     @if($msg91)
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Sender ID</label>
                          <input type="text" name="sender_id" value="{{($msg91->sender_id)}}" class="form-control">
                        </div>
                      </div>
                       <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Msg91 API Key</label>
                          <input type="text" name="api" value="{{($msg91->api_key)}}" class="form-control">
                        </div>
                      </div>

                    </div>
                    @else
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Sender ID</label>
                          <input type="text" name="sender_id" placeholder="Insert Sender Id Of Six Letters Only" class="form-control" required>
                        </div>
                      </div>
                       <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Msg91 API Key</label>
                          <input type="text" name="api" placeholder="Msg91 API Key" class="form-control" required>
                        </div>
                      </div>

                    </div>
                    @endif
                    <button type="submit" class="btn btn-primary pull-center">ON Msg91</button>
                    <div class="clearfix"></div>
                  </form>
              </div>              
            </div>
             
        <div id="dv2Passport" style="display: none">
           <form class="forms-sample" action="{{route('updatetwilio')}}" method="post" enctype="multipart/form-data">
              {{csrf_field()}}      
                   @if($twilio)
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                           <label for="bmd-label-floating">Twilio SID</label>
                        <input type="text" id="sid" class="form-control" value="{{$twilio->twilio_sid}}" name="sid">
                        </div>
                      </div>
                       <div class="col-md-4">
                        <div class="form-group">
                          <label for="bmd-label-floating">Twilio Token</label>
                        <input type="text" id="token" class="form-control" value="{{$twilio->twilio_token}}" name="token">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                         <label for="bmd-label-floating">Twilio Phone</label>
                        <input type="text" id="phone" class="form-control" value="{{$twilio->twilio_phone}}" name="phone">
                        </div>
                      </div>
                    </div>
                    @else
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                         <label for="bmd-label-floating">Twilio SID</label>
                        <input type="text" id="sid" class="form-control" placeholder="Twilio SID" name="sid" required>
                        </div>
                      </div>
                       <div class="col-md-4">
                        <div class="form-group">
                          <label for="bmd-label-floating">Twilio Token</label>
                        <input type="text" id="token" class="form-control" placeholder="Twilio Token" name="token" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                         <label for="bmd-label-floating">Twilio Phone</label>
                        <input type="text" id="phone" class="form-control" placeholder="Twilio Phone" name="phone" required>
                        </div>
                      </div>
                    </div>
                    @endif
                    <button type="submit" class="btn btn-primary pull-center">ON Twilio</button>
                    <div class="clearfix"></div>
                    </form>
              </div> 
          
            <div id="dv3Passport" style="display: none">
             <form class="forms-sample" action="{{route('msgoff')}}" method="post" enctype="multipart/form-data">
              {{csrf_field()}} 
             <button type="submit" class="btn btn-primary pull-center">Otp/SMS OFF</button>
            <div class="clearfix"></div>
            </form>
             </div> 
              </div>
            </div>
			</div>
          </div>
          </div>
@endsection




