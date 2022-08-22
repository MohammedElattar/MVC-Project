<?php $this->view("eshop/header", $data) ?>
<section id="form" class="d-flex justify-content-center align-items-center">
	<!--form-->
	<div class="container">
		<div class="row" style="
    /* display: flex; */
    /* justify-content: space-between; */
    width: 40%;
    margin: auto;
">
			<div class="login-form">
				<!--login form-->
				<div class="alert alert-danger not-exists text-center" style="display: none;">Your Email Address Or Your Password Are Wrong Check Them Again</div>
				<div class="alert alert-success text-center success" style="display: none;">Logged In Successfully</div>
				<h2>Login to your account</h2>
				<form action="" method="POST" class="loginForm">
					<input type="email" name="email" placeholder="Email Address" />
					<input type="password" name="pass" placeholder="Your Password" />
					<span>
						<input type="checkbox" name="keep-me" class="checkbox">
						Keep me signed in
					</span>
					<button type="submit" class="btn btn-default login-btn">Login</button>
				</form>
				<a href="signup">Don't Have Account ? Sign Up Now</a>
			</div>
			<!--/login form-->
		</div>
	</div>
</section>
<!--/form-->


<?php $this->view("eshop/footer");  ?>