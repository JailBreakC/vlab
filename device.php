<?php 
    include('connDB.php');
    $needed = array('vlab_device' => array('id', 'name', 'type', 'price', 'num', 'maker', 
                    'buy_time'));

    $res = array();$query = array();
    foreach ($needed as $k => $subArr) {
        $query[$k] = "SELECT ";
        $length = count($subArr);$i = 1;
        foreach ($subArr as $key => $field) {
            if($i < $length)
                $query[$k] .= $field . ', ';
            else
                $query[$k] .= $field . ' ';
            $i++;
        }
        $query[$k] .= "FROM " . $k;
        $res[$k] = $pdo -> prepare($query[$k]);
        $res[$k] -> execute();
        $res[$k] = $res[$k] -> fetchAll();
    }
include('head.php');
?>
<style>
* {
-moz-box-sizing: content-box;
box-sizing: content-box;
}
td {
font-size: 12px;
}
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
border: 1px solid #DDD;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
padding: 8px;
line-height: 1.42857143;
vertical-align: top;
border-top: 1px solid #DDD;
}
.table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td {
padding: 5px;
}
table {
border-spacing: 0;
border-collapse: collapse;
}
table {
background-color: rgba(0, 0, 0, 0);
}
.table {
width: 100%;
max-width: 100%;
margin-bottom: 20px;
}
.table-bordered {
border: 1px solid #DDD;
}</style>
<div id="fr">
      <div class="fr_title">
        <div class="fr_je">通知公告</div>
        <p>您现在的位置：<a href="index.php">首页</a> &gt; <span><a href="device.php">通知公告</a> &gt; </span></p>
      </div>
      <div class="fr3_cot">         
        <table class="table table-bordered table-hover table-condensed">
          <tr>
            <th>名称</th>
            <th>型号</th>
            <th>数量</th>
            <th>单价（元）</th>
            <th>厂家</th>
            <th>购置日期</th>
            <th>详情</th>
          </tr>
        <?php 
              foreach ($res['vlab_device'] as $key => $value) {
                  $id = $value['id']; $name = $value['name']; $type = $value['type'];
                  $price = $value['price']; $num = $value['num']; $maker = $value['maker'];
                  $buy_time = $value['buy_time'];
                  echo "<tr>
                          <td>$name</td>
                          <td>$type</td>
                          <td>$num</td>
                          <td>$price</td>
                          <td>$maker</td>
                          <td>$buy_time</td>
                          <td><a href='device.php?id=$id'>详情</a></td>
                        </tr>";
              }
        ?>
        </table>

        <div class="fy">
          <div id="pages" class="text-c"><a class="a1">47条</a> <a href="/html/news/index.html" class="a1">上一页</a> <span>1</span> <a href="/html/news/2.html">2</a> <a href="/html/news/2.html" class="a1">下一页</a></div>
        </div>
     </div>
</div>