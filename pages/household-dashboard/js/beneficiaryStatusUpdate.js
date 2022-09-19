document.addEventListener('DOMContentLoaded', init);
function init(){
    hh_unique_num = householdUniqueId;
     
    
    
   document.getElementById("submitStatusUpdateForm").addEventListener('click', submitStatusUpdateForm, false);

}

function submitStatusUpdateForm(){
    vc_unique_id = document.getElementById("vc_unique_id_for_update").innerText
    date = document.getElementById("followup_date").value;
    updateStatus = document.getElementById("status").value;



        //Check for Validation and Missed Entries
        if(date==""){document.getElementById("followup_date_label").innerHTML="Field is required";date_chk=0;$('#collapsebeneficiaryStatusUpdate').collapse('show');}else{date_chk=1;document.getElementById("followup_date_label").innerHTML="";$('#collapsebeneficiaryStatusUpdate').collapse('hide');}
        if(updateStatus=="" || updateStatus=="Select"){document.getElementById("status_label").innerHTML="Field is required";updateStatus_chk=0;$('#collapsebeneficiaryStatusUpdate').collapse('show');}else{updateStatus_chk=1;document.getElementById("status_label").innerHTML="";$('#collapsebeneficiaryStatusUpdate').collapse('hide');}

//Confirm validation and set validation status
    if(date_chk == 0 || updateStatus_chk == 0 ||hh_unique_num == '' ||vc_unique_id == ''){
        validation_state = 'failed';
        Toastify({
            text: "Validation Failed. Review form elements",
            style: {
              background: "linear-gradient(to right, #DC3545, #DC3545)",
            },
            close: true,
            duration: 10000
        }).showToast();
    }
    else{
        createStatusUpdate();
    }
}

function createStatusUpdate(){
    $.ajax({
        url: 'db/createStatusUpdate.php',
        type: 'post',
        data: "hh_unique_id="+hh_unique_num+"&vc_unique_id="+vc_unique_id+"&date="+date+"&updateStatus="+updateStatus,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Beneficiary Status Updated Successfully",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 20000
                }).showToast();
                //re-initialize table
                var vcServicesTable = $('#vcServicesTable').DataTable();
                vcServicesTable.ajax.reload();
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Beneficiary Status NOT updated",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 20000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Error: Beneficiary Already set with this Status",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 20000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}
