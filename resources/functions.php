<?php

$upload_directory = "uploads";

// *******************************************helper functions****************************************************************
function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message'] = $msg;
    }
}

function display_message(){
    
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function redirect($location){
    header("Location: $location ");
}

function query($sql){
    global $connection;
    return mysqli_query($connection, $sql);
}

function comfirm($result){
    global $connection;
    if(!$result){
        die("QUERY FAILED " . mysqli_error($connection));
    }
}

function escape_string($string){
    global $connection;
    
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
    return mysqli_fetch_array($result);
}

function last_id(){
    global $connection;
    
    return mysqli_insert_id($connection);
        
}


//*********************************************FRONT END FUNCTION*********************************************************************
// get products

function get_products(){
    $query = query("SELECT * FROM products");
    comfirm($query);
    while($row = fetch_array($query)){
         $product_image = display_image($row['product_image']);
//        echo $row['product_price'];
        $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <a href="item.php?id={$row['product_id']}"><img src="../resources/{$product_image}" alt=""></a>
                            <div class="caption">
                                <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                                </h4>
                                <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                                <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
                            </div>
                            
                            <div class="ratings">
                                <p class="pull-right">15 reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                </p>
                            </div>
                            
                        </div>
                    </div>
        
        
        
DELIMETER;
        echo $product;
    }

}

//get categories function
function get_categories(){
    global $connection;
    $query = query("SELECT * FROM categories");
    comfirm($query);
    
   
        while($row = fetch_array($query)){
//        echo $row['product_price'];
        $category_links = <<<DELIMETER
        <a href='category.php?id={$row['cat_id']}' class= 'list-group-item' >{$row['cat_title']} </a>
        
        
        
DELIMETER;
        echo $category_links;                      
    }
}


function get_products_in_cat_page(){
    $query = query("SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ");
    comfirm($query);
    while($row = fetch_array($query)){
        $product_image = display_image($row['product_image']);
//        echo $row['product_price'];
        $feature = <<<DELIMETER
        
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="../resources/{$product_image}" alt="">
            <div class="caption">
                <h3>{$row['product_title']}</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <p>
                    <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                </p>
            </div>
        </div>
    </div>
        
        
        
DELIMETER;
        echo $feature;
    
                         
                            
    }
}


function get_products_in_shop_page(){
    $query = query("SELECT * FROM products");
    comfirm($query);
    while($row = fetch_array($query)){
        $product_image = display_image($row['product_image']);
        $feature = <<<DELIMETER
        
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="../resources/{$product_image}" alt="">
            <div class="caption">
                <h3>{$row['product_title']}</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <p>
                    <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                </p>
            </div>
        </div>
    </div>
        
        
        
DELIMETER;
        echo $feature;
    
                         
                            
    }
}

function login_user(){
    
    if(isset($_POST['submit'])){
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);
        
        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        comfirm($query);
        
        if(mysqli_num_rows($query)==0){
            set_message("Password or Username is Incorrect");
            redirect("login.php");
            
        }else{
            $_SESSION['username'] = $username;
            redirect("admin");
        }
    }
    
}


function send_message(){
    
    if(isset($_POST['submit'])){
        $to = "some_email@gmail.com";
        
        $from_name = $_POST['name'];
        
        $subject = $_POST['subject'];
        
        $email = $_POST['email'];
        
        $message = $_POST['message'];
        
        
        $headers = "FROM: {$from_name} {$email}";
        
        $result = mail($to, $subject, $message, $headers);
        
        if(!result){
             set_message("Your Message was not Sent");
            redirect("contact.php");
            
        }else{
            set_message("Your Message has been Sent");
            redirect("contact.php");
        }
    }
}



//*********************************************Back END FUNCTION*********************************************************************
function display_orders(){
    $query = query("SELECT * FROM orders");
    comfirm($query);
    
    while($row = fetch_array($query)){
        $order_id = $row['order_id'];
        $order_amount = $row['order_amount'];
        $order_transaction = $row['order_transaction'];
        $order_status = $row['order_status'];
        $order_currency = $row['order_currency'];
        
        $orders = <<<DELIMETER
           <tr>
                <td>{$order_id}</td>
                <td>{$order_amount}</td>
                <td>{$order_transaction}</td>
                <td>{$order_currency}</td>
                <td>$order_status</td>
                <td>
                <a class="btn btn-danger"href="../../resources/templates/back/delete_order.php?id={$row['order_id']}">
                <span class = "glyphicon glyphicon-remove">
                </span></a>
                </td>
                
                

            </tr>
     
DELIMETER;
        echo $orders;
    }
    
}


function display_products_in_admin(){
     $query = query("SELECT * FROM products");
     comfirm($query);
    
    while($row = fetch_array($query)){
        $product_id = $row['product_id'];
        $product_title= $row['product_title'];
        $product_category_id = $row['product_category_id'];
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];
        $product_image = display_image($row['product_image']);
        
        $category = show_product_category_title($product_category_id);
        
        $products = <<<DELIMETER
           <tr>
                <td>{$product_id}</td>
                <td>
                {$product_title} <br>
                <a href="index.php?edit_product&id={$product_id}">
                <img width='100' src="../../resources/{$product_image}" alt="">
                </a>
                </td>
                <td>{$category}</td>
                <td>{$product_price}</td>
                <td>{$product_quantity}</td>
                
                <td>
                <a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$product_id}">
                <span class = "glyphicon glyphicon-remove">
                </span></a>
                </td>
               
            </tr>
     
DELIMETER;
        echo $products;
    }
    
}

function add_product(){
    
    if(isset($_POST['publish'])){
        $product_title = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_category_id']);
        $product_price = escape_string($_POST['product_price']);
        $product_description = escape_string($_POST['product_description']);
        $short_desc = escape_string($_POST['short_desc']);
        $product_quantity = escape_string($_POST['product_quantity']);
        
        $product_image = $_FILES['image']['name'];
        $product_image_temp = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($product_image_temp, UPLOAD_DIRECTORY . DS . $product_image)) {
            echo "Uploaded";
        } else {
           echo "Product image was not uploaded";
        }
        
        $query = query("INSERT INTO products(product_title, product_category_id, product_price, product_quantity, product_description, product_image, short_desc) VALUES('{$product_title}','{$product_category_id}','{$product_price}','{$product_quantity}','{$product_description}','{$product_image}','{$short_desc}') ");
        
        
        $last_id = last_id();
        comfirm($query);
        set_message("Product Added With Id: {$last_id}");
        redirect("index.php?products");
        
        
        
        }

        
    }
    
    

function show_categories_add_product_page(){
    global $connection;
    $query = query("SELECT * FROM categories");
    comfirm($query);
    
   
        while($row = fetch_array($query)){
//        echo $row['product_price'];
        $category_options = <<<DELIMETER
        <option value="{$row['cat_id']}">{$row['cat_title']}</option>
        
        
        
DELIMETER;
        echo $category_options;                      
    }
}

function show_product_category_title($product_category_id){
    $category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}' ");
    comfirm($category_query);
    while($category_row = fetch_array($category_query)){
        return $category_row['cat_title'];
    }
}

function display_image($picture){
    global $upload_directory;
    return $upload_directory . DS . $picture;
}

//updateing product in admin
function update_product(){
    
    if(isset($_POST['update'])){
        $product_title = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_category_id']);
        $product_price = escape_string($_POST['product_price']);
        $product_description = escape_string($_POST['product_description']);
        $short_desc = escape_string($_POST['short_desc']);
        $product_quantity = escape_string($_POST['product_quantity']);
        
        $product_image = $_FILES['image']['name'];
        $product_image_temp = $_FILES['image']['tmp_name'];
        
        if(empty($product_image)){
            
            $get_pic = query("SELECT product_image FROM products WHERE product_id =" . escape_string($_GET['id']) . " " );
            comfirm($get_pic);
            
            while($pic = fetch_array($get_pic)){
                $product_image = $pic['product_image'];
            }
        }
        
        if (move_uploaded_file($product_image_temp, UPLOAD_DIRECTORY . DS . $product_image)) {
            echo "Uploaded";
        } else {
           echo "Product image was not uploaded";
        }
        
        
        $query = "UPDATE products SET ";
        
        $query.= "product_title              = '{$product_title}'        , ";
        $query.= "product_category_id        = '{$product_category_id}'  , ";
        $query.= "product_price              = '{$product_price}'        , ";
        $query.= "product_quantity           = '{$product_quantity}'     , ";
        $query.= "product_description        = '{$product_description}'  , ";
        $query.= "product_image              = '{$product_image}'        , ";
        $query.= "short_desc                 = '{$short_desc}'             ";
        $query.= "WHERE product_id= " . escape_string($_GET['id']);
        
        $send_update_query = query($query);

        comfirm($send_update_query);
        set_message("Product has been Updated");
        redirect("index.php?products");
        
        
    }
    
    
    
}

function show_cat_in_admin(){
    
    $query = query("SELECT * FROM categories");
    comfirm($query);
    
   
        while($row = fetch_array($query)){
        
        $cat_id = $row['cat_id'];    
        $cat_title = $row['cat_title'];
            
        $categories = <<<DELIMETER
        
        
        
        <tr>
            <td>{$cat_id}</td>
            <td>{$cat_title}</td>
            <td>
            <a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$cat_id}">
            <span class = "glyphicon glyphicon-remove">
            </span></a>
            </td>
        </tr>
    
        
        
        
DELIMETER;
        echo $categories;                      
    }

}


function add_category(){
  
    if(isset($_POST['add_category'])){
       
        
        $cat_title = escape_string($_POST['cat_title']);
        
         if(empty($cat_title)){
             echo "Category field Cannot be empty.";
             
         }else{
            $query = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
         
            $last_id = last_id();
            comfirm($query);
            set_message("Category Added With Id: {$last_id}");
            redirect("index.php?categories");
         }
        
        
        
        }
        
        
        
        
        
    
}


//*********************************************Users in Admin*********************************************************************


function display_users (){
        $query = query("SELECT * FROM users");
        comfirm($query);
    
   
        while($row = fetch_array($query)){
        
        $user_id = $row['user_id'];    
        $username = $row['username'];
        $user_email = $row['email'];  
        $user_password = $row['password'];
        $user_photo = display_image($row['user_photo']);    
            
        $users = <<<DELIMETER
        
        
        
        <tr>
            <td>{$user_id}</td>
            <td><img width='100' src="../../resources/{$user_photo}" alt=""></td>
            <td>{$username}</td>
            <td>{$user_email}</td>
            
            <td>
            <a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$user_id}">
            <span class = "glyphicon glyphicon-remove">
            </span></a>
            </td>
        </tr>
    
        
        
        
DELIMETER;
        echo $users;                      
    }
    
}

function add_user(){
    
    if(isset($_POST['add_user'])){
        $username = escape_string($_POST['username']);
        $email = escape_string($_POST['email']);
        $pass = escape_string($_POST['password']);
        
        $user_photo = $_FILES['image']['name'];
        $user_photo_temp = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($user_photo_temp, UPLOAD_DIRECTORY . DS . $user_photo)) {
            echo "Uploaded";
        } else {
           echo "User image was not uploaded";
        }
        
         $query = query("INSERT INTO users(username, email, password, user_photo) VALUES('{$username}','{$email}','{$pass}','{$user_photo}') ");
        
        
        
        comfirm($query);
        set_message("User Created");
        redirect("index.php?users");
    }
}



//*********************************************Slides Functions*********************************************************************

function get_slides(){
  $query = query("SELECT * FROM slides");
    
    comfirm($query);
    
    while($row = fetch_array($query)){
        $slide_image = display_image($row['slide_image']);
        $slides = <<<DELIMETER
           
           <div class="item">
            <img class="slide-image" src="../resources/{$slide_image}" alt="">
           </div>
     
DELIMETER;
        echo $slides;
        
    }
}

function add_slides(){
    if (isset($_POST['add_slides'])){
        $slide_title = escape_string($_POST['slide_title']);
        $slide_image = escape_string($_FILES['file']['name']);
        $slide_image_temp = escape_string($_FILES['file']['tmp_name']);
        
        
        if(empty($slide_title) || empty($slide_image)){
            echo "<p class = 'bg bg-danger'>Fields cannot be empty.</p>";
                
        }else{
            move_uploaded_file($slide_image_temp, UPLOAD_DIRECTORY . DS . $slide_image);
            
            $query = query("INSERT INTO slides(slide_title, slide_image) VALUES('{$slide_title}','{$slide_image}') ");
        
        
        
            comfirm($query);
            set_message("Slide Added");
            redirect("index.php?slides");
            }
        
        
        
    }
}

function get_current_slide_in_admin(){
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    
    comfirm($query);
    
    while($row = fetch_array($query)){
        $slide_image = display_image($row['slide_image']);
        $slide_active_admin = <<<DELIMETER
           
           
            <img class="img-responsive" src="../../resources/{$slide_image}" alt="">
          
     
DELIMETER;
        echo $slide_active_admin;
        
    }
}

function get_active_slide(){
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    
    comfirm($query);
    
    while($row = fetch_array($query)){
        $slide_image = display_image($row['slide_image']);
        $slide_active = <<<DELIMETER
           
           <div class="item active">
            <img class="slide-image" src="../resources/{$slide_image}" alt="">
           </div>
     
DELIMETER;
        echo $slide_active;
        
    }
    
}



function get_slide_thumbnails(){
    $query = query("SELECT * FROM slides ORDER BY slide_id ASC");
    
    comfirm($query);
    
    while($row = fetch_array($query)){
        $slide_image = display_image($row['slide_image']);
        $slide_thumb_admin = <<<DELIMETER
           
           
            <div class="col-xs-6 col-md-3 slide-image">
                <a href="">
                    <img src="../../resources/{$slide_image}" class ="img-responsive" alt="">
                </a>
            
            </div>
          
     
DELIMETER;
        echo $slide_thumb_admin;
        
    }
}


?>


































