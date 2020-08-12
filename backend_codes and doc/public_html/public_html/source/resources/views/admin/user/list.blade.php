@extends('admin.layout.app')
<style>
    .btn{
        height:27px !important;
    }
    .material-icons{
        margin-top:0px !important;
        margin-bottom:0px !important;
    }
</style>
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
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">App Users</h4>
    </div>
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>User_name</th>
            <th>User Phone</th>
            <th>User Email</th>
            <th>Registeration Date</th>
            <th>Is Verified</th>
            <th class="text-right">Active/Block</th>
        </tr>
    </thead>
    <tbody>
           @if(count($users)>0)
          @php $i=1; @endphp
          @foreach($users as $user)
        <tr>
            <td class="text-center">{{$i}}</td>
            <td>{{$user->user_name}}</td>
            <td>{{$user->user_phone}}</td>
            <td>{{$user->user_email}}</td>
            <td>{{$user->reg_date}}</td>
            @if($user->is_verified==0)
            <td style="color:red">Not Verified</td>
            @else
            <td style="color:green">Verified</td>
            @endif
            
               
            <td class="td-actions text-right">
                 @if($user->block==1)
               <a href="{{route('userunblock',$user->user_id)}}" rel="tooltip" class="btn btn-danger">
                    <i class="material-icons">block</i>Blocked
                </a>
                @else
                <a href="{{route('userblock',$user->user_id)}}" rel="tooltip" class="btn btn-primary">
                    <i class="material-icons">check</i>Active
                </a>
                @endif
            </td>
        </tr>
          @php $i++; @endphp
                 @endforeach
                  @else
                    <tr>
                      <td>No data found</td>
                    </tr>
                  @endif
    </tbody>
</table>
<div class="pagination justify-content-end" align="right" style="width:100%;float:right !important">{{$users->links()}}</div>
</div>
</div>
</div>
</div>
<div>
    </div>
    @endsection
</div>