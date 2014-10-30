<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>湖南科技大学虚拟仿真实验室后台管理中心</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link href="css/fonts/font-awesome.css" rel="stylesheet">
    <style>
    .foot-bar{
      color: rgb(133, 133, 133);
      background: rgb(240, 248, 255);
      margin-top: 50px;
    }
    </style>
<body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="admin.php">HNUST</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="admin.php?page=adminCenter">实验中心介绍</a></li>
            <li><a href="admin.php?page=adminNews">新闻公告</a></li>
            <li><a href="admin.php?page=adminResource">中心虚拟资源</a></li>
            <li><a href="admin.php?page=adminDevice">仪器设备</a></li>
            <li><a href="admin.php?page=adminRule">管理制度</a></li>
            <li><a href="admin.php?page=adminTeacher">机构成员</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">预设值管理 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="admin.php?page=adminTitle">职称|学位</a></li>
                <li><a href="admin.php?page=adminMajor">专业</a></li>
              </ul>
            </li>
            <li class=""><a href="admin.php">管理员管理</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>