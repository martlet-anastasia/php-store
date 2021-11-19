<?php

//    try{
//        $connection = new mysqli('localhost', 'root2', '', 'mvc');
//    } catch (Exception $e)
//    {
//        echo $e->getMessage();
//    };
//    echo mysqli_connect_errno();
//    echo mysqli_connect_errno();


    function render($template='',  $vars = []) {

        foreach($vars as $varName => $varValue) {
            ${$varName} = $varValue;
        }

        $path = __DIR__."/../views/".$template;
        if(file_exists($path) && is_file($path)) {
            include $path;
        } else {
            echo 'VIEW NOT FOUND';
//            include __DIR__."/../views/404.php";
        }
    }