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
                 $('#user_profile_img').attr('src', e.target.result);
             }
             reader.readAsDataURL(input.files[0]);
         }
     }
   /* ===========================/. PREVIEW IMAGE BEFORE UPLOAD ===================== */

    /*===================================== Change ANY-USER-INFO-by SYSTEM-ADMIN================================*/
    $('#data_tbl1').on('click', '.which-user', function () {
       var userId = $(this).data('user-id');
       $(this).attr('data-href', 'manageUser/anyProfile/'+userId);
       window.location = $(this).data('href');
    });

    // Change personal-info
    $('#any_user_edit_info').on('submit', function (e) {
       e.preventDefault();
       var data = new FormData(this);
       $.ajax({
           type: 'POST',
           url: '/manageUser/anyProfile/editInfo1',
           data: data,
           dataType: 'json',
           processData: false,
           contentType: false,
           cache: false,
           success: function (response) {
               if (response.result === 'success') {
                   setTimeout(function () {
                       location.reload();
                   }, 3000);

               }
               $('#any_user_msg').css('display', 'block');
               $('#any_user_msg').html(response.msg);
               $('#any_user_msg').attr('style',response.style);
           },
           error: function (e) {
               console.log(e);
           }
       });

    });

    // Reset password
    $('#any_user_reset_password').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
       $.ajax({
          type: 'POST',
          url: '/manageUser/anyProfile/editInfo2',
          data: data,
          dataType: 'json',
           contentType: false,
           processData: false,
           cache: false,
           success:function (response) {
              if (response.result === 'success') {
                  setTimeout(function () {
                      location.reload();
                  }, 3000);
              }
               $('#any_user_msg').css('display', 'block');
               $('#any_user_msg').html(response.msg);
               $('#any_user_msg').attr('style',response.style);
           },
           error:function (err) {
               console.log(err);
           }
       });
    });

    // Change any-user photo
    $('#any_user_photo').change(function () {
        var formData = new FormData($('#any_user_edit_photo_form')[0]);
        $.ajax({
           type: 'POST',
            url: '/manageUser/anyProfile/changePhoto',
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            data: formData,
            success:function (response) {
               if (response.result === 'success') {
                   setTimeout(function () {
                       location.reload();
                   }, 3000);
               }
                $('#any_user_msg').css('display', 'block');
                $('#any_user_msg').html(response.msg);
                $('#any_user_msg').attr('style',response.style);
            },
            error:function (err) {
                console.log(err);
            }

        });
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#any_user_img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    /*===================================== /. Change ANY-USER-INFO-by SYSTEM-ADMIN================================*/


    /* =================================== Change any-system-admin info by SUPER-ADMIN ===========================*/
    $('.any_system_admin_link').click(function () {
        var id = $(this).data('sa-id');
        var href = "/system-admin/anyProfile/" + id;
        $(this).attr('data-href', href);
        window.location = $(this).data('href');
    });

    // Change personal Info
    $('#any_system_admin_edit_info').on('submit', function (e) {
       e.preventDefault();
       var formData = new FormData(this);
       $.ajax({
          type: 'POST',
          url: '/system-admin/anyProfile/editInfo1',
          data: formData,
          processData: false,
          contentType: false,
          cache: false,
          dataType: 'json',
          success: function (response) {
              if (response.result === 'success') {
                  setTimeout(function () {
                      location.reload();
                  }, 3000);
              }
              $('#any_system_admin_msg').css('display', 'block');
              $('#any_system_admin_msg').html(response.msg);
              $('#any_system_admin_msg').attr('style',response.style);
          },
          error: function (err) {
              console.log(err);
          }
       });
    });

    // Change PASSWORD
    $('#any_system_admin_reset_password').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/system-admin/anyProfile/editInfo2',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            success: function (response) {
                if (response.result === 'success') {
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
                $('#any_system_admin_msg').css('display', 'block');
                $('#any_system_admin_msg').html(response.msg);
                $('#any_system_admin_msg').attr('style',response.style);
            },
            error: function (err) {
                console.log(err);
            }
        });
    });

    // Change any-system-admin photo
    $('#any_system_admin_photo').change(function () {
        var formData = new FormData($('#any_system_admin_edit_photo_form')[0]);
        $.ajax({
            type: 'POST',
            url: '/system-admin/anyProfile/editPhoto',
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            data: formData,
            success:function (response) {
                if (response.result === 'success') {
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
                $('#any_system_admin_msg').css('display', 'block');
                $('#any_system_admin_msg').html(response.msg);
                $('#any_system_admin_msg').attr('style',response.style);
            },
            error:function (err) {
                console.log(err);
            }

        });
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#any_system_admin_img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    /* ===================================/. Change any-system-admin info by SUPER-ADMIN ===========================*/
});

var photo = '';
