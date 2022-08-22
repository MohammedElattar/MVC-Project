<?php $this->view("eshop/header", $data); ?>

<div class="container">
    <div class="" style="width: 35%;
    margin: 50px auto;
    display: flex;
    justify-content: center;
    ">
        <div class="signup-form">
            <!--sign up form-->
            <h2 style="text-align: center;font-weight:bold;">New User Signup!</h2>
            <div class="alert alert-danger exists" style="display:none;">This Account is already Exists</div>
            <div class="alert alert-danger valid-name" style="display:none;">Type A Valid Name</div>
            <div class="alert alert-danger valid-email" style="display:none;">Type A Valid Email</div>
            <div class="alert alert-danger pass" style="display:none;">Password Must Be More Than 4 Characters</div>
            <div class="alert alert-success success" style="display: none;">Your Account Has Been Created Successfully</div>
            <form action="" method="POST" class="sign-up-form">
                <input type="text" placeholder="Name" name="name" />
                <input type="email" placeholder="Email Address" name="email" />
                <input type="password" name="pass" placeholder="Password" />
                <button type="submit" class="btn btn-default signup-btn">Signup</button>
            </form>
        </div>
        <!--/sign up form-->
    </div>
</div>
<?php $this->view("eshop/footer") ?>