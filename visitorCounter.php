<?php
//include('connDB.php');
session_start();

function getIPLoc_QQ($queryIP) { 
    $url = 'http://ip.qq.com/cgi-bin/searchip?searchip1='.$queryIP; 
    $ch = curl_init($url); 
    curl_setopt($ch,CURLOPT_ENCODING ,'gb2312'); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
    $result = curl_exec($ch); 
    $result = mb_convert_encoding($result, "utf-8", "gb2312"); // 编码转换，否则乱码 
    curl_close($ch); 
    preg_match("@<span>(.*)</span></p>@iU",$result,$ipArray); 
    $loc = $ipArray[1]; 
    return $loc; 
}
function isExist($ip) {
    global $pdo;
    $query = "SELECT * FROM `vlab_visitor` WHERE ip = '$ip'";
    $res = $pdo->prepare($query);
    $res->execute();
    $res->setFetchMode(PDO::FETCH_ASSOC);
    $res = $res->fetchALL();
    if(isset($res[0]))
        $res = $res[0];
    if($res) 
        return $res;
    else 
        return false;
}

if(!isset($_SESSION['visited'])) {
    $IP = $_SERVER['REMOTE_ADDR'];
    $loc = getIPLoc_QQ($IP);
    if($loc && $loc != '' && $loc != ' '){
        $time = date('Y-m-d h:i:s',time());
        $visitor = isExist($IP);
        $count = intval($visitor['count'], 10) + 1;
        $id = $visitor['id'];
        if($visitor) {
            $query = "UPDATE `vlab_visitor` SET `count` = '$count', `time` = '$time' WHERE `id` = $id";
        }else {
            $query = "INSERT INTO `vlab_visitor` (`ip`, `from`, `count`, `time`) value ('$IP', '$loc', 1, '$time')";
        }
        $res = $pdo->prepare($query);
        if($res->execute())
            $_SESSION['visited'] = true;
    }
}