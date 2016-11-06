<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SkyTax | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="/assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link href="/assets/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="/assets/admin/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="/assets/admin/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="/assets/admin/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="/assets/admin/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="/assets/admin/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/assets/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- Dropzone -->
        <link href="/assets/admin/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/admin/dropzone/basic.min.css" rel="stylesheet" type="text/css" />

        <link href="/assets/css/custom.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="/assets/jstree/themes/default/style.min.css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="/" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src = "/assets/admin/img/logo-header.png" class="icon"></a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>@if (Auth::check()) {{Auth::user()->name}} @endif <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="/assets/admin/img/avatar3.png" class="img-circle" alt="User Image" />
                                    <p>
                                        @if (Auth::check()) {{Auth::user()->name}} @endif
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="/auth/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="/assets/admin/img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, @if (Auth::check()) {{Auth::user()->name}} @endif </p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    @if(Auth::check() && Auth::user()->role == 'admin')

                        {{--*/
                            $non_admin_users = \App\User::nonAdminUsers();
                        /*--}}

                       <div class="form-group">
                           <select class="form-control user_select">
                                <option value="0">{{\Auth::user()->name}}</option>
                                @if (count($non_admin_users) > 0)
                                @foreach($non_admin_users as $user)
                                <option value="{{$user->id}}"
                                    @if (\Session::has("selected_user") && \Session::get("selected_user") == $user->id)
                                        selected
                                    @endif
                                >{{$user->name}}</option>
                                @endforeach
                                @endif
                           </select>

                       </div>

                    <div class="menu-left-top">

					<a
                            @if (\Session::has("selected_user"))
                                href="/user/{{\Session::get('selected_user')}}/home"
                            @else
                                href="/user/{{\Auth::user()->id}}/home"
                            @endif
                         ><li
                            @if (Request::is('user/*') && Request::segment(3) =="home")
                                style="background-color: #00ccff; box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3);"
							 @elseif (Request::is('/*') && Request::segment(3) =="")
                                style="background-color: #00ccff; box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3);"
                            @endif
                        >Home</li></a>
                    </div>

                    <div class="menu-left">
					<a
                        @if (\Session::has("selected_user"))
                            href="/user/{{\Session::get('selected_user')}}"
                        @else
                            href="/user/{{\Auth::user()->id}}"
                        @endif
                        ><li
                            @if (Request::is('user/*') && Request::segment(3) =="")
                                style="background-color: #00ccff; box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3);"
                            @endif
                        >Files</li></a>
                         <a><li>Messaging</li></a>
                         <a><li>My Bills</li></a>
                         <a><li>Tasks</li></a>
                         <a
                            @if (\Session::has("selected_user"))
                                href="/user/{{\Session::get('selected_user')}}/history"
                            @else
                                href="/user/{{\Auth::user()->id}}/history"
                            @endif
                         ><li
                            @if (Request::is('user/*') && Request::segment(3) == "history")
                                style="background-color: #00ccff; box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3);"
                            @endif
                          >History</li></a>


                    </div>
                    <div class="menu-left-bottom">
                        <a href="/user"><li>Appointments</li></a>
                    </div>
                    @endif
					<!-- USER LEFT MENU START -->
					   @if(Auth::check() && Auth::user()->role != 'admin')

                        {{--*/
                            $non_admin_users = \App\User::nonAdminUsers();
                        /*--}}

                       <!--<div class="form-group">
                           <select class="form-control user_select">
                                <option value="0">{{\Auth::user()->name}}</option>
                                @if (count($non_admin_users) > 0)
                                @foreach($non_admin_users as $user)
                                <option value="{{$user->id}}"
                                    @if (\Session::has("selected_user") && \Session::get("selected_user") == $user->id)
                                        selected
                                    @endif
                                >{{$user->name}}</option>
                                @endforeach
                                @endif
                           </select>

                       </div>-->

                    <div class="menu-left-top">

					<a
                            @if (\Session::has("selected_user"))
                                href="/user/{{\Session::get('selected_user')}}/home"
                            @else
                                href="/user/{{\Auth::user()->id}}/home"
                            @endif
                         ><li
                            @if (Request::is('user/*') && Request::segment(3) =="home")
                                style="background-color: #00ccff; box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3);"
							 @elseif (Request::is('/*') && Request::segment(3) =="")
                                style="background-color: #00ccff; box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3);"
                            @endif
                        >Home</li></a>
                    </div>

                    <div class="menu-left">
					<a
                        @if (\Session::has("selected_user"))
                            href="/user/{{\Session::get('selected_user')}}"
                        @else
                            href="/user/{{\Auth::user()->id}}"
                        @endif
                        ><li
                            @if (Request::is('user/*') && Request::segment(3) =="")
                                style="background-color: #00ccff; box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3);"
                            @endif
                        >Files</li></a>
                         <a><li>Messaging</li></a>
                         <a><li>My Bills</li></a>
                         <a><li>Tasks</li></a>
                         <a
                            @if (\Session::has("selected_user"))
                                href="/user/{{\Session::get('selected_user')}}/history"
                            @else
                                href="/user/{{\Auth::user()->id}}/history"
                            @endif
                         ><li
                            @if (Request::is('user/*') && Request::segment(3) == "history")
                                style="background-color: #00ccff; box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3);"
                            @endif
                          >History</li></a>


                    </div>
                    <div class="menu-left-bottom">
                        <a href="/user"><li>Appointments</li></a>
                    </div>
                    @endif






                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                @yield('content')

            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src="/assets/admin/js/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="/assets/admin/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="/assets/admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="/assets/admin/js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="/assets/admin/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="/assets/admin/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="/assets/admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="/assets/admin/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="/assets/admin/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="/assets/admin/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="/assets/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="/assets/admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="/assets/admin/js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--script src="/assets/admin/js/AdminLTE/dashboard.js" type="text/javascript"></script-->

        <!-- Dropzone -->
        <script src="/assets/admin/dropzone/dropzone.min.js" type="text/javascript"></script>

        <script src="/assets/jstree/jstree.min.js"></script>

        <script src="/assets/js/main.js"></script>

        <script>
            $(document).ready(function ()
            {
                $('#lhs-menu-div').jstree({
                    "core" : {
                        "check_callback" : true,
                        "themes" : { "stripes" : true }
                    },
                })
                .on('changed.jstree', function (e, data) {
                    var i, j, r = [];
                    for(i = 0, j = data.selected.length; i < j; i++) {
                      r.push(data.instance.get_node(data.selected[i]).data['link']);
                        console.log(data.instance.get_node(data.selected[i]));
                    }
                    location.href = r.join(', ');
                });
            });
        </script>

        @yield('extra_scripts')

    </body>
</html>
