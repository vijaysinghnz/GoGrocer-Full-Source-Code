
@extends('web.layout.app')
<style>
    body{
        background-color: #EBEBEB !important;
    }
</style>

@section('content')
<div class="container" style="background-color: white;border-radius: 10px;width: 73%;padding: 40px 40px 30px 40px;margin-top: 160px;">

  <div class="row">
    <div class="col-sm-12" style="">
      <h3>Register</h3>
    </div>
  </div>
  
       <form class="login100-form validate-form" method="POST" action="{{ route('web_verify_otp') }}">
 {{ csrf_field() }}
  <div class="row"  style="margin-top: 20px;">
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
   <div class="col-sm-7" style="border-right: 1px solid #CCCCCC">
      <label for="basic-url" style="color: gray;">Enter OTP<span style="color: red;">*</span></label>
<div class="input-group mb-3">
 
  <input type="text" name="otp" style="max-width: 84%;" class="form-control" id="basic-url" aria-describedby="basic-addon3">
  <input type="hidden" name="user_phone" value={{$user_phone}}>
</div>




<button type="submit" class="btn" style="background-color: #FB641B;color: white;width: 45%;font-size: 17px;margin-top: 20px;">Verify OTP</button>


</form>
<p style="color: gray;margin-top: 30px;">Already Registered <a href="login.php" style="color:#FB641B; ">LOGIN</a></p>

    </div>

    <div class="col-sm-5">
      


<div class="row">
  <div class="col-sm-3" style="margin-top: 40px;">

<span style="float: right;color: #B8B8B8;font-size: 30px;"><i class="fas fa-truck"></i></span>

  </div>
  <div class="col-sm-9" style="margin-top: 40px;">
<p style="color: #B8B8B8;font-weight: 500">Manage your orders</p>
<p style="color: #B8B8B8;font-weight: 500;margin-top: -15px;">
 Easily track orders, Create returns.


</p>

  </div>

   <div class="col-sm-3" style="margin-top: 20px;">

<span style="float: right;color: #B8B8B8;font-size: 30px;"><i class="fas fa-bell"></i></span>

  </div>
  <div class="col-sm-9" style="margin-top: 20px;">
<p style="color: #B8B8B8;font-weight: 500">Manage your orders</p>
<p style="color: #B8B8B8;font-weight: 500;margin-top: -15px;">
 Easily track orders, Create returns.


</p>

  </div>

   <div class="col-sm-3" style="margin-top: 20px;">

<span style="float: right;color: #B8B8B8;font-size: 30px;"><i class="fas fa-thumbs-up"></i></span>

  </div>
  <div class="col-sm-9" style="margin-top: 20px;">
<p style="color: #B8B8B8;font-weight: 500">Manage your orders</p>
<p style="color: #B8B8B8;font-weight: 500;margin-top: -15px;">
 Easily track orders, Create returns.


</p>

  </div>
</div>

    </div>
  </div>
</div>
<br>
@endsection