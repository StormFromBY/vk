<?php

//Подключаем базу данных
$host="localhost"; 			/*Имя сервера*/
$user="root";				/*Имя пользователя*/
$password="123qweasdzxc";	/*Пароль пользователя*/
$db="vk";				/*Имя базы данных*/

mysql_connect($host, $user, $password) or die("MySQL сервер недоступен!".mysql_error());
mysql_query("SET CHARSET utf8");
mysql_query("SET NAMES utf8");
mysql_select_db($db) or die("Нет соединения с БД".mysql_error());
 
?>