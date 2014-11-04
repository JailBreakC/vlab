<?php 
    include('connDB.php');
    $needed = array('vlab_rule' => array('id', 'title', 'content', 'add_time')
                    );
    if(!isset($_GET['id'])){

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
  }else {
    $id = $_GET['id'];
    $disc = "SELECT * FROM vlab_rule WHERE id = $id";
    $res = $pdo -> prepare($disc);
    $res -> execute();
    $res =  $res -> fetchAll();
    $res = $res[0];
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
<?php if(isset($_GET['id'])) :?>
     <?php 
      //print_r($res);
                  $title = $res['title']; $content = $res['content'];
                  $time = $res['add_time'];
        ?>
       <div id="fr">
      <div class="fr_title">
        <div class="fr_je">管理制度</div>
        <p><a href="index.php">首页</a><span> &gt; </span><a href="rule.php">管理制度</a> &gt;  正文</p>
      </div>
      <div class="fr3_cot">
      <div class="walk_te"><?php echo $title ?></div>
      <div class="fgx">时间:<?php echo $time ?></div>
        <div class="walk_cot">
          <div style="LAYOUT-GRID:  15.6pt none" class="Section0">
            <?php echo $content ?>
          </div>
        </div>
      </div>
    </div>
      


</div>
<?php else : ?>
  <div id="fr">
  <div class="fr_title">
        <div class="fr_je">管理制度</div>
        <p>您现在的位置：<a href="index.php">首页</a> &gt; <span><a href="rule.php">管理制度</a></span></p>
      </div>
      <div class="fr3_cot">         
        <ul>
        <?php 
              foreach ($res['vlab_rule'] as $key => $value) {
                  $title = $value['title']; $id = $value['id']; $time = $value['add_time'];
                  echo "<li><a href='rule.php?id=$id' title='$title'>$title</a><span class='date'>$time</span></li>";
              }
            ?>
      </ul>
  </div>
  </div>
<?php endif; ?>

<?php include('bottom.php'); ?>