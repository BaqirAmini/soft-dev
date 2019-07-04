$(document).ready(function () {
    $('#data_tbl3').on('click', '.btn_add_sale', function () {
        var itemID = $(this).data('item-id');
        var itemName = $(this).data('item-name');
        var itemPrice = $(this).data('item-price');
        
        $('input[type=hidden]').attr({'id':itemID, 'value':itemPrice});
        $('#test').append('<div class="row sale-list col-md-12 col-xs-12" style="display:block">'+
        '<input type="hidden">' + 
        '<div class="col-xs-1">'+
           ' <button class="btn btn-danger btn_remove_sale" onclick="deleteSale('+itemID+');"  style="padding:8px;"><i class="fa fa-remove" id = "'+itemID+'"></i></button>'+
        '</div>'+
       '<div class="col-xs-3">'+
          '<input type="text" class="form-control" value="'+itemName+'" placeholder="Item">'+
        '</div>' +
        '<div class="col-xs-2">'+
          '<input type="number" onchange="add('+itemID+');" class="form-control item_qty" min="0" value="1" placeholder="Qty" id="'+itemID+"b"+'">'+
        '</div>' +
        '<div class="col-xs-3">'+
          '<input type="number"  class="form-control" onchange="add('+itemID+');"  min="0" value="'+itemPrice+'" placeholder="Qty" id="'+itemID+"a"+'">'+
        '</div>' +
        '<div class="input-group col-xs-3">'+
          '<span class="input-group-addon">$</span>'+
          '<input type="number" class="form-control"  min="0" step="0.01" placeholder="Sub Total" id="'+itemID+"c"+'">'+
        '</div>'+
     '</div>'+'<br>');
     add(itemID);
      // each row of added sale
         $(this).prop('disabled', true);
         $(this).removeClass('btn btn-primary');
         $(this).addClass('btn btn-default');

         // get tax value
         var taxValue = $('input#tax').val();
         var total = $('input#total').val();
         if (tax !== "") {
            var finalValue = total - ( taxValue * total ) / 100;
         }
        //  // To sum all subtotals for TOTAL
        //  var sum = 0;
        //  for (let i = 0; i < itemID.length; i++) {
        //       sum += $('input#'+itemID+'c').val();
        //       totalInput.val(sum);
        //  }

     });

     // button to save sales into sales-table
     $('#btn_add_sale').click(function () { 
       var billNo = parseInt($('input[name=bill_no]').val());
       var billNo = billNo++;
       $('select#select_customer').prop('required');
          var itemID = $('button.btn_add_sale').data('item-id');
          var cust = $('#select_customer').val();
          var qty = $('input#item_qty').val();
          var subTotal = $('input.subtotal').val();
          var tax = $('input#tax').val();
          var total = $('input#total').val();
          var net_price = (tax / 100) * total + total; 
          $.post("sale", {'billNo': billNo, 'cust': cust, 'item_id': itemID,  'tax': tax, 'netPrice': net_price, 'total':total, '_token': $('input[name=_token]').val()},
            function (data) {
              console.log(data);
              $('input[name=bill_no').val(billNo++);
            }
          );
      });
    
}); 
var sum = 0;
function add(id){ 
          
     var price = $('input#'+id+'a').val();
     var qty = $('input#'+id+'b').val();
     var result = qty * price;
     //alert(result); 
    $('input#'+id+'c').val(result);
    var sub = $('input#'+id+'c').val();
    colculateTotal(parseFloat(sub));
    
 }
  
 function colculateTotal(res)
 {
   var totalInput = $('input#total');
    sum += res;
    totalInput.val(sum);

 }
 // SELECT PAYMENT METHOD
function selectPayment() {
  var st = $('select#payment_type option:selected');
  if (st.val() == 'cache') {
    $('#cache').show();
    $('.t-card').hide();
  } else if (st.val() == "credit card" || st.val() == "debit card") {
    $('.t-card').show();
    $('#cache').hide();
  }
}

// DELETE ANY SALE-ROW
function deleteSale(id) {
  $('div').remove('input#'+id);
  
}