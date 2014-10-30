$(document).ready(function(){
    $('#editor').wysiwyg();
    var page = window.location.href.split('=')[1];
    //发送数据
    var sendText = function(save, id, data) {
            $.ajax({
                type:"post",
                url:"adminDataAPI.php",
                data:{'save':save, 'id':id, 'data':data},
                dataType:"text",
                success:function(ret){
                    if(ret === 'success'){
                        alert("更新成功");
                        window.location.reload()
                    }else{
                        alert("更新失败");
                    }
                },
                error:function(ret){
                    alert("网络故障，稍后重试 " + ret);
                }
            });
        };
    //获取数据
    var getText = function(query, id, fn) {
        var data;
        $.ajax({
                type:"post",
                url:"adminDataAPI.php",
                data:{'query':query, 'id':id},
                dataType:"text",
                success:function(ret){
                    //console.log(ret);
                    data = JSON.parse(ret);
                    fn(data);
                },
                error:function(ret){
                    alert("网络故障，稍后重试 " + ret);
                }
        });
        return data;
    }
    //删除数据
    var deleteText = function(deleteTable, id) {
        $.ajax({
                type:"post",
                url:"adminDataAPI.php",
                data:{'delete':deleteTable, 'id':id},
                dataType:"text",
                success:function(ret){
                    if(ret === 'success'){
                        alert("删除成功");
                        window.location.reload()
                    }else{
                        alert("删除失败");
                    }
                },
                error:function(ret){
                    alert("网络故障，稍后重试 " + ret);
                }
        });
    }
    //获取当前日期
    var getDate = function() {
        var date = new Date();
        return date = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
    }
    //加载简介中心文章
    var parseCenter = function(content) {
        content = content[0]
        $('#editor').html(content.content);
        $('#addTime').attr('value',content.add_time);
        $('#nowTime').attr('value',getDate());
    }
    if( page === 'adminCenter') {
        getText('vlab_disc', 'last', parseCenter);
        $('#save').click(function() {
            var data = {}
            data.content = $('#editor').html();
            data.add_time = $('#nowTime').val();
            sendText('vlab_disc', 'no', data);
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
    if( page === 'adminDevice') {
        getText('vlab_device', 'all', parseDevice)
        $('#new').click(function() {
            var data = {};
            $('#editTr').children().each(function(index,ele) {
                var id = $(ele).find('input').attr('id');
                if(id)
                    data[id] = $(ele).find('input').val();
            });
            data.disc = $('#editor').html();
            sendText('vlab_device', 'no', data);
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
                sendText('vlab_device', id, data);
            else
                alert('请先读取要修改的文章');
        });
        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).text();
            deleteText('vlab_device', id);
        });
        $('.table').on('click', '.items', function() {
            var id = $(this).find('td').eq(0).html();
            getText('vlab_device', id, parseItems);
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
    if(page === 'adminNews') {
        $('#nowTime').attr('value',getDate());
        getText('vlab_news', 'all', parseNewsTable);

        $('#new').click(function() {
            var data = {};
            data.title = $('#title').val();
            data.content = $('#editor').html();
            data.add_time = $('#nowTime').val();
            sendText('vlab_news', 'no', data);
            $('#save').attr('data-target-id','');
        });
        $('#save').click(function() {
            var data = {};
            var id = $('#save').attr('data-target-id');
            if(id){
                data.title = $('#title').val();
                data.content = $('#editor').html();
                data.add_time = $('#nowTime').val();
                sendText('vlab_news', id, data);
            }else{
                alert('请先读取要修改的文章');
            }
        });

        $('.table').on('click', '.read', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            $('#save').attr('data-target-id', id);
            getText('vlab_news', id, parseNews);
        });

        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            deleteText('vlab_news', id);
        });

    }
    if(page === 'adminRule') {
        $('#nowTime').attr('value',getDate());
        getText('vlab_rule', 'all', parseNewsTable);

        $('#new').click(function() {
            var data = {};
            data.title = $('#title').val();
            data.content = $('#editor').html();
            data.add_time = $('#nowTime').val();
            sendText('vlab_rule', 'no', data);
            $('#save').attr('data-target-id','');
        });
        $('#save').click(function() {
            var data = {};
            var id = $('#save').attr('data-target-id');
            if(id){
                data.title = $('#title').val();
                data.content = $('#editor').html();
                data.add_time = $('#nowTime').val();
                sendText('vlab_rule', id, data);
            }else{
                alert('请先读取要修改的文章');
            }
        });

        $('.table').on('click', '.read', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            $('#save').attr('data-target-id', id);
            getText('vlab_rule', id, parseNews);
        });

        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            deleteText('vlab_news', id);
        });

    }
    if(page === 'adminResource') {
        $('#nowTime').attr('value',getDate());
        getText('vlab_resource', 'all', parseNewsTable);

        $('#new').click(function() {
            var data = {};
            data.title = $('#title').val();
            data.content = $('#editor').html();
            data.add_time = $('#nowTime').val();
            sendText('vlab_resource', 'no', data);
            $('#save').attr('data-target-id','');
        });
        $('#save').click(function() {
            var data = {};
            var id = $('#save').attr('data-target-id');
            if(id){
                data.title = $('#title').val();
                data.content = $('#editor').html();
                data.add_time = $('#nowTime').val();
                sendText('vlab_resource', id, data);
            }else{
                alert('请先读取要修改的文章');
            }
        });

        $('.table').on('click', '.read', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            $('#save').attr('data-target-id', id);
            getText('vlab_resource', id, parseNews);
        });

        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).html();
            deleteText('vlab_resource', id);
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
                    + '  <td>' + data[i].major + '</td>'
                    + '  <td>' + data[i].degree + '</td>'
                    + '  <td>' + data[i].add_time + '</td>'
                    + '  <td>' + data[i].web_page + '</td>'
                    + '  <td><button class="read btn btn-xs btn-primary">修改</button>'
                    +'      <button class="delete btn btn-xs btn-danger">删除</button></td>'
                    +'</tr>';
            $('#showTable').append(tr[i]);
        }
    }
    if(page === 'adminTeacher') {
        getText('vlab_teacher', 'all', parseTeacher);
        $('#new').click(function() {
            var data = {};
            $('#editTr').children().each(function(index,ele) {
                var id = $(ele).find('input').attr('id');
                if(id)
                    data[id] = $(ele).find('input').val();
            });
            data.disc = $('#editor').html();
            sendText('vlab_teacher', 'no', data);
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
                sendText('vlab_teacher', id, data);
            else
                alert('请先读取要修改的文章');
        });
        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).text();
            deleteText('vlab_teacher', id);
        });
        $('.table').on('click', '.items', function() {
            var id = $(this).find('td').eq(0).html();
            getText('vlab_teacher', id, parseItems);
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
            getText('vlab_title', 'all', parseTitle('title'));
            getText('vlab_degree', 'all', parseTitle('degree'));
        }else{
            getText('vlab_major', 'all', parseTitle('major'));
        }
        var newData = function(table) {
            var data = {};
            $('#' + table).children().each(function(index,ele) {
                var id = $(ele).find('input').attr('id');
                if(id)
                    data[id] = $(ele).find('input').val();
            });
            sendText(table, 'no', data);
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
            deleteText(table, id);
        });
    }
});