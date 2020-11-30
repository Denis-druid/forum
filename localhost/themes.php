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
    $us_id = null;
    foreach($users as $user){
        $us_id = $user['user_id'];
    };
    
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Мини-Форум</title>
    </head>
    <body>
    
    ';

    if($_GET != null){
        if(isset($_GET['all'])){
            echo '<div><b>Все темы:</b></div></br>';
            $query = $pdo -> query("SELECT theme_title, theme_id, theme_text FROM thems WHERE theme_block = 1");
            $thems = $query->fetchAll(PDO::FETCH_ASSOC);
            $count_t = 0;
            $count = 0;
            foreach($thems as $them){
                $id = 0;
                echo '<div><b>Заголовок:</b></div>';
            
                echo '<a href = "/them.php?them_id=' . $them['theme_id'] .'">' . $them['theme_title'] . '</a>';
                
                echo '<div><b>Текст:</b></div>';
                echo '<div>' . $them['theme_text'] . '</div>';
                
                $id = $them['theme_id'];
                
                $query = $pdo ->query("SELECT * FROM comments WHERE theme_id= '{$id}'");
                $commets =$query->fetchAll(PDO::FETCH_ASSOC);
                if($commets){
                    foreach($commets as $comment){
                        $count += 1;
                    }    
                }
                
                
                echo "<div><b>Ответов:" . $count . "</b></div>";
                $count = 0;
            };

            echo '<a href = "/index.php">' . "Вернуться назад" . '</a>';

        }else if(isset($_GET['my'])){
            
            echo '<div><b>Мои темы:</b></div></br>
                    <div><b>Темы которые прошли модератора</b></div>';
            
            
            $query = $pdo -> query("SELECT theme_title, theme_id, theme_text FROM thems WHERE user_id = '{$us_id}' AND theme_block = 1");
            $thems = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach($thems as $them){

                $id = 0;
                echo '<div><b>Заголовок:</b></div>';
            
                echo '<a href = "/them.php?them_id=' . $them['theme_id'] .'&my">' . $them['theme_title'] . '</a>';
                
                echo '<div><b>Текст:</b></div>';
                echo '<div>' . $them['theme_text'] . '</div>';
                
                $id = $them['theme_id'];
                
                $query = $pdo ->query("SELECT * FROM comments WHERE theme_id= '{$id}'");
                $commets =$query->fetchAll(PDO::FETCH_ASSOC);
                if($commets){
                    foreach($commets as $comment){
                        $count += 1;
                    }    
                }
                
                
                echo "<div><b>Ответов:" . $count . "</b></div>";
                $count = 0;

            }
            
            // Темы не прошли через модератора
            echo '<div><b>Темы которые не прошли через модератора</b></div>';

            $query = $pdo -> query("SELECT theme_title, theme_id, theme_text FROM thems WHERE user_id = '{$us_id}' AND  theme_block = 0");
                $thems = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($thems as $them){

                $id = 0;
                echo '<div><b>Заголовок:</b></div>';
            
                echo '<a href = "/them.php?them_id=' . $them['theme_id'] .'&my">' . $them['theme_title'] . '</a>';
                
                echo '<div><b>Текст:</b></div>';
                echo '<div>' . $them['theme_text'] . '</div>';
                
                $id = $them['theme_id'];
                
                $query = $pdo ->query("SELECT * FROM comments WHERE theme_id= '{$id}'");
                $commets =$query->fetchAll(PDO::FETCH_ASSOC);
                if($commets){
                    foreach($commets as $comment){
                        $count += 1;
                    }    
                }
                
                
                echo "<div><b>Ответов:" . $count . "</b></div>";
                $count = 0;

            };



            echo '<div><b>Темы которые ожидают модератора</b></div>';

            $query = $pdo -> query("SELECT theme_title, theme_id, theme_text FROM thems WHERE user_id = '{$us_id}' AND  theme_block = 2");
                $thems = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($thems as $them){

                $id = 0;
                echo '<div><b>Заголовок:</b></div>';
            
                echo '<a href = "/them.php?them_id=' . $them['theme_id'] .'&my">' . $them['theme_title'] . '</a>';
                
                echo '<div><b>Текст:</b></div>';
                echo '<div>' . $them['theme_text'] . '</div>';
                
                $id = $them['theme_id'];
                
                $query = $pdo ->query("SELECT * FROM comments WHERE theme_id= '{$id}'");
                $commets =$query->fetchAll(PDO::FETCH_ASSOC);
                if($commets){
                    foreach($commets as $comment){
                        $count += 1;
                    }    
                }
                
                
                echo "<div><b>Ответов:" . $count . "</b></div>";
                $count = 0;

            }


            echo '<a href = "/index.php">' . "Вернуться назад" . '</a>';

        }else if(isset($_GET['create'])){
            echo '
            <div>Создание темы:</div>';
            include_once 'create_t.php';
        }
    }else{

        echo '
            <div><h2>Форум любителей газет</h2></div>
            <a href = "/themes.php?my">Посмотреть свои темы</a>
            </br>
            <a href = "/themes.php?all">Посмотреть все темы</a>
            </br>
            <a href = "/themes.php?create">Создать тему</a>
            </br>
            <a href="/logout.php">Выйти из аккаунта</a>;
            '; 

        echo '
            </body>
            </html>
        ';
    }