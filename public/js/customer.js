$(document).ready(function () {
   
    $('#modal-customer').on('click', '#btn_add_customer', function () { 

            var businessName = $('input[name=business_name]').val();
            var custName = $('input[name=cust_name]').val();
            var custLastName = $('input[name=cust_lastname]').val();
            var custPhone = $('input[name=cust_phone]').val();
            var custEmail = $('input[name=cust_email]').val();
            var custState = $('input[name=cust_state]').val();
            var custَAddress = $('input[name=cust_addr]').val();
            var token = $('input[name=_token]').val();
           
           $.ajax({
               type: "POST",
               url: "customer",
               dataType: 'json',
               data: {
                   'cBName':businessName, 
                   'cName':custName, 
                   'cLastName':custLastName,
                   'cPhone':custPhone,
                   'cEmail':custEmail,
                   'cState':custState,
                   'cAddr':custَAddress,
                   '_token':token
                    },
            
               success: function (response) {
                   if (response.result === 'success') {
                       $('#modal-customer').modal('hide');
                       location.reload();
                   } else {
                       $('#modal-customer').modal('show');
                   }
                   $('#cust_message').css(
                       {
                           'display':'block',
                           'margin-top':'10px',
                           'text-align': 'center'
                   });
                   $('#cust_message').text(response.message);
                   $('#cust_message').attr('style', response.style);
                   $('#data_tbl5').load(' #data_tbl5');
                   // location.reload();
                
               },
               error: function (error) { 
                   console.log(error);
                }
           });  
     });

     // ============================ EDIT CUSTOMER ======================== 
    $('#btn_enable_cust_edit').click(function () { 
        $('#profile input').prop('readonly', false);
        $('#profile button').prop('disabled', false);
        // for links attr used instead of prop
        $('#profile a[type="button"]').attr('disabled', false);
        $(this).removeClass('btn btn-primary');
        $(this).addClass('btn btn-default');
        $(this).prop('disabled', true);
     });
    $('#cust-edit-profile-form').on('submit', function (e) { 
        e.preventDefault();
        
            var custData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/customer/edit",
                data: custData,
                contentType: false,
                processData: false,
                cache: false,
                dataType: "json",
                success: function (response) {
                    $('#profile_msg').css('display', 'block');
                    $('#profile_msg').html('<li>' + response.cust_msg + '</li>');
                    // $('#cust-edit-profile-form').load(' #cust-edit-profile-form');
                    setTimeout(function () { 
                        location.reload();
                     }, 2000);
                },
                error: function (error) {  
                    console.log(error);
                }
            });
     });
     // ============================ /. EDIT CUSTOMER ======================== 

     // when customer delete-icon clicked...
     $('#data_tbl5').on('click', '.delete-customer', function () { 
            var custId = $(this).data('cust-id');
            $('#modal-delete-customer input[name=cust_id]').val(custId);
            
      });
 // Customer profile & balance
    $('#data_tbl5').on('click', '.customer-detail', function () { 
            var custId = $(this).data('cust-id');
            href = "customer/custDetail/" + custId;
            $(this).attr('data-href', href);
            window.location = $(this).data('href');
     });  

     // When purchase-history link clicked
     $('#purchase_history').click(function () { 
            var custId = $(this).data('pur-cust-id');
            var href = "customer/purHistory/"+custId;
            $(this).attr('data-href', href);
            window.location = $(this).data('href');
      });

      /** ================================ INVOICE DETAIL ============================= */
    $('.invoice_detail').click(function () { 
        var invoiceId = $(this).data('inv-id');
        href = "invoice/detail/" + invoiceId;
        $(this).attr('data-href', href);
        window.location = $(this).data('href');
     });
      /** ================================/. INVOICE DETAIL ============================= */

});


// to delete cusotmer
function deleteCustomer() {

    var custId = $('input[name=cust_id').val();
       $.ajax({
           type: "GET",
           url: "customer/delete",
           data: {'custId': custId},
           success: function (response) {
               console.log(response);
               $('#modal-delete-customer').modal('hide');
               $('#data_tbl5').load(' #data_tbl5');
           },
           error: function (error) { 
               console.log(error);
            }
       });
}
