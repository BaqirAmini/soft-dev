
$(document).ready(function () {
    /* --------------------------- DROPDOWN of modal-user------------------------------*/
    $('#select_role').change(function () {
       var selectedVal = $('#select_role option:selected');
        if (selectedVal.val() === '') {
            $('#btn_save_in_modal_user').prop('disabled', true);
            $('#btn_save_in_modal_user').removeClass('btn-primary');
            $('#btn_save_in_modal_user').addClass('btn-default');
        } else if (selectedVal.val() !== '') {
            $('#btn_save_in_modal_user').prop('disabled', false);
            $('#btn_save_in_modal_user').removeClass('btn-default');
            $('#btn_save_in_modal_user').addClass('btn-primary');
        }
    });
    /* --------------------------- /. DROPDOWN of modal-user------------------------------*/

    // Set user-id inside modal-user
    $('.btn_role').click(function () {
        var userID = $(this).data('user-id');
         var modalUser = $('#modal-user');
         modalUser.find('input#role_id').val(userID);
    });

    // When status-button clicked
    $('#data_tbl1').on('click', '.btn-user-set-status', function () {
        var userId = $(this).data('user-id');
        var statusValue = $(this).data('user-status-value');
        var ref = this;
        $.ajax({
            type: "POST",
            url: "manageUser/status",
            data: {'userId': userId, 'statusValue': statusValue, '_token': $('input[name=_token]').val()},
            dataType: "json",
            success: function (response) {
                $(ref).removeClass(response.remove_class);
                $(ref).addClass(response.add_class);
                $(ref).html(response.label);
                // $('#data_tbl1').load(' #data_tbl1');
                if (response.user_count == "over") {
                    $('#add_user').prop('disabled', true);
                    $('#add_user').removeClass('btn btn-primary btn-sm');
                    $('#add_user').addClass('btn btn-default btn-sm');
                    $('#modal-new-user').modal('hide');
                    $('#status_msg').css('display', 'block');
                    $('#status_msg').attr('style', response.style);
                    $('button#new_user').attr(response.style);
                    $('#status_msg').html('<li>' + response.user_msg + '</li>');
                    $('#status_msg').attr(response.style);
                }
                setTimeout(function () {
                    location.reload();
                }, 2000);
            },
            error: function (error) {
                console.log(error);
             }
        });
     });

    /*=====  End of User Status __ enabling or disabling  ======*/

 });

/** ======================= CHANGE USER-ROLE =============== */
$('#user_role_form').on('submit', function (e) {
    e.preventDefault();
    var roleData = new FormData(this);
    $.ajax({
        type: "POST",
        url: "manageUser",
        data: roleData,
        contentType: false,
        processData: false,
        cache: false,
        dataType: "json",
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            console.log(error);
         }
    });

 });
/** =========================== / change USER-ROLE ===================== */
/* ======================= Super-admin status (Enable/Disable) ===================== */
$('#super_admin_data_tbl').on('click', '.btn-sa-set-status', function () {
    var saId = $(this).data('sa-id');
    var statusValue = $(this).data('sa-status-value');
    var ref = this;
    $.ajax({
        type: "POST",
        url: "super-admin/status",
        data: { 'saId': saId, 'statusValue': statusValue, '_token': $('input[name=_token]').val() },
        dataType: "json",
        success: function (response) {
            $(ref).removeClass(response.remove_class);
            $(ref).addClass(response.add_class);
            $(ref).html(response.label);
            $('#super_admin_data_tbl').load(' #super_admin_data_tbl');
                // $('#btn-new-system-admin').prop('disabled', true);
                // $('#btn-new-system-admin').removeClass('btn btn-primary btn-sm');
                // $('#btn-new-system-admin').addClass('btn btn-default btn-sm');
                // $('#modal-new-user').modal('hide');
                $('p#role-msg').css('display', 'block');
                $('p#role-msg').attr('style', response.style);
                // $('button#new_user').attr(response.style);
                $('p#role-msg').text(response.user_msg);
                $('p#role-msg').attr(response.style);
                $('p#role-msg').text(response.user_msg);
        },
        error: function (error) {
            console.log(error);
        }
    });
});

/* ========================= /. System-admin status ============================== */

/* ============================== Enable/disable status of system-admins by SUPER-USER  */
$('#data_tbl_for_specific_users').on('click', '.btn-system-admin-set-status', function () {
    var userId = $(this).data('user-id');
    var statusValue = $(this).data('user-status-value');
    var ref = this;
    $.ajax({
        type: "POST",
        url: "/systemAdmin/status",
        data: { 'userId': userId, 'statusValue': statusValue, '_token': $('input[name=_token]').val() },
        dataType: "json",
        success: function (response) {
            $(ref).removeClass(response.remove_class);
            $(ref).addClass(response.add_class);
            $(ref).html(response.label);
            $('#data_tbl_for_specific_users').load(' #data_tbl_for_specific_users');
        },
        error: function (error) {
            console.log(error);
        }
    });
});
/* ================================= /. Enable/Disable status of system-admins by SUPER-USERS ============================= */
