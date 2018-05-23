function showUploadImageContentZip()
{
    $("#uploadImageContentZipFile").click();
}

function uploadImageContentZip()
{
    $("#overlay").show();
    var comicsId = $("#comicsId").val();
    var formData = new FormData();
    var zipFile = $("#uploadImageContentZipFile")[0].files[0];
    var comics_chapter_id = $("#comics_chapter_id").val();

    if(zipFile.size<41943040)
    {
        formData.append("zip",zipFile);
        formData.append("comics_chapter_id",comics_chapter_id);
        
        $.ajax({ 
            url : '/admin/book/cartoonContent/uploadZip/'+comicsId, 
            dataType:'json', 
            type : 'POST', 
            data : formData, 
            processData : false, 
            contentType : false,
            success : function(response) {
                alert('success!');
                $("#overlay").hide();
            }, 
            error : function(response) { 
                alert('exception!');
            } 
        });

    }else{
        alert('zip maximum 40M');
    }
}

function destroyImageContent(id)
{
    if(confirm("Are you sure?"))
    {
        var url = '/admin/book/cartoonContent/'+id;
        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: "json", 
            data:{}, 
            success: function( response ) {

                if(response.status == 200)
                {
                    alert('success!');
                    $("#ImageContent_"+id).remove();
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















