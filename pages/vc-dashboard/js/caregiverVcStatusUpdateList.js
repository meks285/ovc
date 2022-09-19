$(document).ready(function(){

    $('#caregiverVcStatusUpdateTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/getcaregiverVcStatusUpdateList.php?vc_unique_id='+vcUniqueId
     },
     'columns': [
        {data: 'hh_member_category'},
        {data: 'vc_unique_id'},
        {data: 'hiv_status'},
        {data: 'dateoftest'},
        {data: 'birth_certificate'},
        {data: 'child_in_school'},
        {data: 'child_on_vocational_training'},
        {data: 'action'}
    ]
   });   
})