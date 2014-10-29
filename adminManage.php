<?php 
    $query = 'select * from vlab_admin where level >= 1';
    $result = $pdo -> prepare($query);
    $result -> bindParam(1,$user_name);
    $result -> bindParam(2,$password);
    if(!$result -> execute()) {
        echo '查询错误！';
        exit();
    }
    $all_admin = $result -> fetchAll();
    //print_r($all_admin);
?>
<div class="container">
    <h2>管理员管理</h2>
    <hr>
    <table class="table table-bordered table-hover">
        <tr>
            <th>用户名</th>
            <th>密码</th>
            <th>手机号</th>
            <th>邮箱</th>
            <th>权限</th>
            <th>姓名</th>
        </tr>
        <?php 
       
            foreach($all_admin as $admin){
                echo'<tr>'.
                      '<td style="width:55px">'.$admin['user_name'].'</td>'.
                      '<td>'.'</td>'.
                      '<td>'.$admin['phone'].'</td>'.
                      '<td>'.$admin['mail'].'</td>'.
                      '<td>'.$admin['level'].'</td>'.
                      '<td>'.$admin['name'].'</td>'.
                    '</tr>';
            }
            /*echo'<tr>'.
                      '<td><input name="user_name" type="text" value=""></td>'.
                      '<td><input name="pw" type="text"></td>'.
                      '<td><input name="phone" type="text" value=""></td>'.
                      '<td><input name="mail" type="text" value=""></td>'.
                      '<td> <select name="authority">
                                <option value="1">超级管理员</option>
                                <option value="2">普通管理员</option>
                                <option value="3">录入员</option>
                            </select></td>'.
                      '<td><input name="name" type="text"></td>'.
                      '<td><a>新增</a></td>'.
                    '</tr>';
            */
        ?>
    </table>
</div>