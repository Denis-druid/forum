<?php
    
    $id = $_GET['theme_id'];
    
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
   
    echo '<div><b>Все комментарии:</b></div></br>';
    $query = $pdo -> query("SELECT * FROM comments WHERE theme_id ={$id}");
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach($comments as $comment){
        
    }

                
    echo '<a href = "/index.php">' . "Вернуться назад" . '</a>';
        
    