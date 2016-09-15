<!DOCTYPE html>
<html class="bg-white">
    <head>
        <meta charset="UTF-8">
        <title>SkyTax | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="/assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="/assets/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/assets/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css" />

    </head>
    <body class="bg-white">
        <img src = "../assets/admin/img/logo-with-icon.png" style="width:250px;margin:auto;display:block;margin-bottom:2px;">
<div class="form-logo-area">

</div>

        <div class="form-box" id="login-box">

            <div class="header">
              Sign In</div>

            <form action="/auth/login" method="post">
                {!! csrf_field() !!}
                <div class="body bg-navy">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email"/>
                        @if ($errors->first('email'))
                        <span id="helpBlock" class="help-block">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                        @if ($errors->first('password'))
                        <span id="helpBlock" class="help-block">{{$errors->first('password')}}</span>
                        @endif
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember"/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-aqua btn-block">Sign me in</button>
                    
                    <!--p><a href="#">I forgot my password</a></p-->
                    
                    <a href="/auth/register" class="text-center">Register a New Account (it's free!)</a>
                </div>
            </form>


        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>


<!-- resources/views/auth/login.blade.php -->


