<?php

include("includes/header.php");

// Force Admin to login

if(!isset($_GET['isAdmin']) || $_GET['isAdmin'] != 'true'){

    header("Location: admin/login.php");
}


?>


<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-12">

        <div class="huge text-center" style="font-size: 30px;" >OLATERU ELIJAH OLU :)</div>
        <h3 class="text-center">So you get here ... Nature is awesome <span style="color: red;">↓↓↓</span> ... It is fun coding today!</h3>

        <img src="includes/images/Sky-Nature-Background.jpg" width="100%" alt="" class="img-responsive">


    </div>


</div>
<!-- /.row -->

<?php include("includes/footer.php"); ?>
