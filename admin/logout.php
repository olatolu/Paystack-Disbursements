<?php require_once("includes/header.php"); ?>

<?php
/*--------------------------------------------------------------*/
/* Logout
 *
 */
$session->logout();

redirect("index.php");

?>