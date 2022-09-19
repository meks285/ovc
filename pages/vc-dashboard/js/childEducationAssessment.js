$(document).ready(function(){

    $('#childEducationAssessmentTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/getchildEducationAssessmentList.php?vc_unique_id='+vcUniqueId
     },
     'columns': [
        {data: 'vc_unique_id'},
        {data: 'Question1'},
        {data: 'Question2'},
        {data: 'Question3'},
        {data: 'Question4'},
        {data: 'Question5'},
        {data: 'Question6'},
        {data: 'teacher_date'},
        {data: 'action'}
    ]
   });   
})