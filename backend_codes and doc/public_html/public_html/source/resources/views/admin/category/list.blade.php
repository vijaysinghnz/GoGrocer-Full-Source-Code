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
     <a href="{{route('AddCategory')}}" class="btn btn-primary ml-auto" style="width:16%;float:right;padding: 3px 0px 3px 0px;"><i class="material-icons">add</i>Add Category</a>
   </div> 
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">Category List</h4>
    </div>
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Cat Name</th>
            <th>Parent Category</th>
            <th>Cat image</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
           @if(count($category)>0)
          @php $i=1; @endphp
          @foreach($category as $cat)
        <tr>
            <td class="text-center">{{$i}}</td>
            <td>{{$cat->title}}</td>
            @if($cat->parent == 0)
            <td>-------</td>
            @endif
            @if($cat->parent != 0)
            <td>{{$cat->tttt}}</td>
            @endif
            <td><img src="{{url($cat->image)}}" alt="category image" style="width:50px; height:50px; border-radius:50%;"/></td>
            <td class="td-actions text-right">
                <a href="{{route('EditCategory',$cat->cat_id)}}" rel="tooltip" class="btn btn-success">
                    <i class="material-icons">edit</i>
                </a>
               <a href="{{route('DeleteCategory',$cat->cat_id)}}" rel="tooltip" class="btn btn-danger">
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
<div class="pagination justify-content-end" align="right" style="width:100%;float:right !important">{{$category->links()}}</div>
</div>

</div>
</div>
</div>
<div>
    </div>
    @endsection
</div>