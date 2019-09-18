$(document).ready(function () {
  // Add new item
    $('#item_form_data').on('submit', function (e) {
        e.preventDefault();
        var itemData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "item/add",
            data: itemData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response.result === 'success') {
                    $('#modal-item').modal('hide');
                    $('#Item_data_table').load(' #Item_data_table');
                } else if(response.result === 'fail') {
                    $('#modal-item').modal('show');
                }
                $('#item_message').css({'display':'block'});
                $('#item_message').attr('style', response.style);
                $('#item_message').html('<li>'+response.item_msg+'</li>');

             },
             error: function (error) {
                 console.log(error);
              }
        });
     });
     // Deleting items row
$('#Item_data_table').on('click', '.btn_delete_product', function () {
        var itemID = $(this).data('product-id');
        $('input[name=item_id]').val(itemID);
    });


/* ================================== Importing Excel-file ========================================================*/
    $('#excel_file').change(function () {
       $('#item_excel_name').val($(this)[0].files[0].name);
    });
/* ==================================/. Importing Excel-file ========================================================*/
 });

 // Editing items
 $('#Item_data_table').on('click', '.btn_edit_item', function () {
    var itemId = $(this).data('item-id');
    var itemName = $(this).data('item-name');
    var itemDesc = $(this).data('item-desc');
    var itemPurchase = $(this).data('item-purchase');
    var itemSell = $(this).data('item-sell');
    var itemQty = $(this).data('item-qty');
    var barcode = $(this).data('item-barcode');
    $('#edit_item_form_data input[name=item_id]').val(itemId);
    $('#edit_item_form_data input[name=item_name]').val(itemName);
    $('#edit_item_form_data input[name=item_desc]').val(itemDesc);
    $('#edit_item_form_data input[name=quantity]').val(itemQty);
    $('#edit_item_form_data input[name=barcode_number]').val(barcode);
    $('#edit_item_form_data input[name=cost]').val(itemPurchase);
    $('#edit_item_form_data input[name=sell_price]').val(itemSell);

  });

  // Now update items
  $('#edit_item_form_data').on('submit', function (e) {
    e.preventDefault();
    var editData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "item/update",
        data: editData,
        dataType: "json",
        success: function (response) {
            if (response.result === 'success') {
                $('#modal-edit-item').modal('hide');
                // $('#Item_data_table').load(' #Item_data_table');
                setTimeout(function () {
                    location.reload();
                }, 500);
            } else if(response.result === 'fail') {
                $('#modal-edit-item').modal('show');
            }
            $("#item_edit_message").css('display', 'block');
            $("#item_edit_message").html('<li>' + response.edit_msg + '</li>');
            $("#item_edit_message").attr('style', response.style);
        },
        error: function (error) {
            console.log(error);
         }
    });
 });

 // Delete Items/products
 function deleteProduct() {
     var itemId = $('input[name=item_id]').val();
     $.ajax({
         type: "GET",
         url: "item/delete",
         data: {'itemId': itemId},
         processData: false,
         contentType: false,
         cache: false,
         dataType: "json",
         success: function (response) {
             console.log(response.msg);
             $('#modal-delete-item').modal('hide');
             $('#Item_data_table').load(' #Item_data_table');
         },
         error: function (error) {
             console.log(error);
          }
     });
 }
