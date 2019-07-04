$(document).ready(function () { 
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
                $('#data_tbl1').load(' #data_tbl1');
                
            },
            error: function (error) { 
                console.log(error);
             }
        });
     });
   /* $('#data_tbl1').on('click', '.btn-user-set-status', function () { 
        var userStatus = $(this).data('user-status-value');
        var userId = $(this).data('user-id');
        // alert(userId + " userStatus: " + userStatus);
        if (userStatus == 0) {
            onActivate(userId, userStatus, this)
        } else if(userStatus == 1) {
            onDeactivate(userId, userStatus, this)
        }
     }); */
    
    /*=====  End of User Status __ enabling or disabling  ======*/
    
 });

function setRole() {
    
    var m = $('#modal-user');
    var userID = m.find('input#role_id').val();
    var role = $('input[name="role"]:checked').val();
    $.ajax({
        type: "POST",
        url: "manageUser",
        data: {'id':userID, 'role': role, '_token': $('input[name=_token]').val()},
        success: function (response) {
            m.modal('hide');
            $('p#role-msg').css('display', 'block');
            $('p#role-msg').text(response.role_msg);
            location.reload();
        },
        error: function (error) { 
            console.log(error);
         },
        dataType: 'json'
    });
}
