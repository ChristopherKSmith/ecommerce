<?php require_once("../resources/config.php");?>

   <?php include(TEMPLATE_FRONT . DS . "header.php");?>


    <!-- Page Content -->
    <div class="container">
        <?php
            $query = query("SELECT * FROM categories WHERE cat_id = " . escape_string($_GET['id']) . " ");
            comfirm($query);


            while($row = fetch_array($query)){
            $cat_title =  $row['cat_title'];
            }
        ?>
        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>Welcome to the <?php echo $cat_title; ?> Category!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
<!--            <p><a class="btn btn-primary btn-large">Call to action!</a>-->
            </p>
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Products</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

           <!-- Category Features -->
            <?php get_products_in_cat_page(); ?>

        </div>
        <!-- /.row -->

       
    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php");?>