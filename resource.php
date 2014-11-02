<?php 
    include('connDB.php');
    if(!isset($_GET['id'])){
    $needed = array('vlab_resource' => array('id', 'title', 'add_time')
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
  }
  else{
    $id = $_GET['id'];
    $disc = "SELECT * FROM vlab_resource WHERE id = $id";
    $res = $pdo -> prepare($disc);
    $res -> execute();
    $res =  $res -> fetchAll();
    $res = $res[0];
  }
include('head.php');
?>
<?php if (!isset($_GET['id'])) : ?>
<div id="fr">
      <div class="fr_title">
        <div class="fr_je">中心资源</div>
        <p>您现在的位置：<a href="index.php">首页</a> &gt; <span><a href="resource.php">中心资源</a> &gt; </span></p>
      </div>
      <div class="fr3_cot">         
        <ul>
        <?php 
              foreach ($res['vlab_resource'] as $key => $value) {
                  $title = $value['title']; $id = $value['id']; $time = $value['add_time'];
                  echo "<li><a href='resource.php?id=$id' title='$title'>$title</a><span class='date'>$time</span></li>";
              }
            ?>
        </ul>
        <!--
        <div class="fy">
          <div id="pages" class="text-c"><a class="a1">47条</a> <a href="/html/news/index.html" class="a1">上一页</a> <span>1</span> <a href="/html/news/2.html">2</a> <a href="/html/news/2.html" class="a1">下一页</a></div>
        </div>-->
     </div>
</div>
<?php else: ?>
  <div id="fr">
      <div class="fr_title">
        <div class="fr_je"></div>
        <p><a href="index.php">首页</a><span> &gt; </span><a href="resource.php">中心资源</a> &gt;  正文</p>
      </div>
      <div class="fr3_cot">
      <div class="walk_te"><?php echo $res['title'] ?></div>
      <div class="fgx">时间:<?php echo $res['add_time'] ?></div>
        <div class="walk_cot">
          <div style="LAYOUT-GRID:  15.6pt none" class="Section0">
            <?php echo $res['content'] ?>
          </div>
        </div>
      </div>
    </div>
<?php endif; ?>

<?php include('bottom.php'); ?>