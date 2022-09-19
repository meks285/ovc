$(document).ready(function(){

    $('#caregiverTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/getCaregiverList.php?householdUniqueId='+householdUniqueId
     },
     'columns': [
        {data: 'action'},
        {data: 'hhuniqueid'},
        {data: 'beneficiary_id'},
        {data: 'surname'},
        {data: 'firstname'},
        {data: 'dateofenrollment'},
        {data: 'currenthivstatus'},
        {data: 'beneficiarytype'}
    ]
   });   
})