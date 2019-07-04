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
                $('#item_message').css({'display':'block'});
                $('#item_message').attr('style', response.style);
                $('#item_message').append('<br><li>'+response.item_msg+'</li>');
                $('#Item_data_table').load(' #Item_data_table');
                // $('#modal-item').load(' #modal-item');
                // location.reload();

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
    $('#edit_item_form_data input[name=item_id').val(itemId);
    $('#edit_item_form_data input[name=item_name').val(itemName);
    $('#edit_item_form_data input[name=item_desc').val(itemDesc);
    $('#edit_item_form_data input[name=quantity').val(itemQty);
    $('#edit_item_form_data input[name=barcode_number').val(barcode);
    $('#edit_item_form_data input[name=purchase_price').val(itemPurchase);
    $('#edit_item_form_data input[name=sell_price').val(itemSell);
    
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
            $('#modal-edit-item').modal('hide');
            $("#item_message_area").css('display', 'block');
            $("#item_message_area").html(response.edit_msg);
            $("#item_message_area").attr('style', response.style);
            $("#item_message_area").fadeOut(5000);
            $('#Item_data_table').load(' #Item_data_table');
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