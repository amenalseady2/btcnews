function showUploadPdfContent()
{
    $("#uploadPdfContentFile").click();
}

function uploadPdfContent()
{
    $("#overlay").show();
    var bookId = $("#bookId").val();
    var formData = new FormData();
    var uploadFile = $("#uploadPdfContentFile")[0].files[0];
    if(uploadFile.size<41943040)
    {                  
        formData.append("pdf",uploadFile);
        $.ajax({ 
            url : '/admin/book/pdfContent/uploadPdf/'+bookId, 
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











