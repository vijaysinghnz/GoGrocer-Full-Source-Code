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
     <a href="{{route('store')}}" class="btn btn-primary ml-auto" style="width:10%;float:right;padding: 3px 0px 3px 0px;"><i class="material-icons">add</i>Add Store </a>
</div>     
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">Store List</h4>
    </div>
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
                      <!--<th>ID</th>-->
                      <th>Store Name</th>
                      <th>City</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Admin Share</th>
                      <th>orders</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                         @if(count($city)>0)
                          @php $i=1; @endphp
                          @foreach($city as $cities)
                            <tr>
                                <td class="text-center">{{$i}}</td>
                                <td>{{$cities->store_name}}</td>
                                <td>{{$cities->city}}</td>
                                <td>{{$cities->phone_number}}</td>
                                <td>{{$cities->email}}</td>
                                <td>{{$cities->admin_share}} %</td>
                                <td><a href="{{route('admin_store_orders', $cities->store_id)}}" rel="tooltip">
                                <i class="material-icons" style="color:green">layers</i></a></td>
                                <td class="td-actions text-center">
                    
                                    <a href="{{route('storedit', $cities->store_id)}}" button type="button" class="btn btn-success">
                                        <i class="material-icons">edit</i>
                                    </button></a>
                                     <a href="{{route('storedelete', $cities->store_id)}}" button type="button" class="btn btn-danger">
                                        <i class="material-icons">close</i>
                                    </button></a>
                                    <a target="_blank" rel="noopener noreferrer" href="{{route('secret-login', $cities->store_id)}}" style="padding-top:24px; background-color:black" button type="button" class="btn btn-success">
                                       <i class="fa fa-user-secret fa-2x"></i>
                                    </button></a>
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
<div class="pagination justify-content-end" align="right" style="width:100%;float:right !important">{{$city->links()}}</div>
</div>
</div>
</div>
</div>
<div>
    </div>
    @endsection
</div>