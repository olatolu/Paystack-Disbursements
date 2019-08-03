<?php include("includes/header.php"); ?>

<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php

$suppliers = Supplier::find_all();

if (isset($_GET['id'])) {

    $recipient = $_GET['id'];
}

// Collect and Process the Transfer Form

if (isset($_POST['submit'])) {

    $amount = trim($_POST['amount']);
    $recipient = trim($_POST['recipient']);
    $reason = trim($_POST['reason']);
    $balance = "balance";

    /* **************************
    *   Perform series of validation
    *   Trim of the data collected
    *   Check for empty
    *   Check for numbers/email where necessary
    *****************************/

    if (empty($amount) || $recipient == "0") {

        $message = "Compulsory fields are mark in asterisk";
    } elseif (!is_numeric($amount) || $amount < 100) {

        $message = "Transfer amount be invalid and at least NGN 100";

    } elseif (Transfer::balance(1) - 15000 < $amount) {

        $message = "You do not have sufficient balance to process your transfer";

    } else {

        //Process the data to be send

        $amount_kobo = $amount * 100; // Converting to Kobo

        if ($otp = Transfer::make_transfer($amount_kobo, $recipient, $reason)) {

            $finalize_transfer = true;

            $otp_transaction_ref = $otp->transfer_code;

            if ($transfer_details = Transfer::fetch_transfer($otp_transaction_ref)) {

                //Collecting data needed for the next step

                $transfer_otp_code = $transfer_details->transfer_code;

                $transfer_des = $transfer_details->currency . " " . number_format($transfer_details->amount / 100, 2) . " to " . $transfer_details->recipient->details->account_name;
                $transfer_acnt_details = "<b>" . $transfer_details->recipient->details->account_number . "</b> " . $transfer_details->recipient->details->bank_name;

            } else {

                $message = "An Error occur, please try again later";
            }

        } else {

            $message = "An Error occur, please try again later";
        }
    }

} else {

    $message = "";
}

/* **************************
*   PROCESSING THE SECOND STAGE DATA
*   Trim of the data collected
*   Check for empty
*   Check for numbers/email where necessary
*****************************/

if (isset($_POST['submit_otp'])) {

    $otp_code = $amount = trim($_POST['confirm_otp']);
    $otp_transaction_ref = trim($_POST['otp_transaction_ref']);

    //validation

    if (empty($otp_code) || empty($otp_transaction_ref)) {

        $finalize_transfer = true;

    } elseif (!is_numeric($otp_code)) {

        $finalize_transfer = true;

        $message = "An error occur please try again later";

    } else {

        if ($check = Transfer::finalize_transfer($otp_transaction_ref, $otp_code)) {

            if ($check->status == "true") {

                $session->message("Your transfer was successful");

                redirect("transactions.php"); // Redirection

            } else {

                $finalize_transfer = true;

                $message = "An error occur please try again later"; // Catching exceptional cases
            }


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
            <div class="row">
                <div class="col-lg-12">
                    <!--
                    |Checking for which stage we are and showing relevant form
                    |
                    -->
                    <?php if (!isset($finalize_transfer) || $finalize_transfer != true) { ?>
                        <h1 class="page-header">
                            Make Transfer
                        </h1>

                        <form action="" method="post">

                            <div class="col-md-8">

                                <?php if (!empty($message)) { ?>

                                    <div class="alert alert-warning"><?php echo $message; ?></div>

                                <?php } ?>

                                <div class="form-group">

                                    <label for="balance">Choose Balance</label>

                                    <select name="balance" id="" class="form-control">
                                        <option value="balance"><?php echo "Balance - " . Transfer::balance(); ?></option>
                                    </select>

                                </div>

                                <div class="form-group">

                                    <label for="account_number">Amount to send<span id="compulsory"> *</span></label>

                                    <input type="text" id="amount" name="amount" value="<?php if (isset($amount)) {
                                        echo $amount;
                                    } ?>" class="form-control" placeholder="Amount (NGN)">
                                    <span class="field_description">Minimum transfer amount is NGN 100</span>

                                </div>

                                <div class="form-group">

                                    <label for="bank_code">Choose Supplier<span id="compulsory"> *</span></label>

                                    <select name="recipient" class="form-control">

                                        <option value="0">-- select option --</option>
                                        <?php
                                        foreach ($suppliers->data as $supplier) {

                                            if (isset($recipient) && ($recipient == $supplier->recipient_code)) {

                                                echo "<option selected='selected' value='" . $supplier->recipient_code . "'> " . $supplier->details->account_name . " (" . $supplier->details->account_number . " " . $supplier->details->bank_name . ")</option>";

                                            } else {
                                                echo "<option value='" . $supplier->recipient_code . "'> " . $supplier->details->account_name . " (" . $supplier->details->account_number . " " . $supplier->details->bank_name . ")</option>";
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>

                                <div class="form-group">

                                    <label for="reason">Transfer Note</label>

                                    <input type="text" name="reason" value="<?php if (isset($reason)) {
                                        echo $reason;
                                    } ?>" placeholder="Optional" class="form-control">

                                </div>

                                <span class="field_description">You will be charged NGN 50 for this transfer</span>
                                <br>
                                <div class="form-group">
                                    <input type="submit" name="submit" id="submit" value="Transfer"
                                           class="btn btn-primary">
                                </div>

                            </div>

                        </form>

                    <?php } else /* Showing the Next Stage instead */ { ?>

                        <h1 class="page-header">
                            Finalize Transfer
                        </h1>

                        <form action="" method="post">

                            <div class="col-md-8">

                                <?php if (!empty($message)) { ?>

                                    <div class="alert alert-warning"><?php echo $message; ?></div>

                                <?php } ?>

                                <div class="transfer_conf_det">

                                    <h3><?php if (isset($transfer_des)) {
                                            echo $transfer_des;
                                        } ?></h3>
                                    <h4><?php if (isset($transfer_acnt_details)) {
                                            echo $transfer_acnt_details;
                                        } ?></h4>

                                    <p>We sent you a confirmation code at your phone number on file. Please enter the
                                        code here to complete this transfer</p>

                                </div>

                                <div class="form-group">

                                    <label for="otp">Enter Code</label>

                                    <input type="text" name="confirm_otp" value="<?php if (isset($otp_code)) {
                                        echo $otp_code;
                                    } ?>" placeholder="Confirmation code" class="form-control">
                                    <input type="hidden" name="otp_transaction_ref"
                                           value="<?php if (isset($otp_transaction_ref)) {
                                               echo $otp_transaction_ref;
                                           } ?>">
                                    <a href="" id="resendCode" class="resend_otp_a"><i class="fa fa-undo"></i> Resend
                                        code</a>
                                    <p class="alert-danger" id="otp-info"></p>

                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit_otp" id="submit_otp" value="Confirm Transaction"
                                           class="btn btn-primary">
                                </div>

                            </div>

                        </form>


                    <?php } ?>

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

            $('#account_name').prop('disabled', true);

            <?php if (Transfer::balance(1) < 15000) {

            echo "$('#submit').prop('disabled', true);
                 $('#amount').prop('disabled', true);
                    
                   ";

        } ?>

            /*$("select.bank_code").change(function(){

                //validation

                var account_number = $('#account_num').val();
                var bank_code = $("select.bank_code").val();




                $.ajax({
                    type: "POST",
                    url: 'includes/ajax.php',
                    data: {action: 'accountVerify', account_number: account_number, bank_code: bank_code},
                    dataType: 'json',
                    success: function(data){

                        if(data.code == 200) {

                            $('#account_name').val(data.msg);

                            $('#main_account_name').val(data.msg);

                            $('#account_name_error').hide();

                            $('#submit').prop('disabled', false);

                        }else{

                            $('#account_name').val('');

                            $('#account_name_error').toggle(1000);

                            $('#account_name_error').html('Account can not be confirm at the moment!!! Check the details or try again later');

                            $('#submit').prop('disabled', true);

                        }
                    }
                });

            });*/

            $('#resendCode').click(function (event) {

                event.preventDefault();

                $('#otp-info').html('');

                //alert("Resend Code");

                $.ajax({
                    type: "POST",
                    url: 'includes/ajax.php',
                    data: {
                        action: 'reSendCode', transfer_ref: '<?php if (isset($transfer_code)) {
                            echo $transfer_otp_code;
                        } ?>'
                    },
                    dataType: 'json',
                    success: function (data) {

                        if (data.code == 200) {

                            $('#otp-info').html(data.msg);


                        } else {

                            $('#otp-info').html(data.msg);

                        }
                    }
                });

            });
        });

    </script>

<?php include("includes/footer.php"); ?>