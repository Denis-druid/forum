<?php

    if(isset ($_GET['login']) && isset($_GET['action'])){
        if(isset($_POST['email']) 
            && isset($_POST['password']) 
            && (strlen($_POST['email']) > 0)
            && (strlen($_POST['password'] > 0))){
                
            $user_email = $_POST['email'];
            $user_password = $_POST['password'];

            $query = $pdo->query("SELECT * FROM users WHERE user_email = '{$user_email}'");
            $user = $query ->fetch(PDO::FETCH_ASSOC);

            if($user){

                if($user_password === $user['user_password']){

                    setcookie("user_email", $user_email , time() + 36000);
                    setcookie("user_password", $user_password, time() + 36000);

                    header('Location: /index.php');
                }
                
                else{

                    $error = 'Неверный пароль';

                }
            }
            
            else{
                $error='Неверный емайл';
            };

        }
        
        else{
            $error='Введите данные';
        };

    }

    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Мини-Форум</title>
    </head>
    <body>
    ';

    echo '
        <form method="post" action = "/index.php?login&action">
            <lable>Email</lable>
            <input name = "email" type = "text"/>
            <lable>Пароль</lable>
            <input name = "password" type = "passwpd"/>
            <input type="submit" value = "Авторизация">
            <a href = "index.php?reg">Регистрация</a>

        </form>';

    echo '
        </body>
        </html>
    ';

