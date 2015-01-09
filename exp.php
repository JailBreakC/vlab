<?php
function _p($data) {
    echo "<br>";
    print_r($data);
    echo "<br>";
}
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
    _p($loc);
    return $loc; 
}

function getIPLoc_Sina($queryIP) {
    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip='.$queryIP;
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
    $result = curl_exec($ch); 
    curl_close($ch); 
    preg_match("@\{.*\}@",$result,$ipArray); 
    $result = $ipArray[0];
    return json_decode($result);
}
if(isset($_GET['q'])){
    include('connDB.php');
    $loc = getIPLoc_QQ($_GET['q']);

    $query = "SELECT * FROM `vlab_visitor`";

    $result = $pdo->prepare($query);
    $result->execute();
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result = $result->fetchAll();

    foreach($result as $key => $value) {
        $ip = $value['ip'];       
        echo $ip;
        _p($loc = getIPLoc_Sina($ip));
        if($loc->ret == 1) {
            $location = "$loc->country $loc->province $loc->city $loc->isp";
        } else {
            $location = '未知';
        }
        $query = "UPDATE `vlab_visitor` SET `from` = '$location' where `ip` = '$ip'";
        $result = $pdo->prepare($query);
        $result->execute();
    }
}