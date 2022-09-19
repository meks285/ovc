$(document).ready(function(){

    $('#hhConsentTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/getConsentList.php?householdUniqueId='+householdUniqueId
     },
     'columns': [
        {data: 'hh_unique_num'},
        {data: 'caregiver'},
        {data: 'ip'},
        {data: 'cbo_code'},
        {data: 'donor'},
        {data: 'household_witness'},
        {data: 'hh_caregiver_sign_date'},
        {data: 'action'}
    ]
   });   
})