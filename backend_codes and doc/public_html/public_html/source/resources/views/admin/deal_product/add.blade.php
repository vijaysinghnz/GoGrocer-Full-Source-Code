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
                  <h4 class="card-title">Add Deal Product</h4>
                  <form class="forms-sample" action="{{route('AddNewDeal')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                </div>
                <div class="card-body">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Select Product</label>
                          <select name="varient_id" class="form-control">
                              <option disabled selected>Select Product</option>
                              @foreach($deal as $deals)
        		          	<option value="{{$deals->varient_id}}">{{$deals->product_name}} ({{$deals->quantity}}{{$deals->unit}})</option>
        		              @endforeach
                              
                          </select>
                        </div>
                      </div>

                    </div>

 
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Deal Price</label>
                          <input type="text" name="deal_price" class="form-control">
                        </div>
                      </div>

                    </div>
                    
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label">Valid From</label><br>
                          <input type="datetime-local" name="valid_from" class="form-control">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label">Valid To</label><br>
                          <input type="datetime-local" name="valid_to" class="form-control">
                        </div>
                      </div>

                    </div>


                    <button type="submit" class="btn btn-primary pull-center">Submit</button>
                    <a href="{{route('deallist')}}" class="btn">Close</a>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
			</div>
          </div>
@endsection




