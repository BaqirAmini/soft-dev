 $(document).ready(function () { 
     // load datatable
     $('#Item_data_table').DataTable();
     $('#data_tbl1').DataTable();
  
     // sale-datatable
     $('#data_tbl3').DataTable();
     //categories-datatable
     $('#data_tbl4').DataTable();
  
     //customer-datatable
     $('#data_tbl5').DataTable();
     //daily-report-datatable
     $('#data_tbl6').DataTable();
     $('#data_tbl7').DataTable();
     // company-datatable
     $('#data_comp_tbl').DataTable();
     // Purchase-history
     $('#data_tbl_purchase_history').DataTable();
  
     $('#modal-default').trigger('focus');
     // MORISS chart
   /*  new Morris.Line({
         // ID of the element in which to draw the chart.
         element: 'chart',
         // Chart data records -- each entry in this array corresponds to a point on
         // the chart.
         data: [
           { year: '2008', value: 20 },
           { year: '2009', value: 10 },
           { year: '2010', value: 5 },
           { year: '2011', value: 5 },
           { year: '2012', value: 20 }
         ],
         // The name of the data record attribute that contains x-values.
         xkey: 'year',
         // A list of names of data record attributes that contain y-values.
         ykeys: ['value'],
         // Labels for the ykeys -- will be displayed when you hover over the
         // chart.
         labels: ['Value']
       });
       Morris.Area({
         element: 'sales-chart',
         data: [
           { y: '2006', a: 100, b: 90 },
           { y: '2007', a: 75,  b: 65 },
           { y: '2008', a: 50,  b: 40 },
           { y: '2009', a: 75,  b: 65 },
           { y: '2010', a: 50,  b: 40 },
           { y: '2011', a: 75,  b: 65 },
           { y: '2012', a: 100, b: 90 }
         ],
         xkey: 'y',
         ykeys: ['a', 'b'],
         labels: ['Series A', 'Series B']
       });
       Morris.Bar({
         element: 'anual',
         data: [
           { y: '2006', a: 100, b: 90 },
           { y: '2007', a: 75,  b: 65 },
           { y: '2008', a: 50,  b: 40 },
           { y: '2009', a: 75,  b: 65 },
           { y: '2010', a: 50,  b: 40 },
           { y: '2011', a: 75,  b: 65 },
           { y: '2012', a: 100, b: 90 }
         ],
         xkey: 'y',
         ykeys: ['a', 'b'],
         labels: ['Series A', 'Series B']
       });
       Morris.Donut({
         element: 'weekly',
         data: [
           {label: "Sales A", value: 12},
           {label: "Sales B", value: 30},
           {label: "Sales C", value: 20}
         ]
       }); */
 });
 