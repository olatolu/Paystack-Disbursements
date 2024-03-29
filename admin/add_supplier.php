<?php include("includes/header.php"); ?>

<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php

/* **************************
*   Performing series of validation
*   Trim of the data collected
*   Check for empty
*   Check for numbers/email where necessary
*****************************/

if (isset($_POST['submit'])) {

    $account_number = trim($_POST['account_number']);
    $bank_code = trim($_POST['bank_code']);
    $account_name = trim($_POST['main_account_name']);
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);

    if (empty($account_number) || empty($account_name) || $bank_code == 0 || empty($bank_code)) {

        $message = "Compulsory fields are mark in asterisk";

    } elseif (!is_numeric($account_number)) {

        $message = "Invalid Account Number format";

    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Invalid email format";

    } elseif (Supplier::account_verify($account_number, $account_name, $bank_code) == false) {

        $message = "We can not verify the account at the moment. Please check the details or try again later";

    } else {


        if ($save = Supplier::create($account_name, $account_number, $bank_code, $email, $name)) {


            $session->message("Transfer recipient created successfully");

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
                        Add New Supplier
                    </h1>

                    <form action="" method="post">

                        <div class="col-md-8">

                            <?php if (!empty($message)) { ?>

                                <div class="alert alert-warning"><?php echo $message; ?></div>

                            <?php } ?>

                            <div class="form-group">

                                <label for="account_number">Account Number</label>

                                <input type="text" id="account_num" name="account_number"
                                       value="<?php if (isset($account_number)) {
                                           echo $account_number;
                                       } ?>" class="form-control">
                                <span id="account_num_error" class="alert alert-danger"></span>
                            </div>

                            <div class="form-group">

                                <label for="bank_code">Account Bank</label>

                                <select name="bank_code" class="bank_code form-control">

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
                            </div>

                            <div class="form-group">

                                <label for="account_name">Account Name</label>

                                <input type="text" id="account_name" value="<?php if (isset($account_name)) {
                                    echo $account_name;
                                } ?>" class="form-control">
                                <input type="hidden" id="main_account_name" name="main_account_name"
                                       value="<?php if (isset($account_name)) {
                                           echo $account_name;
                                       } ?>" class="form-control">

                                <div class="account_name_alert">
                                    <span id="account_name_error" class="alert-danger"></span>
                                    <span id="account_name_success" class="alert-success"></span>
                                    <span id="account_name_loading" class="alert-info"></span>
                                </div>

                            </div>

                            <div class="form-group">

                                <label for="email">Supplier Email</label>

                                <input type="text" name="email" value="<?php if (isset($email)) {
                                    echo $email;
                                } ?>" class="form-control">

                            </div>

                            <div class="form-group">

                                <label for="description">Supplier Company Name (Optional)</label>

                                <textarea name="name" id="" cols="30" rows="3"
                                          class="form-control"><?php if (isset($name)) {
                                        echo $name;
                                    } ?></textarea>

                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" id="submit" disabled="disabled" value="Create"
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

    <script type="text/javascript">

        $(document).ready(function () {

            $(".bank_code option:first").attr("disabled", "true");

            $('#account_name').prop('disabled', true);
            $('#submit').prop('disabled', true);
            $('.bank_code').prop('disabled', true);

            $("#account_num").keyup(function () {

                var account_number = $('#account_num').val();

                if ($.isNumeric(account_number) && account_number.length == 10) {

                    $('#account_num').css('border-color', '#41b90a');

                    $('.bank_code').prop('disabled', false);

                    $('.bank_code').css('border-color', '#F00');

                    $('.bank_code').focus();

                } else {

                    $('#account_num').css('border-color', '#F00');

                    $('.bank_code').css('border-color', '#ccc');

                    $(".bank_code").prop("selectedIndex", 0);

                    $('.bank_code').prop('disabled', true);

                    $('#submit').prop('disabled', true);


                }

            });

            $("select.bank_code").change(function () {

                //validation

                var account_number = $('#account_num').val();
                var bank_code = $("select.bank_code").val();

                $('#account_name_error').html('').css('display', 'none');

                $('#account_name_success').html('').css('display', 'none');

                $('#account_name_loading').html('<i class="fa fa-spinner"> please wait ...</i>').css('display', 'inline-block');

                $('#submit').prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: 'includes/ajax.php',
                    data: {action: 'accountVerify', account_number: account_number, bank_code: bank_code},
                    dataType: 'json',
                    success: function (data) {

                        if (data.code == 200) {

                            $('#account_name').val(data.msg);

                            $('#main_account_name').val(data.msg);

                            $('#account_name_error').hide();


                            $('.bank_code').css('border-color', '#41b90a');

                            $('#submit').prop('disabled', false);

                            $('#account_name_error').html('').css('display', 'none');
                            $('#account_name_loading').html('').css('display', 'none');
                            $('#account_name_success').html('Account confirmed!').css('display', 'inline-block');

                            $('#submit').focus();

                        } else {

                            $('#account_name').val('');

                            $('#account_name_error').show(1000);

                            $('#account_name_loading').html('').css('display', 'none');
                            $('#account_name_success').html('').css('display', 'none');

                            $('#account_name_error').html('Account can not be confirm at the moment!!! Check the details or try again later').css('display', 'inline-block');

                            $('#submit').prop('disabled', true);

                        }
                    }
                });

            });
        });

    </script>

<?php include("includes/footer.php"); ?>