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
                  <h4 class="card-title">FCM Server Key</h4>
                  <form class="forms-sample" action="{{route('updatefcm')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                </div>
                <div class="card-body">
                     <div class="row">
                       <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">User App FCM Server Key</label>
                          <input type="text" name="fcm" value="{{($fcm->server_key)}}" class="form-control">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                       <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Store App FCM Server Key</label>
                          <input type="text" name="fcm2" value="{{($fcm->store_server_key)}}" class="form-control">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                       <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Driver App FCM Server Key</label>
                          <input type="text" name="fcm3" value="{{($fcm->driver_server_key)}}" class="form-control">
                        </div>
                      </div>

                    </div>
                    <button type="submit" class="btn btn-primary pull-center">Update</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
			</div>
          </div>
@endsection