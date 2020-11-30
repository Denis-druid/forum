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


    $query_id = $pdo->query("SELECT user_id FROM users WHERE user_email= '{$_COOKIE["user_email"]}'");
    $users = $query_id->fetchAll(PDO::FETCH_ASSOC);
    foreach($users as $user){
        $us_id = $user['user_id'];
    };
    $error = null;


    if(isset($_GET['action'])){
        if(isset($_POST['theme_title']) 
        && isset($_POST['theme_text']) 
        && (strlen($_POST['theme_title']) > 0)
        && (strlen($_POST['theme_text'])> 0)){

            $theme_title = $_POST['theme_title'];
            $theme_text = $_POST['theme_text'];
            $query = $pdo ->query("SELECT * FROM thems WHERE theme_title='{$theme_title}' AND theme_text='$theme_text'");
            $themes = $query->fetch(PDO::FETCH_ASSOC);
            if($thems){

                $error = "Такая запись уже существует";
            }else{

                $prepare = $pdo->prepare("INSERT INTO thems(user_id,
                                                            theme_title,
                                                            theme_text,
                                                            theme_date,
                                                            theme_block)
                                                    value(:user_id, 
                                                        :theme_title,
                                                        :theme_text,
                                                        :theme_date,
                                                        :theme_block)");
                $prepare -> bindValue(":user_id",$us_id);
                $prepare -> bindValue(":theme_title",$theme_title);
                $prepare -> bindValue(":theme_text",$theme_text);
                $prepare -> bindValue(":theme_date", time());
                $prepare -> bindValue(":theme_block",2);
                $execute = $prepare ->execute();
                
                if($execute){
                    header("Location: /index.php");
                }else{
                    $error = "Что-то пошло не так. Разраб скоро исправит";
                    
                }
            };

        }else{
            $error = 'Нет всех обязательных данных';
        }
    }
    echo '
        <form  method = post action="/create_t.php?action">
            <lable>Название:</lable>
            <input type = "text" name="theme_title">
            <lable>Текст:</lable>
            <textarea name = "theme_text"></textarea>
            <input type = "submit">
        </form>
        ';
    echo $error;
    
    echo '
        <a href = "/index.php">Вернуться назад</a></br>
    '; 