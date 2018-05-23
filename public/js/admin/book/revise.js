$("[data-mask]").inputmask();

$("#fristCategoryId").change(function(){

    var id  = $("#fristCategoryId").val();
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
                var htmlString = '';
                for(var i=0;i<bookCategories.length;i++)
                {
                    var category = bookCategories[i];
                    htmlString += '<option value="'+category.id+'" >'+category.name+'</option>';
                }
                $("#secondCategoryId").html(htmlString);

            }else{
                var htmlString = '<option value="0" >Null</option>';
                $("#secondCategoryId").html(htmlString);
            }
        },  
        error : function() {  
           alert("exception!");  
        }  
    });
});


$("#bookTag").select2({
    ajax: {
        url: "/admin/book/tag/getByKeyword",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            var query = {
                keyword: params.term,
                page: params.page
            }
            return query;
        },
        processResults: function (response, params) {
            return {
                results: $.map(response.data.bookTags, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
        }
    }
});









