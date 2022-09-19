$(document).ready(function(){
    $('#usersListTable').DataTable({
         'processing': true,
         'responsive': true,
         'paging': false,
         'serverSide': true,
         'lengthChange': false,                
         'searching': false,         
         'bInfo': false,               
         'serverMethod': 'post',
    'ajax': {
        'url':'./db/getUsersList.php?cbo_code='+cbo_code
    },
    'columns': [
       {data: 'status'},
       {data: 'username'},
       {data: 'state'},
       {data: 'lga'},
       {data: 'email'},
       {data: 'surname'},
       {data: 'othernames'},
       {data: 'cbo_name'},
       {data: 'role'},
       {data: 'rights'},
       {data: 'action'}
   ]
  });             
})