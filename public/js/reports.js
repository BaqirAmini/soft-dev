$(document).ready(function () {
    $('#data_tbl6').on('click', '.btn-delete-daily-report', function () { 
        var saleId = $(this).data('sale-id');
        var compId = $(this).data('comp-id');
        
        $.ajax({
            type: "GET",
            url: "reports/daily/delete",
            data: {'saleId': saleId, 'compId': compId},
            dataType: "json",
            success: function (response) {
                $('#delete_sale_msg').html(response.delete_msg);
                $('#delete_sale_msg').attr('style',response.style);

            },
            error: function (error) { console.log(error); }
        });
     });
});