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
                  <h4 class="card-title">Add Coupon</h4>
                  <form class="forms-sample" action="{{route('addcoupon')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                </div>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Coupon Name</label>
                          <input type="text"name="coupon_name" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Coupon Code</label>
                          <input type="text" name="coupon_code" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" name="coupon_desc" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <!--<label class="bmd-label-floating">Valid From</label>-->
                          <p class="card-description">Start Date</p>
                          <input type="datetime-local" name="valid_to" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <p class="card-description">End Date</p>
                          <input type="datetime-local" name="valid_from" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <p class="card-description">Minimum Cart Value</p>
                          <input type="number" name="cart_value" class="form-control">
                        </div>
                      </div>
                    </div><br>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">Discount</label>
                    <select class="form-control form-control-sm img" id="exampleFormControlSelect3" name="coupon_type">
                       <option values="">Select</option>
                      <option value="percentage">Percentage</option>
                      <option value="price">Price</option>
                      
                    </select>
                     <input type="text" class="form-control des_price" id="exampleInputName1" name="coupon_discount" placeholder="Enter discount">
                    </div>
                </div>
                  <div class="col-md-6">
                        <div class="form-group">
                           <label for="exampleFormControlSelect3">Uses Restriction</label>
                          <input type="text" name="restriction" class="form-control" placeholder="maximum uses per user" required>
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