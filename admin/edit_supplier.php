<?php include("includes/header.php"); ?>

<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php

//Gt the supplier data if we have get request

if (empty($_GET['id'])) {

    redirect("suppliers.php");

} else {

    $suppliers = Supplier::find_all();

    foreach ($suppliers->data as $supplier) {

        if ($supplier->recipient_code == $_GET['id']) {

            $account_number = $supplier->details->account_number;
            $bank_code = $supplier->details->bank_code;
            $account_name = $supplier->details->account_name;
            $email = $supplier->email;
            $name = $supplier->name;

        }

    }

    //Check that we have a supplier data else redirect
    if (!isset($account_number)) {

        redirect("suppliers.php");

    }


}

//Collecting submitted data

if (isset($_POST['submit'])) {

    /* **************************
    *   Performing series of validation
    *   Trim of the data collected
    *   Check for empty
    *   Check for numbers/email where necessary
    *****************************/

    $email_new = trim($_POST['email']);
    $name_new = trim($_POST['name']);
    $account_number_new = trim($_POST['account_number']);
    $account_name_new = trim($_POST['account_name']);
    $bank_code_new = trim($_POST['bank_code']);

    if (!empty($email_new) && !filter_var($email_new, FILTER_VALIDATE_EMAIL)) {

        $message = "Invalid email format";

    } else {

        // Updated Supplier

        if (Supplier::update($account_name_new, $account_number_new, $bank_code_new, $email_new, $name_new)) {

            $session->message("Transfer recipient updated successfully");

            redirect("suppliers.php");

        } else {

            $message = "something went wrong please try again later";
        }

    }


} else {

    $message = "";
}


?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <!--TOP MENU-->

        <?php include("includes/admin_top_nav.php"); ?>

        <!-- ADMIN SIDE NAV-->
        <?php include("includes/admin_side_nav.php"); ?>

    </nav>

    <div id="page-wrapper">

        <!-- ADMIN CONTENT AREA - DASHBOARD-->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row" id="m-form">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Edit Supplier
                    </h1>

                    <form action="" method="post">

                        <div class="col-md-8">

                            <?php if (!empty($message)) { ?>

                                <div class="alert alert-warning"><?php echo $message; ?></div>

                            <?php } ?>

                            <div class="form-group">

                                <label for="account_number">Account Number</label>

                                <input type="text" disabled="disabled" id="account_num" name="account_number"
                                       value="<?php if (isset($account_number)) {
                                           echo $account_number;
                                       } ?>" class="form-control">
                                <input type="hidden" name="account_number" value="<?php if (isset($account_number)) {
                                    echo $account_number;
                                } ?>" class="form-control">
                                <input type="hidden" name="account_name" value="<?php if (isset($account_name)) {
                                    echo $account_name;
                                } ?>" class="form-control">

                            </div>

                            <div class="form-group">

                                <label for="bank_code">Account Bank</label>

                                <select disabled="disabled" name="bank_code" class="bank_code form-control">

                                    <option value="0">-- select option --</option>
                                    <?php
                                    foreach (banks() as $data) {

                                        if (isset($bank_code) && ($bank_code == $data->code)) {

                                            echo "<option selected='selected' value='" . $data->code . "'> " . $data->name . "</option>";

                                        } else {
                                            echo "<option value='" . $data->code . "'> " . $data->name . "</option>";
                                        }
                                    }
                                    ?>


                                </select>
                                <input type="hidden" name="bank_code" value="<?php if (isset($bank_code)) {
                                    echo $bank_code;
                                } ?>">
                            </div>

                            <div class="form-group">

                                <label for="account_name">Account Name</label>

                                <input type="text" id="account_name" disabled="disabled"
                                       value="<?php if (isset($account_name)) {
                                           echo $account_name;
                                       } ?>" class="form-control">
                            </div>

                            <div class="form-group">

                                <label for="email">Supplier Email</label>

                                <input type="text" name="email" value="<?php if (isset($email_new)) {
                                    echo $email_new;
                                } elseif (isset($email)) {
                                    echo $email;
                                } ?>" class="form-control">

                            </div>

                            <div class="form-group">

                                <label for="description">Supplier Company Name (Optional)</label>

                                <textarea name="name" id="" cols="30" rows="3"
                                          class="form-control"><?php if (isset($name_new)) {
                                        echo $name_new;
                                    } elseif (isset($name)) {
                                        echo $name;
                                    } ?></textarea>

                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" id="submit" value="Update Supplier"
                                       class="btn btn-primary pull-right">
                                <a href="suppliers.php" class="btn btn-warning pull-left">Cancel</a>
                            </div>

                        </div>

                    </form>
                </div>


            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <!-- /.navbar-collapse -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>