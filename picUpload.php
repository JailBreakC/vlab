<?php
//设定可操作的表
$allowed = array('vlab_banner', 'vlab_resource', 'vlab_video');

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
?>