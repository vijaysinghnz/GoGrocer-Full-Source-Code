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
                  <h4 class="card-title">Edit Coupon Details</h4>
                  <form class="forms-sample" action="{{route('updatecoupon')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                </div>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Coupon Name</label>
                          <input type="hidden" name="coupon_id"  value="{{$coupon->coupon_id}}">
                          <input type="text" value="{{$coupon->coupon_name}}" name="coupon_name" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Coupon Code</label>
                          <input type="text" value="{{$coupon->coupon_code}}" name="coupon_code" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" value="{{$coupon->coupon_description}}"  name="coupon_desc" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <!--<label class="bmd-label-floating">Valid From</label>-->
                          <p class="card-description">Valid To</p>
                          <input type="datetime-local" value="{{$coupon->start_date}}" name="valid_to" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <!--<label class="bmd-label-floating">Valid To</label>-->
                          <p class="card-description">Valid From</p>
                          <input type="datetime-local" value="{{$coupon->end_date}}" name="valid_from" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <!--<label class="bmd-label-floating">Minimum Cart Value</label>-->
                          <p class="card-description">Minimum Cart Value</p>
                          <input type="number" value="{{$coupon->cart_value}}" name="cart_value" class="form-control">
                        </div>
                      </div>
                    </div>
                    <br>
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">Discount</label>
                <select class="form-control form-control-sm img" id="exampleFormControlSelect3" value="{{$coupon->type}}"  name="coupon_type">
                       <!--<option values="">Select</option>-->
                      <option value="percentage" @if($coupon->type == 'percentage' || $coupon->type == 'Percentage' ||$coupon->type == 'PERCENTAGE') selected @endif>Percentage</option>
                      <option value="price" @if($coupon->type == 'price'|| $coupon->type == 'Price' ||$coupon->type == 'PRICE') selected @endif>Price</option>
                      
                    </select>
                     <input type="text" class="form-control " id="exampleInputName1" value="{{$coupon->amount}}" name="coupon_discount" placeholder="Enter discount">
                    </div>
                </div>
                  <div class="col-md-6">
                        <div class="form-group">
                           <label for="exampleFormControlSelect3">Uses Restriction</label>
                          <input type="text" name="restriction" class="form-control" value="{{$coupon->uses_restriction}}">
                        </div>
                      </div>
            </div>

                    <button type="submit" class="btn btn-primary pull-center">Submit</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
			</div>
          </div>
          
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
        	$(document).ready(function(){
        	
                $(".des_price").hide();
                
        		$(".img").on('change', function(){
        	        $(".des_price").show();
        			
        	});
        	});
</script>             
          @endsection