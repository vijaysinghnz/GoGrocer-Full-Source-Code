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
                  <h4 class="card-title">Payment Method Setting</h4>
                  <b>@if($pymnt->razorpay == 1 && $pymnt->paypal == 0) Razorpay is ON &nbsp;<span style="height: 12px;width: 12px;background-color: green;border-radius: 50%;display: inline-block;" class="dot"></span> @endif
                  @if($pymnt->razorpay == 0 && $pymnt->paypal == 1) Paypal is ON &nbsp;<span style="height: 12px;width: 12px;background-color: green;border-radius: 50%;display: inline-block;" class="dot"></span> @endif 
                  @if($pymnt->razorpay == 1 && $pymnt->paypal == 1) Razorpay and Paypal both are ON &nbsp;<span style="height: 12px;width: 12px;background-color: green;border-radius: 50%;display: inline-block;" class="dot"></span> @endif</b>
                  
                 </div> 
                <div class="container">
            <form action="{{route('updategateway')}}" method="POST">     
            {{csrf_field()}}
                 <div class="form-group">    
                <span>Select Your Payment Method</span>
                <select id="ddlPassport" class="form-control" name="pymnt_via">
                    <option disabled selected>Select Your Payment Method <i class="material_icons">setting</i></option>
                    <option value="razor" @if($pymnt->razorpay == 1 && $pymnt->paypal == 0)selected @endif>Razorpay</option>
                    <option value="paypal" @if($pymnt->razorpay == 0 && $pymnt->paypal == 1)selected @endif>Paypal</option>
                    <option value="both" @if($pymnt->razorpay == 1 && $pymnt->paypal == 1) selected @endif>Both</option>
                </select>
                </div>
                <input type="submit" class="btn btn-primary" value="SUBMIT"><br><br>
            </form> 
              </div>
            </div>
			</div>
          </div>
          </div>
@endsection




