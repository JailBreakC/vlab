<?php 
    include('connDB.php');
    $needed = array('vlab_teacher' => array('id', 'name', 'age', 'sex', 'title', 'major', 
                    'degree', 'web_page'));

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
        <div class="fr_je">机构与队伍</div>
        <p>您现在的位置：<a href="index.php">首页</a> &gt; <span><a href="teacher.php">机构与队伍</a></span></p>
      </div>
      <div class="fr3_cot">    

      <?php 
      $id = '';
      include('teacherFile.html');
           ?>
      <!--
        <table class="table table-bordered table-hover table-condensed">
          <tr>
            <th>姓名</th>
            <th>年龄</th>
            <th>性别</th>
            <th>职称</th>
            <th>学历学位</th>
            <th>专业</th>
            <th>主页</th>
          </tr>
        <?php 
            /*
              foreach ($res['vlab_teacher'] as $key => $value) {
                  $id = $value['id']; $name = $value['name']; $age = $value['age']; $sex = $value['sex'];
                  $title = $value['title']; $degree = $value['degree']; $major = $value['major'];
                  $web_page = $value['web_page'];
                  echo "<tr>
                          <td>$name</td>
                          <td>$age</td>
                          <td>$sex</td>
                          <td>$title</td>
                          <td>$degree</td>
                          <td>$major</td>
                          <td><a href='$web_page' target='_blank'>$web_page</a></td>
                        </tr>";
              }*/
        ?>
        </table>
      -->
     </div>
</div>
<?php include('bottom.php');?>