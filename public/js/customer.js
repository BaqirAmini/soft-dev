$(document).ready(function () {
    $('#modal-customer').on('click', '#btn_add_customer', function () { 
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
                    'cName':custName, 
                    'cLastName':custLastName,
                    'cPhone':custPhone,
                    'cEmail':custEmail,
                    'cState':custState,
                    'cAddr':custَAddress,
                    '_token':token
                     },
                
                success: function (response) {
                    $('#modal-customer').modal('hide');
                    $('#cust_message').css(
                        {
                            'display':'block',
                            'margin-top':'10px',
                            'text-align': 'center'
                    });
                    $('#cust_message').text(response.message);
                    $('#cust_message').attr('style', response.style);
                    $('#data_tbl5').load(' #data_tbl5');
                    location.reload();
                },
                error: function (error) { 
                    console.log(error);
                 }
            });  
     });

     // when customer delete-icon clicked...
     $('#data_tbl5').on('click', '.delete-customer', function () { 
            var custId = $(this).data('cust-id');
            $('#modal-delete-customer input[name=cust_id]').val(custId);
            
      });
 // Customer profile & balance
    $('#data_tbl5').on('click', '.customer-detail', function () { 
            var custId = $(this).data('cust-id');
            var custName = $(this).data('cust-name');
            var custLastname = $(this).data('cust-lastname');
            var custPhone = $(this).data('cust-phone');
            var custEmail = $(this).data('cust-email');
            var custState = $(this).data('cust-state');
            var custAddr = $(this).data('cust-addr');
            $('#activity #custName').html(custName + " " + custLastname);
            $('#activity .description').html(custState + ", " + custAddr);
            $('#activity p#customer-phone').html(custPhone);
            $('#activity p#customer-email').html(custEmail);
            $('#purchase_history').attr('data-pur-cust-id', custId);
            // Invoice & Balance
            $('.invoice-info address strong').html(custName + " " + custLastname);
            $('.invoice-info address p').html(custState + "<br>" + custAddr);
            // /. Invoice & Balance
            $('#customer-profile-form input[name=cust_id').val(custId);
            $('#customer-profile-form #edit_cust_name').val(custName);
            $('#customer-profile-form #edit_cust_lastname').val(custLastname);
            $('#customer-profile-form #edit_cust_phone').val(custPhone);
            $('#customer-profile-form #edit_cust_email').val(custEmail);
            $('#customer-profile-form #edit_cust_state').val(custState);
            $('#customer-profile-form #edit_cust_addr').val(custAddr);
            // when submit-btn clicked...
            $('#customer-profile-form').on('click', '#btn-edit-customer', function (e) { 
                e.preventDefault();
                var cId = $('#customer-profile-form input[name = cust_id]').val();
                var cName = $('#customer-profile-form #edit_cust_name').val();
                var cLastName = $('#customer-profile-form #edit_cust_lastname').val();
                var cPhone = $('#customer-profile-form #edit_cust_phone').val();
                var cEmail = $('#customer-profile-form #edit_cust_email').val();
                var cState = $('#customer-profile-form #edit_cust_state').val();
                var cAddr = $('#customer-profile-form #edit_cust_addr').val();
                // Edit now using AJAX
                $.ajax({
                    type: "POST",
                    url: "customer/edit",
                    data: {'cId':cId, 'cName':cName, 'cLastName':cLastName, 'cPhone': cPhone, 'cEmail':cEmail, 'cState':cState, 'cAddr':cAddr, '_token':$('input[name=_token]').val()},
                    success: function (response) {
                            
                            $('#customer-profile').modal('hide');
                            $('#data_tbl5').load(' #data_tbl5');
                            console.log(response);
                            
                    }
                
                });
             });
     });  

     // When purchase-history link clicked
     $('#purchase_history').click(function () { 
            var custId = $(this).data('pur-cust-id');
            var href = "customer/purHistory/"+custId;
            $(this).attr('data-href', href);
            window.location = $(this).data('href');
      });

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
