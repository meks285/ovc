$(document).ready(function(){

    $('#householdListTable').DataTable({
        'processing': true,
        'responsive': true,
        'serverSide': true,
        'pagingType': 'full_numbers',
        'pageLength': 100,
        "lengthMenu": [ [100, 1000, 2500, 5000, 10000, -1], [100, 1000, 2500, 5000, 10000, "All"] ],
        'lengthChange': true,                
        'serverMethod': 'post',
    'ajax': {
        'url':'./db/getHouseHoldList.php?cbo_code='+cbo_code
    },
    'columns': [
       {data: 'hh_unique_num'},
       {data: 'date_of_assessment'},
       {data: 'state'},
       {data: 'lga'},
       {data: 'ward'},
       {data: 'hh_num_children'},
       {data: 'address'},
       {data: 'action'}
   ],
    'dom': 'lBfrtip',
      'buttons': [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
  });             
})