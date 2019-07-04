
$(document).ready(function () {
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
            url: "company/admin",
            data: formValues,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                $('#modal-new-user').modal('show');
                $('p#status-msg').css('display', 'block');
                $('p#status-msg').attr('style', response.style);
                $('p#status-msg').text(response.user_msg);
                $('p#status-msg').attr(response.style);
                $('#data_tbl1').load(' #data_tbl1');
                $('#system_admin_form').load(' #system_admin_form');
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
                $('#role-msg').css('display', 'block');
                $('#role-msg').append('<li>'+response.comp_msg+'</li>');
                $('#role-msg').attr('style', response.style);
                $('#new_company_form').load(' #new_company_form');
                $('#modal-new-company').modal('show');
                $('#data_comp_tbl').load(' #data_comp_tbl');
                // $('#modal-new-user').load(' #modal-new-user');
            },
            error: function (error) { 
                console.log(error);
             }
        });
     });
     // Register new company

     
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
   //UPDATE USER-COUNT OF COMPANIES
   $('#data_comp_tbl').on('click', '.btn-set-user-count', function () { 
       var compID = $(this).data('comp-id');
       $('input[name=input_comp_id]').val(compID);
    });     
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


