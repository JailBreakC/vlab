<?php
    include('connDB.php');
    $needed = array('vlab_device' => array('id', 'name'),
                    'vlab_news' => array('id', 'title', 'add_time'),
                    'vlab_message' => array('id', 'title', 'add_time'),
                    'vlab_resource' => array('id', 'pic', 'title', 'add_time'),
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
    $disc = "SELECT * FROM vlab_disc WHERE id IN (SELECT MAX(id) FROM vlab_disc )";
    $dres = $pdo -> prepare($disc);
    $dres -> execute();
    $res['vlab_disc'] =  $dres -> fetchAll();
?>

<?php include("head.php"); ?>
    </div>    <div id="fr">
      <div class="gs">
        <div class="gs_t">
          <div class="gs_ti">中心简介</div>
          <p class="more"><a href="disc.php">+更多</a></p>
        </div>
        <div class="gs_cot"> <a class="iframe cboxElement" href="disc.php"><img src="images/discpic.jpg" width="262" height="176"></a>
          <p style="TEXT-INDENT: 2em"><?php echo substr($res['vlab_disc'][0]['content'],0,850); ?>
            ...<a href="disc.php" target="_blank">详情</a></p>
        </div>
      </div>
      <div class="js">
        <div class="js_t">
          <div class="js_ti">中心动态</div>
          <p class="more"><a href="news.php">+更多</a></p>
        </div>
        <div class="js_cot">
          <ul>
            <?php 
              foreach ($res['vlab_news'] as $key => $value) {
                  $title = $value['title']; $id = $value['id'];
                  echo "<li><a href='news.php?id=$id' title='$title'>$title</a></li>";
              }
            ?>
          </ul>
        </div>
      </div>
      <div class="js zz">
        <div class="js_t">
          <div class="js_ti">通知公告</div>
          <p class="more"><a href="message.php">+更多</a></p>
        </div>
        <style> .js_cot a{text-overflow: ellipsis;white-space: nowrap;overflow: hidden;}</style>
        <div class="js_cot">
          <ul>
              <?php 
              foreach ($res['vlab_message'] as $key => $value) {
                  $title = $value['title']; $id = $value['id'];
                  echo "<li><a href='message.php?id=$id' title='$title'>$title</a></li>";
              }
              ?>
          </ul>
        </div>
      </div>
      <div class="gs cp">
        <div class="gs_t">
          <div class="gs_ti">中心资源</div>
          <p class="more"><a href="resource.php">+更多</a></p>
        </div>
        <div class="cp_cot">
          <div class="multipleColumn">
            <div class="bd">
              <div class="picList" style="position: relative; width: 735px; height: 396px;"> 
                <ul style="position: absolute; width: 725px; left: 0px; top: 0px; display: none;"><li>
                  <?php 
                    foreach ($res['vlab_resource'] as $key => $value) {
                      $title = $value['title']; $id = $value['id'];
                      echo "<div class='pic'><a><img src='images/soft1.jpg' width='205' height='145' 
                  alt='$title></a></div>
                  <span><a href='#' target='_blank'>$title</a></span> </li><li>";
                    }
                  
                  ?>
                </ul>
               
              </div>
            </div>
            <!-- bd End --> 
          </div>
          <!-- multipleColumn End --> 
          
          <script type="text/javascript">
                /* 使用js分组，每6个li放到一个ul里面 */
                jQuery(".multipleColumn .bd li").each(function(i){ jQuery(".multipleColumn .bd li").slice(i*6,i*6+6).wrapAll("<ul></ul>");});

                /* 调用SuperSlide，每次滚动一个ul，相当于每次滚动6个li */
                jQuery(".multipleColumn").slide({titCell:".hd ul",mainCell:".bd .picList",autoPage:true,effect:"fold",autoPlay:true,delayTime:500,interTime:5000});
            </script> 
        </div>
      </div>
    </div>
  </div>


<?php include("bottom.php"); ?>