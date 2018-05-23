function showUploadEpubContent()
{
    $("#uploadEpubContentFile").click();
}

function uploadEpubContent()
{
    $("#overlay").show();
    var bookId = $("#bookId").val();
    var formData = new FormData();
    var uploadFile = $("#uploadEpubContentFile")[0].files[0];
    var type = $("input[name='type']:checked").val();

    if(!type)
    {
        alert('please choice epub type');
    }

    if(uploadFile.size<41943040)
    {
        formData.append("type",type);
        formData.append("epub",uploadFile);
        $.ajax({ 
            url : '/admin/book/epubContent/uploadEpub/'+bookId, 
            dataType:'json', 
            type : 'POST', 
            data : formData, 
            processData : false, 
            contentType : false,
            success : function(response) {
                alert("success!");
                $("#overlay").hide();
            }, 
            error : function(response) { 
              alert("exception!");
            } 
        });

    }else{
        alert('pdf maximum 40M');
    }
}











