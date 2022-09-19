$(document).ready(function(){

    $('#referralsTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/getreferralsList.php?vc_unique_id='+vcUniqueId
     },
     'columns': [
        {data: 'vc_unique_id'},
        {data: 'referring_organization'},
        {data: 'receiving_organization'},
        {data: 'reservicereferred'},
        {data: 'service_provided'},
        {data: 'service_completed'},
        {data: 'followup_needed'},
        {data: 'action'}
    ]
   });   
})