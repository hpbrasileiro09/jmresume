@extends('layouts.admin')

@section('content')

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="shortcut icon" type="image/ico" href="favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/iCheck/square/blue.css")}}">

  <link rel="stylesheet" href="{{ asset("/css/hpbtec.css")}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!--body class="hold-transition login-page"-->
<body class="login-body">

    <div class="login-box" style="opacity:0.90; filter:alpha(opacity=90);"> 
      <div class="login-logo">
        <!--a href="{{ url('/') }}"><b>Admin</b>LTE</a-->
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body" style="border-radius: 0px;">

        <p class="login-box-msg"><img src="{{ asset("logo1.png") }}" width="168" height="178" class="img-circle" alt="Hpb Tecnologia"/><br />Logar para iniciar sua sessão</p>

        <form action="{{ url('/login') }}" method="POST">
          
          {{ csrf_field() }}

          <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" id="password" name="password" class="form-control" placeholder="Senha">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="row">
            <div class="col-xs-8">
              <!--div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Me manter conectado
                </label>
              </div-->
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Logar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!--a href="{{ url('/password/reset') }}">Esqueci a senha</a><br-->
        <!--a href="{{ url('/register') }}" class="text-center">Registre um novo associado</a-->

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.3.min.js") }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
<!-- iCheck -->
<script src="{{ asset ("/bower_components/AdminLTE/plugins/iCheck/icheck.min.js") }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>

@endsection
