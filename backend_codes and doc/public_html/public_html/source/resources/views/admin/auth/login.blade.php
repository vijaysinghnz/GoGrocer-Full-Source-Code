<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{$logo->name}} Admin</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{url($logo->favicon)}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('assets/login/css/main.css')}}">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img style="width:100px;height:auto;" src="{{url($logo->icon)}}" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('adminLoginCheck') }}">
					<span class="login100-form-title">
					      {{ csrf_field() }}
				 	 {{$logo->name}} Admin
					</span>
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
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email" required/>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="password" required/>
						 @include('admin.partials._googletagmanager')
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<input class="login100-form-btn" type="submit" value="LOGIN">
						
					</div>

				</form>
			</div>
		</div>
	</div>
	
	<script src="{{url('assets/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{url('assets/login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{url('assets/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{url('assets/login/vendor/select2/select2.min.js')}}"></script>
	<script src="{{url('assets/login/vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="{{url('assets/login/js/main.js')}}"></script>

</body>
</html>