<?php
if(isset($_SERVER['HTTP_APPNAME'])){//SAE会生成一个HTTP_APPNAME判断一下它的存在可以方便本地调试
        //for sae
        $dbms='mysql';
        $dbName=SAE_MYSQL_DB;
        $user= SAE_MYSQL_USER;
        $pwd=SAE_MYSQL_PASS;
        $host=SAE_MYSQL_HOST_M.':'. SAE_MYSQL_PORT;
        $dsn="$dbms:host=$host;dbname=$dbName";
        $pdo=new PDO($dsn,$user,$pwd);
        $pdo->query("set names utf8");
        date_default_timezone_set('PRC');
    }else
    {
        //for local 
        $dsn = 'mysql:dbname=vlab;host=localhost';
        $user_name = 'root';
        $user_psw = '';
        $pdo = new PDO($dsn,$user_name,$user_psw);
        $pdo->query("set names 'utf8'");
        date_default_timezone_set('PRC');
    }
?>