<?php include("includes/header.php"); ?>

<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php

$suppliers = Supplier::find_all();


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
                        All Suppliers
                    </h1>

                    <a href="add_supplier.php" class="btn btn-primary">Add Supplier</a>

                    <div class="col-md-12">

                        <?php if (!empty($session->message)) { ?>

                            <br>
                            <div class="alert alert-danger">

                                <?php echo $session->message;

                                ?>

                            </div>

                            <?php $session->unset_message();
                        } ?>

                        <?php if (count($suppliers->data) > 0) {

                            //var_dump($suppliers);?>


                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Recipient Code</th>
                                    <th>Email address</th>
                                    <th>Account</th>
                                    <th>Type</th>
                                    <th>Added On</th>
                                    <th>Action</th>
                                    <th>Transfer</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($suppliers->data as $supplier) : ?>
                                    <tr>
                                        <td><?php echo ($supplier->active == true) ? '<span class="btn btn-success">Active</span>' : '<span class="btn btn-secondary">Inactive</span>'; ?></td>
                                        <td><?php echo $supplier->details->account_name; ?>
                                            <hr><?php echo $supplier->name; ?></td>
                                        <td><?php echo $supplier->recipient_code; ?></td>
                                        <td><?php echo $supplier->email; ?></td>
                                        <td><?php echo '<b>' . $supplier->details->account_number . '</b><br>' . $supplier->details->bank_name; ?></td>
                                        <td><?php echo $supplier->type; ?></td>
                                        <td><?php echo $supplier->createdAt; ?></td>
                                        <td>
                                            <div class="action_links">
                                                <a href="delete_supplier.php?id=<?php echo $supplier->recipient_code; ?>">Delete</a>
                                                <a href="edit_supplier.php?id=<?php echo $supplier->recipient_code; ?>">Edit</a>
                                            </div>
                                        </td>
                                        <td><a href="make_transfer.php?id=<?php echo $supplier->recipient_code; ?>"
                                               autocapitalize="btn btn-danger">Make Transfer</a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>

                        <?php } else {
                            echo "<p> There is no supplier to show </p>";
                        } ?>

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