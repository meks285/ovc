document.addEventListener('DOMContentLoaded', init);

function init(){
 //Launch the OFFER FORM Modal -- START    
    //Hide Phone Number and disable Question Two
document.getElementById("div_phonenumberConsent").style.display = 'none';
document.getElementById("responseQuestion2Offer").disabled = true;
//Set Listener on responseQuestion1; If No open responseQuestion2
document.getElementById("responseQuestion1Offer").addEventListener('change',function(ev){
    if(ev.target.value == 'No'){
        document.getElementById("responseQuestion2Offer").disabled = false;        
    }
    else{
        document.getElementById("responseQuestion2Offer").selectedIndex = 0;
        document.getElementById("responseQuestion2Offer").disabled = true;        
    }
}, false)
//Set Listener on responseQuestion2; If No open div_phonenumberConsent
document.getElementById("responseQuestion2Offer").addEventListener('change',function(ev){
    if(ev.target.value == 'Yes'){
        document.getElementById("div_phonenumberConsent").style.display = 'block';       
    }
    else{
        document.getElementById("phonenumberOfferForm").value='';
        document.getElementById("div_phonenumberConsent").style.display = 'none';       
    }
}, false)
//Activate the submitOfferForm Function to Validate and Submit the Offer Form
document.getElementById("submitOfferForm").addEventListener('click',submitOfferForm,false);
//Launch the OFFER FORM Modal -- STOP 

    function householdDetails(){
        $.ajax({
            url: 'db/householdDetails.php',
            type: 'post', 
            dataType: 'json',
            data: "householdUniqueId="+householdUniqueId,
            success: function(response){ 
            if(response.status=="success"){
                document.getElementById("assessdate").innerText = response.date_of_assessment;
                document.getElementById("hh_id").innerText = response.hh_unique_num;
                document.getElementById("state").innerText = response.state;
                document.getElementById("lga").innerText = response.lga;
                document.getElementById("ward").innerText = response.ward;
                document.getElementById("community").innerText = response.community;
                document.getElementById("address").innerText = response.address;
                document.getElementById("caregiver").innerText = response.surname+' '+response.firstname;
                document.getElementById("phonenumber").innerText = response.phonenumber;
                document.getElementById("sex").innerText = response.gender;

                document.getElementById("marital_status").innerText = response.marital_status;
                document.getElementById("occupation").innerText = response.occupation;
            
                
                var dobString = response.dob;
                getAge(dobString);
                function getAge(dateString) {
                    var today = new Date();
                    var birthDate = new Date(dateString);
                    var age = today.getFullYear() - birthDate.getFullYear();
                    var m = today.getMonth() - birthDate.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    document.getElementById("age").innerText = age;
                }
            }
            else{
                
            }
          }	
        })    
      }
    
      householdDetails();
      checkConsentExists();
      document.getElementById("addVC").addEventListener('click',function(){
        createNewVCId(householdUniqueId);
    },false)
//Close modal on button Click    
      document.getElementById("modalExitButton").addEventListener('click',function(){
        $('#newVcModal').modal('hide');
    },false)
      document.getElementById("modalExitButtonOffer").addEventListener('click',function(){
        $('#newOfferFormModal').modal('hide');
    },false)
      document.getElementById("modalExitButtonCaregiver").addEventListener('click',function(){
        $('#newCaregiverFormModal').modal('hide');
    },false)
      document.getElementById("modalExitButtonConsent").addEventListener('click',function(){
        $('#newConsentFormModal').modal('hide');
    },false)


//Listen for when New Caregiver Modal Launch Button isCLicked newCaregiverLaunchModalButton
document.getElementById("newCaregiverLaunchModalButton").addEventListener('click', function(){
    //console.log("Clicked: "+householdUniqueId);
    document.getElementById("hh_unique_id_cg").innerText = householdUniqueId;
}, false)

// Validate that Date of Birth of caregiver is above 17 years  
document.getElementById("dob").addEventListener('change',function(){

    //Initialize Toast
    const caregiverAgeToast = Toastify({
        text: "Vulnerable Child cannot be older than 17",
        style: {
          background: "linear-gradient(to right, #DC3545, #DC3545)",
        },
        close: true,
        duration: 3000
    });         
            dob_value = new Date(document.getElementById("dob").value);
            dob_year = dob_value.getFullYear();
            //Get Todays Date
            const today = new Date();
            const current_year = today.getFullYear();
            age = current_year-dob_year;
            if(age > 17){
                caregiverAgeToast.showToast();
                document.getElementById("dob").value = "";
            }
        }, false)

document.getElementById("submitVCForm").addEventListener('click', submitVCForm, false);

//Add EventListener to enrollment_setting to open treamtent_number field if enrollment setting is Facility.
document.getElementById("enrollment_setting").addEventListener('change', function(ev){

    if(ev.target.value == 'Facility'){
        document.getElementById("treatment_art_no").disabled = false;

    }
    else{
        document.getElementById("treatment_art_no").disabled = true;
        document.getElementById("treatment_art_no").value = "";

    }
}, false)
//Add EventListner to handle all Events relating to Childs HIV Status
//1.) Disable all the necessary Fields on Form Load
document.getElementById("childdatehivstatus").disabled=true;
document.getElementById("childenrolledontreatment").disabled=true;
document.getElementById("childartstartdate").disabled=true;
document.getElementById("childfacilityenrolled").disabled=true;
//Add EventListner to Open disabled fields if hiv_status is positive or negative
document.getElementById("childhiv_status").addEventListener('change', function(ev){
    var status_hiv = ev.target.value;
    if(status_hiv=='Positive'){
            document.getElementById("childdatehivstatus").disabled=false;
            document.getElementById("childenrolledontreatment").disabled=false;        
    }
    else if(status_hiv=='Negative'){
            document.getElementById("childdatehivstatus").disabled=false;
            document.getElementById("childenrolledontreatment").selectedIndex = 0;
            document.getElementById("childenrolledontreatment").disabled=true;    
            document.getElementById("childfacilityenrolled").selectedIndex = 0;            
            document.getElementById("childfacilityenrolled").disabled=true;         
    }
    
}, false)
//Add EventListner to Open disabled fields if enrolled on treatment is yes
document.getElementById("childenrolledontreatment").addEventListener('change', function(ev){
    var isEnrolled = ev.target.value;
    if(isEnrolled=='Yes'){
            document.getElementById("childfacilityenrolled").disabled=false;       
            document.getElementById("childartstartdate").disabled=false;       
    }
    else{
            document.getElementById("childfacilityenrolled").disabled=true;
            document.getElementById("childartstartdate").value='';
            document.getElementById("childartstartdate").disabled=true;
    }
    
}, false)
//Add EventListener to Search Entered treatment_art_no to find match in ovcoffertable and transfer art data to VC Enrollment Form.
document.getElementById("treatment_art_no").addEventListener('change', function(ev){
    var treatment_art_no = ev.target.value;
    
    //First: Check if FORMAT is OK
    checkTreatmentNo(treatment_art_no);
    if(!isTreatmentNoOk){
        document.getElementById("treatment_art_no").value = '';
                Toastify({
                    text: "Wrong Treatment/ART Number Format",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();    

    }    
else{
            console.log(treatment_art_no);
            $.ajax({
            url: 'db/getOfferDetails.php',
            type: 'post', 
            dataType: 'json',
            data: "treatment_art_no="+treatment_art_no,
            success: function(response){ 
            if(response.status=="success"){
                
                //OPEN all neccesary fields disabled by default
                document.getElementById("childhiv_status").disabled = false;                
                document.getElementById("childenrolledontreatment").disabled = false;                
                document.getElementById("childfacilityenrolled").disabled = false;                
                document.getElementById("childartstartdate").disabled = false;                     
                document.getElementById("childdatehivstatus").disabled=false;
            
                document.getElementById("childhiv_status").value = 'Positive';
                document.getElementById("childenrolledontreatment").value = 'Yes';
                document.getElementById("childfacilityenrolled").value = response.facilityname;
                document.getElementById("childartstartdate").value = response.artstartdate;
                var fullname = response.clientname;
                let surname = fullname.split(" ")[0]
                let othernames = fullname.split(" ")[1]
                //document.getElementById("artstartdate").value = response.artstartdate;
                document.getElementById("surname").value = surname;
                document.getElementById("othernames").value = othernames;
            }
            else{
                document.getElementById("childhiv_status").selectedIndex  = 0;
                document.getElementById("childenrolledontreatment").selectedIndex = 0;
                document.getElementById("childfacilityenrolled").selectedIndex = 0;
                document.getElementById("childartstartdate").value = '';
                document.getElementById("childdatehivstatus").value='';                
                document.getElementById("surname").value = '';
                document.getElementById("othernames").value = '';
                
                document.getElementById("childhiv_status").disabled = false;                
                document.getElementById("childenrolledontreatment").disabled = false;                
                document.getElementById("childfacilityenrolled").disabled = false;                
                document.getElementById("childartstartdate").disabled = false;                     
                document.getElementById("childdatehivstatus").disabled=false;
                //Launch the offer form modal
                $('#newOfferFormModal').modal('toggle');


            }
          }	
        }) 
}

}, false)


//Add EventListner to handle all Events relating to Childs School and Vocational Training
//1.) Disable all the necessary Fields on Form Load
document.getElementById("schoolname").disabled=true;
document.getElementById("schoolgrade").disabled=true;
document.getElementById("vocationalinstitute").disabled=true;

//Add EventListner to Open disabled fields if childinschool is Yes
document.getElementById("childinschool").addEventListener('change', function(ev){
    var isChildInSchool = ev.target.value;
    if(isChildInSchool=='Yes'){
            document.getElementById("schoolname").disabled=false;
            document.getElementById("schoolgrade").disabled=false;        
    }
    else{
            document.getElementById("schoolname").selectedIndex = 0;
            document.getElementById("schoolname").disabled=true;
            document.getElementById("schoolgrade").selectedIndex = 0;
            document.getElementById("schoolgrade").disabled=true;    
    }
    
}, false)
//Add EventListner to Open disabled fields if childonvocationaltraining is Yes
document.getElementById("childonvocationaltraining").addEventListener('change', function(ev){
    var isChildInVocational = ev.target.value;
    if(isChildInVocational=='Yes'){
            document.getElementById("vocationalinstitute").disabled=false;      
    }
    else{
            document.getElementById("vocationalinstitute").value='';    
            document.getElementById("vocationalinstitute").disabled=true;    
    }
    
}, false)

//Check if regex for treatment_art_no_offer returns true
document.getElementById("treatment_art_no_offer").addEventListener('change', function(ev){
    console.log(ev.target.value);
    checkTreatmentNo(ev.target.value);
    if(!isTreatmentNoOk){
        document.getElementById("treatment_art_no_offer").value = '';
                Toastify({
                    text: "Wrong Treatment/ART Number Format",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();    
    }
}, false)

//START FUnction to display element based on value of Question 1 - FORM: Caregiver Access to Emergency Funds Checklist
document.getElementById("efresponseQuestion1").addEventListener('change', function(){
    var value = document.getElementById("efresponseQuestion1").value;
    if(value == 'Yes'){
        document.getElementById("q2").style.display = 'block';
        document.getElementById("q3").style.display = 'none';
        //investigate
       // document.getElementById("efresponseQuestion3").value = '';

    }
    else{
        document.getElementById("q2").style.display = 'none';
        document.getElementById("q3").style.display = 'none';
        document.getElementById("efresponseQuestion2").value = '';
                //investigate
        //document.getElementById("efresponseQuestion3").value = '';
    }
    
}, false)
document.getElementById("efresponseQuestion2").addEventListener('change', function(){
    var value = document.getElementById("efresponseQuestion2").value;
    if(value == 'No'){
        document.getElementById("q3").style.display = 'block';
        document.getElementById("q4").style.display = 'none';
    }
    else{
        document.getElementById("q4").style.display = 'block';
        document.getElementById("q3").style.display = 'none';

    }
    
}, false)

document.getElementById("table_q3").addEventListener('click',function(){
    //Convert efresponseQuestion3 Checkbox to Array and toString for insert
    var checked = []
    $("input[name='efresponseQuestion3[]']:checked").each(function ()
    {
        checked.push($(this).val());
        console.log($(this).val())
        if($(this).val()=='Others'){
            document.getElementById("divefresponseQuestion3_other").style.display = 'block';
        }
        else{
            document.getElementById("divefresponseQuestion3_other").style.display = 'none';
        }

    });

}, false)
document.getElementById("table_q4").addEventListener('click',function(){
    //Convert efresponseQuestion3 Checkbox to Array and toString for insert
    var checked = []
    $("input[name='efresponseQuestion4[]']:checked").each(function ()
    {
        checked.push($(this).val());
        if($(this).val()=='Others'){
            document.getElementById("divefresponseQuestion4_other").style.display = 'block';
        }
        else{
            document.getElementById("divefresponseQuestion4_other").style.display = 'none';
        }

    });
}, false)
// END FUnction to display element based on value of Question 1 - FORM: Caregiver Access to Emergency Funds Checklist

//Listen for Button Click on Emergency Fund Form
document.getElementById("submitEmergencyFundForm").addEventListener('click', submitEmergencyFundForm, false);
//Listen for Button Click on submitReferralForm
document.getElementById("submitReferralForm").addEventListener('click', submitReferralForm, false);

//Check if User has rights to Data Entry, IF no, Disable the HHVA Form
if(!privilege.includes("Data Entry")){
    document.getElementById("submitVCForm").disabled = true;
    document.getElementById("submitVCForm").style.backgroundColor = 'gray';
    document.getElementById("submitVCForm").innerText = 'disabled';

    document.getElementById("submitVCServicesForm").disabled = true;
    document.getElementById("submitVCServicesForm").style.backgroundColor = 'gray';
    document.getElementById("submitVCServicesForm").innerText = 'disabled';

    document.getElementById("submitConsentForm").disabled = true;
    document.getElementById("submitConsentForm").style.backgroundColor = 'gray';
    document.getElementById("submitConsentForm").innerText = 'disabled';

    document.getElementById("submitStatusUpdateForm").disabled = true;
    document.getElementById("submitStatusUpdateForm").style.backgroundColor = 'gray';
    document.getElementById("submitStatusUpdateForm").innerText = 'disabled';

    document.getElementById("submitNewCaregiverForm").disabled = true;
    document.getElementById("submitNewCaregiverForm").style.backgroundColor = 'gray';
    document.getElementById("submitNewCaregiverForm").innerText = 'disabled';

    document.getElementById("submitOfferForm").disabled = true;
    document.getElementById("submitOfferForm").style.backgroundColor = 'gray';
    document.getElementById("submitOfferForm").innerText = 'disabled';

    document.getElementById("submitNewCaregiverUpdateForm").disabled = true;
    document.getElementById("submitNewCaregiverUpdateForm").style.backgroundColor = 'gray';
    document.getElementById("submitNewCaregiverUpdateForm").innerText = 'disabled';

    document.getElementById("submitEmergencyFundForm").disabled = true;
    document.getElementById("submitEmergencyFundForm").style.backgroundColor = 'gray';
    document.getElementById("submitEmergencyFundForm").innerText = 'disabled';

    document.getElementById("submitReferralForm").disabled = true;
    document.getElementById("submitReferralForm").style.backgroundColor = 'gray';
    document.getElementById("submitReferralForm").innerText = 'disabled';

        Toastify({
            text: "This User does not have DATA ENTRY rights.",
            style: {
              background: "linear-gradient(to right, #DC3545, #DC3545)",
            },
            close: true,
            duration: 10000
        }).showToast();    
}


}

//START Script to Check if the Consent Form is filled for this Household. If not, popup the Consent Form modal
    function checkConsentExists(){
        $.ajax({
            url: 'db/checkExistingConsent.php',
            type: 'post', 
            dataType: 'json',
            data: "householdUniqueId="+householdUniqueId,
            success: function(response){ 
            if(response.status=="success"){
				//Consent Form Does not Exist. Popup Modal and Show Notification
            Toastify({
                text: "Consent Form Loaded.",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();	
                $('#newConsentFormModal').modal('show');
				document.getElementById("addVC").disabled=true;
            }
            else{
				//Consent Form Exist
            }
          }	
        })    
      }
//END Script to Check if the Consent Form is filled for this Household. If not, popup the Consent Form modal
function submitVCForm(ev){
    ev.preventDefault();
    enrollment_date = document.getElementById("enrollment_date").value;
    hh_unique_num = householdUniqueId;
    vc_unique_id = document.getElementById("vc_unique_id").value;
    vc_count = vc_count;
    surname = document.getElementById("surname").value;
    othernames = document.getElementById("othernames").value;
    gender = document.getElementById("gender").value;
    dob = document.getElementById("dob").value;
    //Convert EnrollmentStream Checkbox to Array and toString for insert
    var checked = []
    $("input[name='enrollmentstream[]']:checked").each(function ()
    {
        checked.push($(this).val());
    });
    enrollmentstream = checked.toString();
    enrollmentstreambasedon = document.getElementById("enrollmentstreambasedon").value;
//    hiv_status = document.getElementById("hiv_status").value;
    birthcertificate = document.getElementById("birthcertificate").value;
    childinschool = document.getElementById("childinschool").value;
    caregiverrelationshiptochild = document.getElementById("caregiverrelationshiptochild").value;
    caregiver = document.getElementById("caregivername").value;
    
//New Columns Addition
    enrollment_setting = document.getElementById("enrollment_setting").value;
    treatment_art_no = document.getElementById("treatment_art_no").value;
    childhiv_status = document.getElementById("childhiv_status").value;
    childdatehivstatus = document.getElementById("childdatehivstatus").value;
    childenrolledontreatment = document.getElementById("childenrolledontreatment").value;
    childartstartdate = document.getElementById("childartstartdate").value;
    childfacilityenrolled = document.getElementById("childfacilityenrolled").value;
    schoolname = document.getElementById("schoolname").value;
    schoolgrade = document.getElementById("schoolgrade").value;
    childonvocationaltraining = document.getElementById("childonvocationaltraining").value;
    vocationalinstitute = document.getElementById("vocationalinstitute").value;

        //Check for Validation and Missed Entries -- New Columns Addition
        if(enrollment_setting=="" || enrollment_setting=="Select"){document.getElementById("enrollment_setting_label").innerHTML="Field is required";enrollment_setting_chk=0;$('#collapseenrollmentSettings').collapse('show');}else{enrollment_setting_chk=1;document.getElementById("enrollment_setting_label").innerHTML="";$('#collapseenrollmentSettings').collapse('hide');}
        if(enrollment_setting=="Facility" && treatment_art_no==""){document.getElementById("treatment_art_no_label").innerHTML="Field is required";treatment_art_no_chk=0;$('#collapsegeneralInformation').collapse('show');}else{treatment_art_no_chk=1;document.getElementById("treatment_art_no_label").innerHTML="";$('#collapsegeneralInformation').collapse('hide');}

        if(childhiv_status=="" || childhiv_status=="Select"){document.getElementById("childhiv_status_label").innerHTML="Field is required";childhiv_status_chk=0;$('#collapsechildsHIVStatus').collapse('show');}else{childhiv_status_chk=1;document.getElementById("childhiv_status_label").innerHTML="";$('#collapsechildsHIVStatus').collapse('hide');}
        if((childhiv_status=="Positive" || childhiv_status=="Negative") && childdatehivstatus==""){document.getElementById("childdatehivstatus_label").innerHTML="Field is required";childdatehivstatus_chk=0;$('#collapsechildsHIVStatus').collapse('show');}else{childdatehivstatus_chk=1;document.getElementById("childdatehivstatus_label").innerHTML="";$('#collapsechildsHIVStatus').collapse('hide');}
        if(childhiv_status=="Yes" && childenrolledontreatment=="Select"){document.getElementById("childenrolledontreatment_label").innerHTML="Field is required";childenrolledontreatment_chk=0;$('#collapsechildsHIVStatus').collapse('show');}else{childenrolledontreatment_chk=1;document.getElementById("childenrolledontreatment_label").innerHTML="";$('#collapsechildsHIVStatus').collapse('hide');}
        if(childenrolledontreatment=="Yes" && childartstartdate==""){document.getElementById("childartstartdate_label").innerHTML="Field is required";childartstartdate_chk=0;$('#collapsechildsHIVStatus').collapse('show');}else{childartstartdate_chk=1;document.getElementById("childartstartdate_label").innerHTML="";$('#collapsechildsHIVStatus').collapse('hide');}
        if(childenrolledontreatment=="Yes" && childfacilityenrolled==""){document.getElementById("childfacilityenrolled_label").innerHTML="Field is required";childfacilityenrolled_chk=0;$('#collapsechildsHIVStatus').collapse('show');}else{childfacilityenrolled_chk=1;document.getElementById("childfacilityenrolled_label").innerHTML="";$('#collapsechildsHIVStatus').collapse('hide');}

        //Check for Validation and Missed Entries
        if(enrollment_date==""){document.getElementById("enrollment_date_label").innerHTML="Field is required";enrollment_date_chk=0;$('#collapsegeneralInformation').collapse('show');}else{enrollment_date_chk=1;document.getElementById("enrollment_date_label").innerHTML="";$('#collapsegeneralInformation').collapse('hide');}
        //if(hh_unique_num==""){document.getElementById("hh_unique_num_label").innerHTML="Field is required";hh_unique_num_chk=0;$('#collapsegeneralInformation').collapse('show');}else{hh_unique_num_chk=1;document.getElementById("hh_unique_num_label").innerHTML="";$('#collapsegeneralInformation').collapse('hide');}
        if(vc_unique_id==""){document.getElementById("vc_unique_id_label").innerHTML="Field is required";vc_unique_id_chk=0;$('#collapsegeneralInformation').collapse('show');}else{vc_unique_id_chk=1;document.getElementById("vc_unique_id_label").innerHTML="";$('#collapsegeneralInformation').collapse('hide');}
        if(surname==""){document.getElementById("surname_label").innerHTML="Field is required";surname_chk=0;$('#collapsegeneralInformation').collapse('show');}else{surname_chk=1;document.getElementById("surname_label").innerHTML="";$('#collapsegeneralInformation').collapse('hide');}
        if(othernames==""){document.getElementById("othernames_label").innerHTML="Field is required";othernames_chk=0;$('#collapsegeneralInformation').collapse('show');}else{othernames_chk=1;document.getElementById("othernames_label").innerHTML="";$('#collapsegeneralInformation').collapse('hide');}
        if(gender=="" || gender == 'Select'){document.getElementById("gender_label").innerHTML="Field is required";gender_chk=0;$('#collapsegeneralInformation').collapse('show');}else{gender_chk=1;document.getElementById("gender_label").innerHTML="";$('#collapsegeneralInformation').collapse('hide');}
        if(dob==""){document.getElementById("dob_label").innerHTML="Field is required";dob_chk=0;$('#collapsegeneralInformation').collapse('show');}else{dob_chk=1;document.getElementById("dob_label").innerHTML="";$('#collapsegeneralInformation').collapse('hide');}
        if(enrollmentstream==""){document.getElementById("enrollmentstream_label").innerHTML="Field is required";enrollmentstream_chk=0;$('#collapseenrollmentStreams').collapse('show');}else{enrollmentstream_chk=1;document.getElementById("enrollmentstream_label").innerHTML="";$('#collapseenrollmentStreams').collapse('hide');}
        if(enrollmentstreambasedon==""){document.getElementById("enrollmentstreambasedon_label").innerHTML="Field is required";enrollmentstreambasedon_chk=0;$('#collapseenrollmentStreams').collapse('show');}else{enrollmentstreambasedon_chk=1;document.getElementById("enrollmentstreambasedon_label").innerHTML="";$('#collapseenrollmentStreams').collapse('hide');}
//        if(hiv_status=="" || hiv_status=="Select"){document.getElementById("hiv_status_label").innerHTML="Field is required";hiv_status_chk=0;$('#collapsechildsHIVStatus').collapse('show');}else{hiv_status_chk=1;document.getElementById("hiv_status_label").innerHTML="";$('#collapsechildsHIVStatus').collapse('hide');}
        if(birthcertificate=="" || birthcertificate=="Response"){document.getElementById("birthcertificate_label").innerHTML="Field is required";birthcertificate_chk=0;$('#collapsebirthCertEducation').collapse('show');}else{birthcertificate_chk=1;document.getElementById("birthcertificate_label").innerHTML="";$('#collapsebirthCertEducation').collapse('hide');}
        if(childinschool=="" || childinschool=="Response"){document.getElementById("childinschool_label").innerHTML="Field is required";childinschool_chk=0;$('#collapsebirthCertEducation').collapse('show');}else{childinschool_chk=1;document.getElementById("childinschool_label").innerHTML="";$('#collapsebirthCertEducation').collapse('hide');}
        if(caregiverrelationshiptochild=="" || caregiverrelationshiptochild=="Select"){document.getElementById("caregiverrelationshiptochild_label").innerHTML="Field is required";caregiverrelationshiptochild_chk=0;$('#collapsecaregiverInformation').collapse('show');}else{caregiverrelationshiptochild_chk=1;document.getElementById("caregiverrelationshiptochild_label").innerHTML="";$('#collapsecaregiverInformation').collapse('hide');}
        if(caregiver=="" || caregiver=="Select"){document.getElementById("caregiver_label").innerHTML="Field is required";caregiver_chk=0;$('#collapsecaregiverInformation').collapse('show');}else{caregiver_chk=1;document.getElementById("caregiver_label").innerHTML="";$('#collapsecaregiverInformation').collapse('hide');}
        //Check for Validation and Missed Entries -- New Columns Addition
        if(childinschool=="Yes" && schoolname=="Response"){document.getElementById("schoolname_label").innerHTML="Field is required";schoolname_chk=0;$('#collapsebirthCertEducation').collapse('show');}else{schoolname_chk=1;document.getElementById("schoolname_label").innerHTML="";$('#collapsebirthCertEducation').collapse('hide');}
        if(childinschool=="Yes" && schoolgrade=="Response"){document.getElementById("schoolgrade_label").innerHTML="Field is required";schoolgrade_chk=0;$('#collapsebirthCertEducation').collapse('show');}else{schoolgrade_chk=1;document.getElementById("schoolgrade_label").innerHTML="";$('#collapsebirthCertEducation').collapse('hide');}
        if(childonvocationaltraining=="" ||  childonvocationaltraining=="Response"){document.getElementById("childonvocationaltraining_label").innerHTML="Field is required";childonvocationaltraining_chk=0;$('#collapsebirthCertEducation').collapse('show');}else{childonvocationaltraining_chk=1;document.getElementById("childonvocationaltraining_label").innerHTML="";$('#collapsebirthCertEducation').collapse('hide');}
        if(childonvocationaltraining=="Yes" &&  vocationalinstitute==""){document.getElementById("vocationalinstitute_label").innerHTML="Field is required";vocationalinstitute_chk=0;$('#collapsebirthCertEducation').collapse('show');}else{vocationalinstitute_chk=1;document.getElementById("vocationalinstitute_label").innerHTML="";$('#collapsebirthCertEducation').collapse('hide');}
//If enrollment stream is CLHIV then Childs HIV status Must be Positive
        if(enrollmentstream.includes("Child living with HIV (CLHIV)") && childhiv_status!='Positive'){
            enrollmentStreamHIVStatusMismatch = 1;
        } 
        else{
            enrollmentStreamHIVStatusMismatch = 0;
        }
        
//Confirm validation and set validation status
    if(
        enrollment_date_chk == 0 ||
        vc_unique_id_chk == 0 ||
        surname_chk == 0 ||
        othernames_chk == 0 ||
        gender_chk == 0 ||
        dob_chk == 0 ||
        enrollmentstream_chk == 0 ||
        enrollmentstreambasedon_chk == 0 ||
        birthcertificate_chk == 0 ||
        childinschool_chk == 0 ||
        caregiverrelationshiptochild_chk == 0 ||
        caregiver_chk == 0 ||
        enrollment_setting_chk == 0 ||
        treatment_art_no_chk == 0 ||
        childhiv_status_chk == 0 ||
        childdatehivstatus_chk == 0 ||
        childenrolledontreatment_chk == 0 ||
        childartstartdate_chk == 0 ||
        childfacilityenrolled_chk == 0||
        schoolname_chk == 0||
        schoolgrade_chk == 0||
        childonvocationaltraining_chk == 0||
        vocationalinstitute_chk == 0
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
    }
    else{
        if(enrollmentStreamHIVStatusMismatch==0){
            createVCEnrollment();        
        }
        else{
            Toastify({
                text: "If enrollment stream is CLHIV then Childs HIV status Must be Positive. Review Recommended",
                style: {
                  background: "linear-gradient(to right, #DC3545, #DC3545)",
                },
                close: true,
                duration: 10000
                }).showToast();	        
        }

    }
}
function createVCEnrollment(){

    $.ajax({
        url: 'db/createVCEnrollment.php',
        type: 'post',
        data: "enrollment_date="+enrollment_date
        +"&hh_unique_num="+hh_unique_num
        +"&vc_unique_id="+vc_unique_id
        +"&vc_count="+vc_count
        +"&surname="+surname
        +"&othernames="+othernames
        +"&gender="+gender
        +"&dob="+dob
        +"&enrollmentstream="+enrollmentstream
        +"&enrollmentstreambasedon="+enrollmentstreambasedon
        +"&hiv_status="+childhiv_status
        +"&birthcertificate="+birthcertificate
        +"&childinschool="+childinschool
        +"&caregiverrelationshiptochild="+caregiverrelationshiptochild
        +"&caregiver="+caregiver
        +"&enrollment_setting="+enrollment_setting
        +"&treatment_art_no="+treatment_art_no
        +"&datehivstatus="+childdatehivstatus
        +"&enrolledontreatment="+childenrolledontreatment
        +"&artstartdate="+childartstartdate
        +"&facilityenrolled="+childfacilityenrolled
        +"&schoolname="+schoolname
        +"&schoolgrade="+schoolgrade
        +"&childonvocationaltraining="+childonvocationaltraining
        +"&vocationalinstitute="+vocationalinstitute
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Vulnerable Child Added to Household",
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
                    text: "Error: Vulnerable Child NOT created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "VC already exists, Please review",
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

function createNewVCId(householdUniqueId){

    $.ajax({
        url: 'db/createNewVCId.php',
        type: 'post',
        data: "householdUniqueId="+householdUniqueId,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "VC Form Loaded Successfully",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();
                vc_id = response.vc_id;
                vc_count = response.vc_id;
                vc_id_len = vc_id.toString().length;
                for(let i=vc_id_len; i<5; i++){
                    new_vc_id = 0+vc_id.toString();
                    vc_id = new_vc_id;
                }
                document.getElementById("vc_unique_id").value = householdUniqueId+'/'+vc_id;

            }
            else if(response.status=="no_rows"){
                Toastify({
                    text: "This HouseHolde Does not Exist",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="vc_maxed_out"){
                Toastify({
                    text: "All VC within this household has been created",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
                document.getElementById("enrollment_date").value="";
            }
            },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown+XMLHttpRequest); 
    }  	
  })
}
function submitOfferForm(ev){
        ev.preventDefault();
        console.log('Click');
    treatment_art_no_offer = document.getElementById("treatment_art_no_offer").value;
    artstartdate_offer = document.getElementById("artstartdate_offer").value;
    clientname = document.getElementById("clientname").value;
    facilityname = document.getElementById("facilityname").value;
    consentQuestion1 = document.getElementById("consentQuestion1Offer").innerText;
    responseQuestion1 = document.getElementById("responseQuestion1Offer").value;
    consentQuestion2 = document.getElementById("consentQuestion2Offer").innerText;
    responseQuestion2 = document.getElementById("responseQuestion2Offer").value;
    phonenumberOfferForm = document.getElementById("phonenumberOfferForm").value;
    caregiver_name = document.getElementById("caregiver_name").value;
    caregiver_signature = document.getElementById("caregiver_signatureOffer").value;
    caregiver_date = document.getElementById("caregiver_date").value;
    facility_staff_name = document.getElementById("facility_staff_name").value;
    facility_staff_signature = document.getElementById("facility_staff_signature").value;
    facility_staff_date = document.getElementById("facility_staff_date").value;
    lgaofresidence = document.getElementById("lgaofresidence").value;
    stateofresidence = document.getElementById("stateofresidence").value;
    
    //Create Form ID to be used to reset form elements
    entryOfferForm = document.getElementById("entryOfferForm");
    
        //Check for Validation and Missed Entries for HOUSEHOLD DETAILS Panel
        if(treatment_art_no_offer==""){document.getElementById("treatment_art_no_offer_label").innerHTML="Field is required";treatment_art_no_offer_chk=0;$('#collapseartDetails').collapse('show');}else{treatment_art_no_offer_chk=1;document.getElementById("treatment_art_no_offer_label").innerHTML="";$('#treatment_art_no').collapse('hide');}
        if(artstartdate_offer==""){document.getElementById("artstartdate_offer_label").innerHTML="Field is required";artstartdate_offer_chk=0;$('#collapseartDetails').collapse('show');}else{artstartdate_offer_chk=1;document.getElementById("artstartdate_offer_label").innerHTML="";$('#collapseartDetails').collapse('hide');}
        if(clientname==""){document.getElementById("clientname_label").innerHTML="Field is required";clientname_chk=0;$('#collapseartDetails').collapse('show');}else{clientname_chk=1;document.getElementById("clientname_label").innerHTML="";$('#collapseartDetails').collapse('hide');}
        if(facilityname==""){document.getElementById("facilityname_label").innerHTML="Field is required";facilityname_chk=0;$('#collapseartDetails').collapse('show');}else{facilityname_chk=1;document.getElementById("facilityname_label").innerHTML="";$('#collapseartDetails').collapse('hide');}
        if(stateofresidence=="" || stateofresidence=="Select State"){document.getElementById("stateofresidence_label").innerHTML="Field is required";stateofresidence_chk=0;$('#collapseartDetails').collapse('show');}else{stateofresidence_chk=1;document.getElementById("stateofresidence_label").innerHTML="";$('#collapseartDetails').collapse('hide');}
        if(lgaofresidence=="" || lgaofresidence=="Select LGA" ){document.getElementById("lgaofresidence_label").innerHTML="Field is required";lgaofresidence_chk=0;$('#collapseartDetails').collapse('show');}else{lgaofresidence_chk=1;document.getElementById("lgaofresidence_label").innerHTML="";$('#collapseartDetails').collapse('hide');}

        if(responseQuestion1=="" || responseQuestion1 == 'Response'){document.getElementById("responseQuestion1_label").innerHTML="Field is required";responseQuestion1_chk=0;$('#collapseconsentConditions').collapse('show');}else{responseQuestion1_chk=1;document.getElementById("responseQuestion1_label").innerHTML="";$('#collapseconsentConditions').collapse('hide');}
        if(responseQuestion1=="No" && responseQuestion2 == 'Response'){document.getElementById("responseQuestion2_label").innerHTML="Field is required";responseQuestion2_chk=0;$('#collapseconsentConditions').collapse('show');}else{responseQuestion2_chk=1;document.getElementById("responseQuestion2_label").innerHTML="";$('#collapseconsentConditions').collapse('hide');}
        if(responseQuestion2=="Yes" && phonenumberOfferForm==""){document.getElementById("phonenumberOfferForm_label").innerHTML="Field is required";phonenumberOfferForm_chk=0;$('#collapseconsentConditions').collapse('show');}else{phonenumberOfferForm_chk=1;document.getElementById("phonenumberOfferForm_label").innerHTML="";$('#collapseconsentConditions').collapse('hide');}

        if(caregiver_name==""){document.getElementById("caregiver_name_label").innerHTML="Field is required";caregiver_name_chk=0;$('#collapseconsentSignature').collapse('show');}else{caregiver_name_chk=1;document.getElementById("caregiver_name_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(caregiver_signature==""){document.getElementById("caregiver_signatureOffer_label").innerHTML="Field is required";caregiver_signature_chk=0;$('#collapseconsentSignature').collapse('show');}else{caregiver_signature_chk=1;document.getElementById("caregiver_signatureOffer_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(caregiver_date==""){document.getElementById("caregiver_date_label").innerHTML="Field is required";caregiver_date_chk=0;$('#collapseconsentSignature').collapse('show');}else{caregiver_date_chk=1;document.getElementById("caregiver_date_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(facility_staff_name==""){document.getElementById("facility_staff_name_label").innerHTML="Field is required";facility_staff_name_chk=0;$('#collapseconsentSignature').collapse('show');}else{facility_staff_name_chk=1;document.getElementById("facility_staff_name_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(facility_staff_signature==""){document.getElementById("facility_staff_signature_label").innerHTML="Field is required";facility_staff_signature_chk=0;$('#collapseconsentSignature').collapse('show');}else{facility_staff_signature_chk=1;document.getElementById("facility_staff_signature_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
        if(facility_staff_date==""){document.getElementById("facility_staff_date_label").innerHTML="Field is required";facility_staff_date_chk=0;$('#collapseconsentSignature').collapse('show');}else{facility_staff_date_chk=1;document.getElementById("facility_staff_date_label").innerHTML="";$('#collapseconsentSignature').collapse('hide');}
    
//Confirm validation and set validation status
    if(treatment_art_no_offer_chk == 0 || artstartdate_offer == 0 || clientname_chk == 0 || facilityname_chk == 0 || responseQuestion1_chk == 0 || responseQuestion2_chk == 0
         || phonenumberOfferForm_chk == 0 || caregiver_name_chk == 0 || caregiver_signature_chk == 0 || caregiver_date_chk == 0 || facility_staff_name_chk == 0
        || facility_staff_signature_chk == 0 || facility_staff_date_chk == 0 || stateofresidence_chk == 0 || lgaofresidence_chk == 0){
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
        createOfferRecord();
    }    

}
    
    
function createOfferRecord(){
    $.ajax({
        url: 'db/createOfferRecord.php',
        type: 'post',
        data: "treatment_art_no="+treatment_art_no_offer+"&artstartdate="+artstartdate_offer+"&clientname="+clientname+"&facilityname="+facilityname+"&consentQuestion1="+consentQuestion1+"&responseQuestion1="+responseQuestion1+"&consentQuestion2="+consentQuestion2+"&responseQuestion2="+responseQuestion2+"&phonenumberOfferForm="+phonenumberOfferForm
        +"&caregiver_name="+caregiver_name+"&caregiver_signature="+caregiver_signature+"&caregiver_date="+caregiver_date+"&facility_staff_name="+facility_staff_name+"&facility_staff_signature="+facility_staff_signature
        +"&facility_staff_date="+facility_staff_date
        +"&lgaofresidence="+lgaofresidence
        +"&stateofresidence="+stateofresidence
        ,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Offer Form Created. Continue with VC Enrollment Form",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();
                entryOfferForm.reset();
                $('#newOfferFormModal').modal('hide');
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Offer Form Not Created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Error: Treament ID already exists, Please review",
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
function launchOfferModal(){
    
}

function getCaregiverDetails(caregiver){
        $.ajax({
            url: 'db/getCaregiverDetails.php',
            type: 'post', 
            dataType: 'json',
            data: "caregiverid="+caregiver,
            success: function(response){ 
            if(response.status=="success"){
                document.getElementById("unique_id_for_ef").innerText = response.unique_id;
                document.getElementById("record_id_ef").innerText = response.id;
            }
            else{
                
            }
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
    beneficiaryid = document.getElementById("beneficiary_id_for_ef").innerText;
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
        +"&unique_id="+beneficiaryid
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
               document.getElementById("entryFormEmergencyFund").reset();
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
function closeModalButtonEmergencyFundChkList(){
    $('#newaccessToEmergencyFundForm').modal('hide');
}
function closeModalReferral(){
    $('#newreferralForm').modal('hide');
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
    beneficiaryid = document.getElementById("beneficiaryid_for_rf").innerText;

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
        data: "referring_organization="+referring_organization+"&receiving_organization="+receiving_organization+"&reservicereferred="+reservicereferred+"&organization_providingreferral="+organization_providingreferral+"&service_provided="+input_service_provided+"&service_completed="+input_service_completed+"&followup_needed="+input_followup_needed+"&followup_date="+input_followup_date+"&referral_status="+referral_status+"&referral_receiver="+referral_receiver+"&referral_receiver_designation="+referral_receiver_designation+"&referral_receiver_phonenumber="+referral_receiver_phonenumber+"&vc_unique_id="+beneficiaryid+"&hh_unique_num="+hh_unique_num+"&referral_receiver_email="+referral_receiver_email+"&referral_date="+referral_date,  
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
            else{
                Toastify({
                    text: "DB-Error: "+response.status,
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
