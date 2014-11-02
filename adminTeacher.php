<?php 
include('connDB.php');
    $needed = array('vlab_major' => array('id', 'major'),
                    'vlab_title' => array('id', 'title'),
                    'vlab_degree' => array('id', 'degree')
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
?>
<div class="container">
<style>input {
width: 100px;
}</style>
    <div class="container">
        <h2>机构成员</h2>
        <hr>
        <table class="table table-bordered table-hover">
            <tr>
                <th>序号</th>
                <th>姓名</th>
                <th>性别</th>
                <th>年龄</th>
                <th>手机</th>
                <th>职称</th>
                <th>学历学位</th>
                <th>专业</th>
                <th>加入时间</th>
                <th>个人主页</th>
                <th>操作</th>
            </tr>
            <tr id="editTr">
                <td id="id"></td>
                <td><input id="name" type="text"></td>
                <td><input id="sex" type="text"></td>
                <td><input id="age" type="text"></td>
                <td><input id="phone" type="text"></td>
                <td><select id="title">
                      <?php 
                      foreach ($res['vlab_title'] as $key => $value) {
                        $value = $value['title'];
                      echo "<option value='$value'>$value</option>";
                      }
                      ?>
                  </select>
                </td>
                <td><select id="degree">
                      <?php 
                      foreach ($res['vlab_degree'] as $key => $value) {
                        $value = $value['degree'];
                      echo "<option value='$value'>$value</option>";
                      }
                      ?>
                  </select>
                </td>
                <td><select id="major">
                      <?php 
                      foreach ($res['vlab_major'] as $key => $value) {
                        $value = $value['major'];
                      echo "<option value='$value'>$value</option>";
                      }
                      ?>
                  </select>
                </td>
                <td><input id="add_time" type="text"></td>
                <td><input id="web_page" type="text"></td>
                <td><button class="btn btn-xs btn-primary">↓</button></td>
            </tr>
        </table>
        <h3>成员简介：</h3>
        <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="icon-font"></i><b class="caret"></b></a>
              <ul class="dropdown-menu">
              <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
            </div>
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
              <ul class="dropdown-menu">
              <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
              <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
              <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
              </ul>
          </div>
          <div class="btn-group">
            <a class="btn btn-default" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
            <a class="btn btn-default" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
            <a class="btn btn-default" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="icon-strikethrough"></i></a>
            <a class="btn btn-default" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
          </div>
          <div class="btn-group">
            <a class="btn btn-default" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="icon-list-ul"></i></a>
            <a class="btn btn-default" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="icon-list-ol"></i></a>
            <a class="btn btn-default" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
            <a class="btn btn-default" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="icon-indent-right"></i></a>
          </div>
          <div class="btn-group">
            <a class="btn btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
            <a class="btn btn-default" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
            <a class="btn btn-default" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
            <a class="btn btn-default" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
          </div>
          <div class="btn-group">
              <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="icon-link"></i></a>
                <div class="dropdown-menu input-append">
                    <input class="span2" placeholder="URL" type="text" data-edit="createLink">
                    <button class="btn btn-default" type="button">Add</button>
            </div>
            <a class="btn btn-default" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="icon-cut"></i></a>

          </div>
          
          <div class="btn-group">
            <a class="btn btn-default" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="icon-picture"></i></a>
            <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 37px; height: 30px;">
          </div>
          <div class="btn-group">
            <a class="btn btn-default" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
            <a class="btn btn-default" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
          </div>
          <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" style="display: none;">
          <button id="save" class="btn btn-primary pull-right">保存修改</button>
          <button id="new" class="btn btn-success pull-right">新增成员</button>
        </div>
        <div id="editor" style="overflow:scroll;height:400px;border: solid 2px #8188AC;margin:10px 0;"></div>
        <table id="showTable" class="table table-bordered table-hover" style="cursor:pointer;">
            <tr>
                <th>序号</th>
                <th>姓名</th>
                <th>性别</th>
                <th>年龄</th>
                <th>手机</th>
                <th>职称</th>
                <th>专业</th>
                <th>学历学位</th>
                <th>加入时间</th>
                <th>个人主页</th>
                <th>操作</th>
            </tr>
            
        </table>
    </div>

</div>