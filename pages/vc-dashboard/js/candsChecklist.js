$(document).ready(function(){

    $('#careAndSupportTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/getcandsList.php?vc_unique_id='+vcUniqueId
     },
     'columns': [
        {data: 'vc_unique_id'},
        {data: 'hh_unique_num'},
        {data: 'beneficiaryonart'},
        {data: 'service_date'},
        {data: 'total_questions'},
        {data: 'total_yes'},
        {data: 'total_no'},
        {data: 'action'}
    ]
   });   
})