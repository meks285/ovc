function deactivateRecipient(id){
    console.log('Deactivate');
 var table = $('#usersListTable').DataTable();
 $.ajax({
     url: 'db/actions.php',
     type: 'post',
     data: "id="+id+"&function=deactivate",  
     dataType: 'json',
     success: function(response){ 
       if(response.status=="success"){
         $(window).scrollTop(0);
         alert('User Deactivated');
         table.ajax.reload();
     }
     else{
         $(window).scrollTop(0);
         alert('Error: Failed Deactivation');
       }
     }	
})
}
function activateRecipient(id){
    console.log('activate');
    var table = $('#usersListTable').DataTable();
 $.ajax({
     url: 'db/actions.php',
     type: 'post',
     data: "id="+id+"&function=activate",  
     dataType: 'json',
     success: function(response){ 
       if(response.status=="success"){
         $(window).scrollTop(0);
         alert('User Activated');
         table.ajax.reload();
     }
     else{
         $(window).scrollTop(0);
         alert('Error: Failed Activation');
       }
     }	
})
}   
function deleteRecipient(id){
  console.log('delete');
  var table = $('#usersListTable').DataTable();
$.ajax({
   url: 'db/actions.php',
   type: 'post',
   data: "id="+id+"&function=delete",  
   dataType: 'json',
   success: function(response){ 
     if(response.status=="success"){
       $(window).scrollTop(0);
       alert('User Deleted');
       table.ajax.reload();
   }
   else{
       $(window).scrollTop(0);
       alert('Error: Failed Deletion');
     }
   }	
})
}
function provideService(id){
  $.ajax({
    url: 'db/actions.php',
    type: 'post',
    data: "id="+id+"&function=provideService",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        console.log('VC ID: '+response.vc_unique_id);
        document.getElementById("vc_unique_id_for_service").innerText = response.vc_unique_id;
    }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed Deletion');
      }
    }	
 })
}
function beneficiaryStatusUpdate(id){
  $.ajax({
    url: 'db/actions.php',
    type: 'post',
    data: "id="+id+"&function=provideStatusUpdate",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        console.log('VC ID: '+response.vc_unique_id);
        document.getElementById("vc_unique_id_for_update").innerText = response.vc_unique_id;
    }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed Deletion');
      }
    }	
 })
}