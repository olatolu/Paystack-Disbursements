<?php include("includes/header.php"); ?>

<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php

if (isset($_GET['page']) && is_numeric($_GET['page'])) {

    $transfers = Supplier::listTransfers(PERPAGE, $_GET['page']);
} else {

    $_GET['page'] = 1;

    $transfers = Supplier::listTransfers(PERPAGE, $_GET['page']);

}

$totalTransfers = Supplier::listTransfers();

$pageNum = pagination(count($totalTransfers));


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
                        All Transaction
                    </h1>

                    <a href="make_transfer.php" class="btn btn-primary">Make a Transfer</a>

                    <div class="col-md-12">

                        <?php if (!empty($session->message)) { ?>

                            <br>
                            <div class="alert alert-danger">

                                <?php echo $session->message; ?>

                            </div>

                            <?php $session->unset_message();
                        } ?>

                        <?php if (count($transfers) > 0) { ?>

                            <div class="table-responsive" id="m_table">


                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Transfer Details</th>
                                        <th>Recipient Account</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach ($transfers as $transfer) : ?>
                                        <tr>
                                            <td><?php echo ($transfer->status == 'success') ? '<i id="stat_on" class="fa fa-toggle-on"></i>' : '<i id="stat_off" class="fa fa-toggle-off"></i>'; ?></td>
                                            <td>
                                                <b><?php echo $transfer->recipient->currency . number_format($transfer->amount / 100, 2); ?></b>
                                                to <?php echo $transfer->recipient->name; ?></td>
                                            <td><?php echo "<b>" . $transfer->recipient->details->account_number . "</b> " . $transfer->recipient->details->bank_name; ?></td>
                                            <td><?php echo date('d M, Y @ H:i:s A', strtotime($transfer->createdAt)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>

                        <?php } else {
                            echo "<p> There is no transaction to show </p>";
                        } ?>

                        <nav aria-label="...">
                            <ul class="pagination pagination-sm">
                                <?php for ($i = 1; $i <= $pageNum; $i++) {
                                    if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] == $i) { ?>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"
                                               tabindex="-1"><?php echo $i; ?></a>
                                        </li>
                                    <?php } else { ?>

                                        <li class="page-item"><a class="page-link"
                                                                 href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        </nav>

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