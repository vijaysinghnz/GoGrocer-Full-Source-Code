@extends('admin.layout.app')
<style>
sup {
    color:red;
    position: initial;
    font-size: 111%;
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
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Add Varient</h4>
                  <form class="forms-sample" action="{{route('AddNewvarient')}}" method="POST" enctype="multipart/form-data">
                      {{csrf_field()}}
                </div>
                <div class="card-body">
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputName1">MRP</label>
                           <input type="hidden" name="id" value="{{$id}}">
                          <input type="number" step="0.01" class="form-control" id="exampleInputName1" name="mrp" placeholder="Enter MRP">
                        </div>
                      </div>

                    </div>
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Quantity</label>
                          <input type="number" name="quantity" class="form-control">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Unit (G/KG/Ltrs/Ml)</label>
                          <input type="text" name="unit" class="form-control" pattern="[A-Za-z]{1-10}" title="KG/G/Ltrs/Ml etc" required>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Price</label>
                          <input type="number" step="0.01" name="price" class="form-control">
                        </div>
                      </div>
                    </div>
                    
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form">
                          <label class="bmd-label-floating">Varient Image</label>
                          <input type="file"name="varient_image" class="form-control">
                        </div>
                      </div>
                    </div>
                    
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <textarea type="text" name="description" class="form-control"></textarea>
                        </div>
                      </div>
                    </div>


                    <button type="submit" class="btn btn-primary pull-center">Submit</button>
                    <a href="{{route('varient', $id)}}" class="btn">Close</a>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
			</div>
          </div>       

@endsection