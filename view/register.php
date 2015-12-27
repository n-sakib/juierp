<?php include('template/blankStart.php');?>
<div class="col-lg-12">
	<h1 class="text-center">রেজিস্টার করুন</h1>
	<!-- just to center the form -->
	<div class="col-lg-3"></div>

	<form action="register.php" class="col-lg-6" method="post">
		<h3 class="text-center">ইউজার নেম</h3>
		<input type="text" name="user" class="form-control ">
		<h3 class="text-center">পাসওয়ার্ড</h3>
		<input type="password" name="pass" class="form-control ">
		<!-- <h3 class="text-center">নাম</h3>
		<input type="text" name="name" class="form-control ">
		<h3 class="text-center">ইউজার নেম</h3>
		<input type="text" name="user" class="form-control ">
		<h3 class="text-center">ইমেইল</h3>
		<input type="text" name="email1" class="form-control ">
		<h3 class="text-center">ইমেইলটি পুনরায় লিখুন</h3>
		<input type="text" name="email2" class="form-control ">
		<h3 class="text-center">পাসওয়ার্ড</h3>
		<input type="password" name="pass1" class="form-control ">
		<h3 class="text-center">পাসওয়ার্ডটি পুনরায় লিখুন</h3>
		<input type="password" name="pass2" class="form-control "> -->
		<br>
		<input type="submit" value="সাবমিট" class="form-control ">
	</form>
</div>
<?php 
	require_once '../model/user.php';
	if($_POST)
	{	
		$newUser = new user($_POST["user"],$_POST["pass"]);
		$newUser->create();		
	}

 ?>

<?php include('template/blankEnd.php');?>