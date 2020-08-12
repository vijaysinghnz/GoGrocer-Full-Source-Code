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
     <a href="{{route('AddDeal')}}" class="btn btn-primary ml-auto" style="width:16%;float:right;padding: 3px 0px 3px 0px;"><i class="material-icons">add</i>Add Deal Products</a>
</div> 
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">Deal Products</h4>
    </div>
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Product_name</th>
            <th>Deal Price</th>
            <th>Valid From</th>
            <th>Valid To</th>
            <th>Status</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
           @if(count($deal_p)>0)
          @php $i=1; @endphp
          @foreach($deal_p as $deal)
        <tr>
            <td class="text-center">{{$i}}</td>
            <td>{{$deal->product_name}} ({{$deal->quantity}}{{$deal->unit}})</td>
            <td>{{$deal->deal_price}}</td>
            <td>{{$deal->valid_from}}</td>
            <td>{{$deal->valid_to}}</td>
            @if($deal->valid_to > $currentdate && $currentdate >= $deal->valid_from)
            <td style="color:green">Ongoing</td>
            @endif
            @if($deal->valid_to < $currentdate)
            <td style="color:red">Expired</td>
            @endif
            @if($deal->valid_from > $currentdate)
            <td style="color:blue">Coming soon</td>
            @endif
          
            
            <td class="td-actions text-right">
                <a href="{{route('EditDeal',$deal->deal_id)}}" rel="tooltip" class="btn btn-success">
                    <i class="material-icons">edit</i>
                </a>
               <a href="{{route('DeleteDeal',$deal->deal_id)}}" rel="tooltip" class="btn btn-danger">
                    <i class="material-icons">close</i>
                </a>
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
<div class="pagination justify-content-end" align="right" style="width:100%;float:right !important">{{$deal_p->links()}}</div>
</div>
</div>
</div>
</div>
<div>
    </div>
    @endsection
</div>