
        <div id="page-wrapper">

            <div class="container-fluid">

<h1 class="page-header">
  Product Categories
 
  

</h1>


<div class="col-md-4">
    
    <form action="" method="post">
    
        <div class="form-group">
               <p class = "text-center bg bg-success">
                 <?php  add_category(); ?>
                 <?php  display_message(); ?>
                </p>
            <label for="category-title">Category Title</label>
            <input type="text" name="cat_title" class="form-control">
        </div>

        <div class="form-group">
            
            <input type="submit" name="add_category" class="btn btn-primary" value="Add Category">
        </div>      


    </form>


</div>


<div class="col-md-8">

    <table class="table">
            <thead>

        <tr>
            <th>id</th>
            <th>Title</th>
        </tr>
            </thead>



            <tbody>
                <!--    table rows     -->
                <?php show_cat_in_admin(); ?>
                
            </tbody>
        
        </table>

</div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  