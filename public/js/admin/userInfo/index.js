
function destroy(id)
{
    if(confirm("Are you sure?"))
    {
        var url = '/admin/user/info/'+id;
        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: "json", 
            data:{}, 
            success: function( response ) {

                if(response.status == 200)
                {
                    alert('success!');
                    $("#Userinfo_"+id).remove();
                }else{
                    alert('fail!');
                }
            },  
            error : function() {  
               alert("exception!");  
            }
        });
    }
}















