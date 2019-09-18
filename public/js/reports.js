$(document).ready(function () {
    /* ----------------------------- Print any invoice of a customer ----------------------------------*/
    $('.print_invoice').click(function () {
        var printContents = document.getElementById('data_tbl_invoice_detail');
        w = window.open();
        w.document.write('<html lang="en"><head><title>' + document.title  + '</title>');
        w.document.write("<link rel=\"stylesheet\" href=\"/css/bootstrap.css\" type=\"text/css\"/>");
        w.document.write("<link rel=\"stylesheet\" href=\"/css/bootstrap-theme.css\" type=\"text/css\"/>");
        w.document.write("<link rel=\"stylesheet\" href=\"/css/styles.css\" type=\"text/css\"/>");
        w.document.write("<script src=\"/js/script.js\"></script>");
        w.document.write('</head><body onload="window.print();window.close()">');
        // Remember OUTERHTML for tables
        w.document.write(printContents.outerHTML);
        w.document.write('</body></html>');
        w.document.close(); // necessary for IE >= 10
        w.focus(); // necessary for IE >= 10
        setTimeout(function () {
            w.print();
        }, 500);
        return false;
    });
    /* ----------------------------- Print any invoice of a customer ----------------------------------*/

    $('.btn_print_reports').click(function () {
        // var printContents = document.getElementsByClassName('report_print_area').innerHTML;
        var printContents = $('.report_print_area').html();
        w = window.open();
        w.document.write('<html><head><title>' + document.title  + '</title>');
        w.document.write("<link rel=\"stylesheet\" href=\"/css/bootstrap.css\" type=\"text/css\"/>");
        w.document.write("<link rel=\"stylesheet\" href=\"/css/bootstrap-theme.css\" type=\"text/css\"/>");
        w.document.write("<link rel=\"stylesheet\" href=\"/css/styles.css\" type=\"text/css\"/>");
        w.document.write('</head><body onload="window.print();window.close()">');
        // w.document.write('<h1>' + document.title  + '</h1>');
        w.document.write(printContents);
        w.document.write('</body></html>');
        w.document.close(); // necessary for IE >= 10
        w.focus(); // necessary for IE >= 10
        setTimeout(function () {
            w.print();
        }, 500);
        return false;
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
               $('#atc_credit').text('$' + response.credit);
               $('#atc_debit').text('$' + response.debit);
               $('#atc_recievable').text('$' + response.recievable);
           }
       });
     });
     /* ===================================/. ANALYTICS in dashboard =================================== */
});
