<div class="container">
    <ul id="listeditor">
        <li class="mainTitle"><button class="glyphicon glyphicon-plus-sign"></button>主标题：<input type="text">　　
            <ul>
                <li class="subTitle"><button class="glyphicon glyphicon-plus-sign"></button>副标题：<input type="text">　　
                    <ul>
                        <li class="content">
                            <button class="glyphicon glyphicon-plus-sign"></button>
                            网址：<input type="text">　描述<input type="text">　　
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
    <button class="save btn btn-sm btn-primary">保存修改</button>　
    <button class="add btn btn-sm btn-success">新增一栏</button>
    <hr>
    <ul>
<?php
include "connDB.php";
$query = "SELECT * FROM `vlab_list` ORDER BY `id` desc limit 0,1";
$result = $pdo->prepare($query);
$result->setFetchMode(PDO::FETCH_ASSOC);
if($result->execute()){
    $row = $result->fetchAll();
    $row = $row[0]['content'];
    $row = json_decode($row);
    echo '<pre>';
    print_r($row);
    echo '</pre>';
    foreach ($row->title as $value) {
        echo "<li>";
        echo $value->val;
        print_r($value);
        echo "<ul>";
        foreach ($value->subTitle as $v) {
            echo "<li>$v->val";
            echo "<ul>";
            foreach ($v->content as $va) {
                print_r($va);
                echo "<li>$va->href|$va->text";
                foreach ($va->content as $val) {

                }
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
</div>

<li>
    <ul></ul>
</li>
