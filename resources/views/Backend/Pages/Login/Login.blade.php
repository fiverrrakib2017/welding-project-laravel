
@if (auth()->guard('admin')->check())

<script>
   window.location = "{{ route('admin.dashboard') }}";
</script>

@endif
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In | School Management System </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link href="{{asset('Backend/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- icheck bootstrap -->
    <link href="{{asset('Backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset('Backend/dist/css/adminlte.min.css?v=3.2.0')}}" rel="stylesheet" type="text/css" />

    <style>
        .login-box .card,
        .register-box .card {

            border: 2px #838383 dotted !important;
        }
        .login-card-body, .register-card-body{
            border-bottom: 20px !important;
        }
    </style>
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <!-- <div class="register-logo">
   <img  width="90px" src="http://103.146.16.154/profileImages/avatar.png">
  </div> -->

        <div class="card">
            @if ($errors->any())
            <div class="card-header">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @if(Session::has('error-message'))
            <div class="card-header">
                  <p class="alert alert-danger">{{ Session::get('error-message') }}</p>
            </div>
            @endif
            <div class="card-body register-card-body">
                <div class="register-logo">
                    <img width="90px" src="{{asset('Backend/images/it-fast.png')}}">
                </div>
                <p class="login-box-msg">Welcome Back</p>


                <form action="{{ route('login.functionality') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input  type="email" name="email" class="form-control" placeholder="Enter Your Email" value="{{old('email')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Enter Your Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <button  type="submit" class="btn btn-block btn-success">
                        Login  <i class="fas fa-sign-in-alt"></i>
                    </button>
                </form>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="https://adminlte.io/themes/v3/"></script>
    <script src="{{ asset('Backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Backend/dist/js/adminlte.min.js?v=3.2.0') }}"></script>

</body>

</html>
