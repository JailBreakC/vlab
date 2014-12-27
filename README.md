#湖南科技大学虚拟仿真实验室系统(hnust vlab)源码文档

##概述
本系统是采用PHP进行编写，使用MySQL数据库。实现了一个基本完备的信息管理系统。拥有全面后台管理功能。后台采用统一化的AJAX API进行操作。可扩展性强。

##数据库表
- 用户     vlab_user 
id student_id pw name mail major add_time
- 管理员   vlab_admin 
id user_name pw phone mail level name add_time
- 中心介绍 vlab_disc 
id content add_time pic
- 新闻     vlab_news 
id title content add_time
- 公告     vlab_message 
id title content add_time
- 教师     vlab_teacher 
id name sex age phone title major degree add_time web_page disc photo
- 制度     vlab_rule 
id title content add_time
- 职称     vlab_title 
-id title
- 学历学位 vlab_degree 
id dgree
- 专业     vlab_major 
id major
- 虚拟资源 vlab_resource 
id title pic add_time content
- 仪器设备 vlab_device 
id name type price num maker  buy_time pic
- 首页轮播图 vlab_banner 
id pic
- 侧边栏 vlab_list /*侧边栏结构较复杂，并且修改较少，故采用JSON格式字符串储存在content元素中。*/
id sub_title_id content

##目录结构
- css ——样式表文件夹
    - xmmain.css ——前台界面主样式
    - main.css ——前台界面副样式
    - 其他 ——其他样式库
- fonts ——bootstrap的字体库
- images ——图片
    - vlab_banner ——中心轮播图图片
    - vlab_resource ——仿真资源缩略图
    - 其他 ——前台其他图片
- js ——javascript代码文件夹
    - js.js ——前台首页导航条效果代码
    - main.js ——前台主代码
    - admin.js ——后台数据解析、处理代码。(后台业务逻辑)
    - transfer.js ——后台数据传输模块。(操作adminDataAPI.php、picUpload.php接口)
    - htmlshiv.js ——HTML5 标签兼容性适配代码
    - dropzone.min.js 后台富文本编辑框插件代码
    - 其他 其他库代码
- README.md ——描述文档 
- admin.php ——路由逻辑        
- adminRule.php ——规章制度界面      
- adminTitle.php ——职称管理
- adminDevice.php ——仪器设备管理
- adminFoot.php ——统一尾部界面
- adminHead.php ——统一头部界面，导航
- adminList.php ——侧栏管理
- adminLogin.php ——登录界面
- adminMajor.php ——专业管理
- adminManage.php ——管理员信息
- adminMessage.php ——公告管理
- adminNews.php ——新闻管理
- adminResource.php ——仿真资源管理
- adminCenter.php ——中心介绍，轮播图管理
- adminTeacher.php ——师资力量管理
- adminDataAPI.php ——数据库操作API
- picUpload.php  ——图片上传接口
- connDB.php ——连接数据库
- index.php ——前台主页
- rule.php ——前台规章制度页
- disc.php ——前台中心介绍页
- head.php ——前台统一头
- bottom.php ——前台统一尾
- teacher.php ——机构与队伍页
- device.php ——仪器设备页
- contact.php ——联系我们
- message.php ——公告
- news.php ——新闻
- resource.php ——中心虚拟资源页
- teacherFile.html ——教师信息 //临时
- t1.html ——设备信息1 //临时
- t2.html ——设备信息2 //临时
- t3.html ——设备信息3 //临时
- codeLineCount.txt 代码行数统计。

##接口使用方法与源码注释
###前端数据接口：transfer.js
该插件依赖jQuery使用之前先引入资源
    
    <script type="text/javascript" src="js/jQuery.min.js"></script>
    <script type="text/javascript" src="js/transfer.js"></script>
    
生成唯一ID

    var guid = $.transfer.guid();
    
发送数据 

`method`：'insert' 新增表 'updata' 修改表；

`table`：表名；

`[id]`：行ID，'no'为新增行；

`[data]`：数据；

`[fn]`：回调函数；

`[norefresh]`：默认false。为true则成功后不刷新页面，否则刷新页面；

    $.transfer.sendText('insert', 'vlab_resource', 'no', data, appendEle, true);
    
获取数据

`tablename`：表名；

`id`：行ID，'no'为新增行；

`[fn]`：回调函数；

`[field]`：请求的元素列表,类型为数组；

    $.transfer.getText('vlab_teacher', 'all', parseTeacher, ['id', 'name', 'sex', 'age',
         'phone', 'title', 'major', 'degree', 'add_time', 'web_page']);

删除数据

`tablename`：表名；

`id`：行ID；

`norefresh`：默认false。为true则成功后不刷新页面，否则刷新页面；

    $.transfer.deleteText('vlab_banner', id, true);
    
###前端图片接口 jQuery.fileupload.js

使用前先引入资源

    <script type="text/javascript" src="js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="js/jquery.fileupload.js"></script>
    
    var uploadFile = function(fn, table, id){
        $('#centerPic').fileupload({
            url:'picUpload.php',
            formData:{update:table, id:id},
            done: function(e, result) {
                console.log(result.result);
                var rs = JSON.parse(result.result);
                if(rs.state !== 'failed'){
                    fn&&fn(rs);
               }else{
                    alert('uploading failed');
                }
            }
        });
    };
    
`fn`：回调函数, 参数为图片地址;

`table`：图片储存的表名；

`id`：行ID，'no'为新增行；

    uploadFile(addImg, 'vlab_banner');
    
###源码与注释

####transfer.js *前台数据接口*
    
    ;(function($){
        $.transfer = function(){
            return {
                //生成GUID
                guid: function() {
                    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                        var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
                        return v.toString(16);
                    });
                },
                //发送数据
                sendText : function(method, tablename, id, data, fn, norefresh) {
                        $.ajax({
                            type:"post",
                            url:"adminDataAPI.php",
                            data:{'method':method, 'save':tablename, 'id':id, 'data':data},
                            dataType:"text",
                            success:function(ret){
                                if(ret === 'success'){
                                    fn&&fn(data);
                                    alert("更新成功");
                                    if(!norefresh)
                                        window.location.reload()
                                }else{
                                    alert("更新失败");
                                }
                            },
                            error:function(ret){
                                alert("网络故障，稍后重试 " + ret);
                            }
                        });
                    },
                //获取数据
                getText : function(tablename, id, fn, field) {
                    field = field || '';
                    var data;
                    console.log(field);
                    $.ajax({
                            type:"post",
                            url:"adminDataAPI.php",
                            data:{'query':tablename, 'id':id, 'field':field},
                            dataType:"text",
                            success:function(ret){
                                //console.log(ret);
                                data = JSON.parse(ret);
                                fn&&fn(data);
                            },
                            error:function(ret){
                                alert("网络故障，稍后重试 " + ret);
                            }
                    });
                    return data;
                },
                //删除数据
                deleteText : function(deleteTable, id, norefresh) {
                    $.ajax({
                            type:"post",
                            url:"adminDataAPI.php",
                            data:{'delete':deleteTable, 'id':id},
                            dataType:"text",
                            success:function(ret){
                                if(ret === 'success'){
                                    if(!norefresh){
                                        alert("删除成功");
                                        window.location.reload()
                                    }
                                }else{
                                    alert("删除失败");
                                }
                            },
                            error:function(ret){
                                alert("网络故障，稍后重试 " + ret);
                            }
                    });
                }
            }
        }
    })(window.jQuery)
    
####adminDataAPI.php *后台数据接口*
    
    session_start();
    //可访问表单控制
    $allowed = array('vlab_disc', 'vlab_resource', 'vlab_news', 'vlab_message', 'vlab_rule',
     'vlab_major', 'vlab_teacher', 'vlab_title', 'vlab_device', 'vlab_degree', 'vlab_banner', 'vlab_list');
    
        //获取数据可以无需登录
    if(isset($_POST['query']) && isset($_POST['id'])){
        include('connDB.php');
        $q = $_POST['query'];
        $id = $_POST['id'];
        if(in_array($q, $allowed)) {
            $field = '*';
            if(isset($_POST['field']) && $_POST['field'])
            {   
                $field = '';
                //print_r($_POST['field']);
                $len = count($_POST['field']);
                $i = 1;
                foreach ($_POST['field'] as $key => $value) {
                    if($i<$len) $field .= $value . ', ';
                    else $field .= $value;
                    $i++;
                }
                //echo $field;
            }
            if($id == 'all'){
                //获取整个表单的数据
                $query = "SELECT $field FROM $q";
                $result = $pdo -> prepare($query);
            }else if($id == 'last'){
                //获取最后一行数据
                $query = "SELECT $field FROM $q WHERE id IN (SELECT MAX(id) FROM $q )";
                $result = $pdo -> prepare($query);
            }else{
                //获取指定行的数据
                $query = "SELECT $field FROM $q WHERE id = ?";
                $result = $pdo -> prepare($query);
                $result -> bindParam(1,$id);
            }
            //echo $query;
            if(!$result -> execute()) {
                echo 'getting data failed!';
                exit();
            }
            else{
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $row = $result -> fetchAll();
                //print_r($row);
                echo json_encode($row);
            }
        }
            //若处于登录状态，则可以进行数据的修改
    }else if(isset($_POST['method']) && isset($_POST['save']) && isset($_POST['id']) && isset($_POST['data']) && isset($_SESSION['user'])){
        include('connDB.php');
        $method = $_POST['method'];    $save = $_POST['save'];    $id = $_POST['id'];    $data = $_POST['data'];
        if(in_array($save, $allowed)){
                //若未指定id则新增数据
            if($method == 'insert'){
                //拼凑SQL语句
                $query = "insert into " . $save . "(";
                $value = " value(";
                $length = count($data);
                $i = 1;
                foreach($data as $key => $v) {
                    if($i < $length){
                        $query .= $key . ','; $value .= '?,';
                    }
                    else {
                        $query .= $key . ')'; $value .= '?)';
                    }
                    $i++;
                }
                $query .= $value;
                //echo $query;
                $result = $pdo -> prepare($query);
                $i = 1;
                foreach($data as $key => $v) {
                    //此处必须绑定$data[$key]，若绑定$v则所有绑定值都相同
                    $result -> bindParam($i,$data[$key]);
                    $i++;
                }
                if(!$result -> execute())
                    echo 'sql查询失败';
                else
                    echo 'success';
            }
            else{
                $query = "update ". $save . " set ";
                $i = 1;
                $length = count($data);
                foreach($data as $key => $v) {
                    if($i < $length){
                        $query .= $key . '=?,';
                    }
                    else {
                        $query .= $key . '=? where id =' . $id;
                    }
                    $i++;
                }
                //echo $query;
                $result = $pdo -> prepare($query);
                $i = 1;
                foreach($data as $key => $v) {
                    //此处必须绑定$data[$key]，若绑定$v则所有绑定值都相同
                    $result -> bindParam($i,$data[$key]);
                    $i++;
                }
                if(!$result -> execute())
                    echo 'sql更新失败';
                else
                    echo 'success';
            }
        }
        //若处于登录状态，可删除数据。
    }else if(isset($_POST['delete']) && isset($_POST['id']) && isset($_SESSION['user'])){
        include('connDB.php');
        $delete = $_POST['delete'];
        $id = $_POST['id'];
        if(in_array($delete, $allowed)){
            $query = "DELETE FROM $delete WHERE id = $id";
            //echo $query;
            $result = $pdo -> prepare($query);
            if(!$result -> execute())
                echo 'sql删除失败';
            else
                echo 'success';
        }
    }else {
        echo "请输入正确的参数";
    }
####picUpload.php *后台图片接口*

    //设定可操作的表
    $allowed = array('vlab_banner', 'vlab_resource');
    session_start();
    if(isset($_SESSION['user'])){    
        include('connDB.php');
        $time = date('Y-m-d H:i:s');
        $regexFileExt = "/\.(jpg|jpeg|png|gif)$/i";
        $tmpName = $_FILES['files']['tmp_name'];
        $photoName = $_FILES['files']['name'];
        /*print_r($_POST);*/
        if(isset($_POST['update']) && in_array($_POST['update'], $allowed)){
          $table = $_POST['update'];
          //正则校验文件名
          if(preg_match($regexFileExt,$photoName)){
            $arrEXIFType=array(IMAGETYPE_JPEG,IMAGETYPE_PNG,IMAGETYPE_GIF);
            //校验文件头
            if(in_array(exif_imagetype($tmpName),$arrEXIFType)){
              $photoNameSave = date('ymdHis');
              $phototype = explode('.',$photoName);
              $j = count($phototype);
              //sae上传
              if(isset($_SERVER['HTTP_APPNAME'])){ 
                $photoUrl = $photoNameSave.'.'.$phototype[$j-1];
                $storage = new SaeStorage();
                $domain = 'pic';
                $destFileName = $photoUrl;
                $srcFileName = $tmpName;
                //$attr = array('encoding'=>'gzip');
                $result = $storage->upload($domain,$destFileName, $srcFileName, -1, $attr, true);
                $photoUrl = $result;
                //$attr = array('access' => 'public');
                //$storage -> setFileAttr($domain,$destFileName,$attr);
              }else {
                //本地上传
                $photoUrl = 'images/'.$table.'/'.$photoNameSave.'.'.$phototype[$j-1];
                if(move_uploaded_file($tmpName,$photoUrl)) {
                    if(isset($_POST['id']) && $_POST['id']){
                        //带id参数时，更新数据库。
                        $id = $_POST['id'];
                        $query = "UPDATE `$table` SET `pic` = '$photoUrl' WHERE `id` = $id";
                    }else if($table == 'vlab_banner') {
                        $query = "INSERT INTO `$table` (`pic`) VALUES ('$photoUrl')";
                    }else {
                        //当不带参数id且不为更新vlab_banner表时，不写入数据库，只返回地址。
                        $msg = array('state'=>'succeed', 'msg'=>$photoUrl);
                        echo json_encode($msg);
                        exit();
                    }
                    //echo $query;
                    $result = $pdo->prepare($query);
                    if(!$result->execute()){
                        $msg = array('state'=>'failed', 'msg'=>'Can\'t insert into database');
                        echo json_encode($msg);
                        exit();
                    }else{
                        //获取刚写入字段的id
                        $query = "SELECT LAST_INSERT_ID()";
                        $result = $pdo->prepare($query);
                        if(!$result->execute()){
                            $msg = array('state'=>'failed', 'msg'=>'Can\'t get ID');
                            echo json_encode($msg);
                        }else{
                            $id = $result->fetchALL();
                            $id = $id[0][0];
                            $msg = array('state'=>'succeed', 'msg'=>$photoUrl, 'id'=>$id);
                            echo json_encode($msg);
                        }
                    }
                }else{
                    $msg = array('state'=>'failed', 'msg'=>'Can\'t move uploaded file');
                    echo json_encode($msg);
                    exit();
                }
              }
            }
          }
        }
    }