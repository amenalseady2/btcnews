function uploadImage(fileId,toInputId)
{
    var imageWidth = $("#"+fileId).attr('imageWidth');
    var imageHeight = $("#"+fileId).attr('imageHeight');

    var formData = new FormData();
    formData.append("uploadFile",$("#"+fileId)[0].files[0]);

    if(imageWidth){
        formData.append("width",imageWidth);
    }

    if(imageHeight){
        formData.append("height",imageHeight);
    }

    $.ajax({ 
        url : '/admin/iamgeUpload', 
        dataType:'json', 
        type : 'POST', 
        data : formData, 
        processData : false, 
        contentType : false,
        success : function(response) {

            if(response.status==200){
                $("#"+toInputId).val(response.data.url);
            }else{
                alert('fail!');
            }
        }, 
        error : function(response) { 
           alert("Can only upload pictures");
        } 
    });
}

function uploadTxt(fileId,toInputId)
{
    var formData = new FormData();
    formData.append("uploadFile",$("#"+fileId)[0].files[0]);
    //formData.append("name",name);
    $.ajax({ 
        url : '/admin/txtUpload', 
        dataType:'json', 
        type : 'POST', 
        data : formData, 
        processData : false, 
        contentType : false,
        success : function(response) {

            if(response.status==200){
                $("#"+toInputId).val(response.data.url);
            }else{
                alert('fail!');
            }
        }, 
        error : function(response) { 
           alert("You can only upload files of type txt");
        } 
    });
}

function buttionSubmit(formId,buttomElement)
{
    $(buttomElement).attr({"disabled":"disabled"});
    $("#"+formId).submit();
}


