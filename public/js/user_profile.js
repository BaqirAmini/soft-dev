$(document).ready(function () {
    // New User Reg
    $('#new_user_form').on('submit', function (e) { 
            e.preventDefault();
            var formValues = new FormData(this);
            // Send form values through AJAX
            $.ajax({
                type: "POST",
                url: "/manageUser/register",
                data: formValues,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.result === 'success') {
                        $('#modal-new-user').modal('hide');
                        // $('#data_tbl1').load(' #data_tbl1');
                        setTimeout(function () { 
                            location.reload();
                         }, 5000);
                        
                        // location.reload();
                    } else if(response.result === 'over') {
                        $('ul#status_msg').css('display', 'block');
                        $('ul#status_msg').html('<li>' + response.user_msg + '</li>');
                        $('#modal-new-user').modal('hide');
                        $('#add_user').prop('disabled', true);
                        $('#add_user').removeClass('btn btn-primary btn-sm');
                        $('#add_user').addClass('btn btn-default btn-sm');
                    } else if(response.result === 'fail') {
                        $('#modal-new-user').modal('show');
                    }
                    $('ul#role-msg').css('display', 'block');
                    $('ul#role-msg').attr('style', response.style);
                    $('button#new_user').attr(response.style);
                    $('ul#role-msg').html('<li>' + response.user_msg + '</li>');
                    $('ul#role-msg').attr(response.style);
                    // $('#data_tbl1').load(' #data_tbl1');
                },
                error: function (error) { 
                    console.log(error);
                    // $('button#new_user').attr(error.style);
                    // $('ul#role-msg').css('display', 'block');
                    // $('ul#role-msg').text('<li></li>' + response.user_msg);
                 }
            });
     });

     // New Super-admin
    $('#form-new-super-admin').on('submit', function (e) {
        e.preventDefault();
        var formValues = new FormData(this);
        // Send form values through AJAX
        $.ajax({
            type: "POST",
            url: "super-admin/create",
            data: formValues,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                $('#sa_msg  p').html('<ul><li>' + response.super_msg+'</li></ul>');
                $('#sa_msg  p').attr('style', response.style);
                $('#super_admin_data_tbl').load(' #super_admin_data_tbl');
                if (response.super_msg == 'Super admin added successfully!') {
                    $('#modal-new-super-admin').modal('open');
                    $('#modal-new-super-admin').load(' #modal-new-super-admin');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
     // /. New Super-admin

    // form-data for changing user-profile
    $('#user-edit-profile-form').on('submit', function (e) { 
        e.preventDefault();
        var data = new FormData(this);
        // Send them through AJAX
        $.ajax({
            type: "POST",
            url: "/manageUser/userInfo1",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                $('#profile_msg').html(response.message);
                $('#profile_msg').attr('style', response.style);
                // $('#user_profile_box').load(' #user_profile_box');
                
            },
            error: function (error) { 
                console.log(error);
             }
        });
     });

     /* ==================================== UPDATE PASSWORD ====================== */
    $('#password_edit_form').on('submit', function (e) { 
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: "POST",
            url: "/manageUser/userInfo2",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            success: function (response) {
                $('#profile_msg').html(response.message);
                $('#profile_msg').attr('style', 'display:block');
                $('#profile_msg').attr('style', response.style);
            },
        error: function (error) { 
            console.log(error);
         }
        });
     });
     /* ================================== /. UPDATE PASSWORD ======================== */
     

    /* ========================== PREVIEW IMAGE BEFORE UPLOAD ================ */ 
    $('#user_profile_photo').change(function () {
        photo = $('input[name=user_photo]').val();
        var img = new FormData($('#user-profile-photo-form')[0]);
        $.ajax({
            type: "POST",
            url: "/manageUser/userPhoto",
            data: img,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                $('#user_profile_img').html(response.message);
                $('#user_profile_img').attr('style', 'display:block');
                // $('#user-profile-photo-form').load(' #user-profile-photo-form');
                location.reload();
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
             reader.onload = function (e) {
                 $('#user_profile_img').attr('src', e.target.result)
             }
             reader.readAsDataURL(input.files[0]);
         }
     }
   /* ===========================/. PREVIEW IMAGE BEFORE UPLOAD ===================== */ 
});

var photo = '';
