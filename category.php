<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


<!-- Navigation -->

<?php include "includes/nav.php"; ?>


<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->

        <div class="col-md-8">

            <?php


            if (isset($_GET['category'])) {

                $post_cat_id  = $_GET['category'];




                if (isset($_SESSION['session_user_name']) && isAdmin($_SESSION['session_user_name'])) {





                    $stmt1 = mysqli_prepare($conn, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_cat_id = ?");
                } else {

                    $stmt2 = mysqli_prepare($conn, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_cat_id = ? AND post_status = ? ");

                    $published = 'published';
                }


                if (isset($stmt1)) {

                    mysqli_stmt_bind_param($stmt1, "i", $post_cat_id);

                    mysqli_stmt_execute($stmt1);

                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                    $stmt = $stmt1;
                } else {


                    mysqli_stmt_bind_param($stmt2, "is", $post_cat_id, $published); //s = string i = integer

                    mysqli_stmt_execute($stmt2);

                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                    $stmt = $stmt2;
                }



                // if(mysqli_stmt_num_rows($stmt) < 1) {



                // echo "<h1 class='text-center'>No Post available for this category</h1>";



                // } else 




                while (mysqli_stmt_fetch($stmt)) {


            ?>

                    <h1 class="page-header">
                        <?php  ?>

                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>

                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

            <?php
                }
                mysqli_stmt_close($stmt);
            } else {

                header("Location: index.php");
            }
            ?>
        </div>



        <!-- Blog Sidebar Widgets Column -->


        <?php include "includes/sidebar.php"; ?>


    </div>
    <!-- /.row -->

    <hr>



    <?php include "includes/footer.php"; ?>