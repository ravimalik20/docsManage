<!DOCTYPE html>
<html class="bg-blue">
    <head>
        <meta charset="UTF-8">
        <title>SkyTax| Account Registration</title>
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
    <body class="bg-blue">

        <div class="form-box" id="login-box">
      
             <div class="header bg-blue"><img src = "../assets/admin/img/0skytaxlogo.jpg" style="width:250px;margin:auto;display:block;margin-top:25px;margin-bottom:25px; border-top-left-radius:15px !important;
  border-top-right-radius: 15px !important;
  border-bottom-right-radius: 15px !important;
  border-bottom-left-radius: 15px !important;">
              Register A New Account</div>
            <form action="/auth/register" method="post">
                {!! csrf_field() !!}
                <div class="body bg-navy" style = "border-top-left-radius:15px !important;
  border-top-right-radius: 15px !important;">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Username" value="{{ old('name') }}"/>
                        @if ($errors->first('name'))
                        <span id="helpBlock" class="help-block">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-Mail" value="{{ old('email') }}"/>
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
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password"/>
                        @if ($errors->first('password_confirmation'))
                        <span id="helpBlock" class="help-block">{{$errors->first('password_confirmation')}}</span>
                        @endif
                    </div>
                </div>
                <div class="footer">                    

                    <button type="submit" class="btn bg-aqua btn-block">Sign me up</button>

                    <a href="/auth/login" class="text-center">I already have an account, sign me in!</a>
                </div>
            </form>


        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/assets/admin/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
