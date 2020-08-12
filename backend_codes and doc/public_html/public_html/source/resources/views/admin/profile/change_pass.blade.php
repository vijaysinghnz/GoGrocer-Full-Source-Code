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
             <br>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Change Password</h4>
                </div>
                <div class="card-body">
                  <form action="{{route('updatepass', $admin->id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Current Password</label>
                          <input type="text" name="current_pass" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">New Password</label>
                          <input type="text" name="new_pass" class="form-control">
                        </div>
                      </div>
                    </div><br>
                    <button type="submit" class="btn btn-primary pull-right">Update Password</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
			</div>
          </div>
@endsection          