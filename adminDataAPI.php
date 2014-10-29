<?php
session_start();
    //获取数据可以无需登录
if(isset($_POST['query']) && isset($_POST['id'])){
    include('connDB.php');
    $q = $_POST['query'];
    $id = $_POST['id'];
    //匹配可以进行读取的表单。
    $allowed = ['vlab_disc', 'vlab_resource', 'vlab_news', 'vlab_rule', 'vlab_teacher', 'vlab_title',
    'vlab_device', 'vlab_degree'];
    if(in_array($q, $allowed)){
        if($id == 'all'){
            //获取整个表单的数据
            $query = 'select * from ' . $q;
            $result = $pdo -> prepare($query);
        }else if($id == 'last'){
            //获取最后一行数据
            $query = 'select * from ' . $q . ' where id in (select max(id) from ' . $q . ')';
            $result = $pdo -> prepare($query);
        }else{
            //获取指定行的数据
            $query = 'select * from ' . $q . ' where id = ?';
            $result = $pdo -> prepare($query);
            $result -> bindParam(1,$id);
        }
        //echo $query;
        if(!$result -> execute()) {
            echo '获取数据失败！';
            exit();
        }
        else{
            $row = $result -> fetchAll();
            echo json_encode($row);
        }
    }

        //若处于登录状态，则可以进行数据的修改
}else if(isset($_POST['save']) && isset($_POST['id']) && isset($_POST['data']) && isset($_SESSION['user'])){
    include('connDB.php');
    $save = $_POST['save'];
    $id = $_POST['id'];
    $data = $_POST['data'];
    //匹配可以进行读取的表单。
    $allowed = ['vlab_disc', 'vlab_resource', 'vlab_news', 'vlab_rule', 'vlab_teacher', 'vlab_title',
    'vlab_device', 'vlab_degree'];
    if(in_array($save, $allowed)){
            //若未指定id则新增数据
        if($id == 'no'){
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
            $query = "update ". $save . " set ";//item_number = ? where item_id = id;
            $length = count($data);
            $i = 1;
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
}else if(isset($_POST['delete']) && isset($_POST['id']) && isset($_SESSION['user'])){
    include('connDB.php');
    $delete = $_POST['delete'];
    $id = $_POST['id'];
    $query = "DELETE FROM $delete WHERE id = $id";
    $result = $pdo -> prepare($query);
    if(!$result -> execute())
        echo 'sql删除失败';
    else
        echo 'success';
}else {
    echo "请输入正确的参数";
}
?>