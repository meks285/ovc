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

//EDIT Care and Support Checklist

function editCandSChecklist(id){
  $.ajax({
    url: 'db/openFormsForEdit.php',
    type: 'post',
    data: "id="+id+"&function=openCandSChecklist",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        document.getElementById("record_id_cf").innerText = response.id;
        document.getElementById("vc_unique_id_cf").innerText = response.vc_unique_id;
        //document.getElementById("vc_unique_id_for_update").innerText = response.hh_unique_num;
        document.getElementById("consentQuestion1").innerText = response.consentQuestion1;
        document.getElementById("responseQuestion1").value = response.responseQuestion1;
        document.getElementById("consentQuestion2").innerText = response.consentQuestion2;
        document.getElementById("responseQuestion2").value = response.responseQuestion2;
        document.getElementById("consentQuestion3").innerText = response.consentQuestion3;
        document.getElementById("responseQuestion3").value = response.responseQuestion3;
        document.getElementById("consentQuestion4").innerText = response.consentQuestion4;
        document.getElementById("responseQuestion4").value = response.responseQuestion4;
        document.getElementById("consentQuestion5").innerText = response.consentQuestion5;
        document.getElementById("responseQuestion5").value = response.responseQuestion5;
        document.getElementById("beneficiaryonart").value = response.beneficiaryonart;
        document.getElementById("date").value = response.service_date;

        //$('#openServiceForm').attr('data-target','#newcareandsupportChecklist');
        document.getElementById("submitCareSupportChecklistForm").style.display = 'none';
        document.getElementById("updateCareSupportChecklistForm").style.display = 'block';
        $('#newcareandsupportChecklist').modal('show');
        //Show the Record ID -- Record ID is hidden if a new form modal is loaded
        document.getElementById("record_id_cf").style.display='block';
      }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed To Load Form');
      }
    }	
 })
}

//EDIT Caregiver and VC Update Checklist
function openCaregiverVcStatus(id){
  $.ajax({
    url: 'db/openFormsForEdit.php',
    type: 'post',
    data: "id="+id+"&function=openCaregiverVcStatus",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        document.getElementById("record_id_su").innerText = response.id;
        document.getElementById("vc_unique_id_su").innerText = response.vc_unique_id;
        //document.getElementById("vc_unique_id_for_update").innerText = response.hh_unique_num;
        document.getElementById("hh_member_category").value = response.hh_member_category;
        document.getElementById("hiv_status_su").value = response.hiv_status;
        document.getElementById("lastknownhiv").value = response.hiv_status;
        document.getElementById("dateoftest_su").value = response.dateoftest;
        document.getElementById("birth_certificate_su").value = response.birth_certificate;
        document.getElementById("child_in_school_su").value = response.child_in_school;
        document.getElementById("child_on_vocational_training_su").value = response.child_on_vocational_training;
        document.getElementById("service_provider_su").value = response.service_provider;
        document.getElementById("service_date_su").value = response.service_date;

        //$('#openServiceForm').attr('data-target','#newcareandsupportChecklist');
        document.getElementById("submitcaregiverandVCStatusUpdateForm").style.display = 'none';
        document.getElementById("updatecaregiverandVCStatusUpdateForm").style.display = 'block';
        $('#newcaregiverandVCStatusUpdate').modal('show');
        //Show the Record ID -- Record ID is hidden if a new form modal is loaded
        document.getElementById("record_id_su").style.display='block';
        //Open currentBirthEducationStatus DIV
        document.getElementById("currentBirthEducationStatus").style.display='block';

      }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed To Load Form');
      }
    }	
 })
}

//EDIT Caregiver Access to Emergency Funds
function openCaregiverAccessEmergency(id){
  $.ajax({
    url: 'db/openFormsForEdit.php',
    type: 'post',
    data: "id="+id+"&function=openCaregiverAccessEmergency",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        document.getElementById("record_id_ef").innerText = response.id;
        document.getElementById("vc_unique_id_for_ef").innerText = response.vc_unique_id;

        document.getElementById("efresponseQuestion1").value = response.responseQuestion1;
        document.getElementById("efresponseQuestion2").value = response.responseQuestion2;

        db_efresponseQuestion3 = response.responseQuestion3;
        if(db_efresponseQuestion3.includes('Borrowed from a friend')){$("#efresponseQuestion3_1").prop("checked", true);}else{$("#efresponseQuestion3_1").prop("checked", false);}
        if(db_efresponseQuestion3.includes('Income from trade')){$("#efresponseQuestion3_2").prop("checked", true);}else{$("#efresponseQuestion3_2").prop("checked", false);}
        if(db_efresponseQuestion3.includes('Through my salary')){$("#efresponseQuestion3_3").prop("checked", true);}else{$("#efresponseQuestion3_3").prop("checked", false);}
        if(db_efresponseQuestion3.includes('Took a loan/Received Amount saved or social fund from a SILC group')){$("#efresponseQuestion3_4").prop("checked", true);}else{$("#efresponseQuestion3_4").prop("checked", false);}
        if(db_efresponseQuestion3.includes('Sold some items in the house')){$("#efresponseQuestion3_5").prop("checked", true);}else{$("#efresponseQuestion3_5").prop("checked", false);}
        if(db_efresponseQuestion3.includes('From my personal savings')){$("#efresponseQuestion3_6").prop("checked", true);}else{$("#efresponseQuestion3_6").prop("checked", false);}

        db_efresponseQuestion4 = response.responseQuestion4;
        if(db_efresponseQuestion4.includes('Food')){$("#efresponseQuestion4_1").prop("checked", true);}else{$("#efresponseQuestion4_1").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Agriculture Inputs')){$("#efresponseQuestion4_2").prop("checked", true);}else{$("#efresponseQuestion4_2").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Clothes/Shoes')){$("#efresponseQuestion4_3").prop("checked", true);}else{$("#efresponseQuestion4_3").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Debt Repayment')){$("#efresponseQuestion4_4").prop("checked", true);}else{$("#efresponseQuestion4_4").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Businesss Investment')){$("#efresponseQuestion4_5").prop("checked", true);}else{$("#efresponseQuestion4_5").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Gift')){$("#efresponseQuestion4_6").prop("checked", true);}else{$("#efresponseQuestion4_6").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Livestock')){$("#efresponseQuestion4_7").prop("checked", true);}else{$("#efresponseQuestion4_7").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Water')){$("#efresponseQuestion4_8").prop("checked", true);}else{$("#efresponseQuestion4_8").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Medical')){$("#efresponseQuestion4_9").prop("checked", true);}else{$("#efresponseQuestion4_9").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Transport')){$("#efresponseQuestion4_10").prop("checked", true);}else{$("#efresponseQuestion4_10").prop("checked", false);}
        if(db_efresponseQuestion4.includes('House Rent/Shelter Materials')){$("#efresponseQuestion4_11").prop("checked", true);}else{$("#efresponseQuestion4_11").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Savings/In Hand/SILC')){$("#efresponseQuestion4_12").prop("checked", true);}else{$("#efresponseQuestion4_12").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Household Items')){$("#efresponseQuestion4_13").prop("checked", true);}else{$("#efresponseQuestion4_13").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Firewood')){$("#efresponseQuestion4_14").prop("checked", true);}else{$("#efresponseQuestion4_14").prop("checked", false);}
        if(db_efresponseQuestion4.includes('Others')){$("#efresponseQuestion4_15").prop("checked", true);}else{$("#efresponseQuestion4_15").prop("checked", false);}

        document.getElementById("service_date_ef").value = response.service_date;

        //Check conditions and open DIV as specified
        if(response.responseQuestion1=='Yes'){document.getElementById("q2").style.display='block';}else{document.getElementById("q2").style.display='none';}
        if(response.responseQuestion2=='Yes'){document.getElementById("q4").style.display='block';document.getElementById("q3").style.display='none';}else{document.getElementById("q4").style.display='none';document.getElementById("q3").style.display='block';}

        //$('#openServiceForm').attr('data-target','#newcareandsupportChecklist');
        document.getElementById("submitEmergencyFundForm").style.display = 'none';
        document.getElementById("updateEmergencyFundForm").style.display = 'block';
        $('#newaccessToEmergencyFundForm').modal('show');
        //Show the Record ID -- Record ID is hidden if a new form modal is loaded
        document.getElementById("record_id_ef").style.display='block';
        //Open All Hidden DIV
/*         document.getElementById("q3").style.display='block';
        document.getElementById("q4").style.display='block';
        document.getElementById("divefresponseQuestion3_other").style.display='block';
        document.getElementById("divefresponseQuestion4_other").style.display='block';
 */
      }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed To Load Form');
      }
    }	
 })
}

//EDIT Referrals Checklist
function openReferralsChecklist(id,referral_date){
  $.ajax({
    url: 'db/openFormsForEdit.php',
    type: 'post',
    data: "id="+id+"&referral_date="+referral_date+"&function=openReferralsChecklist",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        //document.getElementById("record_id_rf").innerText = response.id;
        document.getElementById("vc_unique_id_for_rf").innerText = response.vc_unique_id;
        document.getElementById("record_date_rf").innerText = response.referral_date;

        document.getElementById("referring_organization").value = response.referring_organization;
        document.getElementById("receiving_organization").value = response.receiving_organization;
        //document.getElementById("reservicereferred").value = response.reservicereferred;
        document.getElementById("organization_providingreferral").value = response.organization_providingreferral;
        // document.getElementById("efresponseQuestion1").value = response.service_provided;
        // document.getElementById("efresponseQuestion2").value = response.service_completed;
        // document.getElementById("efresponseQuestion1").value = response.followup_needed;
        // document.getElementById("efresponseQuestion2").value = response.followup_date;
        document.getElementById("rf_referral_status").value = response.referral_status;
        document.getElementById("referral_date").value = response.referral_date;
        document.getElementById("referral_receiver").value = response.referral_receiver;
        document.getElementById("referral_receiver_designation").value = response.referral_receiver_designation;
        document.getElementById("referral_receiver_phonenumber").value = response.referral_receiver_phonenumber;
        document.getElementById("referral_receiver_email").value = response.referral_receiver_email;

        rf_reservicereferred = response.reservicereferred;
        if(rf_reservicereferred.includes('Prevention Support (PrEP/Condoms/VMMC)')){$("#reservicereferred_1").prop("checked", true);}else{$("#reservicereferred_1").prop("checked", false);}
        if(rf_reservicereferred.includes('Wasting/Edema')){$("#reservicereferred_2").prop("checked", true);}else{$("#reservicereferred_2").prop("checked", false);}
        if(rf_reservicereferred.includes('Severe Acute Malnutrition (SAM)')){$("#reservicereferred_3").prop("checked", true);}else{$("#reservicereferred_3").prop("checked", false);}
        if(rf_reservicereferred.includes('Food and Nutrition Supplement')){$("#reservicereferred_4").prop("checked", true);}else{$("#reservicereferred_4").prop("checked", false);}
        if(rf_reservicereferred.includes('Water Treatment')){$("#reservicereferred_5").prop("checked", true);}else{$("#reservicereferred_5").prop("checked", false);}
        if(rf_reservicereferred.includes('Insecticide Treated Nets')){$("#reservicereferred_6").prop("checked", true);}else{$("#reservicereferred_6").prop("checked", false);}
        if(rf_reservicereferred.includes('Vitamin A, Zinc & Iron Complements')){$("#reservicereferred_7").prop("checked", true);}else{$("#reservicereferred_7").prop("checked", false);}
        if(rf_reservicereferred.includes('Emergency Healthcare')){$("#reservicereferred_8").prop("checked", true);}else{$("#reservicereferred_8").prop("checked", false);}
        if(rf_reservicereferred.includes('Routine Healthcare (e.g. Immunization)')){$("#reservicereferred_9").prop("checked", true);}else{$("#reservicereferred_9").prop("checked", false);}
        if(rf_reservicereferred.includes('Sexual/Reproductive Health')){$("#reservicereferred_10").prop("checked", true);}else{$("#reservicereferred_10").prop("checked", false);}
        if(rf_reservicereferred.includes('STI Treatment')){$("#reservicereferred_11").prop("checked", true);}else{$("#reservicereferred_11").prop("checked", false);}
        if(rf_reservicereferred.includes('TB Diagnosis')){$("#reservicereferred_12").prop("checked", true);}else{$("#reservicereferred_12").prop("checked", false);}
        if(rf_reservicereferred.includes('CD4 VL')){$("#reservicereferred_13").prop("checked", true);}else{$("#reservicereferred_13").prop("checked", false);}
        if(rf_reservicereferred.includes('ART')){$("#reservicereferred_14").prop("checked", true);}else{$("#reservicereferred_14").prop("checked", false);}
        if(rf_reservicereferred.includes('Early Infant Diagnosis (EID)')){$("#reservicereferred_15").prop("checked", true);}else{$("#reservicereferred_15").prop("checked", false);}
        if(rf_reservicereferred.includes('HIV Related Testing (HTS, PMTCT)')){$("#reservicereferred_16").prop("checked", true);}else{$("#reservicereferred_16").prop("checked", false);}
        if(rf_reservicereferred.includes('Emergency Shelter')){$("#reservicereferred_17").prop("checked", true);}else{$("#reservicereferred_17").prop("checked", false);}
        if(rf_reservicereferred.includes('Post-violence Medical Services')){$("#reservicereferred_18").prop("checked", true);}else{$("#reservicereferred_18").prop("checked", false);}
        if(rf_reservicereferred.includes('Birth Registration')){$("#reservicereferred_19").prop("checked", true);}else{$("#reservicereferred_19").prop("checked", false);}
        if(rf_reservicereferred.includes('Life Building Skills')){$("#reservicereferred_20").prop("checked", true);}else{$("#reservicereferred_20").prop("checked", false);}
        if(rf_reservicereferred.includes('Community Support Group')){$("#reservicereferred_21").prop("checked", true);}else{$("#reservicereferred_21").prop("checked", false);}
        if(rf_reservicereferred.includes('Spiritual Support')){$("#reservicereferred_22").prop("checked", true);}else{$("#reservicereferred_22").prop("checked", false);}
        if(rf_reservicereferred.includes('Post-violence-trauma-informed counselling')){$("#reservicereferred_23").prop("checked", true);}else{$("#reservicereferred_23").prop("checked", false);}
        if(rf_reservicereferred.includes('Income generating activities')){$("#reservicereferred_24").prop("checked", true);}else{$("#reservicereferred_24").prop("checked", false);}
        if(rf_reservicereferred.includes('Private and Public sector skills acquisition scheme')){$("#reservicereferred_25").prop("checked", true);}else{$("#reservicereferred_25").prop("checked", false);}
        if(rf_reservicereferred.includes('Microfinance')){$("#reservicereferred_26").prop("checked", true);}else{$("#reservicereferred_26").prop("checked", false);}
        if(rf_reservicereferred.includes('Skill Acquisition training')){$("#reservicereferred_27").prop("checked", true);}else{$("#reservicereferred_27").prop("checked", false);}
        if(rf_reservicereferred.includes('Legal Services')){$("#reservicereferred_28").prop("checked", true);}else{$("#reservicereferred_28").prop("checked", false);}
        if(rf_reservicereferred.includes('Income generating activities')){$("#reservicereferred_29").prop("checked", true);}else{$("#reservicereferred_29").prop("checked", false);}
        if(rf_reservicereferred.includes('Private and Public sector skills acquisition scheme')){$("#reservicereferred_30").prop("checked", true);}else{$("#reservicereferred_30").prop("checked", false);}
        if(rf_reservicereferred.includes('Microfinance')){$("#reservicereferred_31").prop("checked", true);}else{$("#reservicereferred_31").prop("checked", false);}
        if(rf_reservicereferred.includes('Vocational Training')){$("#reservicereferred_32").prop("checked", true);}else{$("#reservicereferred_32").prop("checked", false);}

          //Grab the Services Provided which are comma separated by the db and split them into an array. 
          //Use the Array to create the number of required input fields for result entry
          service_provided_str = response.service_provided;
          const service_provided = service_provided_str.split(',');

          service_completed_str = response.service_completed;
          const service_completed = service_completed_str.split(',');

          followup_needed_str = response.followup_needed;
          const followup_needed = followup_needed_str.split(',');

          followup_date_str = response.followup_date;
          const followup_date = followup_date_str.split(',');

          for (let i = 0; i < service_provided.length; i++) {
              console.log('Entry for Service Provided: '+service_completed[i]);
                    var row = $('#tbl tbody tr:first').clone();
                    row.find('input[id=rf_service_provided]').val(service_provided[i]);
                    row.find('select[id=rf_service_completed]').val(service_completed[i]);
                    row.find('select[id=rf_followup_needed]').val(followup_needed[i]);
                    row.find('input[id=rf_followup_date]').val(followup_date[i]);
                    $('#tbl tbody').append(row);
                    //Set input values to ReadOnly if the test already has result set. Don't if the input has no result set
/*                     if(results[i]==''){
                        row.find('input[id=result]').prop("readonly", false);
                        }
                    else{
                        row.find('input[id=result]').prop("readonly", true); 
                    } */
            }
            //Remove the first row created by the HTML Table block
              $('#tbl tbody tr:first').remove();

        //$('#openServiceForm').attr('data-target','#newcareandsupportChecklist');
        document.getElementById("submitReferralForm").style.display = 'none';
        document.getElementById("updateReferralForm").style.display = 'block';
        $('#newreferralForm').modal('show');
        //Show the Record ID -- Record ID is hidden if a new form modal is loaded
        document.getElementById("record_date_rf").style.display='block';

      }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed To Load Form');
      }
    }	
 })
}

function openChildEducationAssessment(id){
  $.ajax({
    url: 'db/openFormsForEdit.php',
    type: 'post',
    data: "id="+id+"&function=openChildEducationAssessment",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        document.getElementById("record_id_for_cepa").innerText = response.id;
        document.getElementById("vc_unique_id_for_cepa").innerText = response.vc_unique_id;
        document.getElementById("ppassessmentresponseQuestion1").value = response.responseQuestion1;
        document.getElementById("ppassessmentresponseQuestion2").value = response.responseQuestion2;
        document.getElementById("ppassessmentresponseQuestion3").value = response.responseQuestion3;
        document.getElementById("aaassessmentresponseQuestion1").value = response.responseQuestion4;
        document.getElementById("aaassessmentresponseQuestion2").value = response.responseQuestion5;
        document.getElementById("aaassessmentresponseQuestion3").value = response.responseQuestion6;
        document.getElementById("aaassessmentresponseQuestion4").value = response.responseQuestion7;
        document.getElementById("aaassessmentresponseQuestion5").value = response.responseQuestion8;
        document.getElementById("cso_staffname").value = response.cso_staffname;
        document.getElementById("cso_date").value = response.cso_date;
        document.getElementById("teacher_name").value = response.teacher_name;
        document.getElementById("teacher_date").value = response.teacher_date;

        //$('#openServiceForm').attr('data-target','#newcareandsupportChecklist');
        document.getElementById("submitEducationalPerformanceForm").style.display = 'none';
        document.getElementById("updateEducationalPerformanceForm").style.display = 'block';
        $('#newChildEducationalPerfAssForm').modal('show');
        //Show the Record ID -- Record ID is hidden if a new form modal is loaded
        document.getElementById("record_id_for_cepa").style.display='block';
      }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed To Load Form');
      }
    }	
 })
}

function openHivRiskAssessment(id){
  $.ajax({
    url: 'db/openFormsForEdit.php',
    type: 'post',
    data: "id="+id+"&function=openHivRiskAssessment",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        document.getElementById("record_id_for_cbpaeds").innerText = response.id;
        document.getElementById("vc_unique_id_for_cbpaeds").innerText = response.vc_unique_id;
        document.getElementById("respondent_childrelationship").value = response.respondent_childrelationship;
        document.getElementById("childhivstatusknowledge").value = response.childhivstatusknowledge;
        document.getElementById("childhivstatus_paeds").value = response.childhivstatus_paeds;
        document.getElementById("cbp_subQuestionResponse1_1").value = response.subQuestionResponse1_1;
        document.getElementById("cbp_subQuestionResponse2_1").value = response.subQuestionResponse2_1;
        document.getElementById("cbp_subQuestionResponse1_2").value = response.subQuestionResponse1_2;
        document.getElementById("cbp_subQuestionResponse2_2").value = response.subQuestionResponse2_2;
        document.getElementById("cbp_subQuestionResponse1_3").value = response.subQuestionResponse1_3;
        document.getElementById("cbp_subQuestionResponse2_3").value = response.subQuestionResponse2_3;
        document.getElementById("cbp_QuestionResponse4").value = response.QuestionResponse4;
        document.getElementById("cbp_subQuestionResponse1_5").value = response.subQuestionResponse1_5;
        document.getElementById("cbp_subQuestionResponse2_5").value = response.subQuestionResponse2_5;
        document.getElementById("cbp_subQuestionResponse1_6").value = response.subQuestionResponse1_6;
        document.getElementById("cbp_subQuestionResponse2_6").value = response.subQuestionResponse2_6;
        document.getElementById("cbp_QuestionResponse7").value = response.QuestionResponse7;
        document.getElementById("cbp_QuestionResponse8").value = response.QuestionResponse8;
        document.getElementById("cbp_QuestionResponse9").value = response.QuestionResponse9;
        document.getElementById("childatrisk").value = response.childatrisk;
        document.getElementById("serviceprovider").value = response.serviceprovider;
        document.getElementById("serviceprovisiondate").value = response.serviceprovisiondate;

        //$('#openServiceForm').attr('data-target','#newcareandsupportChecklist');
        document.getElementById("submitcommunityBasedPaedsForm").style.display = 'none';
        document.getElementById("updatecommunityBasedPaedsForm").style.display = 'block';
        $('#newcommunityBasedPaedsForm').modal('show');
        //Show the Record ID -- Record ID is hidden if a new form modal is loaded
        document.getElementById("record_id_for_cbpaeds").style.display='block';
        //Open HIV Status input if childhivstatusknowledge = 'Yes'
        if(document.getElementById("childhivstatusknowledge").value=='Yes'){
          document.getElementById("childhivstatus_div").style.display = 'block';
        }
      }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed To Load Form');
      }
    }	
 })
}

function openNutritionalAssessment(id){
  $.ajax({
    url: 'db/openFormsForEdit.php',
    type: 'post',
    data: "id="+id+"&function=openNutritionalAssessment",  
    dataType: 'json',
    success: function(response){ 
      if(response.status=="success"){
        document.getElementById("record_id_for_na").innerText = response.id;
        document.getElementById("vc_unique_id_for_na").innerText = response.vc_unique_id;
        document.getElementById("assessmentdate").value = response.assessmentdate;
        document.getElementById("weight").value = response.weight;
        document.getElementById("height").value = response.height;
        document.getElementById("bmi").value = response.bmi;
        document.getElementById("oedema").value = response.oedema;
        document.getElementById("muac").value = response.muac;
        document.getElementById("naresponseQuestion1").value = response.responseQuestion1;
        document.getElementById("naresponseQuestion2").value = response.responseQuestion2;
        document.getElementById("naresponseQuestion3").value = response.responseQuestion3;
        document.getElementById("naresponseQuestion4").value = response.responseQuestion4;
        document.getElementById("naresponseQuestion5").value = response.responseQuestion5;
        document.getElementById("responseQuestion6").value = response.responseQuestion6;
        document.getElementById("responseQuestion7").value = response.responseQuestion7;
        document.getElementById("responseQuestion8").value = response.responseQuestion8;
        document.getElementById("responseQuestion9").value = response.responseQuestion9;
        document.getElementById("responseQuestion10").value = response.responseQuestion10;
        document.getElementById("responseQuestion11").value = response.responseQuestion11;
        document.getElementById("responseQuestion12").value = response.responseQuestion12;
        document.getElementById("responseQuestion13").value = response.responseQuestion13;
        //document.getElementById("conditionaffecting_nutrition").value = response.conditionaffecting_nutrition;
        //document.getElementById("referral").value = response.referral;
        document.getElementById("serviceprovider_na").value = response.serviceprovider;
        document.getElementById("serviceprovisiondate_na").value = response.serviceprovisiondate;

        na_conditionaffecting_nutrition = response.conditionaffecting_nutrition;
        if(na_conditionaffecting_nutrition.includes('Diarhhea')){$("#conditionaffecting_nutrition_1").prop("checked", true);}else{$("#conditionaffecting_nutrition_1").prop("checked", false);}
        if(na_conditionaffecting_nutrition.includes('Nausea')){$("#conditionaffecting_nutrition_2").prop("checked", true);}else{$("#conditionaffecting_nutrition_2").prop("checked", false);}
        if(na_conditionaffecting_nutrition.includes('Vomiting')){$("#conditionaffecting_nutrition_3").prop("checked", true);}else{$("#conditionaffecting_nutrition_3").prop("checked", false);}
        if(na_conditionaffecting_nutrition.includes('Poor Appetite')){$("#conditionaffecting_nutrition_4").prop("checked", true);}else{$("#conditionaffecting_nutrition_4").prop("checked", false);}
        if(na_conditionaffecting_nutrition.includes('Mouth Sore')){$("#conditionaffecting_nutrition_5").prop("checked", true);}else{$("#conditionaffecting_nutrition_5").prop("checked", false);}
        if(na_conditionaffecting_nutrition.includes('Difficult or Painful Chewing/Swallowing')){$("#conditionaffecting_nutrition_6").prop("checked", true);}else{$("#conditionaffecting_nutrition_6").prop("checked", false);}

        na_referral = response.referral; 
        if(na_referral.includes('Nutritional Support (Cooking demonstration/establishment of home garden/ growth monitoring/ etc)')){$("#referral_1").prop("checked", true);}else{$("#referral_1").prop("checked", false);}
        if(na_referral.includes('Referred for HIV risk assessment')){$("#referral_2").prop("checked", true);}else{$("#referral_2").prop("checked", false);}

        //$('#openServiceForm').attr('data-target','#newcareandsupportChecklist');
        document.getElementById("submitNutritionalAssessmentForm").style.display = 'none';
        document.getElementById("updateNutritionalAssessmentForm").style.display = 'block';
        $('#newnutritionalAssessmentForm').modal('show');
        //Show the Record ID -- Record ID is hidden if a new form modal is loaded
        document.getElementById("record_id_for_na").style.display='block';
        //Open HIV Status input if childhivstatusknowledge = 'Yes'
/*         if(document.getElementById("childhivstatusknowledge").value=='Yes'){
          document.getElementById("childhivstatus_div").style.display = 'block';
        } */
      }
    else{
        $(window).scrollTop(0);
        alert('Error: Failed To Load Form');
      }
    }	
 })
}
