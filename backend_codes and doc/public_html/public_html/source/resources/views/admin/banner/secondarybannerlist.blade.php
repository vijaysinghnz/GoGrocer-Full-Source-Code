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
     <a href="{{route('secbanner')}}" class="btn btn-primary ml-auto" style="width:10%;float:right;padding: 3px 0px 3px 0px;"><i class="material-icons">add</i>Add Banner</a>
</div> 
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">Secondary Banner List</h4>
    </div>
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Slider Name</th>
            
            <th>Banner Image</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
           @if(count($banner)>0)
          @php $i=1; @endphp
          @foreach($banner as $cat)
        <tr>
            <td class="text-center">{{$i}}</td>
            <td>{{$cat->banner_name}}</td>
            <td><img src="{{url($cat->banner_image)}}" style= "height:100px;width:250px;" ></td>
            <td class="td-actions text-right">
                <a href="{{route('secbanneredit',$cat->sec_banner_id)}}" rel="tooltip" class="btn btn-success">
                    <i class="material-icons">edit</i>
                </a>
               <a href="{{route('secbannerdelete',$cat->sec_banner_id)}}" rel="tooltip" class="btn btn-danger">
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
</div>
</div>
</div>
</div>
<div>
    </div>
    @endsection
</div>