<?php

    $auth = FAlse;


    if($auth){
        if($_GET != null){
            include_once 'themes.php';
        }
    }else{
        if($_GET != null){
            if(isset($_GET['reg'])){
                include_once "reg.php";
            }else{
                include_once "login.php";
            }
        }else{
            include_once "login.php";
        }
        
    }