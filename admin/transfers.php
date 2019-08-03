<?php include("includes/header.php"); ?>

<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>


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
                        Make a Transfer
                        <small></small>
                    </h1>

                    <div class="col-md-12">

                        <?php if (!empty($session->message)) { ?>

                            <div class="alert alert-danger">

                                <?php echo $session->message;

                                ?>

                            </div>

                            <?php $session->unset_message();
                        } ?>

                        <?php if (count($photos) > 0) { ?>

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Id</th>
                                    <th>Filename</th>
                                    <th>Title</th>
                                    <th>Size</th>
                                    <th>Comments</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($photos as $photo) : ?>
                                    <tr>
                                        <td><img src="<?php echo $photo->picture_path(); ?>" id="admin-photo-thubnail"
                                                 alt="">
                                            <div class="picture_link">
                                                <a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a>
                                                <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a>
                                                <a href="../photo.php?id=<?php echo $photo->id ?>"
                                                   target="_blank">View</a>
                                            </div>

                                        </td>
                                        <td><?php echo $photo->id; ?></td>
                                        <td><?php echo $photo->filename; ?></td>
                                        <td><?php echo $photo->title; ?></td>
                                        <td><?php echo $photo->convertPhotoSize($photo->size); ?></td>
                                        <td>

                                            <?php

                                            $comments = Comment::find_the_comments($photo->id);

                                            echo (count($comments) > 0) ? "<a href='comments_photo.php?id=" . $photo->id . "'>" . count($comments) . "</a>" : "No comment";

                                            ?>


                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>

                        <?php } else {
                            echo "<p> There is no photos to show </p>";
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