
function destroyBookCategory(id)
{

    if(confirm("Are you sure？"))
    {
        var url = '/admin/book/category/'+id;
        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: "json", 
            data:{}, 
            success: function( response ) {

                if(response.status == 200)
                {
                    alert('success!');
                    $("#BookCategory_"+id).remove();
                }else{
                    alert('fail!');
                }
            },  
            error : function( messages ) {  
               
                var messageDatas = messages.responseJSON;
                var info="";
                if(messageDatas.id)
                {
                    for(var i=0;i<messageDatas.id.length;i++)
                    {
                        info+=messageDatas.id[i]+"\n";
                    }                
                }
     
                alert(info);
            }
        });
    }

}











