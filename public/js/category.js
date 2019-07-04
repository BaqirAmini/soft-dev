$(document).ready(function () {
    // New Category
    $('#new_ctg_form').on('submit', function (e) { 
        e.preventDefault();
        var ctgData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "category/add",
            data: ctgData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                $('#ctg_message').css('display', 'block');
                $('#ctg_message').html('<li>'+response.ctg_msg+'</li>');
                $('#ctg_message li').attr('style', response.style);
                $('input[name=ctg_name]').val('');
                $('input[name=ctg_desc]').val('');
                $('#data_tbl4').load(' #data_tbl4');
            }, 
            error: function (error) { 
                console.log(error);
             }
        });
     });
    // New Category

    // Edit Category
    $('#data_tbl4').on('click', '.btn-edit-ctg', function () { 
            var ctgId = $(this).data('ctg-id');
            var ctgName = $(this).data('ctg-name');
            var ctgDesc = $(this).data('ctg-desc');
            var modal = $('#modal-edit-category');
             modal.find('input#ctgId').val(ctgId);
             modal.find('#ctg_name').val(ctgName);
             modal.find('#ctg_desc').val(ctgDesc);
     });
    // Delete Category
    $('#data_tbl4').on('click', '.btn-delete-ctg', function (param) { 
        var ctgId = $(this).data('ctg-id');
        var modal = $('#modal-delete-category');
        modal.find('input#ctg_id').val(ctgId);
        
     });
     $('#modal-delete-category').on('click', '#btn-delete-ctg', function () { 
            var id = $('input#ctg_id').val();
            $.ajax({
                type: "GET",
                url: "category/delete",
                data: {'cid': id},
                dataType: "json",
                
                success: function (response) {
                    $('#modal-delete-category').modal('hide');
                    $('span#msg').text(response.msg);
                    $('span#msg').attr('style', response.style);
                    $('#data_tbl4').load(' #data_tbl4');
                }
            });
      });
     // Now edit Category
     $('#edit-category-form').on('submit', function (e) { 
         e.preventDefault();
         $.ajax({
             type: "POST",
             url: "category/edit",
             data: new FormData(this),
             dataType: "json",
             processData: false,
             contentType: false,
             cache: false,
             success: function (response) {
                 $('#modal-edit-category').modal('hide');
                 $('span#msg').text(response.msg);
                 $('span#msg').attr('style', response.style);
                 $('#data_tbl4').load(' #data_tbl4');
             },
             error: function (error) { 
                 console.log(error);
              }
         });
      });


});

// now delete category
function deleteCategory(cid) {
   /* var modal = $('#modal-delete-category');
    var ctgId = modal.find('input#ctg_id').val(); */
    var ctgId = cid;
    
    // send id through AJAX
    $.ajax({
        type: "GET",
        url: "category/delete",
        data: {'cid': ctgId},
        dataType: 'json',
        processData: false,
        contentType: false,
        cache:false,
        success: function (response) {
            // $('#modal-delete-category').modal('hide');
            // $('span#msg').text(response.msg);
            console.log(response.code);
        },
        error: function (error) { 
            console.log(error);
         }
    });
}

