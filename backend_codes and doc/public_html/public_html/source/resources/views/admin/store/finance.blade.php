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
      <h4 class="card-title ">Store Earnings</h4>
      <!--<p class="card-category">List Of Categories</p>-->
    </div>
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
                      <!--<th>ID</th>-->
                      <th>Store</th>
                      <th>Address</th>
                      <th>Total Revenue</th>
                      <th>Already Paid</th>
                      <th>Pending Balance</th>
                    </thead>
                    <tbody>
                         @if(count($total_earnings)>0)
                          @php $i=1; @endphp
                          @foreach($total_earnings as $total_earning)
                            <tr>
                                <td class="text-center">{{$i}}</td>
                                <td>{{$total_earning->store_name}}<p style="font-size:14px">({{$total_earning->phone_number}})</p></td>
                                <td>{{$total_earning->address}}</td>
                                <td>{{$total_earning->sumprice}}</td>
                                @if($total_earning->paid != NULL)
                                <td>{{$total_earning->paid}}</td>
                                @else
                                <td>0</td>
                                @endif
                                 @if($total_earning->paid != NULL)
                                <td>{{$total_earning->sumprice - $total_earning->paid }}</td>
                                @else
                                <td>{{$total_earning->sumprice}}</td>
                                @endif
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
<div class="pagination justify-content-end" align="right" style="width:100%;float:right !important">{{$total_earnings->links()}}</div>
</div>
</div>
</div>
</div>
<div>
 </div>
    @endsection
</div>