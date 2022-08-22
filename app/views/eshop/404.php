<?php $this->view("eshop/header", $data) ?>

<body>
	<div class="container text-center">
		<div class="logo-404">
			<a href="<?= ROOT ?>"><img src="<?= ASSETS ?>images/home/logo.png" alt="" /></a>
		</div>
		<div class="content-404">
			<img src="<?= ASSETS ?>images/404/404.png" style="width: 200px;margin:10px auto; font-size:50px;" class="img-responsive" alt="" />
			<h1><b>OPPS!</b> We Couldn’t Find this Page</h1>
			<p>Uh... So it looks like you brock something. The page you are looking for has up and Vanished.</p>
			<h2><a href="<?= ROOT ?>">Bring me back Home</a></h2>
		</div>
	</div>
</body>

</html>
<?php require("footer.php") ?>