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
                    fn(data[0]);
                },
                error:function(ret){
                    alert("网络故障，稍后重试 " + ret);
                }
        });
        return data;
    }
    var getDate = function() {
        var date = new Date();
        return date = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
    }
    var parseContent = function(content) {
        $('#editor').html(content.content);
    }
    if( page === 'adminCenter'){
        getText('vlab_disc', 'last', parseContent);
        $('#save').click(function(){
            var data = {}
            data.content = $('#editor').html();
            data.add_time = getDate();
            sendText('vlab_disc', '10', data);
        })
    }
});