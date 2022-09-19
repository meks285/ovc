$(document).ready(function(){

    $('#caregiverAccessEmergencyTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/getcaregiverAccessEmergencyList.php?householdUniqueId='+householdUniqueId
     },
     'columns': [
        {data: 'hh_unique_num'},
        {data: 'unique_id'},
        {data: 'service_date'},
        {data: 'serviceQuestion1'},
        {data: 'responseQuestion1'},
        {data: 'action'}
    ]
   });   
})