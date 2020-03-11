<?php
 header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
 header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
if(isset($_FILES['file'])){
    $name = $_FILES['file']['name'];
    $path_parts = pathinfo($name);
    $extension = $path_parts['extension'];
    echo $extension;
    if(($extension == 'docx') || ($extension == 'doc')){
           if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
            echo json_encode(array("message"=>"文件已存在","type"=>'error' ));
            http_response_code(406);
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
           if(move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"])){
                echo "成功";
           }
        }
    
    }else{     
    echo json_encode(array("message"=>"文件不是 docx 或者 doc","type"=>'error' ));
        http_response_code(406);
    }
}