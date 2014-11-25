$(document).ready(function(){
    $('#editor').wysiwyg();
    var t = transfer();
    var page = window.location.href.split('=')[1];

    //获取当前日期
    var getDate = function() {
        var date = new Date();
        return date = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
    }
    //加载简介中心文章
    var parseCenter = function(content) {
        content = content[0];
        $('#editor').html(content.content);
        $('#addTime').attr('value',content.add_time);
        $('#nowTime').attr('value',getDate());
    }

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
    }
    if( page === 'adminCenter') {
        t.getText('vlab_disc', 'last', parseCenter);
        var addImg = function(rs){
            $('#bannerCt').append('<img id="'+rs.id+'" class="col-xs-12 img-thumbnail" src="' + rs.msg + 
            '"><button class="delete btn btn-xs btn-danger pull-right">删除</button>');
        //alert('succeed');
        }
        uploadFile(addImg, 'vlab_banner');
        $('#bannerCt').on('click', '.delete', function(){
            var img = $(this).prev()
            var id = img.attr('id');
            t.deleteText('vlab_banner', id, 'norefresh');
            img.remove();
            $(this).remove();
        });
        $('#save').click(function() {
            var data = {}
            data.content = $('#editor').html();
            data.add_time = $('#nowTime').val();
            t.sendText('vlab_disc', 'no', data);
        })
    }
    //加载仪器设备列表
    var parseDevice = function(data) {
        var tr = [];
        for(var i in data){
            tr[i] = '<tr class="items">'
                + '<td>'+ data[i].id + '</td>'
                + '<td>' + data[i].name + '</td>'
                + '<td>' + data[i].type + '</td>'
                + '<td>' + data[i].price + '</td>'
                + '<td>' + data[i].num + '</td>'
                + '<td>' + data[i].maker + '</td>'
                + '<td>' + data[i].buy_time + '</td>'
                + '<td><button class="btn btn-xs btn-primary">修改</button>   '
                +      '<button class="delete btn btn-xs btn-danger">删除</button>'
                + '</td>'
            + '</tr>'
            $('#showTable').append(tr[i]);
        }
    }
    //加载仪器设备文章到编辑器
    var parseItems = function(data) {
        data = data[0];
        $('#editor').html(data.disc);
        for(var i in data){
            if(i === 'id')
                $('#id').html(data[i])
            else
                $('#'+i).val(data[i]);
        }
    }
    //-------------处理adminDevice.php----------------
    if( page === 'adminDevice') {
        t.getText('vlab_device', 'all', parseDevice, ['id', 'name', 'type', 'price', 'num', 'maker', 'buy_time'])
        $('#new').click(function() {
            var data = {};
            $('#editTr').children().each(function(index,ele) {
                var id = $(ele).find('input').attr('id');
                if(id)
                    data[id] = $(ele).find('input').val();
            });
            data.disc = $('#editor').html();
            t.sendText('vlab_device', 'no', data);
        });
        $('#save').click(function() {
            var data = {};
            $('#editTr').children().each(function(index,ele) {
                var id = $(ele).find('input').attr('id');
                if(id)
                    data[id] = $(ele).find('input').val();
            });
            data.disc = $('#editor').html();
            var id = $('#id').html()
            if(id)
                t.sendText('vlab_device', id, data);
            else
                alert('请先读取要修改的文章');
        });
        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).text();
            t.deleteText('vlab_device', id);
        });
        $('.table').on('click', '.items', function() {
            var id = $(this).find('td').eq(0).html();
            t.getText('vlab_device', id, parseItems);
        })
    }
    //加载新闻公告列表(中心资源，管理制度通用)
    var parseNewsTable = function(data) {
        var tr = []
        for(var i in data){
            tr[i] = '<tr>'
                    +'  <td>' + data[i].id + '</td>'
                    +'  <td>' + data[i].title + '</td>'
                    +'  <td>' + data[i].add_time + '</td>'
                    +'  <td><button class="read btn btn-xs btn-primary">读取文章</button></td>'
                    +'  <td><button class="read btn btn-xs btn-primary">修改</button>'
                    +'      <button class="delete btn btn-xs btn-danger">删除</button></td>'
                    +'</tr>'
            $('.table').append(tr[i]);
        }
    }
    //加载新闻内容到编辑器(中心资源，管理制度通用)
    var parseNews = function(data) {
        data = data[0];
        $('#editor').html(data.content);
        $('#title').val(data.title);
        $('#addTime').val(data.add_time);
        $('#nowTime').val(getDate());
    }
    if(page === 'adminNews' || page === 'adminMessage') {
        $('#nowTime').attr('value',getDate());
        var table =  page === 'adminNews' ? 'vlab_news' : 'vlab_message';
        t.getText(table, 'all', parseNewsTable, ['id', 'title', 'add_time']);

        $('#new').click(function() {
            var data = {};
            data.title = $('#title').val();
            data.content = $('#editor').html();
            data.add_time = $('#nowTime').val();
            t.sendText(table, 'no', data);
            $('#save').attr('data-target-id','');
        });
        $('#save').click(function() {
            var data = {};
            var id = $('#save').attr('data-target-id');
            if(id){
                data.title = $('#title').val();
                data.content = $('#editor').html();
                data.add_time = $('#nowTime').val();
                t.sendText(table, id, data);
            }else{
                alert('请先读取要修改的文章');
            }
        });

        $('.table').on('click', '.read', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            $('#save').attr('data-target-id', id);
            t.getText(table, id, parseNews);
        });

        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            t.deleteText(table, id);
        });

    }
    if(page === 'adminRule') {
        $('#nowTime').attr('value',getDate());
        t.getText('vlab_rule', 'all', parseNewsTable, ['id', 'title', 'add_time']);

        $('#new').click(function() {
            var data = {};
            data.title = $('#title').val();
            data.content = $('#editor').html();
            data.add_time = $('#nowTime').val();
            t.sendText('vlab_rule', 'no', data);
            $('#save').attr('data-target-id','');
        });
        $('#save').click(function() {
            var data = {};
            var id = $('#save').attr('data-target-id');
            if(id){
                data.title = $('#title').val();
                data.content = $('#editor').html();
                data.add_time = $('#nowTime').val();
                t.sendText('vlab_rule', id, data);
            }else{
                alert('请先读取要修改的文章');
            }
        });

        $('.table').on('click', '.read', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            $('#save').attr('data-target-id', id);
            t.getText('vlab_rule', id, parseNews);
        });

        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            t.deleteText('vlab_rule', id);
        });

    }
    var parseResource = function(data) {
        data = data[0];
        $('#editor').html(data.content);
        $('#title').val(data.title);
        $('#addTime').val(data.add_time);
        $('#nowTime').val(getDate());
        $('#img').attr('src', data.pic);
    }
    if(page === 'adminResource') {
        var changeImg = function(rs){
            $('#img').attr('src', rs.msg);
        }
        //绑定图像上传事件，不更新数据表，只获取图片地址
        uploadFile(changeImg, 'vlab_resource');

        $('#nowTime').attr('value',getDate());
        t.getText('vlab_resource', 'all', parseNewsTable, ['id', 'title', 'add_time']);
        
        $('#new').click(function() {
            var data = {};
            data.title = $('#title').val();
            data.content = $('#editor').html();
            data.add_time = $('#nowTime').val();

            //新增实例时需要写入图片地址
            data.pic = $('#img').attr('src');

            var appendEle = function(data) {
                var ele = "<tr><td>NaN</td><td>"+data.title+"(修改前请刷新)</td><td>"+data.add_time
                + "</td><td><button class='read btn btn-xs btn-primary'>读取文章</button></td> "
                + " <td><button class='read btn btn-xs btn-primary'>修改</button>"
                + "<button class='delete btn btn-xs btn-danger'>删除</button></td></tr>"
                $('.table>tbody').append(ele);
            }
            t.sendText('vlab_resource', 'no', data, appendEle, 'norefresh');
            $('#save').attr('data-target-id','');
        });

        $('#save').click(function() {
            var data = {};
            var id = $('#save').attr('data-target-id');
            if(id){
                data.title = $('#title').val();
                data.content = $('#editor').html();
                data.add_time = $('#nowTime').val();
                data.pic = $('#img').attr('src');
                t.sendText('vlab_resource', id, data);
            }else{
                alert('请先读取要修改的文章');
            }
        });

        $('.table').on('click', '.read', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            $('#save').attr('data-target-id', id);
            t.getText('vlab_resource', id, parseResource);
            //注册头像事件
            uploadFile(changeImg, 'vlab_resource', id);
        });

        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            t.deleteText('vlab_resource', id);
        });

    }

    //加载机构成员列表
    var parseTeacher = function(data) {
        var tr = [];
        for(var i in data){
            tr[i] = '<tr class="items">'
                    + '  <td>' + data[i].id + '</td>'
                    + '  <td>' + data[i].name + '</td>'
                    + '  <td>' + data[i].sex + '</td>'
                    + '  <td>' + data[i].age + '</td>'
                    + '  <td>' + data[i].phone + '</td>'
                    + '  <td>' + data[i].title + '</td>'
                    + '  <td>' + data[i].degree + '</td>'
                    + '  <td>' + data[i].major + '</td>'
                    + '  <td>' + data[i].add_time + '</td>'
                    + '  <td>' + data[i].web_page + '</td>'
                    + '  <td><button class="read btn btn-xs btn-primary">修改</button>'
                    +'      <button class="delete btn btn-xs btn-danger">删除</button></td>'
                    +'</tr>';
            $('#showTable').append(tr[i]);
        }
    }
    if(page === 'adminTeacher') {
        t.getText('vlab_teacher', 'all', parseTeacher, ['id', 'name', 'sex', 'age',
         'phone', 'title', 'major', 'degree', 'add_time', 'web_page']);
        $('#new').click(function() {
            var data = {};
            $('#editTr').children().each(function(index,ele) {
                var id = $(ele).children().first().attr('id');
                if(id)
                    data[id] = $('#' + id).val();
            });
            data.disc = $('#editor').html();
            t.sendText('vlab_teacher', 'no', data);
        });
        $('#save').click(function() {
            var data = {};
            $('#editTr').children().each(function(index,ele) {
                var id = $(ele).children().first().attr('id');
                if(id)
                    data[id] = $('#' + id).val();
            });
            data.disc = $('#editor').html();
            var id = $('#id').html()
            if(id)
                t.sendText('vlab_teacher', id, data);
            else
                alert('请先读取要修改的文章');
        });
        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).text();
            t.deleteText('vlab_teacher', id);
        });
        $('.table').on('click', '.items', function() {
            var id = $(this).find('td').eq(0).html();
            t.getText('vlab_teacher', id, parseItems);
        })
    }
    //解析预设值(title,degree,major)
    var parseTitle = function(attr){
            return function(data) {
                    var tr = [];
                    for(var i in data) {
                        tr[i] = '<tr>'
                                +'    <td>' + data[i].id + '</td>'
                                +'    <td>' + data[i][attr] + '</td>'
                                +'    <td><button class="delete btn btn-danger">删除</button></td>'
                                +'</tr>';
                        $('#vlab_' + attr).append(tr[i]);
                }
        }
    }
    if(page === 'adminTitle' || page === 'adminMajor') {
        if(page === 'adminTitle'){
            t.getText('vlab_title', 'all', parseTitle('title'));
            t.getText('vlab_degree', 'all', parseTitle('degree'));
        }else{
            t.getText('vlab_major', 'all', parseTitle('major'));
        }
        var newData = function(table) {
            var data = {};
            $('#' + table).children().each(function(index,ele) {
                var id = $(ele).find('input').attr('id');
                if(id)
                    data[id] = $(ele).find('input').val();
            });
            t.sendText(table, 'no', data);
        }
        $('.new-title').click(function() {
            newData('vlab_title');
        });
        $('.new-degree').click(function() {
            newData('vlab_degree');
        });
        $('.new-major').click(function() {
            newData('vlab_major');
        });

        $('.row').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            var table = $(this).closest('table').attr('id');
            t.deleteText(table, id);
        });
    }
    if(page === 'adminList') {
        $('#listeditor').on('click', 'li>button', function(){
            $(this).parent().clone().appendTo($(this).parent().parent());
        });
        $('.save').click(function(){
            var data = {};
            $('.mainTitle').each(function(index, ele){
                data[index].title.val = $(ele).children('input').val();
                $(ele).find('.subTitle').each(function(idx, el){
                    data[index].title.subTitle[idx].val = $(el).children('input').val()
                    $(el).find('.content').each(function(i,e){
                        data[index].title.subTitle[idx].content.href = $(e).children('input').eq(0).val();
                        data[index].title.subTitle[idx].content.text = $(e).children('input').eq(1).val();
                    });
                });
            });
            console.log(data);
        });
    }

});