<?php
$page='login';
require_once '../cms/overall/header.php';
?>
<div class="container ">
    <div class=" col-xs-10 col-md-6 col-lg-5">
        <h1 class="text-center">Sign In</h1>
    </div>
    <form method="post" class="col-xs-8 col-md-6 col-lg-5 card pb-3 pt-3">
        <div class="form-group">
            <?php
                require_once 'login.inc.php';
            ?>
        </div>
        <div class="form-group">
            <label for="username">Email Address</label><span class="required">*</span>
            <input type="email" class="form-control" name="username" id="username" aria-describedBy="emailHelp" value="<?php echo Input::get('user_email')?>" />
            <small id="emailHelp" class="form-text text-muted">Enter your registered email address.</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label><span class="required">*</span>
            <input type="password" class="form-control" id="user_pass" name="user_pass" aria-describedBy="passwordHelp" />
            <small id="passwordHelp" class="form-text text-muted">Enter password.</small>
        </div>
        <div class="form-group">
            <div><span class="required">*</span> Required fields</div>
            <div><a href="#">I have forgotten my password</a></div>
            <input type="checkbox" name="remember" class="pl-3" id="tandc"/> 
            <label for="tandc"> Remember me.</label>
        </div>
        <button type="submit" class="btn btn-primary w-50 m-auto">Sign In</button>
    </form>
</div>
<?php
require_once '../cms/overall/footer.php';
?>

