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
                  <h4 class="card-title">App Setting</h4>
                  <form class="forms-sample" action="{{route('updateappdetails')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                </div>
                <div class="card-body">
 
                     <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">App Name</label>
                          <input type="text"name="app_name" value="{{($logo->name)}}" class="form-control">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-md-6">
                     <img src="{{url($logo->icon)}}" alt="app logo" class="rounded-circle" style="width:100px; height:100px;">
                     
                     
                        <div class="form">
                          <label class="bmd-label-floating">App Icon</label>
                          <input type="file"name="app_icon" class="form-control">
                        </div>
                      </div>


                     <div class="col-md-6">
                     <img src="{{url($logo->favicon)}}" alt="app logo" class="rounded-circle" style="width:100px; height:100px;">
                        <div class="form">
                          <label class="bmd-label-floating">Web Favicon</label>
                          <input type="file" name="favicon" class="form-control">
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
@endsection




