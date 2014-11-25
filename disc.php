<?php 
include('connDB.php');

$disc = "SELECT * FROM vlab_disc WHERE id IN (SELECT MAX(id) FROM vlab_disc )";
$dres = $pdo -> prepare($disc);
$dres -> execute();
$res['vlab_disc'] =  $dres -> fetchAll();

include('head.php');
?>
<div id="fr">
      <div class="fr_title">
        <div class="fr_je">中心简介</div>
        <p><a href="index.php">首页</a><span> &gt; </span><a href="disc.php">中心简介</a></p>
      </div>
      <div class="fr3_cot">
        <div class="walk_te">中心简介</div>
        <div class="walk_cot">
          <div style="LAYOUT-GRID:  15.6pt none" class="Section0">
              <?php
                echo $res['vlab_disc'][0]['content'];
              ?>
          </div>
      </div>
    </div>
</div>
<?php include('bottom.php');?>