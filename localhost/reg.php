<?php
    
    $error = null;
    
    function reg($errors){
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Мини-Форум</title>
        </head>
        <body>
        ';
        echo '
        <form method = "post" action = "/index.php?reg&action">
            <lable>Email</lable>
            <input name = "email" type = "text"/>
            <lable>Имя</lable>
            <input name = "name" type = "text"/>
            <lable>Фамилия</lable>
            <input name = "surname" type = "text"/>
            <lable>Пароль</lable>
            <input name = "pass" type = "password"/>
            <input type = "submit" value = "Регистрация">
        </form>
        ';
        echo '
        <a href = "index.php">Войти</a>
        
        <div>
        ';
        echo '<p>' . $errors . '</p>';
        
        echo '</div>';
        echo '
        </body>
        </html>';
    };

    if(isset($_GET['reg'])&& isset($_GET['action'])){
        if(isset($_POST['email']) 
            && isset($_POST['name']) 
            && isset($_POST['surname']) 
            && isset($_POST['pass'])
            && (strlen($_POST['email']) > 0)
            && (strlen($_POST['name']) > 0)
            && (strlen($_POST['surname']) > 0)
            && (strlen($_POST['pass'])) > 0)
            
            {
            $user_email = $_POST['email'];
            $user_name = $_POST['name'];
            $user_surname = $_POST['surname'];
            $user_password = $_POST['pass'];
            $user_type = 'Пользователь';
            $user_block = 0;

            $query = $pdo->query("SELECT * FROM users WHERE user_email = '{$user_email}'");
            $user = $query ->fetch(PDO::FETCH_ASSOC);
            
            if($user){
                $error = 'Пользователь с такой почтой существует';
            }else{
                
                $prepare = $pdo ->prepare("INSERT INTO users(
                                                    user_email,
                                                    user_name,
                                                    user_surname,
                                                    user_password,
                                                    user_type,
                                                    user_block)
                                                    
                                                    values(
                                                        :user_email,
                                                        :user_name,
                                                        :user_surname,
                                                        :user_password,
                                                        :user_type,:user_block
                                                    )");
                

                $prepare ->bindValue(":user_email", $user_email);
                $prepare ->bindValue(":user_name" , $user_name);
                $prepare ->bindValue(":user_surname", $user_surname);
                $prepare ->bindValue(":user_password", $user_password);
                $prepare ->bindValue(":user_type", $user_type);
                $prepare ->bindValue(":user_block", $user_block);
                $execute = $prepare -> execute();
            
                if($execute){
                    header('Location: /index.php');
                }          
                else{
                    $error = "Не удалось зарегистрироваться";
                    
                };                                              
            };
        }else{
            $error = 'Нет всех данных';
            
        }

    }else{

    
    
};
reg($error);