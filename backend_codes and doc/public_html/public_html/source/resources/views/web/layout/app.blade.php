<!DOCTYPE html>
<html>
   <head>
      <title>index</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/4ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="{{url('webstyle/owlcarousel/owl.carousel.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{url('webstyle/owlcarousel/owl.theme.default.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{url('webstyle/css/style.css')}}">
      <link href="https://fonts.googleapis.com/css?family=Philosopher&display=swap" rel="stylesheet">
   </head>
   <body>

       @include('web.layout.header')
       @yield('content')
       @include('web.layout.property')

<div class="subs_back">
   <div class="container">
      <div class="row" style="padding-top: 60px;">
         <div class="col-sm-1 in_icon">
         <img src="{{url('webstyle/image/envelope.PNG')}}" height="46">
      </div>
      <div class="col-sm-2 subs_email">
         <span class="subs_font">Subscribe Now With Email</span>
      </div>


      <div class="col-sm-7">
         <input type="search" name="" class="form-control subs_input" placeholder="Enter Your Email Address">
      </div>

      <div class="col-sm-2">
         <button class="btn subs_button">Subscribe</button>
      </div>


      </div>
   </div>
</div>


        @include('web.layout.footer')
   </body>

   </html>


   <script src="owlcarousel/owl.carousel.min.js"></script>
<script>
   $(document).ready(function(){
     $('#owl-one').owlCarousel({
       loop:true,
       margin:10,
       autoplay:true,
       nav:true,
   
                       
   responsive: {
           0:{
               items:1
           },
           600:{
               items:1
           },
           1000:{
               items:2
           }
       }
   })
    $( ".owl-prev").html('<img src="{{url('webstyle/image/l1.PNG')}}" style="margin-left:30px;" height="55"  class="imgkl shadow">');
      $( ".owl-next").html('<img src="{{url('webstyle/image/r2.PNG')}}" style="margin-right:30px;" height="55" class="imgkl shadow">');  
   });
   
   
</script>

<style type="text/css">
.imgkl{
  background-color: white;
}
  .imgkl:hover
  {
     background: white !important;
  }
  
</style>