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
                  <h4 class="card-title">Add Category</h4>
                  <form class="forms-sample" action="{{route('AddNewCategory')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                </div>
                <div class="card-body">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Parent Category</label>
                          <select name="parent_id" class="form-control">
                              <option value="0">no parent</option>
                              @foreach($category as $categorys)
        		          	<option value="{{$categorys->cat_id}}">@if($categorys->level==1)-@endif @if($categorys->level==2)--@endif {{$categorys->title}}</option>
        		              @endforeach
                              
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="col-md-12">
                          <p style="color:green;font-weight:bold">If you select no parent. The category you are adding it becomes main parent category.</p>
                          </div>
                      </div>

                    </div>

 
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Category Title</label>
                          <input type="text" name="cat_name" class="form-control">
                        </div>
                      </div>

                    </div>
                    
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form">
                          <label class="bmd-label-floating">Category Image</label>
                          <input type="file" name="cat_image" class="form-control">
                        </div>
                      </div>

                    </div>
                      <div class="row">
                      <div class="col-md-6">
                        <div class="form">
                          <label class="bmd-label-floating">Description</label>
                          <textarea name="desc" class="form-control"></textarea>
                        </div>
                      </div>

                    </div>

                    <button type="submit" class="btn btn-primary pull-center">Submit</button>
                    <a href="{{route('catlist')}}" class="btn">Close</a>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
			</div>
          </div>
@endsection




