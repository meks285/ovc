function deactivateRecipient(id){
    console.log('Deactivate');
 var table = $('#recipientLogTable').DataTable();
 $.ajax({
     url: 'db/actions.php',
     type: 'post',
     data: "id="+id+"&function=deactivate",  
     dataType: 'json',
     success: function(response){ 
       if(response.status=="success"){
         $(window).scrollTop(0);
         alert('Recipient Deactivated');
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
    var table = $('#recipientLogTable').DataTable();
 $.ajax({
     url: 'db/actions.php',
     type: 'post',
     data: "id="+id+"&function=activate",  
     dataType: 'json',
     success: function(response){ 
       if(response.status=="success"){
         $(window).scrollTop(0);
         alert('Recipient Activated');
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
    var table = $('#recipientLogTable').DataTable();
 $.ajax({
     url: 'db/actions.php',
     type: 'post',
     data: "id="+id+"&function=delete",  
     dataType: 'json',
     success: function(response){ 
       if(response.status=="success"){
         $(window).scrollTop(0);
         alert('Recipient Deleted');
         table.ajax.reload();
     }
     else{
         $(window).scrollTop(0);
         alert('Error: Failed Deletion');
       }
     }	
})
}