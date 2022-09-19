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
function updateBeneficiaryStatus(id){
  $.ajax({
    url: 'db/actions.php',
    type: 'post',
    data: "id="+id+"&function=updateBeneficiaryStatus",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        
        document.getElementById("hh_beneficiary_id").innerText = response.beneficiaryid;
        document.getElementById("upd_cg_surname").value = response.surname;
        document.getElementById("upd_cg_firstname").value = response.firstname;
        document.getElementById("upd_cg_gender").value = response.sex;
        document.getElementById("upd_cg_dob").value = response.dob;
        document.getElementById("upd_cg_phonenumber").value = response.phonenumber;
        document.getElementById("upd_enrollmentdate").value = response.enrollmentdate;
        document.getElementById("upd_cg_marital_status").value = response.maritalstatus;
        document.getElementById("upd_cg_occupation").value = response.occupation;
        document.getElementById("upd_cg_hiv_status").value = response.hiv_status;
        document.getElementById("upd_cg_datehivstatus").value = response.datehivstatus;
        document.getElementById("upd_cg_enrolledontreatment").value = response.enrolledontreatment;
        document.getElementById("upd_cg_artstartdate").value = response.artstartdate;
        document.getElementById("upd_cg_facilityenrolled").value = response.facilityenrolled;
        document.getElementById("upd_cg_treatment_art_no").value = response.treatment_art_no;
        document.getElementById("upd_beneficiary_type").value = response.beneficiarytype;
        document.getElementById("upd_beneficiary_id").value = response.beneficiaryid;
      }
    else{
        document.getElementById("entryFormBeneficiaryStatusUpdate").reset();
        $(window).scrollTop(0);
        alert('Error: Benefiary Data pull fail');
      }
    }	
 })
}
function accessToEmergencyFund(id){
  $.ajax({
    url: 'db/actions.php',
    type: 'post',
    data: "id="+id+"&function=accessToEmergencyFund",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
          //Launch Modal
                $('#newaccessToEmergencyFundForm').modal('show');
        //Assign Values
                document.getElementById("beneficiary_id_for_ef").innerText = response.beneficiaryid;
                document.getElementById("record_id_ef").innerText = response.id;
                document.getElementById("updateEmergencyFundForm").style.display = 'none';
      }
    else{
        document.getElementById("accessToEmergencyFund").reset();
        $(window).scrollTop(0);
        alert('Error: Benefiary Data pull fail');
      }
    }	
 })
}
function referralForm(id){
  $.ajax({
    url: 'db/actions.php',
    type: 'post',
    data: "id="+id+"&function=referralForm",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
          //Launch Modal
                $('#newreferralForm').modal('show');
        //Assign Values
                document.getElementById("beneficiaryid_for_rf").innerText = response.beneficiaryid;
                document.getElementById("record_id_rf").innerText = response.id;
                document.getElementById("record_date_rf").style.display = 'none';
                document.getElementById("updateReferralForm").style.display = 'none';
      }
    else{
        document.getElementById("entryReferralForm").reset();
        $(window).scrollTop(0);
        alert('Error: Benefiary Data pull fail');
      }
    }	
 })
}






