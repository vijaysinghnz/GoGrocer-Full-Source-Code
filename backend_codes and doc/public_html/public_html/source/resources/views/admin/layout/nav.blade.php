 <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <button class="navbar-toggler" align="right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only" align="right">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>    
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">{{$title}}</a>
          </div>
          
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{url($admin->admin_image)}}" style="width:50px; height:50px">
                  <b class="caret"></b>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="{{route('prof')}}">Edit Profile</a>
                  <a class="dropdown-item" href="{{route('passchange')}}">Change Password</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{route('logout')}}">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>