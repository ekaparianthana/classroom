<?php
	if (!isset($_SESSION['dosen_login'])){
		isset($_GET['msg']) ? $msg = 'Login Gagal. Username/Password Salah.' : $msg = 'Selamat Datang' ;
?>

<body class='login'>
	<div class="wrapper">
		<h1>
        <a href="#" ><img src="../assets/img/logo-app-big.png" alt="" width="100" height="80" style="float:left"> </a>
        <a href="#">Classroom Schedule</a>
        </h1>
		<div class="login-body">
			<h2>SIGN IN DOSEN</h2>
			<form method='post' action="login.php" class='form-validate' id="test">
				<div class="control-group">
					<div class="controls">
						<input type="text" name='username' placeholder="Username" class='input-block-level' data-rule-required="true">
					</div>
				</div>
				<div class="control-group">
					<div class="pw controls">
						<input type="password" name="password" placeholder="Password" class='input-block-level' data-rule-required="true">
					</div>
				</div>
				<div class="submit">
					<input type="submit" value="Sign In" class='btn btn-primary'>
				</div>
			</form>
            <div class="forget">
				<a href="#"><span><?php echo $msg ?></span></a>
			</div>
		</div>
	</div>
</body>

<?php } else { echo "<meta http-equiv='refresh' content='0; url=index.php' />";} ?> 
