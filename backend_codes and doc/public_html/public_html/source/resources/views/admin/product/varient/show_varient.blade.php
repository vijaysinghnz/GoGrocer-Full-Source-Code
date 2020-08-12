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
     <a href="{{route('add-varient', $id)}}" class="btn btn-primary ml-auto" style="width:12%;float:right;padding: 3px 0px 3px 0px;"><i class="material-icons">add</i>Add Varient</a>
</div> 
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">Varient List</h4>
    </div>
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>varient_image</th>
            <th>Description</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
           @if(count($product)>0)
          @php $i=1; @endphp
          @foreach($product as $products)
        <tr>
            <td class="text-center">{{$i}}</td>
            <td>{{$products->quantity}}</td>
            <td> {{$products->unit}}</td>
            <td><img src="{{url($products->varient_image)}}" alt="image"  style="width:50px;height:50px; border-radius:50%"/></td>
            <td> {{$products->description}}</td>
            <td class="td-actions text-right">
                <a href="{{route('edit-varient',$products->varient_id)}}" rel="tooltip" class="btn btn-success">
                    <i class="material-icons">edit</i>
                </a>
                <a href="{{route('delete-varient',$products->varient_id)}}" rel="tooltip" class="btn btn-danger">
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
<div class="pagination justify-content-end" align="right" style="width:100%;float:right !important">{{$product->links()}}</div>
</div>
</div>
</div>
</div>
<div>
    </div>
    @endsection
</div>