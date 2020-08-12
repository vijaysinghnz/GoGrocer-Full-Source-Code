@extends('store.layout.app')

@section ('content')
 <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">local_atm</i>
                  </div>
                  <p class="card-category">Total Earning</p>
                  <h3 class="card-title">{{$sum}} </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-danger">local_atm</i>
                    <a href="javascript:;">Total Earnings</a>
                  </div>
                </div>
              </div>
            </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">local_atm</i>
                  </div>
                  <p class="card-category">Paid By Admin</p>
                  <h3 class="card-title">{{$paid}}</h3>
                </div>
                 <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-danger">local_atm</i>
                    <a href="javascript:;">Paid by admin</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">layers</i>
                  </div>
                  <p class="card-category">Pending Orders</p>
                  <h3 class="card-title">{{$pending}}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-danger">layers</i>
                    <a href="javascript:;">Total Pending Orders</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">Cancelled Orders</p>
                  <h3 class="card-title">{{$cancelled}}</h3>
                </div>
               <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-danger">info_outline</i>
                    <a href="javascript:;">Total Cancelled Orders</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">face</i>
                  </div>
                  <p class="card-category">Completed Orders</p>
                  <h3 class="card-title">{{$completed_orders}}</h3>
                </div>
                 <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-danger">face</i>
                    <a href="javascript:;">Completed Orders</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection