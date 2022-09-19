$(document).ready(function(){

    $('#nutritionalAssessmentTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/getnutritionalAssessmentList.php?vc_unique_id='+vcUniqueId
     },
     'columns': [
        {data: 'vc_unique_id'},
        {data: 'assessmentdate'},
        {data: 'weight'},
        {data: 'height'},
        {data: 'bmi'},
        {data: 'oedema'},
        {data: 'muac'},
        {data: 'question'},
        {data: 'action'}
    ]
   });   
})