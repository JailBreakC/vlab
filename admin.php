<?php 
ob_start();
session_start();
$login = 0;
include('connDB.php');
if(isset( $_SESSION['user']))
    if( $_SESSION['user']['user_name'] != null && $_SESSION['user']['user_name'] != '' )
    {
        $login = 1;
    }

if(!$login && isset($_POST['admin_name']) && isset($_POST['admin_pw'])){

    echo $_POST['admin_name'].$_POST['admin_pw'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $time = date('Y-m-d H:i:s');
    $user_name = $_POST['admin_name'];
    $password = $_POST['admin_pw'];
    echo $password = md5($password);

    $query = 'select * from vlab_admin
              where user_name = ? and pw = ? and level >= 1';
    $result = $pdo -> prepare($query);
    $result -> bindParam(1,$user_name);
    $result -> bindParam(2,$password);

    if(!$result -> execute()) {
        echo '用户名或密码不正确';
        exit();
    }

    $row = $result -> fetchAll();
    $row = $row[0];
    if($row['user_name'] !='' ){
        //更新session信息
        $_SESSION['user'] = $row;
        
        if(isset($_POST['checked']) && $_POST['checked'] == 1)
        {
            $lifeTime = 30 * 24 * 3600; 
            //保存session一个月
            setcookie(session_name(), session_id(), time() + $lifeTime, "/"); 
        }
        setcookie(session_name(), session_id(), 0, "/"); 
        
        echo json_encode($row);
    }
    else{
        echo json_encode(FALSE);
    }
}
else if(!$login){
    include('adminLogin.php');
    exit();
}
include('adminHead.php');
if(isset($_GET['page'])){
    include($_GET['page'].'.php');
}else{
    include('adminManage.php');
}
include('adminFoot.php');
?>





