$("#firstCategoryId").change(function(){

    var id  = $("#firstCategoryId").val();
    if(id>0)
    {
        var url = '/admin/book/category/getByBookCategoryId/'+id;
        $.ajax( {  
            url:url,
            data:{},  
            type:'get',  
            dataType:'json',  
            success:function(response) {  

                var bookCategories = response.data.bookCategories;
                if(bookCategories.length >0)
                {
                    var htmlString = '<option value="" >All</option>';
                    for(var i=0;i<bookCategories.length;i++)
                    {
                        var category = bookCategories[i];
                        htmlString += '<option value="'+category.id+'" >'+category.name+'</option>';
                    }
                    $("#secondCategoryId").html(htmlString);

                }else{
                    var htmlString = '<option value="" >All</option>';
                    $("#secondCategoryId").html(htmlString);
                }
            },  
            error : function() {  
               alert("exception!");  
            }  
        });
    }else{

        var htmlString = '<option value="" >All</option>';
        $("#secondCategoryId").html(htmlString);
    }

});


