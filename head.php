<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="keywords" content="湖南科技大学虚拟仿真实验室">
  <meta name="description" content="湖南科技大学虚拟仿真实验室">
  <title>湖南科技大学虚拟仿真实验室</title>
  <link rel="icon" href="images/logo.jpg">
  <link href="js/video-js/video-js.css" rel="stylesheet" type="text/css">
  <link href="css/xmmain.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    body {
      font-family: 'Microsoft Yahei'!important;
    }
    object,embed{                -webkit-animation-duration:.001s;-webkit-animation-name:playerInserted;                -ms-animation-duration:.001s;-ms-animation-name:playerInserted;                -o-animation-duration:.001s;-o-animation-name:playerInserted;                animation-duration:.001s;animation-name:playerInserted;}                @-webkit-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}                @-ms-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}                @-o-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}                @keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}</style><style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
    .en-markup-crop-options {
        top: 18px !important;
        left: 50% !important;
        margin-left: -100px !important;
        width: 200px !important;
        border: 2px rgba(255,255,255,.38) solid !important;
        border-radius: 4px !important;
    }

    .en-markup-crop-options div div:first-of-type {
        margin-left: 0px !important;
    }
  </style>
  <script src="js/video-js/video.js"></script>
  <!--百度统计-->
  <script>
  var _hmt = _hmt || [];
  (function() {
    var hm = document.createElement("script");
    hm.src = "//hm.baidu.com/hm.js?167043a18c199b6495c94f76cd10fa5a";
    var s = document.getElementsByTagName("script")[0]; 
    s.parentNode.insertBefore(hm, s);
  })();
  </script>

</head>

<body>
<div id="all"> <div id="top">
  <div class="logo"> <img src="images/logo.png" alt="湖南科技大学虚拟仿真实验室"></div>
  <div class="tell">
    <p class="tell_t"> <span class="t1"><a href="index.php">首页</a></span> <span class="t2"><a href="disc.php">关于我们</a></span> <span class="t3"><a href="contact.php">联系我们</a></span> </p>
  </div>
</div>
<div id="navall">
  <div class="nav1"></div>
  <div id="nav">
    <ul>
      <li><a href="index.php" title="" id="menu1">网站首页</a></li>
      <li><a href="disc.php" title="" id="menu2">实验中心概要</a></li>
      <li><a href="resource.php" title="" id="">中心资源</a></li>
      <li><a href="device.php" title="" id="menu5">仪器设备</a></li>
      <li><a href="teacher.php" title="" id="menu3">机构与队伍</a></li>
      <li><a href="rule.php" title="" id="menu4">管理制度</a></li>
      <li><a href="news.php" title="" id="menu7">中心动态</a></li>
      <li><a href="message.php" title="" id="menu8">通知公告</a></li>
      <li style="background:none"><a href="contact.php" title="" id="menu10">联系我们</a></li>
    </ul>
  </div>
  <div class="nav3"></div>
</div>
<div id="banner"> 
  <script type="text/javascript" src="js/jquery.min.js"></script> 
  <script type="text/javascript" src="js/jquery.SuperSlide.2.1.js"></script>
  <script src="js/js.js" language="javascript"></script> 
  <div class="focusBox" style="margin:0 auto">
    <div class="tempWrap" style="overflow:hidden; position:relative; width:1000px">
    <ul class="pic" style="width: 5000px; left: 2000px; position: relative; overflow: hidden; padding: 0px; margin: 0px;">
      <?php
      include('connDB.php');
      $query = "SELECT * FROM `vlab_banner`";
      $result = $pdo->prepare($query);
      if($result->execute()){
        $pic = $result->fetchAll();
        $len = count($pic);
        foreach ($pic as $key => $p) {
          $id = $p['id']; $src = $p['pic'];
          echo '<li style="float: left; width: 1000px;"><img src='.$src.'></li>';
        }
      }
      ?>
    </ul></div>
    <a class="prev" href="javascript:void(0)"></a> <a class="next" href="javascript:void(0)"></a>
    <ul class="hd">
      <li class="on"></li>
    <?php 
    for($i = 1; $i < $len; $i++)
        echo '<li class=""></li>';
    ?>
    </ul>
  </div>
    <script type="text/javascript">
        jQuery(".focusBox").slide({ mainCell:".pic",effect:"left", autoPlay:true, delayTime:200});
    </script>
</div>
<script src="js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" href="css/colorbox.css">
        <script>
            $(document).ready(function(){
                //Examples of how to assign the Colorbox event to elements
                $(".group1").colorbox({rel:'group1'});
                $(".group2").colorbox({rel:'group2', transition:"fade"});
                $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
                $(".group4").colorbox({rel:'group4', slideshow:true});
                $(".ajax").colorbox();
                $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
                $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
                $(".iframe").colorbox({iframe:true, width:"700", height:"600"});
                $(".inline").colorbox({inline:true, width:"50%"});
                $(".callbacks").colorbox({
                    onOpen:function(){ alert('onOpen: colorbox is about to open'); },
                    onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
                    onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
                    onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
                    onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
                });

                $('.non-retina').colorbox({rel:'group5', transition:'none'})
                $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
                
                //Example of preserving a JavaScript event for inline calls.
                $("#click").click(function(){ 
                    $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                    return false;
                });
            });
        </script>  <div id="main"> <div id="fl">
      <div class="pr">
        <div class="pr_t">
          <div class="pr_ti">虚拟仿真</div>
        </div>
        <div class="news_cont"> <a href="#" target="_blank"><img style="width:230px" src="images/login.jpg"></a>
        <p style="text-align:center;font-size:16px;"><a href="http://vlab.hnust.cn:8088/" target="_blank"><strong><font color="#FF0000">登录到虚拟仿真中心</font></strong></a></p> </div>
      </div>

<div class="pr news">
        <div class="pr_t">
          <div class="pr_ti">资源展示</div>
          <!--<p class="more"><a href="/html/course/">+更多</a></p>-->
        </div>

<div class="pr_course">
  <div class="sideMenu" style="margin:0 auto">
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
        echo '
            <h3 class="on"><em></em>'.$value->val.'</h3>
            <ul style="display: block;">';
        foreach ($value->subTitle as $v) {
            echo '<li class="course_title">'.$v->val.'</li>';
            foreach ($v->content as $va) {
              echo "<li class='sub'><a href='$va->href' title='$va->text' target='_blank'>$va->text</a></li>";
            }
        }
        echo "</ul>";

    }
}
?> 
  </div>
</div>
          <!-- sideMenu End --> 
          
          <script type="text/javascript">
            jQuery(".sideMenu").slide({
                titCell:"h3", //鼠标触发对象
                targetCell:"ul", //与titCell一一对应，第n个titCell控制第n个targetCell的显示隐藏
                effect:"slideDown", //targetCell下拉效果
                delayTime:500 , //效果时间
                triggerTime:500, //鼠标延迟触发时间（默认150）
                trigger:"click",
                defaultPlay:true,//默认是否执行效果（默认true）
                returnDefault:false //鼠标从.sideMen移走后返回默认状态（默认false）
                });
        </script> 
        </div>
      </div>