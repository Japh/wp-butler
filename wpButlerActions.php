<?php $STATES = array(

        "Add Page"=>"post-new.php?post_type=page",   
        "Add Post"=>"post-new.php?post_type=post",    

    ); 
    $term = $_GET['term']; 

    foreach($STATES as $key => $value) { 
        if(preg_match("/$term/i", $key)) { $return[$key]=$value; } 
    } 
    echo json_encode($return);  