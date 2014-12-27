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