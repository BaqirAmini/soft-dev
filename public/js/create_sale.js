$(document).ready(function () {
    /** =================================== click btn ADD to insert items in the CART ============================= */
    var tax = $('input#tax').val();
    // $(this).prop('disabled', true);


    // when button add clicked...
    $('.link_add_item').click(function () {
        // printJS('#sale_section', 'html');

        var itemID = $(this).data('item-id');
        var itemName = $(this).data('item-name');
        var itemPrice = $(this).data('item-price');
        var taxable = $(this).data('item-taxable');

        $.ajax({
            type: "POST",
            url: "/cart",
            data: {
                'custID': cid,
                'itemID': itemID,
                'itemName': itemName,
                'itemPrice': itemPrice,
                'itemQty': 1,
                'tax': tax,
                '_token': $('input[name=_token]').val()
            },
            success: function (response) {
                console.log(response);
                $('#stock_message').css({'display': 'block', 'text-align': 'center', 'color': 'darkred'});
                $('#stock_message').html(response.stock_msg);
                /*$('#sale_section').load(' #sale_section'); */
                $('#box_cart').load(' #box_cart');
              /*  setTimeout(function () {
                    window.location.reload();
                }, 5);*/
                // $('#payment_area').load(' #payment_area');
                // $('.tax_value').attr('readonly', response.readonly);

            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    /** =================================== /. click btn ADD to insert items in the CART ============================= */

    /* ===================================== SEARCH customer by name or phone ==================================*/
    $('#search_customer').keyup(function () {
        var query = $(this).val();
        if (query !== '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/customer/search',
                method: 'POST',
                data: {query:query},
                success: function (response) {
                    $('#customer_search_result').fadeIn();
                    $('#customer_search_result').html(response);
                    console.log(response);
                },
                error: function (err) {
                    console.log(err);
                },

            });
        }
    });

    $(document).on('click','.cust_search_li', function () {
       cid = $(this).data('li-id');
        onCreateInvoice(cid);
        // $('#select_payment').css('display', 'block');
        $('#btn_new_customer').prop('disabled', true);
        $('#btn_new_customer').removeClass('btn-primary');
        $('#btn_new_customer').addClass('btn-default');
        $('.btn_print_sale').attr('data-print', cid);
        $('#search_customer').val($('input[name=spn_cust_name]').val());
        // Customer info should be set under search box
        $('.customer_chosen_info').show();
        $('#customer_chosen #link1').text($('input[name=spn_cust_name]').val()+" "+$('input[name=spn_cust_lastname]').val());
        $('#customer_chosen_detail').text($('input[name=spn_seller_permit]').val());
        $('#customer_search_result').fadeOut()
    });

    $('#customer_search_result').mouseleave(function () {
       $(this).fadeOut();
    });

    // when link-remove-customer clicked
    $('#link_remove_customer_chosen').click(function () {
        $('.customer_chosen_info').fadeOut();
    });
    /* ===================================== .SEARCH customer by name or phone ==================================*/


    // BELOW is switched to input element to search customer.


   /* $('#select_customer').change(function () {
      if ($('select#select_customer option:selected').val() == "") {
        $('#select_payment').css('display', 'none');
      } else {
        $(this).attr('style', '');
        $('#select_payment').css('display', 'block');
        $('#btn_new_customer').prop('disabled', true);
        $('#btn_new_customer').removeClass('btn-primary');
        $('#btn_new_customer').addClass('btn-default');
        cid = $(this).val();
        $('.btn_print_sale').attr('data-print', cid);

        // generate invoice-id with customer-selection
        // onCreateInvoice(custID);

      }
    });*/
    // To remove an item from the cart
    $('.btn_remove_sale').click(function () {
        var rowId = $(this).data('item-rid');
        var itemId = $(this).data('item-id');
        var qty = $(this).data('item-qty');
        $.ajax({
            type: "GET",
            url: "cart/removeItem",
            data: {'rowId': rowId, 'itemQty': qty, 'itemId':itemId},
            success: function (response) {
                // $('#sale_section').load(' #sale_section');
                /*setTimeout(function () {
                    location.reload();
                }, 5);*/

            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // when btn-delete-invoice clicked invoice_id should be sent to its modal
    $('#data_tbl_purchase_history').on('click', '.btn_delete_invoice', function () {
        var invoiceId = $(this).data('inv-id');
        $('input[name=cust_inv_id]').val(invoiceId);
    });

    // when BTN-SAVE-SALE clicked
    $('.btn_save_sale').click(function () {
        var invoiceID = $(this).data('invoice-id');
        // set hidden inputs
        $('input[name=cust_id_for_print]').val(cid);
        $('input[name=invoice_id_for_print]').val(invoiceID);
    });
    // /. BTN-SAVE-SALE
});

/** =========================== check CHECKBOX if all amount is paid ============================ */
$('#paid_all').change(function () {

    if ($(this).is(':checked')) {
        if ($('select#payment_type option:selected').val() == "Cash") {
            $('div#rvable').css('display', 'none');
            $('div#rvd').css('display', 'none');
            $('div#trans_area').css('display', 'none');
        } else if ($('select#payment_type option:selected').val() == "Master Card" || $('select#payment_type option:selected').val() == "Debit Card") {
            $('div#rvable').css('display', 'none');
            $('div#rvd').css('display', 'none');
            $('div#trans_area').css('display', 'block');
        }
    } else {
        if ($('select#payment_type option:selected').val() == "Cash") {
            $('div#rvable').css('display', 'block');
            $('div#rvd').css('display', 'block');
        } else {
            $('div#rvable').css('display', 'block');
            $('div#rvd').css('display', 'block');
            $('div#trans_area').css('display', 'block');
        }

    }
});
/** =========================== /. check CHECKBOX if all amount is paid ============================ */
/** ============================================ If ALL AMOUNT is not paid (Is in DEBT) ==================================== */
$('input#recieved').change(function () {
    var payable = $('input#payable').val();
    var recieved = $('input#recieved').val();
    var recieveable = parseFloat(payable) - parseFloat(recieved);
    $('input#payable').val(recieveable);
});

/** ============================================ /. If ALL AMOUNT is not paid (Is in DEBT) ==================================== */
// SELECT PAYMENT METHOD
function selectPayment() {
    var st = $('select#payment_type option:selected');
    if (st.val() == "") {
        $('button#btn_print').prop('disabled', true);
        $('button#btn_print').removeClass('btn btn-primary');
        $('button#btn_print').addClass('btn btn-default');
        $('div#rvable').css('display', 'none');
        $('div#rvd').css('display', 'none');
        $('div#trans_area').css('display', 'none');
        $('#chk_area').css('display', 'none');

    } else if (st.val() == 'Cash') {

        $('#chk_area').css('display', 'block');
        if (!$('#paid_all').is(':checked')) {
            $('div#rvable').show();
            $('div#rvd').show();
            $('div#trans_area').hide();
            $('#recieved').css('border', '2px dotted darkred');
            $('#recieved').prop('placeholder', 'Required');
            // $('#recieved::placeholder').css('color', 'darkred');
            $('#recieved').blur(function () {
               if ($(this).val() == '') {
                   alert('Required');
               } else if (parseInt($('#recieved').val()) <= parseInt($('#payable').val())) {
                   $(this).css('border', '');
                   $(this).prop('placeholder', '');
                   $('button#btn_print').prop('disabled', false);
                   $('button#btn_print').removeClass('btn btn-default');
                   $('button#btn_print').addClass('btn btn-primary');
               } else {

               }
            });
        }

        // $('input#recieved').change(function () {
        //   var payable = $('input#payable').val();
        //   var recieved = $('input#recieved').val();
        //   var recieveable = parseFloat(payable) - parseFloat(recieved);
        //   $('input#payable').val(recieveable);
        // });
    } else if (st.val() == "Master Card" || st.val() == "Debit Card") {
        $('#chk_area').css('display', 'block');
        if (!$('#paid_all').is(':checked')) {
            $('div#trans_area').show();
            $('div#rvable').show();
            $('div#rvd').show();
            $('#recieved').css('border', '2px dotted darkred');
            $('#recieved').prop('placeholder', 'Required');
            $('#transCode').css('border', '2px dotted darkred');
            $('#transCode').prop('placeholder', 'required');

            $('#recieved').blur(function () {
                if ($(this).val() === '') {
                    alert('Required');
                } else if ($('#recieved').val() <= $('#payable').val()) {
                    $(this).css('border', '');
                    $(this).prop('placeholder', '');
                    $('button#btn_print').prop('disabled', false);
                    $('button#btn_print').removeClass('btn btn-default');
                    $('button#btn_print').addClass('btn btn-primary');
                }
            });

            $('#transCode').blur(function () {
                if ($(this).val() !== '') {
                    $(this).css('border', '');
                    $(this).prop('placeholder', '');
                }
            });
        }
    }
}

// When btn-print clicked; two actions are done 1- print the cart 2- data is edited into db.
function onSaveSale() {
    var recieved_amount = 0;
    var recieveable_amount = 0;
    if ($('#paid_all').is(':checked')) {
        recieved_amount = $('span#sub_total').data('sub-total');
    } else {
        recieved_amount = $('input#recieved').val();
        recieveable_amount = $('input#payable').val();
    }
    // var recieved_amount = $('input#recieved').val();
    // var recieveable_amount = $('input#payable').val();
    var pntType = $('#payment_type').val();
    var transCode = $('#transCode').val();
    var tax = $('input.tax_value').val();

    $.ajax({
        type: "POST",
        url: "/sale",
        dataType: "json",
        // data: {'_token': $('input[name=_token]').val()},
        data: {
            'custID': cid,
            'payment': pntType,
            'recieved': recieved_amount,
            'recieveable': recieveable_amount,
            'transCode': transCode,
            'tax': tax,
            '_token': $('input[name=_token]').val()
        },
        success: function (response) {
            $('#inv_message').css('display', 'block');
            $('#inv_message').attr('style', response.style);
            $('#inv_message').html(response.sale_msg);
            $('#inv_message').fadeOut(4000);
            _invoiceID = response.invoice_id;
            // $('#sale_section').load(' #sale_section');
            // setTimeout(function () { location.reload(); }, 5000);

        },
        error: function (error) {
            console.log(error);
        }
    });

}

// ======================= while btn CANCEL or PRINT of print-modal clicked, the page should be refreshed =================================
$('#btn_modal_print button').click(function () {
    location.reload();
});

// ======================= /.while btn CANCEL or PRINT of print-modal clicked, the page should be refreshed =================================

// To generate bill/invoice
function onCreateInvoice(customer) {
    var custID = customer;
    $.ajax({
        type: "POST",
        url: "invoice",
        dataType: "json",
        data: {'custId': custID, '_token': $('input[name=_token]').val()},
        success: function (response) {
            $('p#inv_message').css('display', 'block');
            $('p#inv_message').attr('style', response.style);
            $('p#inv_message').html('<i>' + response.inv_msg + '</i>');
            $('p#inv_message').fadeOut(3000);
            $('.btn_save_sale').attr('data-invoice-id', response.invoice_id);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

// Pay with electronic-cards
function onCard(pntType) {
    var transCode = $('input.t-card').val();
    $.ajax({
        type: "POST",
        url: "sale",
        data: {'payment': pntType, 'transcode': transCode, '_token': $('input[name=_token]').val()},
        dataType: "json",
        success: function (response) {

        }
    });
}

// Print Invoice
// Print invoice
function onPrintInvoice(custID, invcID) {

    $('#modal-print').modal('hide');
    var invoice = document.getElementById('invoice');
    $.ajax({
        type: "GET",
        url: "invoice/print",
        data: {'cid': custID, 'invoiceId': invcID, '_token': $('input[name=_token]').val()},
        success: function (data) {
            var total = 0;
            $('#inv_no').html(data[0].inv_id);
            $('#spn_cust_name').html(data[0].cust_name + " " + data[0].cust_lastname);
            // Company details on bill
            $('#company_name').html(data[0].comp_name);
            $('#company_address').html(data[0].comp_name + "<br>" + data[0].comp_state + ", " + data[0].comp_address + "<br>" + data[0].contact_no + "<br>" + data[0].email + "<br>");
            $('#customer_address #customer_detail').html(data[0].cust_state + ", " + data[0].cust_addr + "<br>" + data[0].cust_phone);
            // Sold-date
            /* var d = new Date(Date.parse(data[0].created_at));
             var date = d.getMonth() + 1 + '/' + d.getDate() + '/' + d.getFullYear();
             $('#sold_date').html('Sold Date: ' + date);*/
            $('#print_table > #invoice_body').empty();
            $.each(data, function (i, elem) {
                $('#print_table > #invoice_body').append('<tr style="border-bottom: 1px darkgray dashed"><td style="text-align: center">'
                    + elem.qty_sold + '</td><td style="text-align: center">'
                    + elem.item_name + '</td><td style="text-align: center">$'
                    + elem.subtotal + '</td></tr>')
                total = parseFloat(total) + parseFloat(elem.subtotal);
            });
            $('#inv_total').html('&nbsp; $' + total);
            doPrint(invoice);
        }
    });


}

$('button.btn_print_sale').click(function () {
    // cid (customer-id) is globally declared.
    var invoiceId = $('input[name=invoice_id_for_print]').val();
    onPrintInvoice(cid, _invoiceID);
});

function doPrint(i) {
    w = window.open('');
    w.document.write('<html><head><title>' + document.title + '</title>');
    w.document.write('</head><body >');
    w.document.write("<link rel=\"stylesheet\" href=\"css/bootstrap.css\" type=\"text/css\"/>");
    w.document.write("<link rel=\"stylesheet\" href=\"css/bootstrap-theme.css\" type=\"text/css\"/>");
    w.document.write("<link rel=\"stylesheet\" href=\"css/styles.css\" type=\"text/css\"/>");
    w.document.write('</head><body onload="window.print();window.close()">');
    w.document.write(i.innerHTML);
    w.setTimeout(function () {
        w.print();
        w.close();
    }, 500);
    w.document.close(); // necessary for IE >= 10
    w.focus(); // necessary for IE >= 10
    return true;

    w.document.write('</body></html>');
    w.document.close(); // necessary for IE >= 10
    w.focus(); // necessary for IE >= 10
    setTimeout(function () {
        w.print();
    }, 200);
    return false;
}

// End
// Print Invoice

// Delete invoice based on a specific customer
function deleteInvoice() {
    var invId = $('input[name=cust_inv_id]').val();
    $.ajax({
        type: "POST",
        url: "invoice/test",
        data: {'invId': invId, '_token': $('input[name=_token]').val()},
        dataType: "json",
        success: function (response) {
            console.log(response.msg);
            // $('#data_tbl_purchase_history').load(' #data_tbl_purchase_history');
        },
        error: function (error) {
            console.log(error);
        }
    });
}

// Delete DAILY-report
function deleteDailyReport() {
    var saleId = $('input[name=daily_sale_id]').val();
    $.ajax({
        type: "GET",
        url: "reports/daily/delete",
        data: {'dSaleId': saleId},
        dataType: "json",
        success: function (response) {

        }
    });
}

// This variable is to fetch customer-id when it is selected;
var cid = '';
var _invoiceID = '';
// /. Delete DAILY-report

