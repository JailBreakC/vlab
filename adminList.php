<style>
ul{
    list-style: none;
    margin: 10px;
}
#listeditor{
    border: 2px solid #5CB3E4;
    border-radius: 5px;
    padding: 20px; 
}
</style>
<div class="container">
    <h1>侧边栏导航条元素编辑</h1>
    <hr>
    <ul id="listeditor">
<?php
include "connDB.php";
$query = "SELECT * FROM `vlab_list` ORDER BY `id` desc limit 0,1";
$result = $pdo->prepare($query);
$result->setFetchMode(PDO::FETCH_ASSOC);
if($result->execute()){
    $row = $result->fetchAll();
    $row = $row[0]['content'];
    $row = json_decode($row);
/*    echo '<pre>';
    print_r($row);
    echo '</pre>';*/
    foreach ($row->title as $value) {
        echo "<li class='mainTitle'>　主标题：<input value='$value->val' type='text'> <button class='btn btn-xs btn-primary glyphicon glyphicon-plus-sign'></button> <button class='btn btn-xs btn-danger glyphicon glyphicon-minus-sign'></button>";
        echo "<ul>";
        foreach ($value->subTitle as $v) {
            echo "<li class='subTitle'>　副标题：<input value='$v->val' type='text'> <button class='btn btn-xs btn-primary glyphicon glyphicon-plus-sign'></button> <button class='btn btn-xs btn-danger glyphicon glyphicon-minus-sign'></button>";
            echo "<ul>";
            foreach ($v->content as $va) {
                echo "<li class='content'>
                            网址：<input value='$va->href'type='text'>　描述<input value='$va->text' type='text'> 
                            <button class='btn btn-xs btn-primary glyphicon glyphicon-plus-sign'></button> <button class='btn btn-xs btn-danger glyphicon glyphicon-minus-sign'></button>";
                echo "</li>";
            }
            echo "</ul>";
            echo "</li>";
        }
        echo "</ul>";
        echo "</li>";
    }
}
?> 
    </ul>
    <hr>
    <button class="save btn btn-sm btn-primary">保存修改</button>　
    <a href="admin.php?page=adminList"><button class="btn btn-sm btn-default">撤销修改</button></a>
</div>