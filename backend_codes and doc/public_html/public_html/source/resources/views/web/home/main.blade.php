@extends('web.layout.app')

@section('content')

<div class="bg-overlay">   
<h1><b>Growcer</b></h1>
<h4>Online Grocery Store!</h4>

</div>
<br><br>
<div class="container">
   <div class="row">
      <div class="col-sm-12">
         <h3 style="font-size: calc(20px + 8 * ((100vw - 300px) / 1300));">How does Growcer work?
</h3>
      </div>
   </div>
</div>

<div class="container" style="margin-top: 35px;">
   <div class="row">
      <div class="col-sm-4">
        <img src="image/how1.PNG">
        <h5 class="nevwer_h5">
           Never worry about local stores

        </h5>
        <p class="enter_p">
       Enter location and Start ordering items from selected or nearby store.
    </p>
      </div>

       <div class="col-sm-4">
        <img src="image/how2.PNG">
        <h5 class="nevwer_h5">
           Never worry about local stores

        </h5>
        <p class="enter_p">
       Enter location and Start ordering items from selected or nearby store.
    </p>
      </div>

       <div class="col-sm-4">
        <img src="image/how3.PNG">
        <h5 class="nevwer_h5">
           Never worry about local stores

        </h5>
        <p class="enter_p">
       Enter location and Start ordering items from selected or nearby store.
    </p>
      </div>
   </div>
</div>

<div class="container" style="margin-top: 100px;">
   <div class="row">
      <div class="col-sm-6">

<h3 class="buy_grocery">Buy Groceries Online!<br>
Save time and avoid the line!
</h3>

<p class="enter_p">
      Growcer is a premium online grocery shopping service that has been shipping groceries throughout the world. We meticulously hand-package each order using pristine new


    </p>

      </div>

      <div class="col-sm-6"><img src="image/buy_online.jpg" class="buy_gro_image mob_gro_image"></div>
   </div>
</div>
<div class="shadow-sm section_back_col">
   <div class="container" >
   <div class="row">
      <div class="col-sm-3 fir_phone">
               <img src="image/phone2.PNG" class="phonetwo2">
               <img src="image/3.jpg" class="main_image_sec2" id="image_one">
            </div>
            <div class="col-sm-3 sec_phone">
               <img src="image/phone2.PNG" class="phonetwo">
               <img src="image/1.jpg" class="main_image_sec" id="image_one">
            </div>
      <div class="col-sm-6" style="padding-left: 96px;">

<h3 class="buy_grocery2">Download the growcer you<br> love!
</h3>

<p class="enter_p">
     It's all at your fingertips -- the Grocery stores you love. Find the right products to suit your mood, and make the first bite last. Go ahead, download us.
    </p>
      </div>      
   </div>
</div>
</div>

<div class="container" style="margin-top: 50px;">
   <div class="row">
      <div class="col-sm-3 cus_mob1">
         <h3 class="what_our_rel">What our customers

</h3>
      </div>

      <div class="col-sm-9 cus_mob2" >
         <a href="our_customer.php"><button class="btn view_all_but">View All</button></a>
      </div>
   </div>
</div>



<div class="container-fluid" style="overflow: hidden;">
   <div class="row">
 <div class="owl-carousel owl-theme slide" id="owl-one"  style="transform: translate3d(0px, 7px, 0px);margin-top: 30px;">

      <div class="col-sm-6 item" style="max-width: 100%;">
<div class="row">
   <div class="col-sm-6"><img src="image/what1.jpg" class="testimonial_image"></div>
   <div class="col-sm-6">
<p class="enter_p testimonial_content">
       Enter location and Start ordering items from selected or nearby store.
       Enter location and Start ordering items from selected or nearby store.

<br><br>
       <span class="nevwer_h52">Never worry .....</span>
    </p>

   </div>
</div>

      </div>






       <div class="col-sm-6 item" style="max-width: 100%;">
<div class="row">
   <div class="col-sm-6"><img src="image/what2.jpg" class="testimonial_image"></div>
   <div class="col-sm-6">
<p class="enter_p testimonial_content">
       Enter location and Start ordering items from selected or nearby store.
       Enter location and Start ordering items from selected or nearby store.

<br><br>
       <span class="nevwer_h52">Never worry .....</span>
    </p>

   </div>
</div>

      </div>


       <div class="col-sm-6 item" style="max-width: 100%;">
<div class="row">
   <div class="col-sm-6"><img src="image/what1.jpg" class="testimonial_image"></div>
   <div class="col-sm-6">
<p class="enter_p testimonial_content">
       Enter location and Start ordering items from selected or nearby store.
       Enter location and Start ordering items from selected or nearby store.

<br><br>
       <span class="nevwer_h52">Never worry .....</span>
    </p>

   </div>
</div>

      </div>
   </div>
   </div>
</div>

@endsection