$(document).ready(function () {
    $('#btn_print_reports').click(function () { 
        var printContents = document.getElementById('report_print_area').innerHTML;
        w = window.open();
        w.document.write("<link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\" media=\"print\"/>");
        w.document.write(printContents);
        w.document.write('<scr' + 'ipt type="text/javascript">' + 'window.onload = function() { window.print(); window.close(); };' + '</sc' + 'ript>');

        w.document.close(); // necessary for IE >= 10
        w.focus(); // necessary for IE >= 10

     });

     /* =================================== ANALYTICS in dashboard =================================== */
    $('#analytic').change(function () { 
       var t = $(this).val();
       $.ajax({
           type: "GET",
           url: "/dashboard/" + t,
           data: {'time':t},
           dataType: "json",
           success: function (response) {
               $('#atc_title').text(response.schedule + ' Sales');
               $('#atc_total').text('$' + response.total);
               $('#atc_recieved').text('$' + response.recieved);
               $('#atc_cash').text('$' + response.cash);
               $('#atc_master').text('$' + response.master);
               $('#atc_debit').text('$' + response.debit);
               $('#atc_recievable').text('$' + response.recievable);
           }
       });
     });
     /* ===================================/. ANALYTICS in dashboard =================================== */
});