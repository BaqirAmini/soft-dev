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
});