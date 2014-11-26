<?php
session_start();
//可访问表单控制
$allowed = array('vlab_disc', 'vlab_resource', 'vlab_news', 'vlab_message', 'vlab_rule',
 'vlab_major', 'vlab_teacher', 'vlab_title', 'vlab_device', 'vlab_degree', 'vlab_banner', 'vlab_list');

    //获取数据可以无需登录
if(isset($_POST['query']) && isset($_POST['id'])){
    include('connDB.php');
    $q = $_POST['query'];
    $id = $_POST['id'];
    if(in_array($q, $allowed)) {
        $field = '*';
        if(isset($_POST['field']) && $_POST['field'])
        {   
            $field = '';
            //print_r($_POST['field']);
            $len = count($_POST['field']);
            $i = 1;
            foreach ($_POST['field'] as $key => $value) {
                if($i<$len) $field .= $value . ', ';
                else $field .= $value;
                $i++;
            }
            //echo $field;
        }
        if($id == 'all'){
            //获取整个表单的数据
            $query = "SELECT $field FROM $q";
            $result = $pdo -> prepare($query);
        }else if($id == 'last'){
            //获取最后一行数据
            $query = "SELECT $field FROM $q WHERE id IN (SELECT MAX(id) FROM $q )";
            $result = $pdo -> prepare($query);
        }else{
            //获取指定行的数据
            $query = "SELECT $field FROM $q WHERE id = ?";
            $result = $pdo -> prepare($query);
            $result -> bindParam(1,$id);
        }
        //echo $query;
        if(!$result -> execute()) {
            echo 'getting data failed!';
            exit();
        }
        else{
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $row = $result -> fetchAll();
            //print_r($row);
            echo json_encode($row);
        }
    }
        //若处于登录状态，则可以进行数据的修改
}else if(isset($_POST['method']) && isset($_POST['save']) && isset($_POST['id']) && isset($_POST['data']) && isset($_SESSION['user'])){
    include('connDB.php');
    $method = $_POST['method'];    $save = $_POST['save'];    $id = $_POST['id'];    $data = $_POST['data'];
    if(in_array($save, $allowed)){
            //若未指定id则新增数据
        if($method == 'insert'){
            //拼凑SQL语句
            $query = "insert into " . $save . "(";
            $value = " value(";
            $length = count($data);
            $i = 1;
            foreach($data as $key => $v) {
                if($i < $length){
                    $query .= $key . ','; $value .= '?,';
                }
                else {
                    $query .= $key . ')'; $value .= '?)';
                }
                $i++;
            }
            $query .= $value;
            //echo $query;
            $result = $pdo -> prepare($query);
            $i = 1;
            foreach($data as $key => $v) {
                //此处必须绑定$data[$key]，若绑定$v则所有绑定值都相同
                $result -> bindParam($i,$data[$key]);
                $i++;
            }
            if(!$result -> execute())
                echo 'sql查询失败';
            else
                echo 'success';
        }
        else{
            $query = "update ". $save . " set ";
            $i = 1;
            $length = count($data);
            foreach($data as $key => $v) {
                if($i < $length){
                    $query .= $key . '=?,';
                }
                else {
                    $query .= $key . '=? where id =' . $id;
                }
                $i++;
            }
            //echo $query;
            $result = $pdo -> prepare($query);
            $i = 1;
            foreach($data as $key => $v) {
                //此处必须绑定$data[$key]，若绑定$v则所有绑定值都相同
                $result -> bindParam($i,$data[$key]);
                $i++;
            }
            if(!$result -> execute())
                echo 'sql更新失败';
            else
                echo 'success';
        }
    }
    //若处于登录状态，可删除数据。
}else if(isset($_POST['delete']) && isset($_POST['id']) && isset($_SESSION['user'])){
    include('connDB.php');
    $delete = $_POST['delete'];
    $id = $_POST['id'];
    if(in_array($delete, $allowed)){
        $query = "DELETE FROM $delete WHERE id = $id";
        //echo $query;
        $result = $pdo -> prepare($query);
        if(!$result -> execute())
            echo 'sql删除失败';
        else
            echo 'success';
    }
}else {
    echo "请输入正确的参数";
}
?>