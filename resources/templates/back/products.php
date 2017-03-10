
<div id="page-wrapper">

    

     <div class="row">

        <h1 class="page-header">
           All Products

        </h1>
        <h3 class="text-centered bg-success"><?php display_message(); ?></h3>
        <table class="table table-hover">


            <thead>

              <tr>
                   <th>Product Id</th>
                   <th>Product Title</th>
                   <th>Product Category Id</th>
                   <th>Product Price</th>
                   <th>Product Max Quantity</th>
                   
              </tr>
            </thead>
            <tbody>
                
                <?php
                display_products_in_admin();
                ?>
                
          </tbody>
        </table>
     </div>

          

    </div>
    <!-- /#wrapper -->
