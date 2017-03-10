<?php require_once("../../config.php");

if(isset($_GET['id'])){
    
    $query = query("DELETE FROM categories WHERE cat_id = " . escape_string($_GET['id']));
    comfirm($query);
    set_message("Category Successfully Deleted");
    redirect("../../../public_html/admin/index.php?categories");
    
    
    
}else {
    redirect("../../../public_html/admin/index.php?categories");
    
}

?>