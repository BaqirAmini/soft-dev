
$(document).ready(function () {
 var index = $('input[name=index]').val();
 // alert(index + " Existing user counts: " + $('input[name=index]').data('user-count'));
// While clicking on tab Users btn add system admin should get displayed
    $('#tab_users').click(function () {
        var numOfRows = $('input[name=index]').val();
        var numOfRegisteredUsers = $('input[name=index]').val();
       /* if (numOfRows <= numOfRegisteredUsers) {
            $('#btn_system_admin').prop('disabled', true);
        }*/
        $('#btn_system_admin').show();
    });
//  while clicking tab Configure btn add system admin should get hidden
    $('#tab_configure').click(function () {
        $('#btn_system_admin').hide();
    });

// Close new-company-modal when btn-system-admin clicked inside it.
$('#modal-new-company').on('click', '#btn_system_admin', function () {
    $('#modal-new-company').modal('hide');

 });

    // New System Admin Reg...
    $('#system_admin_form').on('submit', function (e) {
        e.preventDefault();
        var formValues = new FormData(this);
        // Send form values through AJAX
        $.ajax({
            type: "POST",
            url: "/company/system-admin",
            data: formValues,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                if (response.result == 'ok') {
                    $('#modal-new-user').modal('hide');
                } else if(response.result == 'fail') {
                    $('#modal-new-user').modal('show');
                }
                $('p#status-msg').css('display', 'block');
                $('p#status-msg').attr('style', response.style);
                $('p#status-msg').text(response.user_msg);
                $('p#status-msg').attr(response.style);
                $('#data_tbl_for_specific_users').load(' #data_tbl_for_specific_users');

            },
            error: function (error) {
                console.log(error);
             }
        });
 });

    // Register new company
    $('#new_company_form').on('submit', function (e) {
        e.preventDefault();
        var compData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "company/register",
            data: compData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                if (response.result === 'ok') {
                    $('#modal-new-company').modal('hide');
                    // $('#data_comp_tbl').load(' #data_comp_tbl');
                    location.reload();
                } else {
                    $('#modal-new-company').modal('show');
                }
                $('#role-msg').css('display', 'block');
                $('#role-msg').append('<li>'+response.comp_msg+'</li>');
                $('#role-msg').attr('style', response.style);
                // $('#modal-new-user').load(' #modal-new-user');
            },
            error: function (error) {
                console.log(error);
             }
        });
     });
     // Register new company
// =================== COMPANY SETTINGS ================== //
      // Go to company settings/configuration
        $('#data_comp_tbl').on('click', '.company-detail-link', function () {
            var compId = $(this).data('comp-id');
            var href = "company/setting/" + compId;
            $('input #hidden_comp_id').val(compId);
            // set a link to this link to go there while clicked
            $(this).attr("data-href", href);
            // Now when this link has the address so, when clicked should take us to a the defined address
            window.location = $(this).data('href');

         });
      // /. settings / configuration

    // Send data to server to edit/configure company
    $('#form-company-detail').on('submit', function (e) {
        e.preventDefault();
        // var compData = new serialize(this);
        var compData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/company/setCompany",
            data: compData,
            dataType: "json",
            success: function (response) {
                $('#conf_msg').css({'display':'block'});
                $('#conf_msg').html(response.msg);
                $('#conf_msg').attr('style', response.style);
                $('#data_comp_tbl').load(' #data_comp_tbl');
            },
            error: function(error) {
                console.log(error);
            }
        });
     })
 // =================== /. COMPANY SETTINGS ====================== //
        // Change logo of a company by SUPER-ADMIN
    $('#company_logo').change(function () {
        var logoData = new FormData($('#form_company_logo')[0]);
        $.ajax({
            type: "POST",
            url: "/company/logo",
            data: logoData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                if (response.result === 'ok') {
                    $('#conf_msg').html('<li>' + response.message + '</li>');
                    $('#conf_msg').css('display', 'block');
                    $('#conf_msg').attr('style', response.style);
                    location.reload();
                } else if(response.result === 'fail') {
                    $('#conf_msg').html('<li>' + response.message + '</li>');
                    $('#conf_msg').css('display', 'block');
                    $('#conf_msg').attr('style', response.style);
                    location.reload();
                }
            },
            error: function (error) {
                console.log(error);
             }
        });
        readURL(this);
     });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#company_logo_img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        // /. change logo of a company by SUPER-USER

       // when status-button of company clicked
       $('#data_comp_tbl').on('click', '.btn-set-status', function () {
           var compId = $(this).data('comp-id');
           var statusValue = $(this).data('comp-status-value');
           var r = this;
           $.ajax({
               type: "POST",
               url: "company/status",
               data: {'compId': compId, 'compStatus': statusValue, '_token': $('input[name=_token]').val()},
               dataType: "json",
               success: function (data) {
               $(r).removeClass(data.remove_class);
               $(r).addClass(data.add_class);
               $(r).html(data.label);
               $('#data_comp_tbl').load(' #data_comp_tbl');

               },
               error: function (error) {
                   console.log(error);
                }
           });

        });
     //Company-status
   /* /!* ------------------------------- company-setting that is configured by SUPER-ADMIN -----------------------------------*!/
    $('#company_user_count').change(function () {
       alert('Ok');
    });
    /!* -------------------------------/. company-setting that is configured by SUPER-ADMIN -----------------------------------*!/*/



   //UPDATE USER-COUNT OF COMPANIES
   // when nothing selected in DROPDOWN
    $('#company_user_count').change(function () {
        var selectedVal = $('#company_user_count option:selected');
        if (selectedVal.val() === '') {
            $('.btn_set_user_count').prop('disabled', true);
            $('.btn_set_user_count').removeClass('btn-primary');
            $('.btn_set_user_count').addClass('btn-default');
        } else if (selectedVal.val() !== '') {
            $('.btn_set_user_count').prop('disabled', false);
            $('.btn_set_user_count').removeClass('btn-default');
            $('.btn_set_user_count').addClass('btn-primary');
        }
    });

   $('#data_comp_tbl').on('click', '.btn-set-user-count', function () {
       var compID = $(this).data('comp-id');
       $('input[name=input_comp_id]').val(compID);
    });


    /* ================================== Settings of A SPECIFIC COMPANY ============================== */
    // note: if contentType & processData is not set false, it gives error in jquery
    $('#form_specific_company_setting').on('submit', function (e) {
        e.preventDefault();
        var compData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "myCompany/setting",
            data: compData,
           contentType: false,
           processData: false,
            dataType: "json",
            success: function (response) {
                if (response.result == "success") {
                    setTimeout(function () {
                        location.reload();
                     }, 3000);
                }
                    $('#comp-setting-msg').css({ 'display': 'block', 'text-align': 'center' });
                    $('#comp-setting-msg').html(response.msg);
                    $('#comp-setting-msg').attr('style', response.style);


            },
            error:function (error) {
                console.log(error);
             }
        });
    });
    // Change only LOGO
    $('#clogo').change(function () {
        var d = new FormData($('#specific_comp_logo_form')[0]);
        $.ajax({
            type: "POST",
            url: "/myCompany/logo",
            data: d,
            contentType: false,
            processData: false,
            cache: false,
            dataType: "json",
            success: function (response) {
                if (response.result === 'success') {
                    setTimeout(function () {
                        location.reload();
                     }, 3000);
                }
                    $('#comp-setting-msg').css('display', 'block');
                    $('#comp-setting-msg').attr('style', response.style);
                    $('#comp-setting-msg').html(response.msg);

            }
        });
        readLogoURL(this);
     });
     function readLogoURL(input) {
         if (input.files && input.files[0]) {
             var reader = new FileReader();
             reader.onload = function (e) {
                 $('#specific_company_logo').attr('src', e.target.result);
              }
            reader.readAsDataURL(input.files[0]);
         }

     }
    /* ===================================== /. settings of A SPECIFIC COMPANY ============================= */
});

// Change User-count of companies now..
function onUserCount() {
    var compId = $('input[name=input_comp_id]').val();
    var userCount = $('select[name=company_user_count]').val();
    $.ajax({
        type: "POST",
        url: "company/userCount",
        data: {'compId': compId, 'userCount': userCount, '_token': $('input[name=_token]').val()},
        dataType: "json",
        success: function (response) {
            $('#modal-edit-user-count').modal('hide');
            $('#status-msg').css('display', 'block');
            $('#status-msg').attr('style', response.style);
            $('#status-msg').html(response.count_msg);
            $('#data_comp_tbl').load(' #data_comp_tbl');

        },
        error: function (error) {
            console.log(error);
         }
    });
}


