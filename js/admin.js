$(document).ready(function(){
    $('#editor').wysiwyg();
    var page = window.location.href.split('=')[1];
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
    var getText = function(query, id, fn) {
        var data;
        $.ajax({
                type:"post",
                url:"adminDataAPI.php",
                data:{'query':query, 'id':id},
                dataType:"text",
                success:function(ret){
                    data = JSON.parse(ret);
                    fn(data);
                },
                error:function(ret){
                    alert("网络故障，稍后重试 " + ret);
                }
        });
        return data;
    }
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
    var getDate = function() {
        var date = new Date();
        return date = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
    }
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
    var parseDevice = function(data) {
        var tr = [];
        for(var i in data){
            tr[i] = '<tr>'
                + '<td>'+ data[i].id + '</td>'
                + '<td>' + data[i].name + '</td>'
                + '<td>' + data[i].type + '</td>'
                + '<td>' + data[i].price + '</td>'
                + '<td>' + data[i].num + '</td>'
                + '<td>' + data[i].maker + '</td>'
                + '<td>' + data[i].buy_time + '</td>'
                + '<td><button class="btn btn-xs btn-primary">修改</button>'
                +      '<button class="delete btn btn-xs btn-danger">删除</button>'
                + '</td>'
            + '</tr>'
            $('.table').append(tr[i]);
        }
    }
    var parseTable = function(data) {
        var obj = {};
        data = data.split('&');
        for( val in data){ 
            var t = data[val].split('=');
            obj[t[0]] = t[1];
        }
        return obj;
    }
    if( page === 'adminDevice') {
        getText('vlab_device', 'all', parseDevice)
        $('.save').click(function() {
            var data = {};
            $(this).closest('tr').children().each(function(index,ele) {
                if($(ele).find('input').attr('name'))
                    data[$(ele).find('input').attr('name')] = $(ele).find('input').val();
            });
            sendText('vlab_device', 'no', data);
        });
        $('.table').on('click', '.delete', function() {
            var id = $(this).closest('tr').children().eq(0).text();
            deleteText('vlab_device', id);
        });
    }
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
    var parseNews = function(data) {
        data = data[0];
        $('#editor').html(data.content);
        $('#title').val(data.title);
        $('#nowTime').attr('value',data.add_time);
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
            deleteText('vlab_news', id);
        });

    }
});