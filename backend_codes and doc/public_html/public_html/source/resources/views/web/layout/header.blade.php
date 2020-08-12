<div class="fixed-top  shadow-sm">
<p class="header_store">
<span class="header_span">Growcer–Online Grocery Store!
</span>
<span class="header_curr">$
Currency</span>
</p>
   
 <nav class="navbar navbar-expand-sm navbar-light bg-white" style="margin-top: -16px;">
    <a class="navbar-brand" href="index.php" style="margin-top: -6px;height: 30px;"><img src="{{url('webstyle/image/logo.PNG')}}" style="margin-top: -10px;margin-left: 12px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="color: black">
            
            <li class="nav-item" >
              <a class="nav-link" href="about.php" style="color: black">About Us</a>
            </li>

              <li class="nav-item mobile_menu01" style="margin-left: 33px;">
            <a class="nav-link" href="#" style="color: black">Blog</a>
          </li>
            
          <li class="nav-item mobile_menu01" style="margin-left: 33px;">
            <a class="nav-link" href="contact.php" style="color: black">Contact Us</a>
          </li>

          <li class="nav-item mobile_menu01" style="margin-left: 33px;">
            <a class="nav-link" href="{{route('products')}}" style="color: black">Our Products</a>
          </li>
        
          
          </ul>
          <div class="social-part">
      
         <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="color: black">
            
      

              <li class="nav-item mobile_menu02" style="margin-right:16px;">
            <a class="nav-link" href="login.php" style="color: black;display: none;">Login</a>
            <div class="dropdown" style="height: 32px;">
  <p style="margin-top: -5px;">Welcome {{$cust->user_name}} &nbsp; <img src="{{url('webstyle/image/panga.PNG')}}" height="35" style="border-radius: 10px;"></p>
  <div class="dropdown-content" >
    <a href="#" class="drop_anchor">Dashboard</a>
    <a href="#" class="drop_anchor">My orders</a>
    <a href="#" class="drop_anchor">My Account</a>
    <a href="{{route('userlogout')}}">Logout</a>
  </div>
</div>
          </li>
          @if(Session::has('bamaCust'))
          <li class="nav-item header_li_7 mobile_menu03" onclick="openNav()">
            <a class="nav-link" href="#" style="color: black;margin-top: -3px;"><img src="{{url('webstyle/image/cart.PNG')}}" height="28" style="margin-top: -7px;"> <span class="cart_num">7</span></a>
          </li>
        @endif
          
          </ul>
          </div>
        </div>
      </nav>

      </div>




      <div id="mySidepanel" class="sidepanel shadow-lg">

  <h5 class="sidenav_h5">My Cart <span class="sidenav_span" onclick="closeNav()"><i class="fas fa-times" style="font-size: 15px;color: black"></i></span></h5>

 <div class="header_overflow">
  <div class="row" style="padding: 15px 10px 5px 10px;">
    <div class="col-sm-1">
      <img src="{{url('webstyle/image/pro2.jpg')}}" height="40">
    </div>

    <div class="col-sm-4">
     <p style="font-size: 14px;margin-left: 12px;">Nescafe Classic coffee</p>
     <p class="header_para_34">Pack Size: Small | Quantity: 1</p>
    </div>

    <div class="col-sm-3">
     <div class="btn-group btn-group-sm but_div3" role="group" aria-label="...">
  <button class="but_minus3"><i class="fas fa-minus"></i></button>
  <button class="but_one3"><input type="number" style="border: 0;width: 29px;outline: none;" value="1" name=""></button>
  <button class="but_plus3"><i class="fas fa-plus"></i></button>
  
</div>
    </div>

    <div class="col-sm-2">
    <p class="cart_para">$2.00</p>
    </div>

    <div class="col-sm-2">
      <i class="fas fa-times-circle cart_font" ></i>
    </div>
  </div>

<hr style="margin-top: -8px;margin-bottom: -8px;">


<div class="row" style="padding: 15px 10px 5px 10px;">
    <div class="col-sm-1">
      <img src="{{url('webstyle/image/pro2.jpg')}}" height="40">
    </div>

    <div class="col-sm-4">
     <p style="font-size: 14px;margin-left: 12px;">Nescafe Classic coffee</p>
     <p class="header_para_34">Pack Size: Small | Quantity: 1</p>
    </div>

    <div class="col-sm-3">
     <div class="btn-group btn-group-sm but_div3" role="group" aria-label="...">
  <button class="but_minus3"><i class="fas fa-minus"></i></button>
  <button class="but_one3"><input type="number" style="border: 0;width: 29px;outline: none;" value="1" name=""></button>
  <button class="but_plus3"><i class="fas fa-plus"></i></button>
  
</div>
    </div>

    <div class="col-sm-2">
    <p class="cart_para">$2.00</p>
    </div>

    <div class="col-sm-2">
       <i class="fas fa-times-circle cart_font" ></i>
    </div>
  </div>



  <hr style="margin-top: -8px;margin-bottom: -8px;">


<div class="row" style="padding: 15px 10px 5px 10px;">
    <div class="col-sm-1">
      <img src="{{url('webstyle/image/pro2.jpg')}}" height="40">
    </div>

    <div class="col-sm-4">
     <p style="font-size: 14px;margin-left: 12px;">Nescafe Classic coffee</p>
     <p class="header_para_34">Pack Size: Small | Quantity: 1</p>
    </div>

    <div class="col-sm-3">
     <div class="btn-group btn-group-sm but_div3" role="group" aria-label="...">
  <button class="but_minus3"><i class="fas fa-minus"></i></button>
  <button class="but_one3"><input type="number" style="border: 0;width: 29px;outline: none;" value="1" name=""></button>
  <button class="but_plus3"><i class="fas fa-plus"></i></button>
  
</div>
    </div>

    <div class="col-sm-2">
    <p class="cart_para">$2.00</p>
    </div>

    <div class="col-sm-2">
      <i class="fas fa-times-circle cart_font" ></i>
    </div>
  </div>


  <hr style="margin-top: -8px;margin-bottom: -8px;">


<div class="row" style="padding: 15px 10px 5px 10px;">
    <div class="col-sm-1">
      <img src="{{url('webstyle/image/pro2.jpg')}}" height="40">
    </div>

    <div class="col-sm-4">
     <p style="font-size: 14px;margin-left: 12px;">Nescafe Classic coffee</p>
     <p class="header_para_34">Pack Size: Small | Quantity: 1</p>
    </div>

    <div class="col-sm-3">
     <div class="btn-group btn-group-sm but_div3" role="group" aria-label="...">
  <button class="but_minus3"><i class="fas fa-minus"></i></button>
  <button class="but_one3"><input type="number" style="border: 0;width: 29px;outline: none;" value="1" name=""></button>
  <button class="but_plus3"><i class="fas fa-plus"></i></button>
  
</div>
    </div>

    <div class="col-sm-2">
    <p class="cart_para">$2.00</p>
    </div>

    <div class="col-sm-2">
      <i class="fas fa-times-circle cart_font" ></i>
    </div>
  </div>

</div>



<div class="card header_card12">
  <div class="card-body">

<p class="header_para454">
Sub Total <span style="float: right;">$23.00</span></p>

<p class="header_para454">
Tax <span style="float: right;">$2.00</span></p>

<p class="header_span99">
Net Payable <span style="float: right;">$25.00</span></p>


 <a href="cart.php" style="width: 45%;display: inline-block;"><button class="btn header_viewbag">View Bag</button></a><button class="btn header_pay_to">Proceed To pay</button>
    
  </div>
</div>



</div>

<script>
function openNav() {
  document.getElementById("mySidepanel").style.width = "435px";
}

function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}
</script>