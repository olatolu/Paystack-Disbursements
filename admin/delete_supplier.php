<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");} ?>

<?php 

if(!empty($_GET['id'])){

    if(Supplier::delete($_GET['id'])){


        $session->message("The supplier was removed");

        redirect("suppliers.php");

    }else{

        redirect("suppliers.php");

    }



}else{

    redirect("suppliers.php");

}

?>