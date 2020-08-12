@extends('web.layout.app')
<style>
    div#headingone12 {
    margin-top: 4px !important;
}
</style>
@section('content')

<script>
$(document).ready(function(){
  $("#bu1234").click(function(){
    $("#bod1234").show(500);
     $("#dus1234").show();
      $("#bu1234").hide();

  });

   $("#dus1234").click(function(){
    $("#bod1234").hide(500);
     $("#dus1234").hide();
      $("#bu1234").show();

  });
 
});
</script>

<div class="container-fluid canreq_cont">
  <div class="row">
  <div class="col-sm-3">
    <div class="bs-example card filter_pro_duct12">

<h5 class="side_filter">Categories</h5>


<span style="float: right;display: none;padding-right: 22px;" id="dus1234"><i class="fas fa-angle-up"></i></span></h5>

 <div class="accordion" id="bod1234" style="display: none;">
     
      @if(count($category)>0)
        @foreach($category as $cat)
       <div>
            @if($cat->parent == 0)
         <div class="scard-header" id="headingOne" style="margin-bottom: -7px;margin-top: 14px;">
           
            <a data-toggle="collapse" class="collapsed main_side_head"  href="#collapse{{$cat->cat_id}}" style="text-decoration: none;color: black;font-weight: 500">{{$cat->title}}(P)
             
            <span style="float: right;margin-right:13px;">
                <i class="fa fa-plus" ></i></span>
               
               
         </a>
         </div>
          @foreach($category_sub as $cat_sub)
          @if($cat_sub->parent==$cat->cat_id)
            <div id="collapse{{$cat_sub->parent}}" style="margin-top: 3px;" class="collapse sec_para_side show" aria-labelledby="headingOne">
                <div class="card-body" style="margin-bottom: -35px;">
                     <div class="" style="min-width: 235px !important;margin-left: -27px;padding-bottom: 20px;margin-top: -22px;">
                          <div>
                              
                              
                               <div class="scard-header" id="headingone12" style="margin-bottom: -7px;margin-top: 14px;">
                                   <a href="" data-toggle="collapse" class="collapsed main_side_head"></a>
                                   <a   style="text-decoration: none;color:#ea4444;font-size:13px !important" href="{{route('catee', [$cat_sub->cat_id])}}" >{{$cat_sub->title}}
                                 
                              <span style="float: right;margin-right:13px;">
                                  <i class="fa fa-plus" ></i></span>
                                
                                  </a> 
                               </div>
                                @if(count($category_child)>0)
                                 @foreach($category_child as $cat_child)
                               @if($cat_sub->cat_id==$cat_child->parent) 
                              <div id="collapseone{{$cat_child->parent}}" style="margin-top: 3px;" class="collapse sec_para_side" aria-labelledby="headingone12" >
                                <div class="card-body"  style="margin-bottom: -35px;">
                                    <p class="main_side_para">{{$cat_child->title}}(child-cat)</p>
                                   
                    
                                </div>
                            </div>
                                @endif
                              @endforeach
                              @endif
                          </div>
                     </div>
                </div>
            
            </div>
            
              @endif
               @endforeach
             @endif
       </div>
        @endforeach
         @endif
        
    
 </div>
    <br>
</div>

<div class="card filter_pro_duct1212">
  <h5 class="side_filter" style="background-color: white;z-index: 999">Price (&#8377;) </h5>

      <div class="card-body side_price_scroll">
       <form>
  <input type="checkbox" id="fruit1" name="fruit-1" value="Apple">
  <label for="fruit1">0 &#8377; - 500 &#8377;</label>
  
  

    <input type="checkbox" id="fruit2" name="fruit-2" value="afef">
  <label for="fruit2">500 &#8377; - 1000 &#8377;</label>
  
  <input type="checkbox" id="fruit3" name="fruit-3" value="dfwefw">
  <label for="fruit3">1000 &#8377; - 2000 &#8377;</label>

  <input type="checkbox" id="fruit4" name="fruit-4" value="sdfsd">
  <label for="fruit4">2000 &#8377; - 5000 &#8377;</label>

   <input type="checkbox" id="fruit5" name="fruit-5" value="sdfsd">
  <label for="fruit5">5000 &#8377; - 10000 &#8377;</label>

  <input type="checkbox" id="fruit3" name="fruit-3" value="dfwefw">
  <label for="fruit3">Strawberry</label>

  <input type="checkbox" id="fruit4" name="fruit-4" value="sdfsd">
  <label for="fruit4">Strawberry</label>

   <input type="checkbox" id="fruit5" name="fruit-5" value="sdfsd">
  <label for="fruit5">Dabur</label>


</form>
      </div>
    </div>

<div class="card filter_pro_duct1212">
  <h5 class="side_filter" style="background-color: white;z-index: 999">Brands </h5>

      <div class="card-body side_price_scroll">
       <form>
  <input type="checkbox" id="fruit1" name="fruit-1" value="Apple">
  <label for="fruit1">Apple</label>
  
  

    <input type="checkbox" id="fruit2" name="fruit-2" value="afef">
  <label for="fruit2">Apple</label>
  
  <input type="checkbox" id="fruit3" name="fruit-3" value="dfwefw">
  <label for="fruit3">Strawberry</label>

  <input type="checkbox" id="fruit4" name="fruit-4" value="sdfsd">
  <label for="fruit4">Strawberry</label>

   <input type="checkbox" id="fruit5" name="fruit-5" value="sdfsd">
  <label for="fruit5">Dabur</label>

  <input type="checkbox" id="fruit3" name="fruit-3" value="dfwefw">
  <label for="fruit3">Strawberry</label>

  <input type="checkbox" id="fruit4" name="fruit-4" value="sdfsd">
  <label for="fruit4">Strawberry</label>

   <input type="checkbox" id="fruit5" name="fruit-5" value="sdfsd">
  <label for="fruit5">Dabur</label>


</form>
      </div>
    </div>

  </div>



    <div class="col-sm-9" style="margin-left: -45px;">

      <div class="card shadow-sm top_price_menu">
  <div class="card-body">
   <button class="sort_by_but">Sort By Popularity</button>

     <button class="sort_by_but2">Price (Low To High)</button>

     <button class="sort_by_but2">Price (High To Low)</button>
    
  </div>
</div>

<div class="card shadow-sm main_card12_width">
  <div class="card-body">
  @if(count($products)>0)
   @php $i=1; @endphp
        @foreach($products as $product)
         
<!--<a href="product_preview.php" style="color: black;">-->
  <div class="product_div">
     
       <?php 
       $prev_url= url('/');
       
       $base_url= str_replace('-web','', url('/'));
       
       $url= str_replace('gogrocer-ver2.0','gogrocer-ver2.0/', $base_url);
       ?>
  <center>
    <img src="<?=$url?>{{$product->product_image}}" class="product_image">
  </center>
<div style="height: 85px;">
  <p class="product_name"><img src="<?=$prev_url?>/webstyle/image/green.PNG" style="margin-right: 5px;">{{$product->product_name}}</p>

  <p class="product_brand">Exotic Fruits</p>
 @foreach($prod_variant as $variant)
      @if($variant->product_id==$product->product_id[$i])
<p class="product_prize">$5.00{{$variant->price}}</p>
@endif
     @endforeach
</div>

<select class="form-control product_select">
    @foreach($prod_variant as $variant)
      @if($variant->product_id==$product->product_id)
  <option>{{$variant->quantity}}{{$variant->unit}}-Rs<span>{{$variant->mrp}} </span></option>
     @endif
     @endforeach
</select>

<div class="btn-group btn-group-sm but_div" role="group" aria-label="...">
  <button class="but_minus"><i class="fas fa-minus"></i></button>
  <button class="but_one">1</button>
  <button class="but_plus"><i class="fas fa-plus"></i></button>
  <button class="add_once">Add <span id="once_but12">Once</span></button>
</div>

<button class="but_subcribe"><i class="fas fa-bell"></i> &nbsp;Subcribe</button>

</div>
<!--</a>-->
      @php $i++; @endphp
      @endforeach
         @endif
  </div>
</div>

    </div>

  </div>
</div>


<br>

 @endsection 
<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
          $(this).prev(".scard-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
          $(this).prev(".scard-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
        }).on('hide.bs.collapse', function(){
          $(this).prev(".scard-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
        });
    });
</script>
	<script>
		    function getData(){
		        url = "https://thecodecafe.in/gogrocer-ver2.0/api/banner";
		        fetch(url).then((response)=>{
		            console.log("inside first then")
		            return response.json();
		        }).then((data)=>{
		            console.log("inside second then")
		            console.log(data);
		        })
		    }
		    
		    getData()
		</script>