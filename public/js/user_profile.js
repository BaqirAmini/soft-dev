$(document).ready(function () {
    // New User Reg
    $('#new_user_form').on('submit', function (e) { 
            e.preventDefault();
            var formValues = new FormData(this);
            // Send form values through AJAX
            $.ajax({
                type: "POST",
                url: "manageUser/register",
                data: formValues,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    $('#modal-new-user').modal('hide');
                    $('p#role-msg').css('display', 'block');
                    $('p#role-msg').attr('style', response.style);
                    $('button#new_user').attr(response.style);
                    $('p#role-msg').text(response.user_msg);
                    $('p#role-msg').attr(response.style);
                    $('#data_tbl1').load(' #data_tbl1');
                },
                error: function (error) { 
                    $('button#new_user').attr(error.style);
                    $('p#role-msg').css('display', 'block');
                    $('p#role-msg').text(response.user_msg);
                 }
            });
     });

    // Change user-profile-photo
    $('#user-profile-picture-form').on('submit', function (e) { 
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "manageUser/profilePhoto",
            data: new FormData(this),
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                $('#message').css('display', 'block');
                $('#message').html(data.message);
                $('#message').attr('style', data.style);
                $('#uploaded_image').html(data.uploaded_image);
            },
            error: function (error) { console.log(error); }
        });
     });


    // form-data for changing user-profile
    $('#user-edit-profile-form').on('click', '#btn_update_profile', function (e) { 
        e.preventDefault();
        var userId = $('input[name=user_id').val();
        
        var userName = $('input[name=user_name').val();
        var userLastName = $('input[name=user_lastname').val();
        var userPhone = $('input[name=user_phone').val();
        var userEmail = $('input[name=user_email').val();
        var userCurrentPass = $('input[name=current_password').val();
        var userNewPass = $('input[name=new_password').val();
        var confirmPass = $('input[name=password_confirmation').val();
        var token = $('input[name=_token').val();
        // Send them through AJAX
        $.ajax({
            type: "POST",
            url: "manageUser/profile",
            data: {
            'userId':userId,
            'userName':userName,
            'userLastName':userLastName,
            'userPhone':userPhone,
            'userEmail':userEmail,
            'currentPass':userCurrentPass,
            'newPass':userNewPass,
            'confirmPass':confirmPass,
            '_token':token
            },
            success: function (response) {
                $('#user-msg').html(response).css('color', 'red');
                $('.main-header').load(' .main-header');
                // $('#user-edit-profile-form').load(' #user-edit-profile-form');
            },
            error: function (error) { 
                console.log(error);
             }
        });
     });
});