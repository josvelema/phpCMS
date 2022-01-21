<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <?php include "includes/admin_nav.php"; ?>





    <div id="page-wrapper">

        <div class="container-fluid ">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin -
                        <small><?php echo $_SESSION['session_user_name']; ?></small>
                    </h1>



                </div>
            </div>

            <!-- /.row -->

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM posts";
                                    $sel_all_posts = mysqli_query($conn, $query);

                                    $count_posts = mysqli_num_rows($sel_all_posts);
                                    ?>



                                    <div class='huge'><?php echo $count_posts; ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM comments";
                                    $sel_all_comments = mysqli_query($conn, $query);

                                    $count_comments = mysqli_num_rows($sel_all_comments);

                                    ?>
                                    <div class='huge'><?php echo $count_comments; ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM users";
                                    $sel_all_users = mysqli_query($conn, $query);

                                    $count_users = mysqli_num_rows($sel_all_users);
                                    ?>

                                    <div class='huge'><?php echo $count_users; ?></div>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM categories";
                                    $sel_all_cat = mysqli_query($conn, $query);

                                    $count_cat = mysqli_num_rows($sel_all_cat);
                                    ?>

                                    <div class='huge'><?php echo $count_cat; ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

<?php

$query = "SELECT * FROM posts WHERE post_status = 'draft'";
$sel_all_drafts = mysqli_query($conn, $query);

$count_drafts = mysqli_num_rows($sel_all_drafts);

$query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
$sel_all_unapproved = mysqli_query($conn, $query);

$count_unapproved = mysqli_num_rows($sel_all_unapproved);

$query = "SELECT * FROM users WHERE user_role = 'subscriber'";
$sel_all_subs = mysqli_query($conn, $query);

$count_subs = mysqli_num_rows($sel_all_subs);



?>


            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            <?php 
                            
                            $element_text = ['Active Post','Draft Posts','Categories','Users','Subscribers','Comments','Unapproved Comments'];
                            $element_count = [$count_posts,$count_drafts,$count_cat,$count_users,$count_subs,$count_comments,$count_unapproved];

                            for ($i = 0;$i < 7; $i++) {
                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                            }

                            
                            
                            ?>


                            // ['Posts',1000]

 
                        ]);

                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>
                <div id="columnchart_material" style="width: auto; height: 500px;"></div>

            </div>
            <!-- /.row -->


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->



    <?php include "includes/admin_footer.php"; ?>