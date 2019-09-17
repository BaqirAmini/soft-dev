$(document).ready(function () {
    /* =========================== btn to show message for no due ====================================*/
    $('.link_btn_no_due').click(function () {
       $('.no-due-message').text('No due amount for this invoice to pay.');
       $('.no-due-message').addClass('text-primary');
    });
    /* =========================== /.btn to show message for no due ====================================*/
    /* ================================== Register NEW-CUSTOMER ========================================*/
    $('#form_new_customer').on('submit', function (e) {
        e.preventDefault();
        var d = new FormData(this);
        $.ajax({
            url: '/customer/register',
            type: 'POST',
            data: d,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            success: function (response) {
                if (response.result === 'success') {
                    $('#success_message').html(response.message)
                    $('#success_message').css('display', 'block');
                    $('#success_message').attr('style', response.style);
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    $('#error_message').css('display', 'block');
                    if ($('#error_message').html() !== '') {
                        $('#error_message').html('');
                    }
                    $.each(response.message, function (i, m) {
                        $('#error_message').append('<li>' + m + '</li>');
                        // $('#error_message').load(' #error_message');
                    });
                    $('#error_message').attr('style', response.style);
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });
    /* ==================================/. Register NEW-CUSTOMER ========================================*/

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
        var href = "customer/custDetail/" + custId;
        $(this).attr('data-href', href);
        window.location = $(this).data('href');
    });


    // When purchase-history link clicked
    $('#purchase_history').click(function () {
        var custId = $(this).data('pur-cust-id');
        alert(customerId);
        var href = "customer/purHistory/" + custId;
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

    /** ================================================== Make-payment ======================================================== */
    $('#payment_method2').change(function () {
        var selectedOption = $('#payment_method2 option:selected');
        if (selectedOption.val() === '') {
            $('#btn_make_payment').prop('disabled', true);
        } else if (selectedOption.val() === 'Cash') {
            $('#transaction_code').prop('style', 'display:none');
            $('#btn_make_payment').prop('disabled', false);
        } else if (selectedOption.val() === 'Credit Card' || selectedOption.val() === 'Debit Card') {
            $('#btn_make_payment').prop('disabled', false);
            $('#transaction_code').prop('style', 'display:block');
        }

    });
    // Any payment button in invoice table of customer
    $('.link_make_payment').click(function () {
        var invoiceID = $(this).data('invoice-id');
        $('.hidden_invoice_id').val(invoiceID)
    });

    // To send data to server for make payment
    $('#form-make-payment').on('submit', function (e) {
        e.preventDefault();
        var invData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "/customer/custDetail/payment",
            data: invData,
            contentType: false,
            processData: false,
            cache: false,
            dataType: "json",
            success: function (response) {
                if (response.result === 'success') {
                    $('#modal-make-payment').modal('hide');
                    // $('#transaction').load(' #transaction');
                    location.reload();
                } else {
                    $('#modal-make-payment').modal('show');
                    $('#msg_area').html('<li>' + response.message + '</li>')
                }
                $('#msg_area').css('display', 'block');
                $('#msg_area').attr('style', response.style);
            },
            error: function (err) {
                console.log(err);
            }
        });

    });

    /*$('#form-make-payment').on('submit', function (e) {
        e.preventDefault();
        var fData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "/customer/custDetail/payment",
            data: fData,
            contentType: false,
            processData: false,
            cache: false,
            dataType: "json",
            success: function (response) {
                if (response.result === 'success') {
                    /!*$('#modal-make-payment').modal('hide');
                    $('#transaction').load(' #transaction');*!/
                    location.reload();
                } else {
                    $('#modal-make-payment').modal('show');
                    $('#msg_area').html('<li>' + response.message + '</li>')
                }
                $('#msg_area').css('display', 'block');
                $('#msg_area').attr('style', response.style);
            },
            error:function (err) {
                console.log(err);
             }
        });

     });*/

    /** ==================================================/. Make-payment ======================================================== */


    /* ============================================= Import Excel-file =====================================*/
    $('#excel_import_file').change(function () {
        // readExelURL(this);
        $('#excel_name').val($(this)[0].files[0].name);
    });
    /* =============================================/. Import Excel-file =====================================*/

    /* ================================================ While tab button clicked the edit button on the top whould hide ============================== */
    // To hide edit-button
    $('#tab_transaction').click(function () {
        $('#btn_enable_cust_edit').hide();
    });
    // To show
    $('#tab_comp_profile').click(function () {
        $('#btn_enable_cust_edit').show();
    });
    /* ================================================ /. While tab button clicked the edit button on the top whould hide ============================== */


    /* ========================== UPLOAD customer photo ================ */
    $('#customer_photo').change(function () {
        photo = $('input[name=customer_photo]').val();
        var img = new FormData($('#form_cust_upload_photo')[0]);
        /*$.ajax({
            type: "POST",
            url: "/customer/photo",
            data: img,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                $('#success_message').html(response.msg);
                $('#success_message').attr('style', 'display:block');
                // $('#user-profile-photo-form').load(' #user-profile-photo-form');
                location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });*/
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_customer').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    /* ===========================/. UPLOAD customer photo ===================== */
});


// to delete cusotmer
function deleteCustomer() {

    var custId = $('input[name=cust_id]').val();
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
