<div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
      <div class="logo"><a href="{{route('adminHome')}}" class="simple-text logo-normal">
          {{$logo->name}}
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
     
          <li class="nav-item active  ">
            <a class="nav-link" href="{{route('adminHome')}}">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          
           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#noti-dropdown" aria-expanded="false" aria-controls="setting-dropdown">
             <i class="material-icons">notifications</i>
              <span class="menu-title">Send Notification<b class="caret"></b></span>
            </a>
            <div class="collapse" id="noti-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('adminNotification')}}">To Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('Notification_to_store')}}">To Stores</a>
                </li>
                </ul>
                </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#setting-dropdown2" aria-expanded="false" aria-controls="setting-dropdown">
              <i class="material-icons">settings</i>
              <span class="menu-title">Settings<b class="caret"></b></span>
            </a>
            <div class="collapse" id="setting-dropdown2">
              <ul class="nav flex-column sub-menu">
                   <li class="nav-item">
                        <a class="nav-link" href="{{route('msg91')}}">SMS/OTP Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('mapapi')}}"> Google Map API</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('app_details')}}"> App Logo/Name</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('fcm')}}"> FCM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('gateway')}}"> Payment Method</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('del_charge')}}">Delivery Fee</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{route('currency')}}">Currency</a>
                    </li>
                      <li class="nav-item">
                     <a class="nav-link" href="{{route('timeslot')}}">Time Slot</a>
                     </li>
                </ul>
                </div>
          </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#cat-dropdown" aria-expanded="false" aria-controls="setting-dropdown">
             <i class="material-icons">content_paste</i>
              <span class="menu-title">Category/products<b class="caret"></b></span>
            </a>
            <div class="collapse" id="cat-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('catlist')}}">Categories</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('productlist')}}">Product</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('deallist')}}">Deal Products</a>
                </li>
                </ul>
                </div>
          </li>
         
          <li class="nav-item ">
            <a class="nav-link" href="{{route('userlist')}}">
              <i class="material-icons">android</i>
              <p>App Users</p>
            </a>
          </li>
          
           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#city-dropdown" aria-expanded="false" aria-controls="setting-dropdown">
             <i class="material-icons">location_city</i>
              <span class="menu-title">City/Area<b class="caret"></b></span>
            </a>
            <div class="collapse" id="city-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('citylist')}}">City</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('societylist')}}">Area</a>
                </li>

                </ul>
                </div>

          </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#store-dropdown" aria-expanded="false" aria-controls="setting-dropdown">
             <i class="material-icons">house</i>
              <span class="menu-title">Store Management<b class="caret"></b></span>
            </a>
            <div class="collapse" id="store-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('storeclist')}}">Store</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('finance')}}">Store Earnings/Payments</a>
                </li>

                </ul>
                </div>

          </li>
         <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ord-dropdown" aria-expanded="false" aria-controls="setting-dropdown">
             <i class="material-icons">layers</i>
              <span class="menu-title">Orders<b class="caret"></b></span>
            </a>
            <div class="collapse" id="ord-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('store_cancelled')}}">Rejected By Store</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('admin_com_orders')}}">Completed Orders</a>
                </li>
                  <li class="nav-item">
                  <a class="nav-link" href="{{route('admin_pen_orders')}}">Pending Orders</a>
                </li>
                  <li class="nav-item">
                  <a class="nav-link" href="{{route('admin_can_orders')}}">Cancelled Orders</a>
                </li>
                </ul>
                </div>
          </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#payout-dropdown3" aria-expanded="false" aria-controls="setting-dropdown2">
              <i class="menu-icon fa fa-rupee"></i>
              <span class="menu-title">Payout Request/Validation<b class="caret"></b></span>
            </a>
            <div class="collapse" id="payout-dropdown3">
              <ul class="nav flex-column sub-menu">
                   <li class="nav-item">
                        <a class="nav-link" href="{{route('pay_req')}}">Payout Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('prv')}}">Payout value validation</a>
                    </li>

                </ul>
                </div>
          </li>
            
            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#setting-dropdown3" aria-expanded="false" aria-controls="setting-dropdown2">
              <i class="menu-icon fa fa-trophy"></i>
              <span class="menu-title">Reward<b class="caret"></b></span>
            </a>
            <div class="collapse" id="setting-dropdown3">
              <ul class="nav flex-column sub-menu">
                   <li class="nav-item">
                        <a class="nav-link" href="{{route('RewardList')}}">Reward Value</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('reedem')}}">Reedem Value</a>
                    </li>

                </ul>
                </div>
          </li>
            
          </li>
          
          
           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#banner-dropdown" aria-expanded="false" aria-controls="setting-dropdown">
             <i class="material-icons">image</i>
              <span class="menu-title">Banner<b class="caret"></b></span>
            </a>
            <div class="collapse" id="banner-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('bannerlist')}}">Main Banner</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('secbannerlist')}}">Secondary Banner</a>
                </li>

                </ul>
                </div>

          </li>
          
    
          <li class="nav-item ">
            <a class="nav-link" href="{{route('d_boylist')}}">
              <i class="material-icons">android</i>
              <p>Delivery Boy</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="{{route('orderedit')}}">
              <i class="material-icons">bubble_chart</i>
              <p>Min/Max. Order Value</p>
            </a>
          </li>
          
          <li class="nav-item ">
            <a class="nav-link" href="{{route('couponlist')}}">
              <i class="material-icons">view_week</i>
              <p>Coupon</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#pages-dropdown" aria-expanded="false" aria-controls="setting-dropdown">
              <i class="menu-icon fa fa-calendar"></i>
              <span class="menu-title">Pages<b class="caret"></b></span>
            </a>
            <div class="collapse" id="pages-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('about_us')}}">About Us</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('terms')}}">Terms & Condition</a>
                </li>

                </ul>
                </div>

          </li>
        </ul>
      </div>
    </div>