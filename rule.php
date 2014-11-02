<?php 
    include('connDB.php');
    $needed = array('vlab_rule' => array('id', 'title', 'content')
                    );

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
.panel-default {
border-color: #DDD;
}
.panel {
margin-bottom: 20px;
background-color: #FFF;
border: 1px solid #E8E8E8;
border-radius: 4px;
-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
}
.panel-default>.panel-heading {
color: #333;
background-color: #F5F5F5;
border-color: #DDD;
}
.panel-heading {
padding: 10px 15px;
border-bottom: 1px solid rgba(0, 0, 0, 0);
border-top-left-radius: 3px;
border-top-right-radius: 3px;
}
.panel-title {
margin-top: 0;
margin-bottom: 0;
font-size: 16px;
color: inherit;
}
.panel-body {
padding: 15px;
}


</style>
<div id="fr">
      <div class="fr_title">
        <div class="fr_je">管理制度</div>
        <p>您现在的位置：<a href="index.php">首页</a> &gt; <span><a href="rule.php">管理制度</a> &gt; </span></p>
      </div>
      <div class="fr3_cot">         
        <?php 
              foreach ($res['vlab_rule'] as $key => $value) {
                  $id = $value['id']; $title = $value['title']; $content = $value['content'];
                  echo "
                  <div class='panel panel-default'>
                    <div class='panel-heading'>
                      <h3 class='panel-title'>$title</h3>
                    </div>
                    <div class='panel-body'>
                      $content
                    </div>
                  </div>";
              }
        ?>
     </div>
</div>