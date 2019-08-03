<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");} ?>

<?php

$suppliers = Supplier::find_all();

if(isset($_GET['id'])){

    $recipient = $_GET['id'];
}

if(isset($_POST['submit'])){

    $amount = trim($_POST['amount']);
    $recipient = trim($_POST['recipient']);
    $reason = trim($_POST['reason']);
    $balance = "balance";

    //validation

    if(empty($amount) || $recipient == "0"){

        $message = "Compulsory fields are mark in asterisk";
    }elseif(!is_numeric($amount) || $amount < 100){

        $message = "Transfer amount be invalid and at least NGN 100";

    }elseif(Transfer::balance(1) - 15000 < $amount){

        $message = "You do not have sufficient balance to process your transfer";

    }else{

        //echo $reason;

        $amount_kobo = $amount * 100;

        if($r = Transfer::make_transfer($amount_kobo, $recipient, $reason)){

            var_dump($r);
        }
    }




}else{

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
                    <h1 class="page-header">
                        Make Transfer
                    </h1>

                    <form action="" method="post">

                        <div class="col-md-8">

                            <?php if(!empty($message)){ ?>

                                <div class="alert alert-warning"><?php echo $message; ?></div>

                            <?php } ?>

                            <div class="form-group">

                                <label for="balance">Choose Balance</label>

                                <select name="balance" id="" class="form-control">
                                    <option value="balance"><?php echo "Balance - ".Transfer::balance(); ?></option>
                                </select>

                            </div>

                            <div class="form-group">

                                <label for="account_number">Amount to send<span id="compulsory"> *</span></label>

                                <input type="text" id="amount" name="amount" value="<?php if(isset($amount)){ echo $amount; } ?>" class="form-control" placeholder="Amount (NGN)">
                                <span class="field_description">Minimum transfer amount is NGN 100</span>

                            </div>

                            <div class="form-group">

                                <label for="bank_code">Choose Supplier<span id="compulsory"> *</span></label>

                                <select name="recipient" class="form-control">

                                    <option value="0">-- select option --</option>
                                    <?php
                                    foreach ($suppliers->data as $supplier){

                                        if(isset($recipient) && ($recipient == $supplier->recipient_code)){

                                            echo "<option selected='selected' value='". $supplier->recipient_code . "'> " . $supplier->name ." (". $supplier->details->account_number ." ". $supplier->details->bank_name . ")</option>";

                                        }else {
                                            echo "<option value='" . $supplier->recipient_code . "'> " . $supplier->name ." (". $supplier->details->account_number ." ". $supplier->details->bank_name . ")</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="form-group">

                                <label for="reason">Transfer Note</label>

                                <input type="text" name="reason" value="<?php if(isset($reason)){ echo $reason; } ?>" placeholder="Optional" class="form-control">

                            </div>

                            <span class="field_description">You will be charged NGN 50 for this transfer</span>
                            <br>
                            <div class="form-group">
                                <input type="submit" name="submit" id="submit" value="Transfer" class="btn btn-primary">
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

        $(document).ready(function(){

            $('#account_name').prop('disabled', true);

            <?php if (Transfer::balance(1) < 15000 ) {

            echo "$('#submit').prop('disabled', true);
                 $('#amount').prop('disabled', true);
                    
                   ";

        } ?>

            $("select.bank_code").change(function(){

                //validation

                var account_number = $('#account_num').val();
                var bank_code = $("select.bank_code").val();




                $.ajax({
                    type: "POST",
                    url: 'includes/ajax.php',
                    data: {account_number: account_number, bank_code: bank_code},
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

            });
        });

    </script>

<?php include("includes/footer.php"); ?>