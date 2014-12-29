<div class="container">
<h2>访客统计</h2>
<hr>
<table class="table table-bordered">
    <tbody>
        <tr>
            <th>ip</th>
            <th>地址</th>
            <th>访问次数</th>
            <th>最后访问时间</th>
        </tr>
<?php
include('connDB.php');
$query = "SELECT COUNT(*) FROM `vlab_visitor`";
$res = $pdo->prepare($query);
$res->execute();
$res = $res->fetchALL();
echo "<h3>总访客数".$res[0][0]."</h3>";
echo "<hr>";
echo "访问次数TOP100↓";
$query = "SELECT * FROM `vlab_visitor` ORDER BY `count` DESC limit 0, 100";
$res = $pdo->prepare($query);
$res->execute();
$res->setFetchMode(PDO::FETCH_ASSOC);
$res = $res->fetchALL();
foreach ($res as $key => $value) {
    echo '<tr>' .
    '<td>' . $value['ip'] . '</td>' .
    '<td>' . $value['from'] . '</td>' .
    '<td>' . $value['count'] . '</td>' .
    '<td>' . $value['time'] . '</td>' .
    '</tr>';
}
?>
    </tbody>
</table>

</div>