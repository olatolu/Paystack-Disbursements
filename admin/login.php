<?php require_once("includes/header.php"); ?>

<?php

if ($session->is_signed_in()) {

    redirect("index.php");
}

/*--------------------------------------------------------------*/
/* Check login user
 *
 */

if (isset($_POST['submit'])) {

    $username = trim($_POST['username']);

    $password = trim($_POST['password']);

    //Check for username and password submitted


    if ($username == 'admin' && $password == 'admin') {

        $user = 1;

        $session->login($user);

        redirect("index.php");

    } else {

        $the_message = "The credentials is wrong";
    }

} else {

    $the_message = "";
    $username = "";
    $password = "";
}
?>


    <div class="col-md-4 col-md-offset-3">
        <?php if (!empty($the_message)) { ?>
            <div class="alert alert-warning"><?php echo $the_message; ?></div>
        <?php } ?>

        <form id="login-id" action="" method="post">

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" value="admin">

            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" value="admin">

            </div>


            <div class="form-group">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">

            </div>


        </form>


    </div>

<?php include("includes/footer.php"); ?>