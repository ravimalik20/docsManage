{{--*/
                            $non_admin_users = \App\User::nonAdminUsers();
                        /*--}}
<style>
.bluebox100{
	all:unset;
	color:white;
	width:100%;
		height:auto;
	background-color:#3c8dbc;
	float:left;
	text-align:center;
	vertical-align:middle;
	display:block;
	
	margin-top:2%;
	}
	.bluebox40{
	color:white;
	width:40%;
		height:150px;
	background-color:#3c8dbc;
	float:left;
	text-align:center;
	vertical-align:middle;
	display:block;
	margin-left:5%;
	margin-right:5%;
	margin-top:2%;
	}
.bluebox90{
	
	color:white;
	width:90%;
		height:150px;
	background-color:#3c8dbc;
	float:left;
	text-align:center;
	vertical-align:middle;
	display:block;
	margin-left:5%;
	margin:right:5%;
	margin-top:2%;
	}
.bluebox100 a,a:hover,a:active{color:#fff}
.bluebox40 a,a:hover,a:active{color:#fff}
.bluebox90 a,a:hover,a:active{color:#fff}
</style>



               
<!-- For Admins working as another user-->
@if(Auth::check() && (\App\User::authUserType() == \App\User::TYPE_ADMIN_CLIENT))

	<div class="bluebox90">
	<h3>Home @if (count($non_admin_users) > 0)
                                @foreach($non_admin_users as $user)
                                @if (\Session::has("selected_user") && \Session::get("selected_user") == $user->id)
                                   <i class="fa fa-arrow-right" aria-hidden="true"></i> {{$user->name}}
                                    @endif
                                @endforeach
                                @endif</h3>
				<h3><?php $mytime = Carbon\Carbon::today('America/Toronto');
echo str_replace("/",", ",date_format($mytime,'l/F/d/Y'));?></h3><i class="fa fa-home fa-3x" aria-hidden="true"></i>
			</a>
		</div>
		<div class="bluebox90">
		<h3>Client Information</h3>
		<p>A table of clients registration should go here...we can do this later</p>
		</div>
@endif
		<!-- For Admin working as himself-->
		
@if(Auth::check() && \App\User::authUserType() == \App\User::TYPE_ADMIN)
		<div class="bluebox90">
			<a  href="#">
			<h3>Home</h3>
				<h3><?php $mytime = Carbon\Carbon::today('America/Toronto');
echo str_replace("/",", ",date_format($mytime,'l/F/d/Y'));?></h3>
<i class="fa fa-home fa-3x" aria-hidden="true"></i>
			</a>
		</div>
<div class="bluebox90">
			<a  href="#">
			<h3>** New **</h3>
				<span style="margin-right:10px"><i class="fa fa-envelope fa-3x" aria-hidden="true" style="margin-right:25px;margin-left:25px"></i>
				<i class="fa fa-bell-o fa-3x" aria-hidden="true" style="margin-right:25px;margin-left:25px"></i>
				<i class="fa fa-file-o fa-3x" aria-hidden="true" style="margin-right:25px;margin-left:25px"> </i></span>
				
			</a>
		</div>
	
@endif
<!-- For client working as himself-->	
@if(Auth::check() && \App\User::authUserType() == \App\User::TYPE_CLIENT)
	<div class="bluebox90">
	<h1>Hi {{Auth::user()->name}}! Welcome to Skytax.ca</h1>
	<p>FOR USER WORKING AS HIMSELF -  Your are off to a great start to tax season, with the ease of our office in the cloud!</p>
	</div>
	<div class="bluebox40">
	<h3><strong>{{Auth::user()->name}},</strong></h3><h3> You can earn $$ by referring your friends!</h3>
	<p>Earn $10 for every customer you refer! You friend will also get a great deal!</p>
	</div>
	<div class="bluebox40">
	<h3>Did you Know???</h3>
	<p>All of our tax experts have University Degree's with a specialization in Accounting and Tax! We require experience, rigorous testing, yearly upgrading and exams to make sure we stay on top of the everchanging tax rules!</p>
	</div>
	<!-- For client working as client-->
@endif	
@if(Auth::check() && \App\User::authUserType() == \App\User::TYPE_CLIENT_CLIENT)
<P>client working as client</p>
@endif

