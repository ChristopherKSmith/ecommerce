<?php require_once("../../config.php");

if(isset($_GET['id'])){
    
    $query = query("DELETE FROM users WHERE user_id = " . escape_string($_GET['id']));
    comfirm($query);
    set_message("User Successfully Deleted");
    redirect("../../../public_html/admin/index.php?users");
    
    
    
}else {
    redirect("../../../public_html/admin/index.php?users");
    
}

?>
