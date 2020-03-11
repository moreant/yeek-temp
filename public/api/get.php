<?php

$list = scandir('./upload');
$file = array();
foreach($list as $itme=>$val){
    if($itme>1){
        $file[$itme-2] = array("name"=>$val); 
    }
}

echo json_encode($file);