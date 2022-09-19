document.addEventListener('DOMContentLoaded', init);

function init(){
    function householdDetails(){
        $.ajax({
            url: 'db/vcDetails.php',
            type: 'post', 
            dataType: 'json',
            data: "vcUniqueId="+vcUniqueId,
            success: function(response){ 
            if(response.status=="success"){
                var vc_status = response.vc_status;
                vc_status = vc_status.toUpperCase();
                document.getElementById("vc_status").innerText = vc_status;
                document.getElementById("vc_id").innerText = response.vc_unique_id;
                document.getElementById("vc_name").innerText = response.name;
                document.getElementById("vc_gender").innerText = response.gender;
                document.getElementById("vc_age").innerText = response.age;
                document.getElementById("hiv_status").innerText = response.hiv_status;

                //document.getElementById("lastknownhiv").value = response.hiv_status;
                //document.getElementById("l_known_hiv").innerText = response.hiv_status;
                hh_unique_num = response.hh_unique_num;
                public_age = response.age;
                hiv_status = response.hiv_status;
                
                //Variables for Status Update
                su_fullname = response.name;
                su_sex = response.gender;
                su_enrollmentstatus = vc_status;
                su_enrollment_date = response.enrollment_date;
                //console.log('Val: '+response.status)
            //Close Section B of Community Paeds if age is < 15 communityBasedPaedsFormSectionBCard                
                if(public_age < 15){
                    document.getElementById("communityBasedPaedsFormSectionBCard").style.display='none'
                }
                else{
                    document.getElementById("communityBasedPaedsFormSectionBCard").style.display='block'
                }
            }
            else{
                console.log('Failure')
            }
          }	
        })    
      }
    
      householdDetails();


//Function to decide which forms to load
document.getElementById("service_form").addEventListener('change', function(){
    var selected_service_form = document.getElementById("service_form").value;
    document.getElementById("vc_unique_id_cf").innerText = vcUniqueId;
    document.getElementById("vc_unique_id_su").innerText = vcUniqueId; //Status Update


    //document.getElementById("vc_unique_id_for_ef").innerText = vcUniqueId;
    document.getElementById("vc_unique_id_for_rf").innerText = vcUniqueId;
      
    if(selected_service_form == 'Care & Support Checklist'){
        if(hiv_status == 'Negative'){
            Toastify({
                text: "This VC is HIV-, This form is completed only for a HIV+ child.",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();        
            }
        else{
            //Reset All Forms in the service_form select tag
            document.getElementById("entrycandsChecklistForm").reset();
            document.getElementById("caregiverandVCStatusUpdateForm").reset();
            //document.getElementById("entryForm").reset();
            document.getElementById("entryReferralForm").reset();
            //Reset All Forms in the assessment_form select tag
            document.getElementById("childEducationalPerfAssForm").reset();
            document.getElementById("communityBasedPaedsForm").reset();
            document.getElementById("nutritionalAssessmentForm").reset();
            //Open the Selected Service For childEducationalPerfAssForm
            $('#openServiceForm').attr('data-target','#newcareandsupportChecklist');
            //Hide the Update Button and Show the submit Button
            document.getElementById("updateCareSupportChecklistForm").style.display='none';
            document.getElementById("submitCareSupportChecklistForm").style.display='block';
            //Hide the Record ID coming from the edit section
            document.getElementById("record_id_cf").style.display='none';
        }
    }
    else if(selected_service_form == 'Caregiver & VC Status Update'){
            //Reset All Forms in the service_form select tag
            document.getElementById("entrycandsChecklistForm").reset();
            document.getElementById("caregiverandVCStatusUpdateForm").reset();
            //document.getElementById("entryForm").reset();
            document.getElementById("entryReferralForm").reset();
            //Open the Selected Service For childEducationalPerfAssForm
            $('#openServiceForm').attr('data-target','#newcaregiverandVCStatusUpdate');
            //Hide the Update Button and Show the submit Button
            document.getElementById("updatecaregiverandVCStatusUpdateForm").style.display='none';
            document.getElementById("submitcaregiverandVCStatusUpdateForm").style.display='block';
            //Hide the Record ID coming from the edit section
            document.getElementById("record_id_su").style.display='none';
            //PULL Variables from the ovcstatusupdate and set the fields: call the getLastBeneficiaryStatus() Function
            getLastBeneficiaryStatus();
    }

    else if(selected_service_form == 'Referral Form'){
            //Reset All Forms in the service_form select tag
            document.getElementById("entrycandsChecklistForm").reset();
            document.getElementById("caregiverandVCStatusUpdateForm").reset();
            //document.getElementById("entryForm").reset();
            document.getElementById("entryReferralForm").reset();
            //Open the Selected Service For childEducationalPerfAssForm
        $('#openServiceForm').attr('data-target','#newreferralForm');
            //Hide the Update Button and Show the submit Button
            document.getElementById("updateReferralForm").style.display='none';
            document.getElementById("submitReferralForm").style.display='block';
            //Hide the Record ID  & date coming from the edit section
            document.getElementById("record_id_rf").style.display='none';        
            document.getElementById("record_date_rf").style.display='none';        

    }
    else{
        $('#openServiceForm').attr('data-target','#empty');
    }
}, false)

document.getElementById("assessment_form").addEventListener('change', function(){
    var selected_assessment_form = document.getElementById("assessment_form").value;

    if(selected_assessment_form == 'Child Educational Assessment Tool'){
            //Reset All Forms in the assessment_form select tag
            document.getElementById("childEducationalPerfAssForm").reset();
            document.getElementById("communityBasedPaedsForm").reset();
            document.getElementById("nutritionalAssessmentForm").reset();
            //Open the Selected Service For childEducationalPerfAssForm
            document.getElementById("vc_unique_id_for_cepa").innerText = vcUniqueId;
            $('#openAssessmentForm').attr('data-target','#newChildEducationalPerfAssForm');
            //Hide the Record ID  & date coming from the edit section
            document.getElementById("record_id_for_cepa").style.display='none';        
            //Hide the Update Button and Show the submit Button
            document.getElementById("updateEducationalPerformanceForm").style.display='none';
            document.getElementById("submitEducationalPerformanceForm").style.display='block';
            
    }
    else if(selected_assessment_form == 'Community Based Paeds HIV risk assessment tool'){
        if(hiv_status=='Positive'){
        Toastify({
            text: "This Form does not apply to HIV Positive Vulnerable Children...",
            style: {
              background: "linear-gradient(to right, #DC3545, #DC3545)",
            },
            close: true,
            duration: 10000
        }).showToast();        
        }
        else{

            //Reset All Forms in the assessment_form select tag
            document.getElementById("childEducationalPerfAssForm").reset();
            document.getElementById("communityBasedPaedsForm").reset();
            document.getElementById("nutritionalAssessmentForm").reset();
            //Open the Selected Service For childEducationalPerfAssForm
            document.getElementById("vc_unique_id_for_cbpaeds").innerText = vcUniqueId;
            $('#openAssessmentForm').attr('data-target','#newcommunityBasedPaedsForm');
             //Hide the Record ID  & date coming from the edit section
             document.getElementById("record_id_for_cbpaeds").style.display='none';        
            //Hide the Update Button and Show the submit Button
            document.getElementById("updatecommunityBasedPaedsForm").style.display='none';
            document.getElementById("submitcommunityBasedPaedsForm").style.display='block';        
        }
    }
    else if(selected_assessment_form == 'Nutritional Assessment Form'){
            //Reset All Forms in the assessment_form select tag
            document.getElementById("childEducationalPerfAssForm").reset();
            document.getElementById("communityBasedPaedsForm").reset();
            document.getElementById("nutritionalAssessmentForm").reset();
            //Open the Selected Service For childEducationalPerfAssForm
            document.getElementById("vc_unique_id_for_na").innerText = vcUniqueId;
            $('#openAssessmentForm').attr('data-target','#newnutritionalAssessmentForm');
             //Hide the Record ID  & date coming from the edit section
             document.getElementById("record_id_for_na").style.display='none';        
            //Hide the Update Button and Show the submit Button
            document.getElementById("updateNutritionalAssessmentForm").style.display='none';
            document.getElementById("submitNutritionalAssessmentForm").style.display='block';
    }
    else{
        $('#openAssessmentForm').attr('data-target','#empty');
    }
}, false)



//Show option to select child HIV status if Caregiver has knowledge of status
document.getElementById("childhivstatusknowledge").addEventListener('change', function(){
    if(document.getElementById("childhivstatusknowledge").value=='Yes'){
        document.getElementById("childhivstatus_div").style.display = 'block';
    }
    else{
        document.getElementById("childhivstatus_div").style.display = 'none';
    }
}, false)

//calculate BMI and populate the BMI element
document.getElementById("height").addEventListener('change', function(){
    if(document.getElementById("height").value=="" || document.getElementById("weight").value==""){
        Toastify({
            text: "Height and Weight are both required for BMI Calculation.",
            style: {
              background: "linear-gradient(to right, #DC3545, #866EC7)",
            },
            close: true,
            duration: 10000
            }).showToast();    
    }
    else{
            height_cm = parseInt(document.getElementById("height").value);
            weight_kg = parseInt(document.getElementById("weight").value);
        
            height_m2 = parseFloat(height_cm/100);
        
            bmi = weight_kg/(height_m2*height_m2);
            document.getElementById("bmi").value = bmi.toFixed(2);
        }

}, false)
document.getElementById("weight").addEventListener('change', function(){
    if(document.getElementById("height").value=="" || document.getElementById("weight").value==""){
        Toastify({
            text: "Height and Weight are both required for BMI Calculation.",
            style: {
              background: "linear-gradient(to right, #DC3545, #866EC7)",
            },
            close: true,
            duration: 10000
            }).showToast();    
    }
    else{
            height_cm = parseInt(document.getElementById("height").value);
            weight_kg = parseInt(document.getElementById("weight").value);
        
            height_m2 = parseFloat(height_cm/100);
        
            bmi = weight_kg/(height_m2*height_m2);
            document.getElementById("bmi").value = bmi.toFixed(2);
        }

}, false)


document.getElementById("submitCareSupportChecklistForm").addEventListener('click', submitCareSupportChecklistForm, false);
document.getElementById("submitcaregiverandVCStatusUpdateForm").addEventListener('click', submitcaregiverandVCStatusUpdateForm, false);
//document.getElementById("submitEmergencyFundForm").addEventListener('click', submitEmergencyFundForm, false);
document.getElementById("submitReferralForm").addEventListener('click', submitReferralForm, false);

//Assessment Forms
document.getElementById("submitEducationalPerformanceForm").addEventListener('click', submitEducationalPerformanceForm, false);
document.getElementById("submitcommunityBasedPaedsForm").addEventListener('click', submitcommunityBasedPaedsForm, false);
document.getElementById("submitNutritionalAssessmentForm").addEventListener('click', submitNutritionalAssessmentForm, false);

//Update Forms
//document.getElementById("updateCareSupportChecklistForm").addEventListener('click', updateCareSupportChecklistForm, false);
document.getElementById("updatecaregiverandVCStatusUpdateForm").addEventListener('click', updatecaregiverandVCStatusUpdateForm, false);
//document.getElementById("updateEmergencyFundForm").addEventListener('click', updateEmergencyFundForm, false);
document.getElementById("updateReferralForm").addEventListener('click', updateReferralForm, false);
document.getElementById("updateEducationalPerformanceForm").addEventListener('click', updateEducationalPerformanceForm, false);
document.getElementById("updateEducationalPerformanceForm").addEventListener('click', updateEducationalPerformanceForm, false);
document.getElementById("updatecommunityBasedPaedsForm").addEventListener('click', updatecommunityBasedPaedsForm, false);
document.getElementById("updateNutritionalAssessmentForm").addEventListener('click', updateNutritionalAssessmentForm, false);

//Reset Service Forms & Assessment Forms Select Tag once a modal is opened
$(window).on('shown.bs.modal', function() { 
    $('#service_form').prop('selectedIndex',0);
    $('#openServiceForm').attr('data-target','#empty');
    $('#assessment_form').prop('selectedIndex',0);
    $('#openAssessmentForm').attr('data-target','#empty');

});


//Check if User has rights to Data Entry, IF no, Disable the HHVA Form
if(!privilege.includes("Data Entry")){
    document.getElementById("openAssessmentForm").disabled = true;
    document.getElementById("openAssessmentForm").style.backgroundColor = 'gray';
    document.getElementById("openAssessmentForm").innerText = 'disabled';

    document.getElementById("openServiceForm").disabled = true;
    document.getElementById("openServiceForm").style.backgroundColor = 'gray';
    document.getElementById("openServiceForm").innerText = 'disabled';

        Toastify({
            text: "This User does not have data entry rights.",
            style: {
              background: "linear-gradient(to right, #DC3545, #DC3545)",
            },
            close: true,
            duration: 10000
        }).showToast();    
}

}



function submitcaregiverandVCStatusUpdateForm(ev){
    ev.preventDefault();


               hiv_status = document.getElementById("su_hivstatus").value;
               date_hivstatus = document.getElementById("su_date_hivstatus").value;
               enrolledontreatment = document.getElementById("su_enrolledontreatment").value;
               facilityenrolled = document.getElementById("su_facilityenrolled").value;
               artstartdate = document.getElementById("su_artstartdate").value;
               treatment_art_no = document.getElementById("su_treatment_art_no").value;
               childhasbirthcertificate = document.getElementById("su_childhasbirthcertificate").value;
               childinschool = document.getElementById("su_childinschool").value;
               schoolname = document.getElementById("su_schoolname").value;
               schoolgrade = document.getElementById("su_schoolgrade").value;
               childonvocationaltraining = document.getElementById("su_childonvocationaltraining").value;
               vocationalinstitute = document.getElementById("su_vocationalinstitute").value;
               caregivername = document.getElementById("su_caregivername").value;
               enrollmentstatus = document.getElementById("su_enrollmentstatus").value;
               enrollmentstatus_date = document.getElementById("su_enrollmentstatus_date").value;

               //Run Function to Compare Last Update with this current one.
            $.ajax({
            url: 'db/getLastBeneficiaryStatus.php',
            type: 'post', 
            dataType: 'json',
            data: "vcUniqueId="+vcUniqueId,
            success: function(response){ 
            if(response.status=="success"){
                compare_fullname = response.name;
                compare_sex = response.gender;
                compare_currenthivstatus = response.hiv_status;
                compare_enrollmentstatus = response.enrollmentstatus;
                compare_date_enrollmentstatus = response.enrollmentstatus_date;
                compare_hivstatus = response.hiv_status;
                compare_date_hivstatus = response.date_hivstatus;
                compare_enrolledontreatment = response.enrolledontreatment;
                compare_facilityenrolled = response.facilityenrolled;
                compare_artstartdate = response.artstartdate;
                compare_treatment_art_no = response.treatment_art_no;
                compare_childhasbirthcertificate = response.childhasbirthcertificate;
                compare_childinschool = response.childinschool;
                compare_schoolname = response.schoolname;
                compare_schoolgrade = response.schoolgrade;
                compare_childonvocationaltraining = response.childonvocationaltraining;
                compare_vocationalinstitute = response.vocationalinstitute;
                compare_caregivername = response.caregivername;
                compare_enrollmentstatus = response.enrollmentstatus;
                compare_enrollmentstatus_date = response.enrollmentstatus_date;

                //Check if the Information on the DB for the Beneficiary has been modified. If no, do not continue to update the form.
                   if(compare_hivstatus != hiv_status ||
                      compare_date_hivstatus != date_hivstatus ||
                      compare_enrolledontreatment != enrolledontreatment ||
                      compare_facilityenrolled != facilityenrolled ||
                      compare_artstartdate != artstartdate ||
                      compare_treatment_art_no != treatment_art_no ||
                      compare_childhasbirthcertificate != childhasbirthcertificate ||
                      compare_childinschool != childinschool ||
                      compare_schoolname != schoolname ||
                      compare_schoolgrade != schoolgrade ||
                      compare_childonvocationaltraining != childonvocationaltraining ||
                      compare_vocationalinstitute != vocationalinstitute ||
                      compare_caregivername != caregivername ||
                      compare_enrollmentstatus != enrollmentstatus ||
                      compare_enrollmentstatus_date != enrollmentstatus_date){
                          isChanges = true;
                          executeIfChangeOccurs(isChanges);
                          console.log("Changes Detected: "+isChanges);
                      }
                      else{
                          isChanges = false;
                          executeIfChangeOccurs(isChanges);
                          console.log("No: Changes NOT Detected: "+isChanges);                      
                      }                 
            }
            else{
                console.log('Failure')
                alert("Cannot Pull COMPARISON Data");
            }
          }	
        }) 
               
               su_hiv_status = document.getElementById("su_hivstatus").value;
               su_date_hivstatus = document.getElementById("su_date_hivstatus").value;
               su_enrolledontreatment = document.getElementById("su_enrolledontreatment").value;
               su_facilityenrolled = document.getElementById("su_facilityenrolled").value;
               su_artstartdate = document.getElementById("su_artstartdate").value;
               su_treatment_art_no = document.getElementById("su_treatment_art_no").value;
               su_childhasbirthcertificate = document.getElementById("su_childhasbirthcertificate").value;
               su_childinschool = document.getElementById("su_childinschool").value;
               su_schoolname = document.getElementById("su_schoolname").value;
               su_schoolgrade = document.getElementById("su_schoolgrade").value;
               su_childonvocationaltraining = document.getElementById("su_childonvocationaltraining").value;
               su_vocationalinstitute = document.getElementById("su_vocationalinstitute").value;
               su_caregivername = document.getElementById("su_caregivername").value;
               su_enrollmentstatus = document.getElementById("su_enrollmentstatus").value;
               su_enrollmentstatus_date = document.getElementById("su_enrollmentstatus_date").value;


        //Check for Validation and Missed Entries
        if(su_hiv_status=="" || su_hiv_status=="Response"){document.getElementById("su_hivstatus_label").innerHTML="Field is required";su_hiv_status_chk=0;$('#collapsehivTestInformation').collapse('show');}else{su_hiv_status_chk=1;document.getElementById("su_hivstatus_label").innerHTML="";$('#collapsehivTestInformation').collapse('hide');}
        if((su_hiv_status=="Positive" || su_hiv_status=="Negative") && su_date_hivstatus==""){document.getElementById("su_date_hivstatus_label").innerHTML="Field is required";su_date_hivstatus_chk=0;$('#collapsehivTestInformation').collapse('show');}else{su_date_hivstatus_chk=1;document.getElementById("su_date_hivstatus_label").innerHTML="";$('#collapsehivTestInformation').collapse('hide');}
        if(su_hiv_status=="Positive" && su_enrolledontreatment=="Response"){document.getElementById("su_enrolledontreatment_label").innerHTML="Field is required";su_enrolledontreatment_chk=0;$('#collapsehivTestInformation').collapse('show');}else{su_enrolledontreatment_chk=1;document.getElementById("su_enrolledontreatment_label").innerHTML="";$('#collapsehivTestInformation').collapse('hide');}
        if(su_enrolledontreatment=="Yes" && su_facilityenrolled==""){document.getElementById("su_facilityenrolled_label").innerHTML="Field is required";su_facilityenrolled_chk=0;$('#collapsehivTestInformation').collapse('show');}else{su_facilityenrolled_chk=1;document.getElementById("su_facilityenrolled_label").innerHTML="";$('#collapsehivTestInformation').collapse('hide');}
        if(su_enrolledontreatment=="Yes" && su_artstartdate==""){document.getElementById("su_artstartdate_label").innerHTML="Field is required";su_artstartdate_chk=0;$('#collapsehivTestInformation').collapse('show');}else{su_artstartdate_chk=1;document.getElementById("su_artstartdate_label").innerHTML="";$('#collapsehivTestInformation').collapse('hide');}
        if(su_enrolledontreatment=="Yes" && su_treatment_art_no==""){document.getElementById("su_treatment_art_no_label").innerHTML="Field is required";su_treatment_art_no_chk=0;$('#collapsehivTestInformation').collapse('show');}else{su_treatment_art_no_chk=1;document.getElementById("su_treatment_art_no_label").innerHTML="";$('#collapsehivTestInformation').collapse('hide');}
        if(su_childhasbirthcertificate=="" || su_childhasbirthcertificate=="Response"){document.getElementById("su_childhasbirthcertificate_label").innerHTML="Field is required";su_childhasbirthcertificate_chk=0;$('#collapsecurrentBirthEducationStatus').collapse('show');}else{su_childhasbirthcertificate_chk=1;document.getElementById("su_childhasbirthcertificate_label").innerHTML="";$('#collapsecurrentBirthEducationStatus').collapse('hide');}
        if(su_childinschool=="" || su_childinschool=="Response"){document.getElementById("su_childinschool_label").innerHTML="Field is required";su_childinschool_chk=0;$('#collapsecurrentBirthEducationStatus').collapse('show');}else{su_childinschool_chk=1;document.getElementById("su_childinschool_label").innerHTML="";$('#collapsecurrentBirthEducationStatus').collapse('hide');}
        if(su_childinschool=="Yes" && su_schoolname=="Response"){document.getElementById("su_schoolname_label").innerHTML="Field is required";su_schoolname_chk=0;$('#collapsecurrentBirthEducationStatus').collapse('show');}else{su_schoolname_chk=1;document.getElementById("su_schoolname_label").innerHTML="";$('#collapsecurrentBirthEducationStatus').collapse('hide');}
        if(su_childinschool=="Yes" && su_schoolgrade=="Response"){document.getElementById("su_schoolgrade_label").innerHTML="Field is required";su_schoolgrade_chk=0;$('#collapsecurrentBirthEducationStatus').collapse('show');}else{su_schoolgrade_chk=1;document.getElementById("su_schoolgrade_label").innerHTML="";$('#collapsecurrentBirthEducationStatus').collapse('hide');}
        if(su_childonvocationaltraining=="" || su_childonvocationaltraining=="Response"){document.getElementById("su_childonvocationaltraining_label").innerHTML="Field is required";su_childonvocationaltraining_chk=0;$('#collapsecurrentBirthEducationStatus').collapse('show');}else{su_childonvocationaltraining_chk=1;document.getElementById("su_childonvocationaltraining_label").innerHTML="";$('#collapsecurrentBirthEducationStatus').collapse('hide');}
        if(su_childonvocationaltraining=="Yes" && su_vocationalinstitute==""){document.getElementById("su_vocationalinstitute_label").innerHTML="Field is required";su_vocationalinstitute_chk=0;$('#collapsecurrentBirthEducationStatus').collapse('show');}else{su_vocationalinstitute_chk=1;document.getElementById("su_vocationalinstitute_label").innerHTML="";$('#collapsecurrentBirthEducationStatus').collapse('hide');}
        if(su_caregivername=="" || su_caregivername=="Response"){document.getElementById("su_caregivername_label").innerHTML="Field is required";su_caregivername_chk=0;$('#collapsecaregiverInformation').collapse('show');}else{su_caregivername_chk=1;document.getElementById("su_caregivername_label").innerHTML="";$('#collapsecaregiverInformation').collapse('hide');}
        if(su_enrollmentstatus=="" || su_enrollmentstatus=="Select"){document.getElementById("su_enrollmentstatus_label").innerHTML="Field is required";su_enrollmentstatus_chk=0;$('#collapseenrollmentExitInformation').collapse('show');}else{su_enrollmentstatus_chk=1;document.getElementById("su_enrollmentstatus_label").innerHTML="";$('#collapseenrollmentExitInformation').collapse('hide');}
        if(su_enrollmentstatus_date==""){document.getElementById("su_enrollmentstatus_date_label").innerHTML="Field is required";su_enrollmentstatus_date_chk=0;$('#collapseenrollmentExitInformation').collapse('show');}else{su_enrollmentstatus_date_chk=1;document.getElementById("su_enrollmentstatus_date_label").innerHTML="";$('#collapseenrollmentExitInformation').collapse('hide');}





    
    //Confirm validation and set validation status
    if(su_hiv_status_chk == 0 || su_date_hivstatus_chk == 0 || su_enrolledontreatment_chk == 0 || su_facilityenrolled_chk == 0
        || su_artstartdate_chk == 0
        || su_treatment_art_no_chk == 0
        || su_childhasbirthcertificate_chk == 0
        || su_childinschool_chk == 0
        || su_schoolname_chk == 0
        || su_schoolgrade_chk == 0
        || su_childonvocationaltraining_chk == 0
        || su_vocationalinstitute_chk == 0
        || su_caregivername_chk == 0
        || su_enrollmentstatus_chk == 0
        || su_enrollmentstatus_date_chk == 0
        
        ){
        validation_state = 'failed';
        Toastify({
            text: "Validation Failed. Review form elements",
            style: {
              background: "linear-gradient(to right, #DC3545, #DC3545)",
            },
            close: true,
            duration: 10000
        }).showToast();
        $('#collapsecareandSupportFormListTable').attr('class','collapse');
        $('#collapsecareandSupportFormListTable').attr('class','show');

    }
    else{
        function executeIfChangeOccurs(isChange){
            if(isChange){
                createcaregiverandVCStatusUpdateRecord();
            }   
        else{
                Toastify({
                    text: "Error: No changes was detected for the Beneficiary",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }        
        }

    }


}

function createcaregiverandVCStatusUpdateRecord(){

    $.ajax({
        url: 'db/createcaregiverandVCStatusUpdateRecord.php',
        type: 'post',
        data: "unique_id="+vcUniqueId+"&hiv_status="+su_hiv_status+"&date_hivstatus="+su_date_hivstatus+"&enrolledontreatment="+su_enrolledontreatment+"&facilityenrolled="+su_facilityenrolled
        +"&artstartdate="+su_artstartdate
        +"&treatment_art_no="+su_treatment_art_no
        +"&childhasbirthcertificate="+su_childhasbirthcertificate
        +"&childinschool="+su_childinschool
        +"&schoolname="+su_schoolname
        +"&schoolgrade="+su_schoolgrade
        +"&childonvocationaltraining="+su_childonvocationaltraining
        +"&vocationalinstitute="+su_vocationalinstitute
        +"&caregivername="+su_caregivername
        +"&enrollmentstatus="+su_enrollmentstatus
        +"&enrollmentstatus_date="+su_enrollmentstatus_date
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Beneficiary OVC Status Updated",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //re-initialize table
                var caregiverVcStatusUpdateTable = $('#caregiverVcStatusUpdateTable').DataTable();
                caregiverVcStatusUpdateTable.ajax.reload();
                $('#collapsecaregiverUpdateListTable').attr('class','collapse');
                $('#collapsecaregiverUpdateListTable').attr('class','show');
                document.getElementById("caregiverandVCStatusUpdateForm").reset();
                $('#newcaregiverandVCStatusUpdate').modal('hide');
                householdDetailsRefresh();                
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Caregiver/VC Status NOT created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}

function submitEmergencyFundForm(ev){
    ev.preventDefault();
    efserviceQuestion1 = document.getElementById("efserviceQuestion1").innerText;
    efresponseQuestion1 = document.getElementById("efresponseQuestion1").value;
    efserviceQuestion2 = document.getElementById("efserviceQuestion2").innerText;
    efresponseQuestion2 = document.getElementById("efresponseQuestion2").value;
    efserviceQuestion3 = document.getElementById("efserviceQuestion3").innerText;
    var checked_question3 = []
    $("input[name='efresponseQuestion3[]']:checked").each(function ()
    {
        checked_question3.push($(this).val());
    });
    efresponseQuestion3 = checked_question3.toString();

    efserviceQuestion4 = document.getElementById("efserviceQuestion4").innerText;
    var checked_question4 = []
    $("input[name='efresponseQuestion4[]']:checked").each(function ()
    {
        checked_question4.push($(this).val());
    });
    efresponseQuestion4 = checked_question4.toString();
    
    efresponseQuestion3_other = document.getElementById("efresponseQuestion3_other").value;
    efresponseQuestion4_other = document.getElementById("efresponseQuestion4_other").value;
    service_date_ef = document.getElementById("service_date_ef").value;

        //Check for Validation and Missed Entries
        if(efresponseQuestion1=="" || efresponseQuestion1=="Response"){document.getElementById("efresponseQuestion1_label").innerHTML="Field is required";efresponseQuestion1_chk=0;$('#collapseaccessToEmergencyFund').collapse('show');}else{efresponseQuestion1_chk=1;document.getElementById("efresponseQuestion1_label").innerHTML="";$('#collapseaccessToEmergencyFund').collapse('hide');}
        if(efresponseQuestion2=="" || efresponseQuestion2=="Response"){document.getElementById("efresponseQuestion2_label").innerHTML="Field is required";efresponseQuestion2_chk=0;$('#collapseaccessToEmergencyFund').collapse('show');}else{efresponseQuestion2_chk=1;document.getElementById("efresponseQuestion2_label").innerHTML="";$('#collapseaccessToEmergencyFund').collapse('hide');}
        if(service_date_ef==""){document.getElementById("service_date_ef_label").innerHTML="Field is required";service_date_ef_chk=0;$('#collapseefServiceProviderInformation').collapse('show');}else{service_date_ef_chk=1;document.getElementById("service_date_ef_label").innerHTML="";$('#collapseefServiceProviderInformation').collapse('hide');}
 
 
        if(efresponseQuestion2=='Yes'){
            if(efresponseQuestion4==""){document.getElementById("efresponseQuestion4_label").innerHTML="Field is required";efresponseQuestion4_chk=0;$('#collapseaccessToEmergencyFund').collapse('show');}else{efresponseQuestion4_chk=1;document.getElementById("efresponseQuestion4_label").innerHTML="";$('#collapseaccessToEmergencyFund').collapse('hide');}
            
                        //Confirm validation and set validation status
            if(efresponseQuestion1_chk == 0 || efresponseQuestion2_chk == 0 || efresponseQuestion4_chk == 0 || service_date_ef_chk == 0){
                validation_state = 'failed';
                Toastify({
                    text: "Validation Failed. Review form elements",
                    style: {
                    background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();
                $('#collapsecareandSupportFormListTable').attr('class','collapse');
                $('#collapsecareandSupportFormListTable').attr('class','show');

            }
            else{
                createAccesstoEmergencyFundRecord();
            }
        
}   
else if(efresponseQuestion2=='No'){
    if(efresponseQuestion3==""){document.getElementById("efresponseQuestion3_label").innerHTML="Field is required";efresponseQuestion3_chk=0;$('#collapseaccessToEmergencyFund').collapse('show');}else{efresponseQuestion3_chk=1;document.getElementById("efresponseQuestion3_label").innerHTML="";$('#collapseaccessToEmergencyFund').collapse('hide');}

        //Confirm validation and set validation status
        if(efresponseQuestion1_chk == 0 || efresponseQuestion2_chk == 0 || efresponseQuestion3_chk == 0 || service_date_ef_chk == 0){
            validation_state = 'failed';
            Toastify({
                text: "Validation Failed. Review form elements",
                style: {
                background: "linear-gradient(to right, #DC3545, #DC3545)",
                },
                close: true,
                duration: 10000
            }).showToast();
            $('#collapsecareandSupportFormListTable').attr('class','collapse');
            $('#collapsecareandSupportFormListTable').attr('class','show');

        }
        else{
            createAccesstoEmergencyFundRecord();
        }
}   
}

function createAccesstoEmergencyFundRecord(){
    $.ajax({
        url: 'db/createAccesstoEmergencyFundRecord.php',
        type: 'post',
        data: "serviceQuestion1="+efserviceQuestion1
        +"&serviceQuestion2="+efserviceQuestion2
        +"&serviceQuestion3="+efserviceQuestion3
        +"&serviceQuestion4="+efserviceQuestion4
        +"&responseQuestion1="+efresponseQuestion1
        +"&responseQuestion2="+efresponseQuestion2
        +"&responseQuestion3="+efresponseQuestion3
        +"&responseQuestion4="+efresponseQuestion4
        +"&responseQuestion3_other="+efresponseQuestion3_other
        +"&responseQuestion4_other="+efresponseQuestion4_other
        +"&service_date="+service_date_ef
        +"&hh_unique_num="+hh_unique_num
        +"&unique_id="+vcUniqueId
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "New Access To Emergency Fund Checklist Created",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //re-initialize table
                var caregiverAccessEmergencyTable = $('#caregiverAccessEmergencyTable').DataTable();
                caregiverAccessEmergencyTable.ajax.reload();
               document.getElementById("caregiverAccessEmergencyTable").reset();
               $('#collapsecaregiverAccessEmergencyListTable').attr('class','collapse');
               $('#collapsecaregiverAccessEmergencyListTable').attr('class','show');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Access To Emergency Fund Checklist NOT created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Error: Access To Emergency Fund Checklist Entry ALREADY EXISTS, Review Date",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}

function submitReferralForm(ev){
    ev.preventDefault();
    referring_organization = document.getElementById("referring_organization").value;
    receiving_organization = document.getElementById("receiving_organization").value;
    //Convert Checkboxes to Array->toString for field (table) reservicereferred
    var checked_reservicereferred = []
    $("input[name='reservicereferred[]']:checked").each(function ()
    {
        checked_reservicereferred.push($(this).val());
    });
    reservicereferred = checked_reservicereferred.toString();

    organization_providingreferral = document.getElementById("organization_providingreferral").value;
    service_provided = document.getElementById("rf_service_provided").value;
    service_completed = document.getElementById("rf_service_completed").value;
    followup_needed = document.getElementById("rf_followup_needed").value;
    followup_date = document.getElementById("rf_followup_date").value;
    referral_date = document.getElementById("referral_date").value;

    input_service_provided = document.getElementsByName("rf_service_provided[]");
    input_service_completed = document.getElementsByName("rf_service_completed[]");
    input_followup_needed = document.getElementsByName("rf_followup_needed[]");
    input_followup_date = document.getElementsByName("rf_followup_date[]");

    referral_status = document.getElementById("rf_referral_status").value;
    referral_receiver = document.getElementById("referral_receiver").value;
    referral_receiver_designation = document.getElementById("referral_receiver_designation").value;
    referral_receiver_phonenumber = document.getElementById("referral_receiver_phonenumber").value;
    referral_receiver_email = document.getElementById("referral_receiver_email").value;


        //Check for Validation and Missed Entries
        if(organization_providingreferral==""){document.getElementById("organization_providingreferral_label").innerHTML="Field is required";organization_providingreferral_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{organization_providingreferral_chk=1;document.getElementById("organization_providingreferral_label").innerHTML="";$('#collapseservicesReferredSectionB').collapse('hide');}
        if(reservicereferred==""){reservicereferred_chk=0;$('#collapseservicesReferredFor').collapse('show');}else{reservicereferred_chk=1;$('#collapseservicesReferredFor').collapse('hide');}
        if(service_provided==""){service_provided_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{service_provided_chk=1;$('#collapseservicesReferredSectionB').collapse('hide');}
        if(service_completed=="" || service_completed=="Response"){service_completed_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{service_completed_chk=1;$('#collapseservicesReferredSectionB').collapse('hide');}
        if(followup_needed=="" || followup_needed=="Response"){followup_needed_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{followup_needed_chk=1;$('#collapseservicesReferredSectionB').collapse('hide');}
        if(followup_needed=="Yes" && followup_date==""){followup_date_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{followup_date_chk=1;$('#collapseservicesReferredSectionB').collapse('hide');}
   
        if(referral_status=="" || referral_status=="Response"){document.getElementById("rf_referral_status_label").innerHTML="Field is required";rf_referral_status_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{rf_referral_status_chk=1;document.getElementById("rf_referral_status_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_date==""){document.getElementById("referral_date_label").innerHTML="Field is required";referral_date_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_date_chk=1;document.getElementById("referral_date_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver==""){document.getElementById("referral_receiver_label").innerHTML="Field is required";referral_receiver_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_receiver_chk=1;document.getElementById("referral_receiver_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver_designation==""){document.getElementById("referral_receiver_designation_label").innerHTML="Field is required";referral_receiver_designation_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_receiver_designation_chk=1;document.getElementById("referral_receiver_designation_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver_phonenumber==""){document.getElementById("referral_receiver_phonenumber_label").innerHTML="Field is required";referral_receiver_phonenumber_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_receiver_phonenumber_chk=1;document.getElementById("referral_receiver_phonenumber_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver_email==""){document.getElementById("referral_receiver_email_label").innerHTML="Field is required";referral_receiver_email_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_receiver_email_chk=1;document.getElementById("referral_receiver_email_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
  
        if(referring_organization==""){document.getElementById("referring_organization_label").innerHTML="Field is required";referring_organization_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referring_organization_chk=1;document.getElementById("referring_organization_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver_email==""){document.getElementById("referring_organization_label").innerHTML="Field is required";referring_organization_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referring_organization_chk=1;document.getElementById("referring_organization_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
//Confirm validation and set validation status
    if(reservicereferred_chk == 0 || referral_date_chk == 0 || service_provided_chk == 0 ||service_completed_chk == 0 ||followup_needed_chk == 0 ||followup_date_chk == 0 ||rf_referral_status_chk == 0 ||referral_receiver_chk == 0 ||referral_receiver_designation_chk == 0 ||referral_receiver_phonenumber_chk == 0 ||referral_receiver_email_chk == 0 ||referring_organization_chk == 0 ||referring_organization_chk == 0){

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
        for (var i = 0; i < input_service_provided.length; i++) {
            var xinput_service_provided = input_service_provided[i];
            var xinput_service_completed = input_service_completed[i];
            var xinput_followup_needed = input_followup_needed[i];
            var xinput_followup_date = input_followup_date[i];
            createtReferralFormRecord(xinput_service_provided.value,xinput_service_completed.value,xinput_followup_needed.value,xinput_followup_date.value);
            if(i ==input_service_provided.length - 1){
                document.getElementById("entryReferralForm").reset();            
            }
        } 
    }
}

function createtReferralFormRecord(input_service_provided,input_service_completed,input_followup_needed,input_followup_date){
   
    $.ajax({
        url: 'db/createtReferralFormRecord.php',
        type: 'post',
        data: "referring_organization="+referring_organization+"&receiving_organization="+receiving_organization+"&reservicereferred="+reservicereferred+"&organization_providingreferral="+organization_providingreferral+"&service_provided="+input_service_provided+"&service_completed="+input_service_completed+"&followup_needed="+input_followup_needed+"&followup_date="+input_followup_date+"&referral_status="+referral_status+"&referral_receiver="+referral_receiver+"&referral_receiver_designation="+referral_receiver_designation+"&referral_receiver_phonenumber="+referral_receiver_phonenumber+"&vc_unique_id="+vcUniqueId+"&hh_unique_num="+hh_unique_num+"&referral_receiver_email="+referral_receiver_email+"&referral_date="+referral_date,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Referral: "+input_service_provided+"; Created Successfully",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();
                //document.getElementById("entryReferralForm").reset();
                $('#collapsecareandSupportFormListTable').attr('class','collapse');
                $('#collapsecareandSupportFormListTable').attr('class','show');
        
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Referral: "+input_service_provided+"; Not Created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Referral: "+input_service_provided+"; already exists on Specified Date, Please review",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  }) 
}

function submitEducationalPerformanceForm(ev){
    ev.preventDefault();
    question1 = document.getElementById("ppassessmentQuestion1").innerText;
    responseQuestion1 = document.getElementById("ppassessmentresponseQuestion1").value;
    question2 = document.getElementById("ppassessmentQuestion2").innerText;
    responseQuestion2 = document.getElementById("ppassessmentresponseQuestion2").value;
    question3 = document.getElementById("ppassessmentQuestion3").innerText;
    responseQuestion3 = document.getElementById("ppassessmentresponseQuestion3").value
    question4 = document.getElementById("aaassessmentQuestion1").innerText;
    responseQuestion4 = document.getElementById("aaassessmentresponseQuestion1").value;
    question5 = document.getElementById("aaassessmentQuestion2").innerText;
    responseQuestion5 = document.getElementById("aaassessmentresponseQuestion2").value;
    question6 = document.getElementById("aaassessmentQuestion3").innerText;
    responseQuestion6 = document.getElementById("aaassessmentresponseQuestion3").value;
    question7 = document.getElementById("aaassessmentQuestion4").innerText;
    responseQuestion7 = document.getElementById("aaassessmentresponseQuestion4").value;
    question8 = document.getElementById("aaassessmentQuestion5").innerText;
    responseQuestion8 = document.getElementById("aaassessmentresponseQuestion5").value;

    cso_staffname = document.getElementById("cso_staffname").value;
    cso_date = document.getElementById("cso_date").value;
    teacher_name = document.getElementById("teacher_name").value;
    teacher_date = document.getElementById("teacher_date").value;


        //Check for Validation and Missed Entries
        if(responseQuestion1=="" || responseQuestion1=='Response'){document.getElementById("ppassessmentresponseQuestion1_label").innerHTML="Field is required";ppassessmentresponseQuestion1_chk=0;$('#collapsechildEducationalPerfAssForm').collapse('show');}else{ppassessmentresponseQuestion1_chk=1;document.getElementById("ppassessmentresponseQuestion1_label").innerHTML="";$('#collapsechildEducationalPerfAssForm').collapse('hide');}
        if(responseQuestion2=="" || responseQuestion2=='Response'){document.getElementById("ppassessmentresponseQuestion2_label").innerHTML="Field is required";ppassessmentresponseQuestion2_chk=0;$('#collapsechildEducationalPerfAssForm').collapse('show');}else{ppassessmentresponseQuestion2_chk=1;document.getElementById("ppassessmentresponseQuestion2_label").innerHTML="";$('#collapsechildEducationalPerfAssForm').collapse('hide');}
        if(responseQuestion3=="" || responseQuestion3=='Response'){document.getElementById("ppassessmentresponseQuestion3_label").innerHTML="Field is required";ppassessmentresponseQuestion3_chk=0;$('#collapsechildEducationalPerfAssForm').collapse('show');}else{ppassessmentresponseQuestion3_chk=1;document.getElementById("ppassessmentresponseQuestion3_label").innerHTML="";$('#collapsechildEducationalPerfAssForm').collapse('hide');}
 
        if(responseQuestion4=="" || responseQuestion4=='Response'){document.getElementById("aaassessmentresponseQuestion1_label").innerHTML="Field is required";aaassessmentresponseQuestion4_chk=0;$('#collapseacademicAssessment').collapse('show');}else{aaassessmentresponseQuestion4_chk=1;document.getElementById("aaassessmentresponseQuestion1_label").innerHTML="";$('#collapseacademicAssessment').collapse('hide');}
        if(responseQuestion5=="" || responseQuestion5=='Response'){document.getElementById("aaassessmentresponseQuestion2_label").innerHTML="Field is required";aaassessmentresponseQuestion5_chk=0;$('#collapseacademicAssessment').collapse('show');}else{aaassessmentresponseQuestion5_chk=1;document.getElementById("aaassessmentresponseQuestion2_label").innerHTML="";$('#collapseacademicAssessment').collapse('hide');}
        if(responseQuestion6=="" || responseQuestion6=='Response'){document.getElementById("aaassessmentresponseQuestion3_label").innerHTML="Field is required";aaassessmentresponseQuestion6_chk=0;$('#collapseacademicAssessment').collapse('show');}else{aaassessmentresponseQuestion6_chk=1;document.getElementById("aaassessmentresponseQuestion3_label").innerHTML="";$('#collapseacademicAssessment').collapse('hide');}
        if(responseQuestion7=="" || responseQuestion7=='Response'){document.getElementById("aaassessmentresponseQuestion4_label").innerHTML="Field is required";aaassessmentresponseQuestion7_chk=0;$('#collapseacademicAssessment').collapse('show');}else{aaassessmentresponseQuestion7_chk=1;document.getElementById("aaassessmentresponseQuestion4_label").innerHTML="";$('#collapseacademicAssessment').collapse('hide');}
        if(responseQuestion8=="" || responseQuestion8=='Response'){document.getElementById("aaassessmentresponseQuestion5_label").innerHTML="Field is required";aaassessmentresponseQuestion8_chk=0;$('#collapseacademicAssessment').collapse('show');}else{aaassessmentresponseQuestion8_chk=1;document.getElementById("aaassessmentresponseQuestion5_label").innerHTML="";$('#collapseacademicAssessment').collapse('hide');}

        if(cso_staffname==""){document.getElementById("cso_staffname_label").innerHTML="Field is required";cso_staffname_chk=0;$('#collapseserviceProviderInformation').collapse('show');}else{cso_staffname_chk=1;document.getElementById("cso_staffname_label").innerHTML="";$('#collapseserviceProviderInformation').collapse('hide');}
        if(cso_date==""){document.getElementById("cso_date_label").innerHTML="Field is required";cso_date_chk=0;$('#collapseserviceProviderInformation').collapse('show');}else{cso_date_chk=1;document.getElementById("cso_date_label").innerHTML="";$('#collapseserviceProviderInformation').collapse('hide');}
        if(teacher_name==""){document.getElementById("teacher_name_label").innerHTML="Field is required";teacher_name_chk=0;$('#collapseserviceProviderInformation').collapse('show');}else{teacher_name_chk=1;document.getElementById("teacher_name_label").innerHTML="";$('#collapseserviceProviderInformation').collapse('hide');}
        if(teacher_date==""){document.getElementById("teacher_date_label").innerHTML="Field is required";teacher_date_chk=0;$('#collapseserviceProviderInformation').collapse('show');}else{teacher_date_chk=1;document.getElementById("teacher_date_label").innerHTML="";$('#collapseserviceProviderInformation').collapse('hide');}
   
   
//Confirm validation and set validation status
    if(teacher_date_chk == 0 || teacher_name_chk == 0 || cso_date_chk == 0 || cso_staffname_chk == 0 || aaassessmentresponseQuestion8_chk == 0 || aaassessmentresponseQuestion7_chk == 0 || aaassessmentresponseQuestion6_chk == 0 || aaassessmentresponseQuestion5_chk == 0 || aaassessmentresponseQuestion4_chk == 0 || ppassessmentresponseQuestion3_chk == 0 || ppassessmentresponseQuestion2_chk == 0 || ppassessmentresponseQuestion1_chk == 0){
        validation_state = 'failed';
        Toastify({
            text: "Validation Failed. Review form elements",
            style: {
              background: "linear-gradient(to right, #DC3545, #DC3545)",
            },
            close: true,
            duration: 10000
        }).showToast();
        $('#collapsecareandSupportFormListTable').attr('class','collapse');
        $('#collapsecareandSupportFormListTable').attr('class','show');

    }
    else{
        createEducationalPerformance();
    }
}

function createEducationalPerformance(){
    $.ajax({
        url: 'db/createEducationalPerformance.php',
        type: 'post',
        data: "question1="+question1+
        "&responseQuestion1="+responseQuestion1+
        "&question2="+question2+
        "&responseQuestion2="+responseQuestion2+
        "&question3="+question3+
        "&responseQuestion3="+responseQuestion3+
        "&question4="+question4+
        "&responseQuestion4="+responseQuestion4+
        "&question5="+question5+
        "&responseQuestion5="+responseQuestion5+
        "&question6="+question6+
        "&responseQuestion6="+responseQuestion6+
        "&question7="+question7+
        "&responseQuestion7="+responseQuestion7+
        "&question8="+question8+
        "&responseQuestion8="+responseQuestion8+
        "&vc_unique_id="+vcUniqueId+
        "&hh_unique_num="+hh_unique_num+
        "&cso_staffname="+cso_staffname+
        "&cso_date="+cso_date+
        "&teacher_name="+teacher_name+
        "&teacher_date="+teacher_date,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Child Educational Performance Assessment Created Successfully",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();
                document.getElementById("childEducationalPerfAssForm").reset();
                $('#collapsecareandSupportFormListTable').attr('class','collapse');
                $('#collapsecareandSupportFormListTable').attr('class','show');
        
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Child Edicational Performance Assessment Not Created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Alert: Child Edicational Performance Assessment already exists on Specified Date, Please review",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  }) 
}

function submitcommunityBasedPaedsForm(ev){
    ev.preventDefault();

    respondent_childrelationship = document.getElementById("respondent_childrelationship").value;
    childhivstatusknowledge = document.getElementById("childhivstatusknowledge").value;
    childhivstatus_paeds = document.getElementById("childhivstatus_paeds").value;

    cbp_mainQuestion1 = document.getElementById("cbp_mainQuestion1").innerText;
    cbp_subQuestion1_1 = document.getElementById("cbp_subQuestion1_1").innerText;
    cbp_subQuestionResponse1_1 = document.getElementById("cbp_subQuestionResponse1_1").value;
    cbp_subQuestion2_1 = document.getElementById("cbp_subQuestion2_1").innerText;
    cbp_subQuestionResponse2_1 = document.getElementById("cbp_subQuestionResponse2_1").value;

    cbp_mainQuestion2 = document.getElementById("cbp_mainQuestion2").innerText;
    cbp_subQuestion1_2 = document.getElementById("cbp_subQuestion1_2").innerText;
    cbp_subQuestionResponse1_2 = document.getElementById("cbp_subQuestionResponse1_2").value;
    cbp_subQuestion2_2 = document.getElementById("cbp_subQuestion2_2").innerText;
    cbp_subQuestionResponse2_2 = document.getElementById("cbp_subQuestionResponse2_2").value;

    cbp_mainQuestion3 = document.getElementById("cbp_mainQuestion3").innerText;
    cbp_subQuestion1_3 = document.getElementById("cbp_subQuestion1_3").innerText;
    cbp_subQuestionResponse1_3 = document.getElementById("cbp_subQuestionResponse1_3").value;
    cbp_subQuestion2_3 = document.getElementById("cbp_subQuestion2_3").innerText;
    cbp_subQuestionResponse2_3 = document.getElementById("cbp_subQuestionResponse2_3").value;


    cbp_Question4 = document.getElementById("cbp_Question4").innerText;
    cbp_QuestionResponse4 = document.getElementById("cbp_QuestionResponse4").value;

    cbp_mainQuestion5 = document.getElementById("cbp_mainQuestion5").innerText;
    cbp_subQuestion1_5 = document.getElementById("cbp_subQuestion1_5").innerText;
    cbp_subQuestionResponse1_5 = document.getElementById("cbp_subQuestionResponse1_5").value;
    cbp_subQuestion2_5 = document.getElementById("cbp_subQuestion2_5").innerText;
    cbp_subQuestionResponse2_5 = document.getElementById("cbp_subQuestionResponse2_5").value;

    cbp_mainQuestion6 = document.getElementById("cbp_mainQuestion6").innerText;
    cbp_subQuestion1_6 = document.getElementById("cbp_subQuestion1_6").innerText;
    cbp_subQuestionResponse1_6 = document.getElementById("cbp_subQuestionResponse1_6").value;
    cbp_subQuestion2_6 = document.getElementById("cbp_subQuestion2_6").innerText;
    cbp_subQuestionResponse2_6 = document.getElementById("cbp_subQuestionResponse2_6").value;


    cbp_Question7 = document.getElementById("cbp_Question7").innerText;
    cbp_QuestionResponse7 = document.getElementById("cbp_QuestionResponse7").value;


    cbp_Question8 = document.getElementById("cbp_Question8").innerText;
    cbp_QuestionResponse8 = document.getElementById("cbp_QuestionResponse8").value;

    cbp_Question9 = document.getElementById("cbp_Question9").innerText;
    cbp_QuestionResponse9 = document.getElementById("cbp_QuestionResponse9").value;

    childatrisk = document.getElementById("childatrisk").value;
    serviceprovider = document.getElementById("serviceprovider").value;
    serviceprovisiondate = document.getElementById("serviceprovisiondate").value;

        //Check for Validation and Missed Entries
        if(respondent_childrelationship=="" || respondent_childrelationship=='Response'){document.getElementById("respondent_childrelationship_label").innerHTML="Field is required";respondent_childrelationship_chk=0;$('#collapsecommunityBasedPaedsForm').collapse('show');}else{respondent_childrelationship_chk=1;document.getElementById("respondent_childrelationship_label").innerHTML="";$('#collapsecommunityBasedPaedsForm').collapse('hide');}
        if(childhivstatusknowledge=="" || childhivstatusknowledge=='Response'){document.getElementById("childhivstatusknowledge_label").innerHTML="Field is required";childhivstatusknowledge_chk=0;$('#collapsecommunityBasedPaedsForm').collapse('show');}else{childhivstatusknowledge_chk=1;document.getElementById("childhivstatusknowledge_label").innerHTML="";$('#collapsecommunityBasedPaedsForm').collapse('hide');}
        if(childhivstatusknowledge=="Yes" && childhivstatus_paeds=='Response'){document.getElementById("childhivstatus_paeds_label").innerHTML="Field is required";childhivstatus_paeds_chk=0;$('#collapsecommunityBasedPaedsForm').collapse('show');}else{childhivstatus_paeds_chk=1;document.getElementById("childhivstatus_paeds_label").innerHTML="";$('#collapsecommunityBasedPaedsForm').collapse('hide');}

        if(cbp_subQuestionResponse1_1=="" || cbp_subQuestionResponse1_1=='Response'){document.getElementById("cbp_subQuestionResponse1_1_label").innerHTML="Field is required";cbp_subQuestionResponse1_1_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse1_1_chk=1;document.getElementById("cbp_subQuestionResponse1_1_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse2_1=="" || cbp_subQuestionResponse2_1=='Response'){document.getElementById("cbp_subQuestionResponse2_1_label").innerHTML="Field is required";cbp_subQuestionResponse2_1_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse2_1_chk=1;document.getElementById("cbp_subQuestionResponse2_1_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse1_2=="" || cbp_subQuestionResponse1_2=='Response'){document.getElementById("cbp_subQuestionResponse1_2_label").innerHTML="Field is required";cbp_subQuestionResponse1_2_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse1_2_chk=1;document.getElementById("cbp_subQuestionResponse1_2_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse2_2=="" || cbp_subQuestionResponse2_2=='Response'){document.getElementById("cbp_subQuestionResponse2_2_label").innerHTML="Field is required";cbp_subQuestionResponse2_2_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse2_2_chk=1;document.getElementById("cbp_subQuestionResponse2_2_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse1_3=="" || cbp_subQuestionResponse1_3=='Response'){document.getElementById("cbp_subQuestionResponse1_3_label").innerHTML="Field is required";cbp_subQuestionResponse1_3_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse1_3_chk=1;document.getElementById("cbp_subQuestionResponse1_3_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse2_3=="" || cbp_subQuestionResponse2_3=='Response'){document.getElementById("cbp_subQuestionResponse2_3_label").innerHTML="Field is required";cbp_subQuestionResponse2_3_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse2_3_chk=1;document.getElementById("cbp_subQuestionResponse2_3_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse1_5=="" || cbp_subQuestionResponse1_5=='Response'){document.getElementById("cbp_subQuestionResponse1_5_label").innerHTML="Field is required";cbp_subQuestionResponse1_5_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse1_5_chk=1;document.getElementById("cbp_subQuestionResponse1_5_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse2_5=="" || cbp_subQuestionResponse2_5=='Response'){document.getElementById("cbp_subQuestionResponse2_5_label").innerHTML="Field is required";cbp_subQuestionResponse2_5_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse2_5_chk=1;document.getElementById("cbp_subQuestionResponse2_5_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse1_6=="" || cbp_subQuestionResponse1_6=='Response'){document.getElementById("cbp_subQuestionResponse1_6_label").innerHTML="Field is required";cbp_subQuestionResponse1_6_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse1_6_chk=1;document.getElementById("cbp_subQuestionResponse1_6_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        if(cbp_subQuestionResponse2_6=="" || cbp_subQuestionResponse2_6=='Response'){document.getElementById("cbp_subQuestionResponse2_6_label").innerHTML="Field is required";cbp_subQuestionResponse2_6_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_subQuestionResponse2_6_chk=1;document.getElementById("cbp_subQuestionResponse2_6_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
   
        if(cbp_QuestionResponse4=="" || cbp_QuestionResponse4=='Response'){document.getElementById("cbp_QuestionResponse4_label").innerHTML="Field is required";cbp_QuestionResponse4_chk=0;$('#collapsecommunityBasedPaedsFormSectionA').collapse('show');}else{cbp_QuestionResponse4_chk=1;document.getElementById("cbp_QuestionResponse4_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionA').collapse('hide');}
        //Section B
        if(public_age > 14){
            if(cbp_QuestionResponse7=="" || cbp_QuestionResponse7=='Response'){document.getElementById("cbp_QuestionResponse7_label").innerHTML="Field is required";cbp_QuestionResponse7_chk=0;$('#collapsecommunityBasedPaedsFormSectionB').collapse('show');}else{cbp_QuestionResponse7_chk=1;document.getElementById("cbp_QuestionResponse7_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionB').collapse('hide');}
            if(cbp_QuestionResponse8=="" || cbp_QuestionResponse8=='Response'){document.getElementById("cbp_QuestionResponse8_label").innerHTML="Field is required";cbp_QuestionResponse8_chk=0;$('#collapsecommunityBasedPaedsFormSectionB').collapse('show');}else{cbp_QuestionResponse8_chk=1;document.getElementById("cbp_QuestionResponse8_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionB').collapse('hide');}
            if(cbp_QuestionResponse9=="" || cbp_QuestionResponse9=='Response'){document.getElementById("cbp_QuestionResponse9_label").innerHTML="Field is required";cbp_QuestionResponse9_chk=0;$('#collapsecommunityBasedPaedsFormSectionB').collapse('show');}else{cbp_QuestionResponse9_chk=1;document.getElementById("cbp_QuestionResponse9_label").innerHTML="";$('#collapsecommunityBasedPaedsFormSectionB').collapse('hide');}
            if(childatrisk=="" || childatrisk=='Response'){document.getElementById("childatrisk_label").innerHTML="Field is required";childatrisk_chk=0;$('#collapsecommunityBasedPaedsServiceProviderForm').collapse('show');}else{childatrisk_chk=1;document.getElementById("childatrisk_label").innerHTML="";$('#collapsecommunityBasedPaedsServiceProviderForm').collapse('hide');}
        }
        else{
            cbp_QuestionResponse7_chk=1;
            cbp_QuestionResponse8_chk=1;
            cbp_QuestionResponse9_chk=1;
            childatrisk_chk=1;
        }
   
        if(serviceprovider==""){document.getElementById("serviceprovider_label").innerHTML="Field is required";serviceprovider_chk=0;$('#collapsecommunityBasedPaedsServiceProviderForm').collapse('show');}else{serviceprovider_chk=1;document.getElementById("serviceprovider_label").innerHTML="";$('#collapsecommunityBasedPaedsServiceProviderForm').collapse('hide');}
        if(serviceprovisiondate==""){document.getElementById("serviceprovisiondate_label").innerHTML="Field is required";serviceprovisiondate_chk=0;$('#collapsecommunityBasedPaedsServiceProviderForm').collapse('show');}else{serviceprovisiondate_chk=1;document.getElementById("serviceprovisiondate_label").innerHTML="";$('#collapsecommunityBasedPaedsServiceProviderForm').collapse('hide');}
   
   
//Confirm validation and set validation status
    if(respondent_childrelationship_chk == 0 || 
        childhivstatusknowledge_chk == 0 || 
        childhivstatus_paeds_chk == 0 || 
        cbp_subQuestionResponse1_1_chk == 0 || 
        cbp_subQuestionResponse2_1_chk == 0 || 
        cbp_subQuestionResponse1_2_chk == 0 || 
        cbp_subQuestionResponse2_2_chk == 0 || 
        cbp_subQuestionResponse1_3_chk == 0 || 
        cbp_subQuestionResponse2_3_chk == 0 || 
        cbp_subQuestionResponse1_5_chk == 0 || 
        cbp_subQuestionResponse2_5_chk == 0 || 
        cbp_subQuestionResponse1_6_chk == 0 || 
        cbp_subQuestionResponse2_6_chk == 0 || 
        cbp_QuestionResponse4_chk == 0 || 
        cbp_QuestionResponse7_chk == 0 || 
        cbp_QuestionResponse8_chk == 0 || 
        cbp_QuestionResponse9_chk == 0 || 
        childatrisk_chk == 0 || 
        serviceprovider_chk == 0 || 
        serviceprovisiondate_chk == 0){
        validation_state = 'failed';
        Toastify({
            text: "Validation Failed. Review form elements",
            style: {
              background: "linear-gradient(to right, #DC3545, #DC3545)",
            },
            close: true,
            duration: 10000
        }).showToast();
        $('#collapsecareandSupportFormListTable').attr('class','collapse');
        $('#collapsecareandSupportFormListTable').attr('class','show');

    }
    else{
        createcommunityBasedPaedsRecord();
    }
}
function createcommunityBasedPaedsRecord(){

    $.ajax({
        url: 'db/createcommunityBasedPaedsRecord.php',
        type: 'post',
        data: "respondent_childrelationship="+respondent_childrelationship
        +"&childhivstatusknowledge="+childhivstatusknowledge
        +"&childhivstatus_paeds="+childhivstatus_paeds
        +"&mainQuestion1="+cbp_mainQuestion1
        +"&mainQuestion2="+cbp_mainQuestion2
        +"&mainQuestion3="+cbp_mainQuestion3
        +"&mainQuestion5="+cbp_mainQuestion5
        +"&mainQuestion6="+cbp_mainQuestion6
        +"&subQuestion1_1="+cbp_subQuestion1_1
        +"&subQuestion2_1="+cbp_subQuestion2_1
        +"&subQuestion1_2="+cbp_subQuestion1_2
        +"&subQuestion2_2="+cbp_subQuestion2_2
        +"&subQuestion1_3="+cbp_subQuestion1_3
        +"&subQuestion2_3="+cbp_subQuestion2_3
        +"&subQuestion1_5="+cbp_subQuestion1_5
        +"&subQuestion2_5="+cbp_subQuestion2_5
        +"&subQuestion1_6="+cbp_subQuestion1_6
        +"&subQuestion2_6="+cbp_subQuestion2_6
        +"&Question7="+cbp_Question7
        +"&Question8="+cbp_Question8
        +"&Question9="+cbp_Question9
        +"&Question4="+cbp_Question4
        +"&subQuestionResponse1_1="+cbp_subQuestionResponse1_1
        +"&subQuestionResponse2_1="+cbp_subQuestionResponse2_1
        +"&subQuestionResponse1_2="+cbp_subQuestionResponse1_2
        +"&subQuestionResponse2_2="+cbp_subQuestionResponse2_2
        +"&subQuestionResponse1_3="+cbp_subQuestionResponse1_3
        +"&subQuestionResponse2_3="+cbp_subQuestionResponse2_3
        +"&subQuestionResponse1_5="+cbp_subQuestionResponse1_5
        +"&subQuestionResponse2_5="+cbp_subQuestionResponse2_5
        +"&subQuestionResponse1_6="+cbp_subQuestionResponse1_6
        +"&subQuestionResponse2_6="+cbp_subQuestionResponse2_6
        +"&QuestionResponse4="+cbp_QuestionResponse4
        +"&QuestionResponse7="+cbp_QuestionResponse7
        +"&QuestionResponse8="+cbp_QuestionResponse8
        +"&QuestionResponse9="+cbp_QuestionResponse9
        +"&hh_unique_num="+hh_unique_num
        +"&vc_unique_id="+vcUniqueId
        +"&childatrisk="+childatrisk
        +"&serviceprovider="+serviceprovider
        +"&serviceprovisiondate="+serviceprovisiondate,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Community Based PAEDS HIV Risk Assessment Created",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //re-initialize table
               document.getElementById("communityBasedPaedsForm").reset();
               var careAndSupportTable = $('#careAndSupportTable').DataTable();
               careAndSupportTable.ajax.reload();
               $('#collapsecareandSupportFormListTable').attr('class','collapse');
               $('#collapsecareandSupportFormListTable').attr('class','show');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Community Based PAEDS HIV Risk Assessment NOT created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Error: Record Exists, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}
//Nutritional Assessment submitNutritionalAssessmentForm

function submitNutritionalAssessmentForm(ev){
    ev.preventDefault();

    assessmentdate = document.getElementById("assessmentdate").value;
    weight = document.getElementById("weight").value;
    height = document.getElementById("height").value;
    bmi = document.getElementById("bmi").value;
    oedema = document.getElementById("oedema").value;
    muac = document.getElementById("muac").value;
    Question1 = document.getElementById("Question1").innerText;
    responseQuestion1 = document.getElementById("naresponseQuestion1").value;
    Question2 = document.getElementById("Question2").innerText;
    responseQuestion2 = document.getElementById("naresponseQuestion2").value;
    Question3 = document.getElementById("Question3").innerText;
    responseQuestion3 = document.getElementById("naresponseQuestion3").value;
    Question4 = document.getElementById("Question4").innerText;
    responseQuestion4 = document.getElementById("naresponseQuestion4").value;
    Question5 = document.getElementById("Question5").innerText;
    responseQuestion5 = document.getElementById("naresponseQuestion5").value;
    Question6 = document.getElementById("Question6").innerText;
    responseQuestion6 = document.getElementById("responseQuestion6").value;
    Question7 = document.getElementById("Question7").innerText;
    responseQuestion7 = document.getElementById("responseQuestion7").value;
    Question8 = document.getElementById("Question8").innerText;
    responseQuestion8 = document.getElementById("responseQuestion8").value;
    Question9 = document.getElementById("Question9").innerText;
    responseQuestion9 = document.getElementById("responseQuestion9").value;
    Question10 = document.getElementById("Question10").innerText;
    responseQuestion10 = document.getElementById("responseQuestion10").value;
    Question11 = document.getElementById("Question11").innerText;
    responseQuestion11 = document.getElementById("responseQuestion11").value;
    Question12 = document.getElementById("Question12").innerText;
    responseQuestion12 = document.getElementById("responseQuestion12").value;
    Question13 = document.getElementById("Question13").innerText;
    responseQuestion13 = document.getElementById("responseQuestion13").value;
    var checked_conditionaffecting_nutrition = []
    $("input[name='conditionaffecting_nutrition[]']:checked").each(function ()
    {
        checked_conditionaffecting_nutrition.push($(this).val());
    });
    conditionaffecting_nutrition = checked_conditionaffecting_nutrition.toString();
    var checked_referral = []
    $("input[name='referral[]']:checked").each(function ()
    {
        checked_referral.push($(this).val());
    });
    referral_na = checked_referral.toString();
    
    serviceprovider_na = document.getElementById("serviceprovider_na").value;
    serviceprovisiondate_na = document.getElementById("serviceprovisiondate_na").value;


        //Check for Validation and Missed Entries
        if(assessmentdate==""){document.getElementById("assessmentdate_label").innerHTML="Field is required";assessmentdate_chk=0;$('#collapsenutritionalAssessmentForm').collapse('show');}else{assessmentdate_chk=1;document.getElementById("assessmentdate_label").innerHTML="";$('#collapsenutritionalAssessmentForm').collapse('hide');}
        if(weight==""){document.getElementById("weight_label").innerHTML="Field is required";weight_chk=0;$('#collapsenutritionalAssessmentForm').collapse('show');}else{weight_chk=1;document.getElementById("weight_label").innerHTML="";$('#collapsenutritionalAssessmentForm').collapse('hide');}
        if(height==""){document.getElementById("height_label").innerHTML="Field is required";height_chk=0;$('#collapsenutritionalAssessmentForm').collapse('show');}else{height_chk=1;document.getElementById("height_label").innerHTML="";$('#collapsenutritionalAssessmentForm').collapse('hide');}
        if(oedema=="" || oedema=="Response"){document.getElementById("oedema_label").innerHTML="Field is required";oedema_chk=0;$('#collapsenutritionalAssessmentForm').collapse('show');}else{oedema_chk=1;document.getElementById("oedema_label").innerHTML="";$('#collapsenutritionalAssessmentForm').collapse('hide');}
        if(muac=="" || muac=="Response"){document.getElementById("muac_label").innerHTML="Field is required";muac_chk=0;$('#collapsenutritionalAssessmentForm').collapse('show');}else{muac_chk=1;document.getElementById("muac_label").innerHTML="";$('#collapsenutritionalAssessmentForm').collapse('hide');}
        
        if(responseQuestion1=="" || responseQuestion1=="Response"){document.getElementById("naresponseQuestion1_label").innerHTML="Field is required";responseQuestion1_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion1_chk=1;document.getElementById("naresponseQuestion1_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}
        if(responseQuestion2=="" || responseQuestion2=="Response"){document.getElementById("naresponseQuestion2_label").innerHTML="Field is required";responseQuestion2_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion2_chk=1;document.getElementById("naresponseQuestion2_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}
        if(responseQuestion3=="" || responseQuestion3=="Response"){document.getElementById("naresponseQuestion3_label").innerHTML="Field is required";responseQuestion3_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion3_chk=1;document.getElementById("naresponseQuestion3_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}
        if(responseQuestion4=="" || responseQuestion4=="Response"){document.getElementById("naresponseQuestion4_label").innerHTML="Field is required";responseQuestion4_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion4_chk=1;document.getElementById("naresponseQuestion4_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}
        if(responseQuestion5=="" || responseQuestion5=="Response"){document.getElementById("naresponseQuestion5_label").innerHTML="Field is required";responseQuestion5_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion5_chk=1;document.getElementById("naresponseQuestion5_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}
        if(responseQuestion6=="" || responseQuestion6=="Response"){document.getElementById("responseQuestion6_label").innerHTML="Field is required";responseQuestion6_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion6_chk=1;document.getElementById("responseQuestion6_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}
        if(responseQuestion7=="" || responseQuestion7=="Response"){document.getElementById("responseQuestion7_label").innerHTML="Field is required";responseQuestion7_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion7_chk=1;document.getElementById("responseQuestion7_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}
        if(responseQuestion8=="" || responseQuestion8=="Response"){document.getElementById("responseQuestion8_label").innerHTML="Field is required";responseQuestion8_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion8_chk=1;document.getElementById("responseQuestion8_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}
        if(responseQuestion9=="" || responseQuestion9=="Response"){document.getElementById("responseQuestion9_label").innerHTML="Field is required";responseQuestion9_chk=0;$('#collapsenaFoodSecurityandDiet').collapse('show');}else{responseQuestion9_chk=1;document.getElementById("responseQuestion9_label").innerHTML="";$('#collapsenaFoodSecurityandDiet').collapse('hide');}

        if(responseQuestion10=="" || responseQuestion10=="Response"){document.getElementById("responseQuestion10_label").innerHTML="Field is required";responseQuestion10_chk=0;$('#collapsenaHygiene').collapse('show');}else{responseQuestion10_chk=1;document.getElementById("responseQuestion10_label").innerHTML="";$('#collapsenaHygiene').collapse('hide');}
        if(responseQuestion11=="" || responseQuestion11=="Response"){document.getElementById("responseQuestion11_label").innerHTML="Field is required";responseQuestion11_chk=0;$('#collapsenaHygiene').collapse('show');}else{responseQuestion11_chk=1;document.getElementById("responseQuestion11_label").innerHTML="";$('#collapsenaHygiene').collapse('hide');}
        if(responseQuestion12=="" || responseQuestion12=="Response"){document.getElementById("responseQuestion12_label").innerHTML="Field is required";responseQuestion12_chk=0;$('#collapsenaHygiene').collapse('show');}else{responseQuestion12_chk=1;document.getElementById("responseQuestion12_label").innerHTML="";$('#collapsenaHygiene').collapse('hide');}
        if(responseQuestion13=="" || responseQuestion13=="Response"){document.getElementById("responseQuestion13_label").innerHTML="Field is required";responseQuestion13_chk=0;$('#collapsenaHygiene').collapse('show');}else{responseQuestion13_chk=1;document.getElementById("responseQuestion13_label").innerHTML="";$('#collapsenaHygiene').collapse('hide');}

        if(serviceprovider_na==""){document.getElementById("serviceprovider_label").innerHTML="Field is required";serviceprovider_na_chk=0;$('#collapsenaServiceProviderForm').collapse('show');}else{serviceprovider_na_chk=1;document.getElementById("serviceprovider_label").innerHTML="";$('#collapsenaServiceProviderForm').collapse('hide');}
        if(serviceprovisiondate_na==""){document.getElementById("serviceprovisiondate_label").innerHTML="Field is required";serviceprovisiondate_na_chk=0;$('#collapsenaServiceProviderForm').collapse('show');}else{serviceprovisiondate_na_chk=1;document.getElementById("serviceprovisiondate_label").innerHTML="";$('#collapsenaServiceProviderForm').collapse('hide');}

   
   
//Confirm validation and set validation status
    if(assessmentdate_chk == 0 || weight_chk == 0 || height_chk == 0 || oedema_chk == 0 || muac_chk == 0 || responseQuestion1_chk == 0 || responseQuestion2_chk == 0 || responseQuestion3_chk == 0 || responseQuestion4_chk == 0 || responseQuestion5_chk == 0 || responseQuestion6_chk == 0 || responseQuestion7_chk == 0 || responseQuestion8_chk == 0 || responseQuestion9_chk == 0 || responseQuestion10_chk == 0 || responseQuestion11_chk == 0 || responseQuestion12_chk == 0 || responseQuestion13_chk == 0 || serviceprovider_na_chk == 0 || serviceprovisiondate_na_chk == 0){
        validation_state = 'failed';
        Toastify({
            text: "Validation Failed. Review form elements",
            style: {
              background: "linear-gradient(to right, #DC3545, #DC3545)",
            },
            close: true,
            duration: 10000
        }).showToast();
        $('#collapsecareandSupportFormListTable').attr('class','collapse');
        $('#collapsecareandSupportFormListTable').attr('class','show');

    }
    else{
        createNutritionalAssessmentRecord();
    }
}

function createNutritionalAssessmentRecord(){

    $.ajax({
        url: 'db/createNutritionalAssessmentRecord.php',
        type: 'post',
        data: "assessmentdate="+assessmentdate+
        "&weight="+weight+
        "&height="+height+
        "&bmi="+bmi+
        "&oedema="+oedema+
        "&muac="+muac+
        "&Question1="+Question1+
        "&responseQuestion1="+responseQuestion1+
        "&Question2="+Question2+
        "&responseQuestion2="+responseQuestion2+
        "&Question3="+Question3+
        "&responseQuestion3="+responseQuestion3+
        "&Question4="+Question4+
        "&responseQuestion4="+responseQuestion4+
        "&Question5="+Question5+
        "&responseQuestion5="+responseQuestion5+
        "&Question6="+Question6+
        "&responseQuestion6="+responseQuestion6+
        "&Question7="+Question7+
        "&responseQuestion7="+responseQuestion7+
        "&Question8="+Question8+
        "&responseQuestion8="+responseQuestion8+
        "&Question9="+Question9+
        "&responseQuestion9="+responseQuestion9+
        "&Question10="+Question10+
        "&responseQuestion10="+responseQuestion10+
        "&Question11="+Question11+
        "&responseQuestion11="+responseQuestion11+
        "&Question12="+Question12+
        "&responseQuestion12="+responseQuestion12+
        "&Question13="+Question13+
        "&responseQuestion13="+responseQuestion13+
        "&serviceprovider="+serviceprovider_na+
        "&serviceprovisiondate="+serviceprovisiondate_na+
        "&conditionaffecting_nutrition="+conditionaffecting_nutrition+
        "&referral="+referral_na+"&hh_unique_num="+hh_unique_num
        +"&vc_unique_id="+vcUniqueId
    ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Nutritional Assessment Record Created Successfully",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();
                document.getElementById("nutritionalAssessmentForm").reset();
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Nutritional Assessment Record Not Created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Nutritional Assessment Record already exists, Please review",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}

//UPDATE FORMS
function updatecaregiverandVCStatusUpdateForm(){
    $.ajax({
        url: 'db/updatecaregiverandVCStatusUpdate.php',
        type: 'post',
        data: "hh_member_category="+document.getElementById("hh_member_category").value
        +"&hiv_status="+document.getElementById("hiv_status_su").value 
        +"&dateoftest="+document.getElementById("dateoftest_su").value
        +"&birth_certificate="+document.getElementById("birth_certificate_su").value
        +"&child_in_school="+document.getElementById("child_in_school_su").value
        +"&child_on_vocational_training="+document.getElementById("child_on_vocational_training_su").value
        +"&service_provider="+document.getElementById("service_provider_su").value
        +"&service_date="+document.getElementById("service_date_su").value
        +"&id="+document.getElementById("record_id_su").innerText
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Caregiver & VC Status Update Form Updated",
                style: {
                  background: "linear-gradient(to right, #227447, #C6EFCE)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //close Modal
                $('#newcaregiverandVCStatusUpdate').modal('toggle');
                //Reload Caregiver & VC status update Checklist Table
               var caregiverVcStatusUpdateTable = $('#caregiverVcStatusUpdateTable').DataTable();
               caregiverVcStatusUpdateTable.ajax.reload();
               //Open DIV to show Care & Support Table Record
               $('#collapsecaregiverUpdateListTable').attr('class','collapse');
               $('#collapsecaregiverUpdateListTable').attr('class','show');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Caregiver & VC Status Update Form NOT Updated, Review Changes",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}
function updateEmergencyFundForm(){
    var checked_question3 = []
    $("input[name='efresponseQuestion3[]']:checked").each(function ()
    {
        checked_question3.push($(this).val());
    });
    efresponseQuestion3 = checked_question3.toString();

    efserviceQuestion4 = document.getElementById("efserviceQuestion4").innerText;
    var checked_question4 = []
    $("input[name='efresponseQuestion4[]']:checked").each(function ()
    {
        checked_question4.push($(this).val());
    });
    efresponseQuestion4 = checked_question4.toString();


    $.ajax({
        url: 'db/updateEmergencyFundFormUpdate.php',
        type: 'post',
        data: "responseQuestion1="+document.getElementById("efresponseQuestion1").value
        +"&responseQuestion2="+document.getElementById("efresponseQuestion2").value 
        +"&responseQuestion3="+efresponseQuestion3
        +"&responseQuestion4="+efresponseQuestion4
        +"&responseQuestion3_other="+document.getElementById("efresponseQuestion3_other").value
        +"&responseQuestion4_other="+document.getElementById("efresponseQuestion4_other").value
        +"&service_date="+document.getElementById("service_date_ef").value
        +"&id="+document.getElementById("record_id_ef").innerText
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Caregiver Access to Emergency Form Updated",
                style: {
                  background: "linear-gradient(to right, #227447, #C6EFCE)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //close Modal
                $('#newaccessToEmergencyFundForm').modal('toggle');
                //Reload Caregiver & VC status update Checklist Table
               var caregiverAccessEmergencyTable = $('#caregiverAccessEmergencyTable').DataTable();
               caregiverAccessEmergencyTable.ajax.reload();
               //Open DIV to show Care & Support Table Record
               $('#collapsecaregiverAccessEmergencyListTable').attr('class','collapse');
               $('#collapsecaregiverAccessEmergencyListTable').attr('class','show');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Caregiver Access to Emergency Form NOT Updated, Review Changes",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}

function updateReferralForm(){

        //Delete Existing Record from the DB before calling update function
        var record_date_rf = document.getElementById("record_date_rf").innerText;
        var vc_unique_id_for_rf = document.getElementById("vc_unique_id_for_rf").innerText;
            
        deleteReferralRecord(vc_unique_id_for_rf,record_date_rf);
}
function deleteReferralRecord(vc_unique_id_for_rf,record_date_rf){
    $.ajax({
        url: 'db/deleteReferralRecord.php',
        type: 'post',
        data: "vc_unique_id="+vc_unique_id_for_rf
        +"&referral_date="+record_date_rf
        ,
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
                submitReferralFormForUpdate();            
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Referral Form Not Updated: Could not find Parent Record.",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}
function submitReferralFormForUpdate(){
    referring_organization = document.getElementById("referring_organization").value;
    receiving_organization = document.getElementById("receiving_organization").value;
    //Convert Checkboxes to Array->toString for field (table) reservicereferred
    var checked_reservicereferred = []
    $("input[name='reservicereferred[]']:checked").each(function ()
    {
        checked_reservicereferred.push($(this).val());
    });
    reservicereferred = checked_reservicereferred.toString();

    organization_providingreferral = document.getElementById("organization_providingreferral").value;
    service_provided = document.getElementById("rf_service_provided").value;
    service_completed = document.getElementById("rf_service_completed").value;
    followup_needed = document.getElementById("rf_followup_needed").value;
    followup_date = document.getElementById("rf_followup_date").value;
    referral_date = document.getElementById("referral_date").value;

    input_service_provided = document.getElementsByName("rf_service_provided[]");
    input_service_completed = document.getElementsByName("rf_service_completed[]");
    input_followup_needed = document.getElementsByName("rf_followup_needed[]");
    input_followup_date = document.getElementsByName("rf_followup_date[]");

    referral_status = document.getElementById("rf_referral_status").value;
    referral_receiver = document.getElementById("referral_receiver").value;
    referral_receiver_designation = document.getElementById("referral_receiver_designation").value;
    referral_receiver_phonenumber = document.getElementById("referral_receiver_phonenumber").value;
    referral_receiver_email = document.getElementById("referral_receiver_email").value;


        //Check for Validation and Missed Entries
        if(organization_providingreferral==""){document.getElementById("organization_providingreferral_label").innerHTML="Field is required";organization_providingreferral_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{organization_providingreferral_chk=1;document.getElementById("organization_providingreferral_label").innerHTML="";$('#collapseservicesReferredSectionB').collapse('hide');}
        if(reservicereferred==""){reservicereferred_chk=0;$('#collapseservicesReferredFor').collapse('show');}else{reservicereferred_chk=1;$('#collapseservicesReferredFor').collapse('hide');}
        if(service_provided==""){service_provided_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{service_provided_chk=1;$('#collapseservicesReferredSectionB').collapse('hide');}
        if(service_completed=="" || service_completed=="Response"){service_completed_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{service_completed_chk=1;$('#collapseservicesReferredSectionB').collapse('hide');}
        if(followup_needed=="" || followup_needed=="Response"){followup_needed_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{followup_needed_chk=1;$('#collapseservicesReferredSectionB').collapse('hide');}
        if(followup_needed=="Yes" && followup_date==""){followup_date_chk=0;$('#collapseservicesReferredSectionB').collapse('show');}else{followup_date_chk=1;$('#collapseservicesReferredSectionB').collapse('hide');}
   
        if(referral_status=="" || referral_status=="Response"){document.getElementById("rf_referral_status_label").innerHTML="Field is required";rf_referral_status_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{rf_referral_status_chk=1;document.getElementById("rf_referral_status_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_date==""){document.getElementById("referral_date_label").innerHTML="Field is required";referral_date_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_date_chk=1;document.getElementById("referral_date_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver==""){document.getElementById("referral_receiver_label").innerHTML="Field is required";referral_receiver_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_receiver_chk=1;document.getElementById("referral_receiver_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver_designation==""){document.getElementById("referral_receiver_designation_label").innerHTML="Field is required";referral_receiver_designation_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_receiver_designation_chk=1;document.getElementById("referral_receiver_designation_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver_phonenumber==""){document.getElementById("referral_receiver_phonenumber_label").innerHTML="Field is required";referral_receiver_phonenumber_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_receiver_phonenumber_chk=1;document.getElementById("referral_receiver_phonenumber_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver_email==""){document.getElementById("referral_receiver_email_label").innerHTML="Field is required";referral_receiver_email_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referral_receiver_email_chk=1;document.getElementById("referral_receiver_email_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
  
        if(referring_organization==""){document.getElementById("referring_organization_label").innerHTML="Field is required";referring_organization_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referring_organization_chk=1;document.getElementById("referring_organization_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
        if(referral_receiver_email==""){document.getElementById("referring_organization_label").innerHTML="Field is required";referring_organization_chk=0;$('#collapseservicesReferredSectionC').collapse('show');}else{referring_organization_chk=1;document.getElementById("referring_organization_label").innerHTML="";$('#collapseservicesReferredSectionC').collapse('hide');}
//Confirm validation and set validation status
    if(reservicereferred_chk == 0 || referral_date_chk == 0 || service_provided_chk == 0 ||service_completed_chk == 0 ||followup_needed_chk == 0 ||followup_date_chk == 0 ||rf_referral_status_chk == 0 ||referral_receiver_chk == 0 ||referral_receiver_designation_chk == 0 ||referral_receiver_phonenumber_chk == 0 ||referral_receiver_email_chk == 0 ||referring_organization_chk == 0 ||referring_organization_chk == 0){

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
        for (var i = 0; i < input_service_provided.length; i++) {
            var xinput_service_provided = input_service_provided[i];
            var xinput_service_completed = input_service_completed[i];
            var xinput_followup_needed = input_followup_needed[i];
            var xinput_followup_date = input_followup_date[i];
            createtReferralFormRecordUpdate(xinput_service_provided.value,xinput_service_completed.value,xinput_followup_needed.value,xinput_followup_date.value);
        } 
    }
}
function createtReferralFormRecordUpdate(input_service_provided,input_service_completed,input_followup_needed,input_followup_date){
   
    $.ajax({
        url: 'db/createtReferralFormRecord.php',
        type: 'post',
        data: "referring_organization="+referring_organization+"&receiving_organization="+receiving_organization+"&reservicereferred="+reservicereferred+"&organization_providingreferral="+organization_providingreferral+"&service_provided="+input_service_provided+"&service_completed="+input_service_completed+"&followup_needed="+input_followup_needed+"&followup_date="+input_followup_date+"&referral_status="+referral_status+"&referral_receiver="+referral_receiver+"&referral_receiver_designation="+referral_receiver_designation+"&referral_receiver_phonenumber="+referral_receiver_phonenumber+"&vc_unique_id="+vcUniqueId+"&hh_unique_num="+hh_unique_num+"&referral_receiver_email="+referral_receiver_email+"&referral_date="+referral_date,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Referral: "+input_service_provided+"; Updated Successfully",
                style: {
                    background: "linear-gradient(to right, #227447, #C6EFCE)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //close Modal
                $('#newreferralForm').modal('toggle');
                //Reload  Table
               var referralsTable = $('#referralsTable').DataTable();
               referralsTable.ajax.reload();
                //document.getElementById("entryReferralForm").reset();
                $('#collapsecareandSupportFormListTable').attr('class','collapse');
                $('#collapsecareandSupportFormListTable').attr('class','show');
        
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Referral: "+input_service_provided+"; Not Updated, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  }) 
}

function updateEducationalPerformanceForm(){

    $.ajax({
        url: 'db/updateEducationalPerformanceForm.php',
        type: 'post',
        data: "responseQuestion1="+document.getElementById("ppassessmentresponseQuestion1").value
        +"&responseQuestion2="+document.getElementById("ppassessmentresponseQuestion2").value 
        +"&responseQuestion3="+document.getElementById("ppassessmentresponseQuestion3").value
        +"&responseQuestion4="+document.getElementById("aaassessmentresponseQuestion1").value
        +"&responseQuestion5="+document.getElementById("aaassessmentresponseQuestion2").value
        +"&responseQuestion6="+document.getElementById("aaassessmentresponseQuestion3").value
        +"&responseQuestion7="+document.getElementById("aaassessmentresponseQuestion4").value
        +"&responseQuestion8="+document.getElementById("aaassessmentresponseQuestion5").value
        +"&cso_staffname="+document.getElementById("cso_staffname").value
        +"&cso_date="+document.getElementById("cso_date").value
        +"&teacher_name="+document.getElementById("teacher_name").value
        +"&teacher_date="+document.getElementById("teacher_date").value
        +"&id="+document.getElementById("record_id_for_cepa").innerText
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Child Education Assessment Form Updated",
                style: {
                  background: "linear-gradient(to right, #227447, #C6EFCE)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //close Modal
                $('#newChildEducationalPerfAssForm').modal('toggle');
                //Reload Caregiver & VC status update Checklist Table
               var childEducationAssessmentTable = $('#childEducationAssessmentTable').DataTable();
               childEducationAssessmentTable.ajax.reload();
               //Open DIV to show Care & Support Table Record
               $('#collapsechildEducationAssessmentListTable').attr('class','collapse');
               $('#collapsechildEducationAssessmentListTable').attr('class','show');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Child Education Assessment form NOT Updated, Review Changes",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}

function updatecommunityBasedPaedsForm(){

    $.ajax({
        url: 'db/updatecommunityBasedPaedsForm.php',
        type: 'post',
        data: "respondent_childrelationship="+document.getElementById("respondent_childrelationship").value 
        +"&childhivstatusknowledge="+document.getElementById("childhivstatusknowledge").value
        +"&childhivstatus_paeds="+document.getElementById("childhivstatus_paeds").value
        +"&subQuestionResponse1_1="+document.getElementById("cbp_subQuestionResponse1_1").value
        +"&subQuestionResponse2_1="+document.getElementById("cbp_subQuestionResponse2_1").value
        +"&subQuestionResponse1_2="+document.getElementById("cbp_subQuestionResponse1_2").value
        +"&subQuestionResponse2_2="+document.getElementById("cbp_subQuestionResponse2_2").value
        +"&subQuestionResponse1_3="+document.getElementById("cbp_subQuestionResponse1_3").value
        +"&subQuestionResponse2_3="+document.getElementById("cbp_subQuestionResponse2_3").value
        +"&QuestionResponse4="+document.getElementById("cbp_QuestionResponse4").value
        +"&subQuestionResponse1_5="+document.getElementById("cbp_subQuestionResponse1_5").value
        +"&subQuestionResponse2_5="+document.getElementById("cbp_subQuestionResponse2_5").value
        +"&subQuestionResponse1_6="+document.getElementById("cbp_subQuestionResponse1_6").value
        +"&subQuestionResponse2_6="+document.getElementById("cbp_subQuestionResponse2_6").value
        +"&QuestionResponse7="+document.getElementById("cbp_QuestionResponse7").value
        +"&QuestionResponse8="+document.getElementById("cbp_QuestionResponse8").value
        +"&QuestionResponse9="+document.getElementById("cbp_QuestionResponse9").value
        +"&childatrisk="+document.getElementById("childatrisk").value
        +"&serviceprovider="+document.getElementById("serviceprovider").value
        +"&serviceprovisiondate="+document.getElementById("serviceprovisiondate").value
        +"&id="+document.getElementById("record_id_for_cbpaeds").innerText
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "PAEDS HIV Risk Assessment Form Updated",
                style: {
                  background: "linear-gradient(to right, #227447, #C6EFCE)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //close Modal
                $('#newcommunityBasedPaedsForm').modal('toggle');
                //Reload PAEDS HIV Risk Assessment Checklist Table
               var hivRiskAssessmentTable = $('#hivRiskAssessmentTable').DataTable();
               hivRiskAssessmentTable.ajax.reload();
               //Open DIV to show Care & Support Table Record
               $('#collapsehivRiskAssessmentListTable').attr('class','collapse');
               $('#collapsehivRiskAssessmentListTable').attr('class','show');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: PAEDS HIV Risk Assessment form NOT Updated, Review Changes",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}
function updateNutritionalAssessmentForm(){

    var checked_conditionaffecting_nutrition = []
    $("input[name='conditionaffecting_nutrition[]']:checked").each(function ()
    {
        checked_conditionaffecting_nutrition.push($(this).val());
    });
    conditionaffecting_nutrition = checked_conditionaffecting_nutrition.toString();
    var checked_referral = []
    $("input[name='referral[]']:checked").each(function ()
    {
        checked_referral.push($(this).val());
    });
    referral_na = checked_referral.toString();

    $.ajax({
        url: 'db/updateNutritionalAssessmentForm.php',
        type: 'post',
        data: "assessmentdate="+document.getElementById("assessmentdate").value 
        +"&weight="+document.getElementById("weight").value
        +"&height="+document.getElementById("height").value
        +"&bmi="+document.getElementById("bmi").value
        +"&oedema="+document.getElementById("oedema").value
        +"&muac="+document.getElementById("muac").value
        +"&responseQuestion1="+document.getElementById("naresponseQuestion1").value
        +"&responseQuestion2="+document.getElementById("naresponseQuestion2").value
        +"&responseQuestion3="+document.getElementById("naresponseQuestion3").value
        +"&responseQuestion4="+document.getElementById("naresponseQuestion4").value
        +"&responseQuestion5="+document.getElementById("naresponseQuestion5").value
        +"&responseQuestion6="+document.getElementById("responseQuestion6").value
        +"&responseQuestion7="+document.getElementById("responseQuestion7").value
        +"&responseQuestion8="+document.getElementById("responseQuestion8").value
        +"&responseQuestion9="+document.getElementById("responseQuestion9").value
        +"&responseQuestion10="+document.getElementById("responseQuestion10").value
        +"&responseQuestion11="+document.getElementById("responseQuestion11").value
        +"&responseQuestion12="+document.getElementById("responseQuestion12").value
        +"&responseQuestion13="+document.getElementById("responseQuestion13").value
        +"&serviceprovider="+document.getElementById("serviceprovider_na").value
        +"&serviceprovisiondate="+document.getElementById("serviceprovisiondate_na").value
        +"&conditionaffecting_nutrition="+conditionaffecting_nutrition
        +"&referral="+referral_na
        +"&id="+document.getElementById("record_id_for_na").innerText
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Nutritional Assessment Form Updated",
                style: {
                  background: "linear-gradient(to right, #227447, #C6EFCE)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //close Modal
                $('#newnutritionalAssessmentForm').modal('toggle');
                //Reload newnutritionalAssessmentForm Table
               var nutritionalAssessmentTable = $('#nutritionalAssessmentTable').DataTable();
               nutritionalAssessmentTable.ajax.reload();
               //Open DIV nutritionalAssessmentTable Table Record
               $('#collapsenutritionalAssessmentListTable').attr('class','collapse');
               $('#collapsenutritionalAssessmentListTable').attr('class','show');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Nutritional Assessment form NOT Updated, Review Changes",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}
//Get Last Beneficiary Status
function getLastBeneficiaryStatus(){
            $.ajax({
            url: 'db/getLastBeneficiaryStatus.php',
            type: 'post', 
            dataType: 'json',
            data: "vcUniqueId="+vcUniqueId,
            success: function(response){ 
            if(response.status=="success"){
                document.getElementById("fullname").value = response.name;
                document.getElementById("sex").value = response.gender;
                document.getElementById("currenthivstatus").value = response.hiv_status;
                document.getElementById("enrollmentstatus").value = response.enrollmentstatus;
                document.getElementById("date_enrollmentstatus").value = response.enrollmentstatus_date;
                document.getElementById("su_hivstatus").value = response.hiv_status;
                document.getElementById("su_date_hivstatus").value = response.date_hivstatus;
                document.getElementById("su_enrolledontreatment").value = response.enrolledontreatment;
                document.getElementById("su_facilityenrolled").value = response.facilityenrolled;
                document.getElementById("su_artstartdate").value = response.artstartdate;
                document.getElementById("su_treatment_art_no").value = response.treatment_art_no;
                document.getElementById("su_childhasbirthcertificate").value = response.childhasbirthcertificate;
                document.getElementById("su_childinschool").value = response.childinschool;
                document.getElementById("su_schoolname").value = response.schoolname;
                document.getElementById("su_schoolgrade").value = response.schoolgrade;
                document.getElementById("su_childonvocationaltraining").value = response.childonvocationaltraining;
                document.getElementById("su_vocationalinstitute").value = response.vocationalinstitute;
                document.getElementById("su_caregivername").value = response.caregivername;
                document.getElementById("su_enrollmentstatus").value = response.enrollmentstatus;
                document.getElementById("su_enrollmentstatus_date").value = response.enrollmentstatus_date;
            }
            else{
                console.log('Failure')
                alert("Cannot Pull Data");
            }
          }	
        }) 
    
}
//Get Last Beneficiary Status to compare if there are changes in the new form before submit
function getLastBeneficiaryStatusCompare(){
            $.ajax({
            url: 'db/getLastBeneficiaryStatus.php',
            type: 'post', 
            dataType: 'json',
            data: "vcUniqueId="+vcUniqueId,
            success: function(response){ 
            if(response.status=="success"){
                compare_fullname = response.name;
                compare_sex = response.gender;
                compare_currenthivstatus = response.hiv_status;
                compare_enrollmentstatus = response.enrollmentstatus;
                compare_date_enrollmentstatus = response.enrollmentstatus_date;
                compare_hivstatus = response.hiv_status;
                compare_date_hivstatus = response.date_hivstatus;
                compare_enrolledontreatment = response.enrolledontreatment;
                compare_facilityenrolled = response.facilityenrolled;
                compare_artstartdate = response.artstartdate;
                compare_treatment_art_no = response.treatment_art_no;
                compare_childhasbirthcertificate = response.childhasbirthcertificate;
                compare_childinschool = response.childinschool;
                compare_schoolname = response.schoolname;
                compare_schoolgrade = response.schoolgrade;
                compare_childonvocationaltraining = response.childonvocationaltraining;
                compare_vocationalinstitute = response.vocationalinstitute;
                compare_caregivername = response.caregivername;
                compare_enrollmentstatus = response.enrollmentstatus;
                compare_enrollmentstatus_date = response.enrollmentstatus_date;
                console.log("Executed Successfully: getLastBeneficiaryStatusCompare");
            }
            else{
                console.log('Failure')
                alert("Cannot Pull COMPARISON Data");
            }
          }	
        }) 
    
}

    function householdDetailsRefresh(){
        $.ajax({
            url: 'db/vcDetails.php',
            type: 'post', 
            dataType: 'json',
            data: "vcUniqueId="+vcUniqueId,
            success: function(response){ 
            if(response.status=="success"){
                var vc_status = response.vc_status;
                vc_status = vc_status.toUpperCase();
                document.getElementById("vc_status").innerText = vc_status;
                document.getElementById("vc_id").innerText = response.vc_unique_id;
                document.getElementById("vc_name").innerText = response.name;
                document.getElementById("vc_gender").innerText = response.gender;
                document.getElementById("vc_age").innerText = response.age;
                document.getElementById("hiv_status").innerText = response.hiv_status;

                //document.getElementById("lastknownhiv").value = response.hiv_status;
                //document.getElementById("l_known_hiv").innerText = response.hiv_status;
                hh_unique_num = response.hh_unique_num;
                public_age = response.age;
                hiv_status = response.hiv_status;
                
                //Variables for Status Update
                su_fullname = response.name;
                su_sex = response.gender;
                su_enrollmentstatus = vc_status;
                su_enrollment_date = response.enrollment_date;
                //console.log('Val: '+response.status)
            //Close Section B of Community Paeds if age is < 15 communityBasedPaedsFormSectionBCard                
                if(public_age < 15){
                    document.getElementById("communityBasedPaedsFormSectionBCard").style.display='none'
                }
                else{
                    document.getElementById("communityBasedPaedsFormSectionBCard").style.display='block'
                }
            }
            else{
                console.log('Failure')
            }
          }	
        })    
      }
//Activate close modal icon 
function closeModalButtonCaregiverAndVCModal(){
    $('#newcaregiverandVCStatusUpdate').modal('hide');
}
function closeModalButtonCareSupportChkList(){
    console.log('click close modal');
    $('#newcareandsupportChecklist').modal('hide');
}
function closeModalButtonEmergencyFundChkList(){
    $('#newaccessToEmergencyFundForm').modal('hide');
}
function closeModalReferral(){
    $('#newreferralForm').modal('hide');
}

//Assessment Forms
function closeModalChildEduPerfAssess(){
    $('#newChildEducationalPerfAssForm').modal('hide');
}
function closeModalRiskAssess(){
    $('#newcommunityBasedPaedsForm').modal('hide');
}
function closeModalNutriAssess(){
    $('#newnutritionalAssessmentForm').modal('hide');
}










