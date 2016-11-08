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





@if(Auth::check() && \App\User::authUserType() == \App\User::TYPE_ADMIN_CLIENT)
	@if (\Session::has("selected_user") && \Session::get("selected_user") != 1)
	<!-- For Admins working as another user-->
	<div class="bluebox100">
	<h1>Welcome to Skytax.ca</h1>
	<p> Your are off to a great start and on your to getting your taxes taken care of by a profeessional tax specialist, with the ease of our office in the cloud!</p>
	</div>
	<div class="bluebox40">
			<a  class="fileAddModalclick" href="#filerequestmodal" data-toggle="modal" data-target="#filerequestmodal">
				<h3>New File Requests </h3><i class="fa fa-download fa-3x" aria-hidden="true"></i>
			</a>
			</div>

			<div class="bluebox40">
			<a  href="addFileRequestmodal" data-toggle="modal" data-target="#addFileRequestmodal">
				<h3>New Messages </h3><i class="fa fa-comments fa-3x" aria-hidden="true"></i>
			</a>
			</div>
	<div class="bluebox90">
	<h1>Welcome to Skytax.ca</h1>
	<p> Your are off to a great start and on your to getting your taxes taken care of by a profeessional tax specialist, with the ease of our office in the cloud!</p>
	</div>
	@else
		<!-- For Admin working as himself-->
		<div class="bluebox40">
			<a  href="#">
				<h3>Admin Dashboard Home</h3><i class="fa fa-home fa-3x" aria-hidden="true"></i>
			</a>
		</div>

	@endif
@endif
<!-- For user working as himself-->
@if(Auth::check() && (\App\User::authUserType() == \App\User::TYPE_ADMIN || \App\User::authUserType() == \App\User::TYPE_CLIENT))
	<div class="bluebox100">
	<h1>Hi {{Auth::user()->name}}! Welcome to Skytax.ca</h1>
	<p>FOR USER WORKING AS HIMSELF -  Your are off to a great stanal tax specialist, with the ease of our office in the cloud!</p>
	</div>
@endif
