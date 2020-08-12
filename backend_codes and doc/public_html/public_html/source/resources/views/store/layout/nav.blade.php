 <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  
        <div class="container-fluid" align="center">
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
                  <h6>{{$store->store_name}}</h6>
                  <b class="caret"></b>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{route('storelogout')}}">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>