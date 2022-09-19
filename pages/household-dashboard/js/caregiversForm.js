document.addEventListener('DOMContentLoaded', init);
function init(){

document.getElementById("submitNewCaregiverForm").addEventListener('click', submitNewCaregiverForm, false);
document.getElementById("submitNewCaregiverUpdateForm").addEventListener('click', submitNewCaregiverUpdateForm, false);

    
document.getElementById("cg_hiv_status").addEventListener('change', function(ev){
    hivStatus = ev.target.value;
     
     if(hivStatus=='Positive' || hivStatus=='Negative'){
         document.getElementById("cg_datehivstatus").disabled = false;
     }
     else{
         document.getElementById("cg_datehivstatus").value = "";
         document.getElementById("cg_datehivstatus").disabled = true;
         
     }
     if(hivStatus=='Positive'){
         document.getElementById("cg_enrolledontreatment").disabled = false;
     }
     else{
         document.getElementById("cg_enrolledontreatment").selectedIndex = 0;
         document.getElementById("cg_enrolledontreatment").disabled = true;
     }
}, false);
document.getElementById("cg_enrolledontreatment").addEventListener('change', function(ev){
    enrollStatus = ev.target.value;
     
     if(enrollStatus=='Yes'){
         document.getElementById("cg_artstartdate").disabled = false;
         document.getElementById("cg_facilityenrolled").disabled = false;
         document.getElementById("cg_treatment_art_no").disabled = false;
     }
     else{
         document.getElementById("cg_artstartdate").value = "";
         document.getElementById("cg_facilityenrolled").selectedIndex = 0;
         document.getElementById("cg_treatment_art_no").value = "";
         document.getElementById("cg_artstartdate").disabled = true;
         document.getElementById("cg_facilityenrolled").disabled = true;
         document.getElementById("cg_treatment_art_no").disabled = true;
     }

}, false);
document.getElementById("beneficiary_type").addEventListener('change', function(ev){
    beneficiaryType = ev.target.value;
     
     if(beneficiaryType=='Household Head' || beneficiaryType=='Household Head and Caregiver'){
         document.getElementById("beneficiary_id").value = householdUniqueId;
     }
     else if(beneficiaryType=='Caregiver'){
         //Get the last beneficiary ID for that household and append a digit to it
    function getLastBeneficiaryId(){
        $.ajax({
            url: 'db/getLastBeneficiaryId.php',
            type: 'post', 
            dataType: 'json',
            data: "householdUniqueId="+householdUniqueId,
            success: function(response){ 
            if(response.status=="success"){
                //DB Feedback goes here
                // Grab the total length and either append '1' or add 1 it length is the accpted size
                beneficiaryId = response.beneficiaryid;
                beneficiaryIdLength = beneficiaryId.length;
                if(beneficiaryIdLength == 17){
                assignedBeneficiaryId = beneficiaryId+'1';
                }
                else if(beneficiaryIdLength == 18){
                    beneficiarySub = beneficiaryId.substring(0,12);
                    beneficiaryCode = beneficiaryId.substring(12);
                    convertBeneficiaryCodeToInt = parseInt(beneficiaryCode)+1;
                    //Append the codeInt to the BeneficiaryId
                    for(i=2; i < 6; i++){
                        convertBeneficiaryCodeToInt = '0'+convertBeneficiaryCodeToInt;
                    }
                    console.log(convertBeneficiaryCodeToInt);
                    document.getElementById("beneficiary_id").value = beneficiarySub+convertBeneficiaryCodeToInt; 
                    
                }
                
            }
            else if(response.status=="no_rows"){
                //Append '1' to the HH_UNIQUE_ID and display
                beneficiaryId = response.beneficiaryid;
                beneficiaryIdLength = beneficiaryId.length;
                console.log(beneficiaryIdLength);   
                assignedBeneficiaryId = beneficiaryId+'1';
                document.getElementById("beneficiary_id").value = assignedBeneficiaryId; 
            }
          }	
        })    
      }
      getLastBeneficiaryId();
     }
         if(beneficiaryType=='Household Head and Caregiver' || beneficiaryType=='Caregiver'){
             iscaregiver = "Yes";
         }
         else{
             iscaregiver = "No";
         }
         
}, false);

//addEventListener for Beneficiary Status Update Form
document.getElementById("upd_cg_hiv_status").addEventListener('change', function(ev){
    upd_hivStatus = ev.target.value;
     
     if(upd_hivStatus=='Positive' || upd_hivStatus=='Negative'){
         document.getElementById("upd_cg_datehivstatus").disabled = false;
         document.getElementById("upd_cg_datehivstatus").value = "";

     }
     else{
         document.getElementById("upd_cg_datehivstatus").value = "";
         document.getElementById("upd_cg_datehivstatus").disabled = true;
         
     }
     if(upd_hivStatus=='Positive'){
         document.getElementById("upd_cg_enrolledontreatment").disabled = false;
     }
     else{
         document.getElementById("upd_cg_enrolledontreatment").selectedIndex = 0;
         document.getElementById("upd_cg_enrolledontreatment").disabled = true;
     }
}, false);
document.getElementById("upd_cg_enrolledontreatment").addEventListener('change', function(ev){
    upd_enrollStatus = ev.target.value;
     
     if(upd_enrollStatus=='Yes'){
         document.getElementById("upd_cg_artstartdate").disabled = false;
         document.getElementById("upd_cg_facilityenrolled").disabled = false;
         document.getElementById("upd_cg_treatment_art_no").disabled = false;
     }
     else{
         document.getElementById("upd_cg_artstartdate").value = "";
         document.getElementById("upd_cg_facilityenrolled").selectedIndex = 0;
         document.getElementById("upd_cg_treatment_art_no").value = "";
         document.getElementById("upd_cg_artstartdate").disabled = true;
         document.getElementById("upd_cg_facilityenrolled").disabled = true;
         document.getElementById("upd_cg_treatment_art_no").disabled = true;
     }

}, false);


}

function submitNewCaregiverForm(ev){
    ev.preventDefault();
    surname = document.getElementById("cg_surname").value;
    firstname = document.getElementById("cg_firstname").value;
    gender = document.getElementById("cg_gender").value;
    dob = document.getElementById("cg_dob").value;
    phonenumber = document.getElementById("cg_phonenumber").value;
    marital_status = document.getElementById("cg_marital_status").value;
    occupation = document.getElementById("cg_occupation").value;
    hiv_status = document.getElementById("cg_hiv_status").value;
    datehivstatus = document.getElementById("cg_datehivstatus").value;
    enrolledontreatment = document.getElementById("cg_enrolledontreatment").value;
    artstartdate = document.getElementById("cg_artstartdate").value;
    facilityenrolled = document.getElementById("cg_facilityenrolled").value;
    treatment_art_no = document.getElementById("cg_treatment_art_no").value;
    beneficiary_type = document.getElementById("beneficiary_type").value;
    beneficiary_id = document.getElementById("beneficiary_id").value;
    enrollmentdate = document.getElementById("enrollmentdate").value;
    position = 'Secondary';
 if(enrolledontreatment=="Yes"){
     currentenrollmentstatus = "Enrolled";
 }
 else{
     currentenrollmentstatus = "Not Enrolled";
 }

        //Check for Validation and Missed Entries
        if(surname==""){document.getElementById("cg_surname_label").innerHTML="Field is required";surname_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{surname_chk=1;document.getElementById("cg_surname_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(enrollmentdate==""){document.getElementById("enrollmentdate_label").innerHTML="Field is required";enrollmentdate_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{enrollmentdate_chk=1;document.getElementById("enrollmentdate_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(firstname==""){document.getElementById("cg_firstname_label").innerHTML="Field is required";firstname_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{firstname_chk=1;document.getElementById("cg_firstname_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(gender=="" || gender=='Select Gender'){document.getElementById("cg_gender_label").innerHTML="Field is required";gender_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{gender_chk=1;document.getElementById("cg_gender_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(dob==""){document.getElementById("cg_dob_label").innerHTML="Field is required";dob_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{dob_chk=1;document.getElementById("cg_dob_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(phonenumber==""){document.getElementById("cg_phonenumber_label").innerHTML="Field is required";phonenumber_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{phonenumber_chk=1;document.getElementById("cg_phonenumber_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(marital_status=="" || marital_status=='Select Marital Status'){document.getElementById("cg_marital_status_label").innerHTML="Field is required";marital_status_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{marital_status_chk=1;document.getElementById("cg_marital_status_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(occupation=="" || occupation=='Select Occupation'){document.getElementById("cg_occupation_label").innerHTML="Field is required";occupation_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{occupation_chk=1;document.getElementById("cg_occupation_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(hiv_status=="" || hiv_status=='Select HIV Status'){document.getElementById("cg_hiv_status_label").innerHTML="Field is required";hiv_status_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{hiv_status_chk=1;document.getElementById("cg_hiv_status_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if((hiv_status=="Positive" || hiv_status=='Negative') &&  datehivstatus==''){document.getElementById("cg_datehivstatus_label").innerHTML="Field is required";datehivstatus_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{datehivstatus_chk=1;document.getElementById("cg_datehivstatus_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(hiv_status=="Negative" &&  (enrolledontreatment!='Select' || artstartdate!='' || facilityenrolled!='' || treatment_art_no!='')){document.getElementById("cg_hiv_status_label").innerHTML="Negative Status should not have treatment information";hiv_status_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{hiv_status_chk=1;document.getElementById("cg_hiv_status_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(hiv_status=="Positive" && enrolledontreatment=='Select'){document.getElementById("cg_enrolledontreatment_label").innerHTML="Field is required";enrolledontreatment_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{enrolledontreatment_chk=1;document.getElementById("cg_enrolledontreatment_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(hiv_status=="Positive" &&  enrolledontreatment=='Yes' && artstartdate==''){document.getElementById("cg_artstartdate_label").innerHTML="Field is required";artstartdate_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{artstartdate_chk=1;document.getElementById("cg_artstartdate_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(hiv_status=="Positive" &&  enrolledontreatment=='Yes' && facilityenrolled==''){document.getElementById("cg_facilityenrolled_label").innerHTML="Field is required";facilityenrolled_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{facilityenrolled_chk=1;document.getElementById("cg_facilityenrolled_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(hiv_status=="Positive" &&  enrolledontreatment=='Yes' && treatment_art_no==''){document.getElementById("cg_treatment_art_no_label").innerHTML="Field is required";treatment_art_no_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{treatment_art_no_chk=1;document.getElementById("cg_treatment_art_no_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}

        if(beneficiary_type=="" || beneficiary_type=="Select"){document.getElementById("beneficiary_type_label").innerHTML="Field is required";beneficiary_type_chk=0;$('#collapsebeneficiaryStatus').collapse('show');}else{beneficiary_type_chk=1;document.getElementById("beneficiary_type_label").innerHTML="";$('#collapsebeneficiaryStatus').collapse('hide');}
        if((beneficiary_type!="Select") && beneficiary_id==""){document.getElementById("beneficiary_id_label").innerHTML="Field is required";beneficiary_id_chk=0;$('#collapsebeneficiaryStatus').collapse('show');}else{beneficiary_id_chk=1;document.getElementById("beneficiary_id_label").innerHTML="";$('#collapsebeneficiaryStatus').collapse('hide');}

    
    
//Confirm validation and set validation status
    if(
        surname_chk == 0 ||firstname_chk == 0 ||gender_chk == 0 || dob_chk == 0 || phonenumber_chk == 0 || marital_status_chk == 0 || occupation_chk == 0 || hiv_status_chk == 0 || datehivstatus_chk == 0 ||
        enrolledontreatment_chk == 0 ||artstartdate_chk == 0 ||facilityenrolled_chk == 0 ||treatment_art_no_chk == 0 ||beneficiary_type_chk == 0 ||beneficiary_id_chk == 0){
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
            createBeneficiaryStatusUpdate();  
    }    
}
function createBeneficiaryStatusUpdate(){

    $.ajax({
        url: 'db/createBeneficiaryStatusUpdate.php',
        type: 'post',
        data: "hhuniqueid="+householdUniqueId
        +"&beneficiaryid="+beneficiary_id
        +"&enrollmentid="+beneficiary_id
        +"&firstname="+firstname
        +"&surname="+surname
        +"&dateofenrollment="+enrollmentdate
        +"&sex="+gender
        +"&dob="+dob
        +"&phonenumber="+phonenumber
        +"&currenthivstatus="+hiv_status
        +"&dateofcurrenthivstatus="+datehivstatus
        +"&enrolledontreatment="+enrolledontreatment
        +"&dateenrolledontreatment="+artstartdate
        +"&hivtreatmentfacility="+facilityenrolled
        +"&occupation="+occupation
        +"&currentenrollmentstatus="+currentenrollmentstatus
        +"&dateofcurrentenrollmentstatus="+artstartdate
        +"&maritalstatus="+marital_status
        +"&iscaregiver="+iscaregiver
        +"&beneficiarytype="+beneficiary_type
        +"&treatmentid="+treatment_art_no
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Adult Household Beneficiary Created",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //re-initialize table
               var vcListtable = $('#vcListTable').DataTable();
               vcListtable.ajax.reload();

            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Adult Household Beneficiary NOT created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Adult Household Beneficiary already exists, Please review",
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

function submitNewCaregiverUpdateForm(ev){
    ev.preventDefault();
    
    upd_surname = document.getElementById("upd_cg_surname").value;
    upd_firstname = document.getElementById("upd_cg_firstname").value;
    upd_gender = document.getElementById("upd_cg_gender").value;
    upd_dob = document.getElementById("upd_cg_dob").value;
    upd_phonenumber = document.getElementById("upd_cg_phonenumber").value;
    upd_marital_status = document.getElementById("upd_cg_marital_status").value;
    upd_occupation = document.getElementById("upd_cg_occupation").value;
    upd_hiv_status = document.getElementById("upd_cg_hiv_status").value;
    upd_datehivstatus = document.getElementById("upd_cg_datehivstatus").value;
    upd_enrolledontreatment = document.getElementById("upd_cg_enrolledontreatment").value;
    upd_artstartdate = document.getElementById("upd_cg_artstartdate").value;
    upd_facilityenrolled = document.getElementById("upd_cg_facilityenrolled").value;
    upd_treatment_art_no = document.getElementById("upd_cg_treatment_art_no").value;
    upd_beneficiary_type = document.getElementById("upd_beneficiary_type").value;
    upd_beneficiary_id = document.getElementById("upd_beneficiary_id").value;
    upd_enrollmentdate = document.getElementById("upd_enrollmentdate").value;
    upd_position = 'Secondary';
 if(upd_enrolledontreatment=="Yes"){
     upd_currentenrollmentstatus = "Enrolled";
 }
 else{
     upd_currentenrollmentstatus = "Not Enrolled";
 }    
         if(upd_beneficiary_type=='Household Head and Caregiver' || upd_beneficiary_type=='Caregiver'){
             upd_iscaregiver = "Yes";
         }
         else{
             upd_iscaregiver = "No";
         }    
    
        //Check for Validation and Missed Entries
        if(upd_surname==""){document.getElementById("upd_cg_surname_label").innerHTML="Field is required";surname_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{surname_chk=1;document.getElementById("upd_cg_surname_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_enrollmentdate==""){document.getElementById("upd_enrollmentdate_label").innerHTML="Field is required";enrollmentdate_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{enrollmentdate_chk=1;document.getElementById("upd_enrollmentdate_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_firstname==""){document.getElementById("upd_cg_firstname_label").innerHTML="Field is required";firstname_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{firstname_chk=1;document.getElementById("upd_cg_firstname_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_gender=="" || upd_gender=='Select Gender'){document.getElementById("upd_cg_gender_label").innerHTML="Field is required";gender_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{gender_chk=1;document.getElementById("upd_cg_gender_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_dob==""){document.getElementById("upd_cg_dob_label").innerHTML="Field is required";dob_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{dob_chk=1;document.getElementById("upd_cg_dob_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_phonenumber==""){document.getElementById("upd_cg_phonenumber_label").innerHTML="Field is required";phonenumber_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{phonenumber_chk=1;document.getElementById("upd_cg_phonenumber_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_marital_status=="" || upd_marital_status=='Select Marital Status'){document.getElementById("upd_cg_marital_status_label").innerHTML="Field is required";marital_status_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{marital_status_chk=1;document.getElementById("upd_cg_marital_status_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_occupation=="" || upd_occupation=='Select Occupation'){document.getElementById("upd_cg_occupation_label").innerHTML="Field is required";occupation_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{occupation_chk=1;document.getElementById("upd_cg_occupation_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_hiv_status=="" || upd_hiv_status=='Select HIV Status'){document.getElementById("upd_cg_hiv_status_label").innerHTML="Field is required";hiv_status_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{hiv_status_chk=1;document.getElementById("upd_cg_hiv_status_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if((upd_hiv_status=="Positive" || upd_hiv_status=='Negative') &&  upd_datehivstatus==''){document.getElementById("upd_cg_datehivstatus_label").innerHTML="Field is required";datehivstatus_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{datehivstatus_chk=1;document.getElementById("upd_cg_datehivstatus_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_hiv_status=="Negative" &&  (upd_enrolledontreatment!='Select' || upd_artstartdate!='' || upd_facilityenrolled!='' || upd_treatment_art_no!='')){document.getElementById("upd_cg_hiv_status_label").innerHTML="Negative Status should not have treatment information";hiv_status_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{hiv_status_chk=1;document.getElementById("upd_cg_hiv_status_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_hiv_status=="Positive" && upd_enrolledontreatment=='Select'){document.getElementById("upd_cg_enrolledontreatment_label").innerHTML="Field is required";enrolledontreatment_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{enrolledontreatment_chk=1;document.getElementById("upd_cg_enrolledontreatment_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_hiv_status=="Positive" &&  upd_enrolledontreatment=='Yes' && upd_artstartdate==''){document.getElementById("upd_cg_artstartdate_label").innerHTML="Field is required";artstartdate_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{artstartdate_chk=1;document.getElementById("upd_cg_artstartdate_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_hiv_status=="Positive" &&  upd_enrolledontreatment=='Yes' && upd_facilityenrolled==''){document.getElementById("upd_cg_facilityenrolled_label").innerHTML="Field is required";facilityenrolled_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{facilityenrolled_chk=1;document.getElementById("upd_cg_facilityenrolled_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}
        if(upd_hiv_status=="Positive" &&  upd_enrolledontreatment=='Yes' && upd_treatment_art_no==''){document.getElementById("upd_cg_treatment_art_no_label").innerHTML="Field is required";treatment_art_no_chk=0;$('#collapseprimaryCaregiverInformation').collapse('show');}else{treatment_art_no_chk=1;document.getElementById("upd_cg_treatment_art_no_label").innerHTML="";$('#collapseprimaryCaregiverInformation').collapse('hide');}

        if(upd_beneficiary_type=="" || upd_beneficiary_type=="Select"){document.getElementById("upd_beneficiary_type_label").innerHTML="Field is required";beneficiary_type_chk=0;$('#collapsebeneficiaryStatus').collapse('show');}else{beneficiary_type_chk=1;document.getElementById("upd_beneficiary_type_label").innerHTML="";$('#collapsebeneficiaryStatus').collapse('hide');}
        if((upd_beneficiary_type!="Select") && upd_beneficiary_id==""){document.getElementById("upd_beneficiary_id_label").innerHTML="Field is required";beneficiary_id_chk=0;$('#collapsebeneficiaryStatus').collapse('show');}else{beneficiary_id_chk=1;document.getElementById("upd_beneficiary_id_label").innerHTML="";$('#collapsebeneficiaryStatus').collapse('hide');}
    
    
    
//Confirm validation and set validation status
    if(
        surname_chk == 0 ||firstname_chk == 0 ||gender_chk == 0 || dob_chk == 0 || phonenumber_chk == 0 || marital_status_chk == 0 || occupation_chk == 0 || hiv_status_chk == 0 || datehivstatus_chk == 0 ||
        enrolledontreatment_chk == 0 ||artstartdate_chk == 0 ||facilityenrolled_chk == 0 ||treatment_art_no_chk == 0 ||beneficiary_type_chk == 0 ||beneficiary_id_chk == 0){
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
            createBeneficiaryStatusUpdate_update();  
    }      
}

function createBeneficiaryStatusUpdate_update(){
     $.ajax({
        url: 'db/createBeneficiaryStatusUpdate.php',
        type: 'post',
        data: "hhuniqueid="+householdUniqueId
        +"&beneficiaryid="+upd_beneficiary_id
        +"&enrollmentid="+upd_beneficiary_id
        +"&firstname="+upd_firstname
        +"&surname="+upd_surname
        +"&dateofenrollment="+upd_enrollmentdate
        +"&sex="+upd_gender
        +"&dob="+upd_dob
        +"&phonenumber="+upd_phonenumber
        +"&currenthivstatus="+upd_hiv_status
        +"&dateofcurrenthivstatus="+upd_datehivstatus
        +"&enrolledontreatment="+upd_enrolledontreatment
        +"&dateenrolledontreatment="+upd_artstartdate
        +"&hivtreatmentfacility="+upd_facilityenrolled
        +"&occupation="+upd_occupation
        +"&currentenrollmentstatus="+upd_currentenrollmentstatus
        +"&dateofcurrentenrollmentstatus="+upd_artstartdate
        +"&maritalstatus="+upd_marital_status
        +"&iscaregiver="+upd_iscaregiver
        +"&beneficiarytype="+upd_beneficiary_type
        +"&treatmentid="+upd_treatment_art_no
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Beneficiary Update Created",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //re-initialize table
               var vcListtable = $('#vcListTable').DataTable();
               vcListtable.ajax.reload();

            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Beneficiary Update NOT created, Review Entry",
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