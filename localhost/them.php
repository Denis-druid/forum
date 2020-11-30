<?php

    $localhost = 'localhost';
    $dbname = 'forum_dbase';
    $name = 'root';
    $password = 'root';
    try{
        $pdo = new PDO('mysql:host=' . $localhost . ';dbname=' . $dbname, $name, $password);
    }catch(PDOException $e){
        print "Error!:" . $e->getMessage() . "<br/>";
        die();
    };
    
    $id = $_GET['them_id'];
    
    $query = $pdo -> query("SELECT * FROM thems WHERE theme_id='{$id}'");
    $them = $query ->fetch(PDO::FETCH_ASSOC);
    
    $theme_title = $them['theme_title'];
    $theme_text = $them['theme_text'];
    
    $theme_date = $them['theme_date'];
    
    $theme_date = date("Y-m-d h:i",$theme_date);

    $query = $pdo ->query("SELECT * FROM comments WHERE theme_id= '{$id}'");
    $commets =$query->fetchAll(PDO::FETCH_ASSOC);
    $count = 0;
    if($commets){
        foreach($commets as $comment){
            $count += 1;
        }    
    }

    echo"
        <lable><b>Название:</b></lable>
        <div>{$theme_title}</div>

        <lable><b>Дата создания темы:</b></lable>
        <div>{$theme_date}</div>
        <lable><b>Текст:</b></lable>
        <div>{$theme_text}</div>
        <lable><b>Ответы к теме:</b></lable>
        <a href = 'comments.php?theme_id={$id}'>{$count}</a>
    ";