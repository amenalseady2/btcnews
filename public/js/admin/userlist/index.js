function destroyUser(id)
{
    if(confirm("确定吗？"))
    {
        var uri = '/admin/user/list/'+id;
        $.ajax( {  
            url:uri,
            data:{},  
            type:'delete',  
            dataType:'json',  
            success:function(response) {  
                if(response.status == 200){
                    if(response.type=='jinyong'){
                        $(".UserinfoBTN_"+id).removeClass('btn-danger');
                        $(".UserinfoBTN_"+id).addClass('btn-info');
                        $(".UserinfoBTN_"+id).html("恢复");
                    }else if(response.type=='huifu'){
                        $(".UserinfoBTN_"+id).removeClass('btn-info');
                        $(".UserinfoBTN_"+id).addClass('btn-danger');
                        $(".UserinfoBTN_"+id).html("禁用");
                    }
                    
                }else{
                    alert("删除失败，请稍后重试");
                }
            },  
            error : function() {  
               alert("异常！");  
            }  
        });
    }
}



