<div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
      <div class="logo"><a href="{{route('storeHome')}}" class="simple-text logo-normal">
          {{$logo->name}} Store
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="{{route('storeHome')}}">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
           <li class="nav-item ">
            <a class="nav-link" href="{{route('payout_req')}}">
              <i class="material-icons">layers</i>
              <p>Send Payout Request</p>
            </a>
          </li>
           <li class="nav-item ">
            <a class="nav-link" href="{{route('st_product')}}">
              <i class="material-icons">layers</i>
              <p>Update Stock</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="{{route('sel_product')}}">
              <i class="material-icons">layers</i>
              <p>Products Add</p>
            </a>
          </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#setting-dropdown2" aria-expanded="false" aria-controls="setting-dropdown">
              <i class="menu-icon fa fa-calendar"></i>
              <span class="menu-title">Orders<b class="caret"></b></span>
            </a>
            <div class="collapse" id="setting-dropdown2">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                  <a class="nav-link" href="{{route('storeassignedorders')}}">Today Orders</a>
                </li>
 
                <li class="nav-item">
                  <a class="nav-link" href="{{route('storeOrders')}}">Next-Day Orders</a>
                </li>
               
                </ul>
                </div>
          </li>
         
        </ul>
      </div>
    </div>