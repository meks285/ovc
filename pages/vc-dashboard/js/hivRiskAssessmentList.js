$(document).ready(function(){

    $('#hivRiskAssessmentTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
     'ajax': {
         'url':'./db/gethivRiskAssessmentList.php?vc_unique_id='+vcUniqueId
     },
     'columns': [
        {data: 'vc_unique_id'},
        {data: 'respondent_childrelationship'},
        {data: 'childhivstatusknowledge'},
        {data: 'childhivstatus_paeds'},
        {data: 'Question1'},
        {data: 'Question2'},
        {data: 'Question3'},
        {data: 'assessmentDate'},
        {data: 'action'}
    ]
   });   
})