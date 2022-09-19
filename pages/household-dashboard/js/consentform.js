document.addEventListener('DOMContentLoaded', init);
function init(){
    function householdDetails(){
        $.ajax({
            url: 'db/householdDetails.php',
            type: 'post', 
            dataType: 'json',
            data: "householdUniqueId="+householdUniqueId,
            success: function(response){ 
            if(response.status=="success"){
                document.getElementById("state_cf").value = response.state;
                document.getElementById("lga_cf").value = response.lga;
                document.getElementById("ward_cf").value = response.ward;
                document.getElementById("cbo_code_cf").value = response.cbo_code;
                document.getElementById("community_cf").value = response.community;
                document.getElementById("community_cf").value = response.community;
                document.getElementById("hh_caregiver_phone").value = response.phonenumber;
                document.getElementById("fullname").value = response.surname+' '+response.firstname;
                document.getElementById("household_caregiver").value = response.surname+' '+response.firstname;
            }
            else{
                
            }
          }	
        })    
      }
    
      householdDetails();
      
    
    
    document.getElementById("hh_unique_id_consent").innerText = householdUniqueId;

    document.getElementById("submitConsentForm").addEventListener('click', submitConsentForm, false);

    
    document.getElementById("addConsent").addEventListener('click', checkExistingConsent, false);
}

function submitConsentForm(){
    hh_unique_id = document.getElementById("hh_unique_id_consent").innerText
    community_cf = document.getElementById("community_cf").value;
    ward_cf = document.getElementById("ward_cf").value;
    lga_cf = document.getElementById("lga_cf").value;
    state_cf = document.getElementById("state_cf").value;
    ip_cf = document.getElementById("ip_cf").value;
    cbo_code_cf = document.getElementById("cbo_code_cf").value;
    supporting_ip_cf = document.getElementById("supporting_ip_cf").value;
    donor = document.getElementById("donor").value;

    consentQuestion1 = document.getElementById("consentQuestion1").innerText;
    responseQuestion1 = document.getElementById("responseQuestion1").value;
    consentQuestion2 = document.getElementById("consentQuestion2").innerText;
    responseQuestion2 = document.getElementById("responseQuestion2").value;
    consentQuestion3= document.getElementById("consentQuestion3").innerText;
    responseQuestion3 = document.getElementById("responseQuestion3").value;
    consentQuestion4= document.getElementById("consentQuestion4").innerText;
    responseQuestion4 = document.getElementById("responseQuestion4").value;
    consentQuestion5= document.getElementById("consentQuestion5").innerText;
    responseQuestion5 = document.getElementById("responseQuestion5").value;

    household_caregiver = document.getElementById("household_caregiver").value;
    hh_caregiver_signature = document.getElementById("hh_caregiver_signature").value;
    hh_caregiver_phone = document.getElementById("hh_caregiver_phone").value;
    hh_caregiver_sign_date = document.getElementById("hh_caregiver_sign_date").value;
    household_witness = document.getElementById("household_witness").value;
    hh_witness_signature = document.getElementById("hh_witness_signature").value;
    hh_witness_phone = document.getElementById("hh_witness_phone").value;
    hh_witness_sign_date = document.getElementById("hh_witness_sign_date").value;


        //Check for Validation and Missed Entries
        if(hh_unique_id==""){document.getElementById("hh_unique_id_label").innerHTML="Field is required";hh_unique_id_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{hh_unique_id_chk=1;document.getElementById("hh_unique_id_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}
        if(community_cf==""){document.getElementById("community_cf_label").innerHTML="Field is required";community_cf_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{community_cf_chk=1;document.getElementById("community_cf_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}
        if(ward_cf==""){document.getElementById("ward_cf_label").innerHTML="Field is required";ward_cf_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{ward_cf_chk=1;document.getElementById("ward_cf_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}
        if(lga_cf==""){document.getElementById("lga_cf_label").innerHTML="Field is required";lga_cf_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{lga_cf_chk=1;document.getElementById("lga_cf_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}
        if(state_cf==""){document.getElementById("state_cf_label").innerHTML="Field is required";state_cf_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{state_cf_chk=1;document.getElementById("state_cf_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}
        if(ip_cf=="" || ip_cf=="Select"){document.getElementById("ip_cf_label").innerHTML="Field is required";ip_cf_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{ip_cf_chk=1;document.getElementById("ip_cf_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}
        if(cbo_code_cf==""){document.getElementById("cbo_code_cf_label").innerHTML="Field is required";cbo_code_cf_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{cbo_code_cf_chk=1;document.getElementById("cbo_code_cf_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}
        if(supporting_ip_cf==""||supporting_ip_cf=="Select"){document.getElementById("supporting_ip_cf_label").innerHTML="Field is required";supporting_ip_cf_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{supporting_ip_cf_chk=1;document.getElementById("supporting_ip_cf_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}
        if(donor==""||donor=="Select"){document.getElementById("donor_label").innerHTML="Field is required";donor_chk=0;$('#collapseconsentDeclaration').collapse('show');}else{donor_chk=1;document.getElementById("donor_label").innerHTML="";$('#collapseconsentDeclaration').collapse('hide');}

        if(responseQuestion1==""||responseQuestion1=="Response"){document.getElementById("responseQuestion1_label").innerHTML="Field is required";responseQuestion1_chk=0;$('#collapseconsentConditions').collapse('show');}else{responseQuestion1_chk=1;document.getElementById("responseQuestion1_label").innerHTML="";$('#collapseconsentConditions').collapse('hide');}
        if(responseQuestion2==""||responseQuestion2=="Response"){document.getElementById("responseQuestion2_label").innerHTML="Field is required";responseQuestion2_chk=0;$('#collapseconsentConditions').collapse('show');}else{responseQuestion2_chk=1;document.getElementById("responseQuestion2_label").innerHTML="";$('#collapseconsentConditions').collapse('hide');}
        if(responseQuestion3==""||responseQuestion3=="Response"){document.getElementById("responseQuestion3_label").innerHTML="Field is required";responseQuestion3_chk=0;$('#collapseconsentConditions').collapse('show');}else{responseQuestion3_chk=1;document.getElementById("responseQuestion3_label").innerHTML="";$('#collapseconsentConditions').collapse('hide');}
        if(responseQuestion4==""||responseQuestion4=="Response"){document.getElementById("responseQuestion4_label").innerHTML="Field is required";responseQuestion4_chk=0;$('#collapseconsentConditions').collapse('show');}else{responseQuestion4_chk=1;document.getElementById("responseQuestion4_label").innerHTML="";$('#collapseconsentConditions').collapse('hide');}
        if(responseQuestion5==""||responseQuestion5=="Response"){document.getElementById("responseQuestion5_label").innerHTML="Field is required";responseQuestion5_chk=0;$('#collapseconsentConditions').collapse('show');}else{responseQuestion5_chk=1;document.getElementById("responseQuestion5_label").innerHTML="";$('#collapseconsentConditions').collapse('hide');}

        if(household_caregiver==""){document.getElementById("household_caregiver_label").innerHTML="Field is required";household_caregiver_chk=0;$('#collapseconsentSignature').collapse('show');}else{household_caregiver_chk=1;document.getElementById("household_caregiver_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(hh_caregiver_signature==""){document.getElementById("hh_caregiver_signature_label").innerHTML="Field is required";hh_caregiver_signature_chk=0;$('#collapseconsentSignature').collapse('show');}else{hh_caregiver_signature_chk=1;document.getElementById("hh_caregiver_signature_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(hh_caregiver_phone==""){document.getElementById("hh_caregiver_phone_label").innerHTML="Field is required";hh_caregiver_phone_chk=0;$('#collapseconsentSignature').collapse('show');}else{hh_caregiver_phone_chk=1;document.getElementById("hh_caregiver_phone_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(hh_caregiver_sign_date==""){document.getElementById("hh_caregiver_sign_date_label").innerHTML="Field is required";hh_caregiver_sign_date_chk=0;$('#collapseconsentSignature').collapse('show');}else{hh_caregiver_sign_date_chk=1;document.getElementById("hh_caregiver_sign_date_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(household_witness==""){document.getElementById("household_witness_label").innerHTML="Field is required";household_witness_chk=0;$('#collapseconsentSignature').collapse('show');}else{household_witness_chk=1;document.getElementById("household_witness_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(hh_witness_signature==""){document.getElementById("hh_witness_signature_label").innerHTML="Field is required";hh_witness_signature_chk=0;$('#collapseconsentSignature').collapse('show');}else{hh_witness_signature_chk=1;document.getElementById("hh_witness_signature_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(hh_witness_phone==""){document.getElementById("hh_witness_phone_label").innerHTML="Field is required";hh_witness_phone_chk=0;$('#collapseconsentSignature').collapse('show');}else{hh_witness_phone_chk=1;document.getElementById("hh_witness_phone_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(hh_witness_sign_date==""){document.getElementById("hh_witness_sign_date_label").innerHTML="Field is required";hh_witness_sign_date_chk=0;$('#collapseconsentSignature').collapse('show');}else{hh_witness_sign_date_chk=1;document.getElementById("hh_witness_sign_date_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}

//Confirm validation and set validation status
    if(hh_unique_id_chk == 0 || community_cf_chk == 0 ||ward_cf_chk == 0 ||lga_cf_chk == 0 ||state_cf_chk == 0 ||ip_cf_chk == 0 ||cbo_code_cf_chk == 0 ||supporting_ip_cf_chk == 0
        ||donor_chk == 0 ||responseQuestion1_chk == 0 ||responseQuestion2_chk == 0 ||responseQuestion3_chk == 0 ||responseQuestion4_chk == 0 ||responseQuestion5_chk == 0 
        ||hh_witness_sign_date == 0 ||hh_witness_phone == 0 ||hh_witness_signature == 0||household_witness == 0||hh_caregiver_sign_date == 0||hh_caregiver_phone == 0||hh_caregiver_signature == 0||household_caregiver == 0){
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
        createConsent();
    }
}

function createConsent(){
    $.ajax({
        url: 'db/createConsent.php',
        type: 'post',
        data: "hh_unique_id="+hh_unique_id+"&community="+community_cf+"&ward="+ward_cf+"&lga="+lga_cf+"&state="+state_cf+"&ip="+ip_cf
        +"&cbo_code="+cbo_code_cf+"&supporting_ip="+supporting_ip_cf+"&donor="+donor+"&consentQuestion1="+consentQuestion1+"&consentQuestion2="+consentQuestion2
        +"&consentQuestion3="+consentQuestion3+"&consentQuestion4="+consentQuestion4+"&consentQuestion5="+consentQuestion5+"&responseQuestion1="+responseQuestion1
        +"&responseQuestion2="+responseQuestion2+"&responseQuestion3="+responseQuestion3+"&responseQuestion4="+responseQuestion4+"&responseQuestion5="+responseQuestion5
        +"&household_caregiver="+household_caregiver+"&hh_caregiver_signature="+hh_caregiver_signature+"&hh_caregiver_phone="+hh_caregiver_phone
        +"&hh_caregiver_sign_date="+hh_caregiver_sign_date+"&household_witness="+household_witness+"&hh_witness_signature="+hh_witness_signature+"&hh_witness_phone="+hh_witness_phone
        +"&hh_witness_sign_date="+hh_witness_sign_date,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Consent Successfully Created",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 20000
                }).showToast();

                //re-initialize table
                var hhConsentTable =  $('#hhConsentTable').DataTable();
                hhConsentTable.ajax.reload();
                //var vcServicesTable = $('#vcServicesTable').DataTable();
                //vcServicesTable.ajax.reload();
                //Enable the Disabled addVC Button
                document.getElementById("addVC").disabled=false;
                //Close Consent Form Modal
                $('#newConsentFormModal').modal('hide');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Consent NOT created",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 20000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Error: Consent Exists Already for this Household",
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

function checkExistingConsent(){

  $.ajax({
      url: 'db/checkExistingConsent.php',
      type: 'post',
      data: "householdUniqueId="+householdUniqueId,  
      dataType: 'json',
      success: function(response){ 
        if(response.status=="success"){
          Toastify({
              text: "Consent Form Loaded",
              style: {
                background: "linear-gradient(to right, #DC3545, #866EC7)",
              },
              close: true,
              duration: 10000
              }).showToast();
          }
          else if(response.status=="consent_maxed_out"){
              Toastify({
                  text: "This HouseHold already has a consent Form",
                  style: {
                    background: "linear-gradient(to right, #DC3545, #DC3545)",
                  },
                  close: true,
                  duration: 10000
              }).showToast();        
              document.getElementById("fullname").value="";
              document.getElementById("hh_unique_id_consent").innerText = "";
          }
          },
  error: function(XMLHttpRequest, textStatus, errorThrown) { 
      alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
  }  	
})
}