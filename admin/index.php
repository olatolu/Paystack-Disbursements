<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");} ?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            <!--TOP MENU-->

            <?php include("includes/admin_top_nav.php"); ?>


            <!-- ADMIN SIDE NAV-->
        <?php include("includes/admin_side_nav.php"); ?>
           
        </nav>

        <div id="page-wrapper">

            <!-- ADMIN CONTENT AREA - DASHBOARD-->
             <?php include("includes/admin_dash_content.php"); ?>

            <!-- /.navbar-collapse -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>