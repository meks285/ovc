$(document).ready(function(){

   $('#vcListTable').DataTable({
        'processing': true,
        'responsive': true,
        'serverSide': true,
        'paging': false,
        'lengthChange': false,                
        'searching': false,         
        'bInfo': false,               
        'serverMethod': 'post',
    'ajax': {
        'url':'./db/getVcList.php?householdUniqueId='+householdUniqueId
    },
    'columns': [
        {data: 'action'},
        {data: 'vc_unique_id'},
       {data: 'name'},
       {data: 'enrollment_date'},
       {data: 'gender'},
       {data: 'age'},
       {data: 'enrollmentstream'},
       {data: 'status'}
   ]
  });       
  


  
 //VC Services Table 
 var testsTable = $('#vcServicesTable').DataTable({
    'processing': true,
    'responsive': true,
    'serverSide': true,
    'paging':false,
    'lengthChange': false,                
    'searching': false,         
    'bInfo': false,               
    'serverMethod': 'post',
'ajax': {
    'url':'./db/getServicesList.php?householdUniqueId='+householdUniqueId
},
'columns': [            //Add + sign button (import font-awesome to work)
          {
              "className":"details-control",
              "orderable":false,
              "data":null,
              "defaultContent":'',
              "render": function(){
                  return '<i class="fa fa-plus-square details-control" aria-hidden="true"></i>'
              },
          },
          {data: 'vc_unique_id'},
          {data: 'service_date'},
          {data: 'total_domain'},
          {data: 'total_services'}
       ],
       'bFilter': false

}); 

function format(d){
    return '<table cellpadding="5" cellspacing="0" style="padding-left: 50px;">'+
            '<tr>' + 
              '<td>VC Unique ID: </td>' +
              '<td>'+ d.vc_unique_id + '</td>' +
              '</tr>'
        }

$('#vcServicesTable tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var tdi = tr.find("i.fa");
    var row = testsTable.row(tr);
                 
    if ( row.child.isShown() ) {
        // This row is already open - close it
        destroyChild(row);
        row.child.hide();
        tr.removeClass('shown');
        tdi.first().removeClass('fa-minus-square');
        tdi.first().addClass('fa-plus-square');
        }
    else {
        // Open this row
        createChild(row);
        //row.child(format(row.data())).show();
        tr.addClass('shown');
        tdi.first().removeClass('fa-plus-square');
        tdi.first().addClass('fa-minus-square');
        }
});
         

function createChild(row) {
    // This is the table we'll convert into a DataTable
    var table = $('<table class="display" width="100% !important" style="background-color: grey !important; padding-left:20px; padding-right: 20px"/>');
 
    // Display it the child row
    row.child(table).show();
 
    // Initialise as a DataTable
    var testResultsTable = table.DataTable( {
        'processing': true,
        'responsive': true,
        'serverSide': true,
        'paging':false,
        'lengthChange': false,                
        'searching': false,         
        'bInfo': false,               
        'serverMethod': 'post',
            'ajax': {
            'url':'./db/getServicesForVC.php',
            data: function ( d ) {
                d.vc_unique_id = row.data().vc_unique_id;
                d.service_date = row.data().service_date;
            }
        },
        columns: [
            { title: 'Service Date', data: 'service_date' },
            { title: 'VC Unique ID', data: 'unique_id' },
            { title: 'Domain', data: 'domain' },
            { title: 'Services Provided', data: 'services' }
        ],
        'bFilter': false
    });        
}
function destroyChild(row) {
    var table = $("table", row.child());
    table.detach();
    table.DataTable().destroy();
 
    // And then hide the row
    row.child.hide();
}
})