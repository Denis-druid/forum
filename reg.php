<?php


    echo '
    <DOCTYPE html>
    <html>
    <head>
        <meta charset = "utf-8">
        <title>Мини-форум</title>
    </head>
    <body>
    ';
    echo'

        <form method = "post" action = "/index.php?log&action">
            <lable>Email</lable>
            <input type = "text" name = "email">
            <lable>Имя</lable>
            <input type = "text" name = "name">
            <lable>Фамилия</lable>
            <input type = "text" name = "surname">
            <lable>Пароль</lable>
            <input type = "text" name = "pass">
            <input type = "submit">
        </form>
        <a href = "/index.php">Войти</a>
    ';