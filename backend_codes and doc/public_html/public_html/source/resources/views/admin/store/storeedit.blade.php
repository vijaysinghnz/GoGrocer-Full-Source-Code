@extends('admin.layout.app')
 <style>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
      #map {
        height: 100%;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
    </style>
@section ('content')
<div class="row">

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
                  <h4 class="card-title">Update Store Profile</h4>
                  
                   
                </div>
                <div class="card-body">
                  <form class="forms-sample" action="{{route('storeupdate', $store->store_id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Store Name</label>
                          <input type="text" name="store_name" value="{{$store->store_name}}" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Employee Name</label>
                          <input type="text" name="emp_name" value="{{$store->employee_name}}" class="form-control">
                        </div>
                      </div>
                      
                       
                     <div class="col-md-4">
                        <div class="form-group">
                          <label>Store Number</label>
                          <input type="number" name="number" value="{{$store->phone_number}}" class="form-control">
                        </div>
                      </div>
                      
                      
                    </div>
                    
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin Share (%)</label>
                          <input type="number" name="share" value="{{$store->admin_share}}" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" name="email" value="{{$store->email}}" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Password</label>
                          <input type="text" name="password" value="{{$store->password}}" class="form-control">
                        </div>
                      </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6">
                        <div class="form">
                           <label> Select City</label>
                          <select name="city" class="form-control">
                              <option>Select City</option>
                              @foreach($city as $cities)
                              <option value="{{$cities->city_name}}" @if($cities->city_name == $store->city) selected @endif>{{$cities->city_name}}</option>
                              @endforeach
                         </select>
                        </div>
                      </div>
                        <div class="col-md-6">
                        <div class="form-group">
                          <label>Delivery Range (KM)</label><br>
                          <input type="number" name="range" class="form-control" value="{{$store->del_range}}">
                        </div>
                      </div>
                      
                    </div><br>
                       <div class="row">
                      <div class="col-md-12">
                            <div class="form-group">
                              <label for="autocomplete"> Store Address </label>
                              <input type="text" name="address" id="autocomplete" value="{{$store->address}}" class="form-control">
                            </div>
                          </div>
                         </div>
                    <button type="submit" class="btn btn-primary pull-center">Submit</button>
                     <a href="{{route('storeclist')}}" class="btn">Close</a>
                    <div class="clearfix"></div>
                  
                </div>
              </div>
            </div>
			</div>
          </div>
          </form>
          
          
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
{{-- javascript code --}}
<script src="https://maps.google.com/maps/api/js?key={{$map}}=places&callback=initAutocomplete" type="text/javascript"></script>
<script>
   $(document).ready(function() {
        $("#lat_area").addClass("d-none");
        $("#long_area").addClass("d-none");
   });
</script>
<script>
   google.maps.event.addDomListener(window, 'load', initialize);

   function initialize() {
       var input = document.getElementById('autocomplete');
       var autocomplete = new google.maps.places.Autocomplete(input);
       autocomplete.addListener('place_changed', function() {
           var place = autocomplete.getPlace();
           $('#latitude').val(place.geometry['location'].lat());
           $('#longitude').val(place.geometry['location'].lng());
           $("#lat_area").removeClass("d-none");
           $("#long_area").removeClass("d-none");
       });
   }
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{$map}}&libraries=places&callback=initMap"
        async defer></script>              
        
@endsection 

