document.addEventListener('DOMContentLoaded', init);

function init(){
    

//Controls for Section A - ART
document.getElementById("csresponseQuestion1").addEventListener('change',function(ev){
    response1 = ev.target.value;
    if(response1=='Yes'){
        document.getElementById("artfacility").disabled = false;
        document.getElementById("lastdrugpickupdate").disabled = false;
        document.getElementById("currentregimen").disabled = false;
        document.getElementById("refillduration").disabled = false;
        document.getElementById("nextappointmentdate").disabled = false;
        document.getElementById("csresponseQuestion2").disabled = false;
        document.getElementById("missedarvreason").disabled = false;
        document.getElementById("csresponseQuestion3").disabled = false;
        document.getElementById("csresponseQuestion4").disabled = false;
    }
    else{
        document.getElementById("artfacility").selectedIndex = 0;
        document.getElementById("artfacility").disabled = true;
        document.getElementById("lastdrugpickupdate").value = '';
        document.getElementById("lastdrugpickupdate").disabled = true;
        document.getElementById("currentregimen").selectedIndex = 0;
        document.getElementById("currentregimen").disabled = true;
        document.getElementById("refillduration").selectedIndex = 0;
        document.getElementById("refillduration").disabled = true;
        document.getElementById("nextappointmentdate").value = '';
        document.getElementById("nextappointmentdate").disabled = true;
        document.getElementById("csresponseQuestion2").selectedIndex = 0;
        document.getElementById("csresponseQuestion2").disabled = true;
        document.getElementById("missedarvreason").value = '';
        document.getElementById("missedarvreason").selectedIndex = -1;
        document.getElementById("missedarvreason").disabled = true;
        document.getElementById("csresponseQuestion3").selectedIndex = 0;
        document.getElementById("csresponseQuestion3").disabled = true;
        document.getElementById("csresponseQuestion4").selectedIndex = 0;
        document.getElementById("csresponseQuestion4").disabled = true;
    }
}, false)
document.getElementById("csresponseQuestion2").addEventListener('change',function(ev){
    response2 = ev.target.value;
    if(response2=='No'){
        document.getElementById("missedarvreason").value = '';
        document.getElementById("missedarvreason").selectedIndex = -1;
        document.getElementById("missedarvreason").disabled = true;
        //document.getElementById("csresponseQuestion3").selectedIndex = 0;
        //document.getElementById("csresponseQuestion3").disabled = true;
        //document.getElementById("csresponseQuestion4").selectedIndex = 0;
        //document.getElementById("csresponseQuestion4").disabled = true;
    }
    else{
        document.getElementById("missedarvreason").disabled = false;
        //document.getElementById("csresponseQuestion3").disabled = false;
        //document.getElementById("csresponseQuestion4").disabled = false;
    }
},false)

document.getElementById("csresponseQuestion5").addEventListener('change',function(ev){
    response5 = ev.target.value;
    if(response5=='No'){
        document.getElementById("lastviralloadsampledate").value = '';
        document.getElementById("lastviralloadsampledate").disabled = true;
        document.getElementById("csresponseQuestion6").selectedIndex = 0;
        document.getElementById("csresponseQuestion6").disabled = true;
        document.getElementById("viralloadtestresult").value = '';
        document.getElementById("viralloadtestresult").disabled = true;
        document.getElementById("viralloadtestresultdate").value = '';
        document.getElementById("viralloadtestresultdate").disabled = true;
    }
    else{
        document.getElementById("lastviralloadsampledate").disabled = false;
        document.getElementById("csresponseQuestion6").disabled = false;
        document.getElementById("viralloadtestresult").disabled = false;
        document.getElementById("viralloadtestresultdate").disabled = false;
    }
}, false)
document.getElementById("csresponseQuestion6").addEventListener('change',function(ev){
    response6 = ev.target.value;
    if(response6=='No'){
        document.getElementById("viralloadtestresult").value = '';
        document.getElementById("viralloadtestresult").disabled = true;
        document.getElementById("viralloadtestresultdate").value = '';
        document.getElementById("viralloadtestresultdate").disabled = true;
    }
    else{
        document.getElementById("viralloadtestresult").disabled = false;
        document.getElementById("viralloadtestresultdate").disabled = false;
    }
}, false)
document.getElementById("csresponseQuestion8").addEventListener('change',function(ev){
    response8 = ev.target.value;
    if(response8=='No'){
        document.getElementById("csresponseQuestion9").disabled = false;
        document.getElementById("viralloadresultaftereac").disabled = false;
    }
    else{
        document.getElementById("csresponseQuestion9").selectedIndex = 0;
        document.getElementById("csresponseQuestion9").disabled = true;
        document.getElementById("viralloadresultaftereac").value = '';
        document.getElementById("viralloadresultaftereac").disabled = true;
    }
}, false)
document.getElementById("csresponseQuestion9").addEventListener('change',function(ev){
    response9 = ev.target.value;
    if(response9=='Yes'){
        document.getElementById("viralloadresultaftereac").disabled = false;
    }
    else{
        document.getElementById("viralloadresultaftereac").value = '';
        document.getElementById("viralloadresultaftereac").disabled = true;
    }
}, false)
document.getElementById("csresponseQuestion15").addEventListener('change',function(ev){
    response15 = ev.target.value;
    if(response15=='Yes'){
        document.getElementById("tbreferraldate").disabled = false;
    }
    else{
        document.getElementById("tbreferraldate").value = '';
        document.getElementById("tbreferraldate").disabled = true;
    }
}, false)
//Button click event to submitCareSupportChecklistForm 
    document.getElementById("submitCareSupportChecklistForm").addEventListener('click', submitCareSupportChecklistForm, false);
}

function submitCareSupportChecklistForm(ev){
    ev.preventDefault();

    question1 = document.getElementById("csquestion1").innerText;
    responseQuestion1 = document.getElementById("csresponseQuestion1").value;
    artfacility = document.getElementById("artfacility").value;
    lastdrugpickupdate = document.getElementById("lastdrugpickupdate").value;
    currentregimen = document.getElementById("currentregimen").value;
    refillduration = document.getElementById("refillduration").value;
    nextappointmentdate = document.getElementById("nextappointmentdate").value;
    question2 = document.getElementById("csquestion2").innerText;
    responseQuestion2 = document.getElementById("csresponseQuestion2").value;
    missedarvreason = document.getElementById("missedarvreason").value;
    question3 = document.getElementById("csquestion3").innerText;
    responseQuestion3 = document.getElementById("csresponseQuestion3").value;
    question4 = document.getElementById("csquestion4").innerText;
    responseQuestion4 = document.getElementById("csresponseQuestion4").value;
    question5 = document.getElementById("csquestion5").innerText;
    responseQuestion5 = document.getElementById("csresponseQuestion5").value;
    lastviralloadsampledate = document.getElementById("lastviralloadsampledate").value;
    question6 = document.getElementById("csquestion6").innerText;
    responseQuestion6 = document.getElementById("csresponseQuestion6").value;
    viralloadtestresult = document.getElementById("viralloadtestresult").value;
    viralloadtestresultdate = document.getElementById("viralloadtestresultdate").value;
    whyviralloadnotdone = document.getElementById("whyviralloadnotdone").value;
    question7 = document.getElementById("csquestion7").innerText;
    responseQuestion7 = document.getElementById("csresponseQuestion7").value;
    question8 = document.getElementById("csquestion8").innerText;
    responseQuestion8 = document.getElementById("csresponseQuestion8").value;
    question9 = document.getElementById("csquestion9").innerText;
    responseQuestion9 = document.getElementById("csresponseQuestion9").value;
    viralloadresultaftereac = document.getElementById("viralloadresultaftereac").value;
    question10 = document.getElementById("csquestion10").innerText;
    responseQuestion10 = document.getElementById("csresponseQuestion10").value;
    question11 = document.getElementById("csquestion11").innerText;
    responseQuestion11 = document.getElementById("csresponseQuestion11").value;
    question12 = document.getElementById("csquestion12").innerText;
    responseQuestion12 = document.getElementById("csresponseQuestion12").value;
    question13 = document.getElementById("csquestion13").innerText;
    responseQuestion13 = document.getElementById("csresponseQuestion13").value;
    question14 = document.getElementById("csquestion14").innerText;
    responseQuestion14 = document.getElementById("csresponseQuestion14").value;
    question15 = document.getElementById("csquestion15").innerText;
    responseQuestion15 = document.getElementById("csresponseQuestion15").value;
    tbreferraldate = document.getElementById("tbreferraldate").value;
    serviceprovidername = document.getElementById("serviceprovidername").value;
    serviceproviderdesignation = document.getElementById("serviceproviderdesignation").value;
    serviceproviderphone = document.getElementById("serviceproviderphone").value;
    datesigned = document.getElementById("datesigned").value;

console.log("VC Unique ID: "+vcUniqueId);
            //Check for Validation and Missed Entries
            if(responseQuestion1=="Response"){document.getElementById("csresponseQuestion1_label").innerHTML="Field is required";csresponseQuestion1_chk=0;$('#collapsesectionA').collapse('show');}else{csresponseQuestion1_chk=1;document.getElementById("csresponseQuestion1_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion1=="Yes" && (artfacility=="" || lastdrugpickupdate=="" || currentregimen=="Response" || nextappointmentdate=="" || refillduration=="Response")){document.getElementById("csresponseQuestion1_label").innerHTML="Check for concurrency from corresponding fields";csresponseQuestion1_chk=0;$('#collapsesectionA').collapse('show');}else{csresponseQuestion1_chk=1;document.getElementById("csresponseQuestion1_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion1=="Yes" && (lastdrugpickupdate=="")){document.getElementById("lastdrugpickupdate_label").innerHTML="Field is required";lastdrugpickupdate_chk=0;$('#collapsesectionA').collapse('show');}else{lastdrugpickupdate_chk=1;document.getElementById("lastdrugpickupdate_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion1=="Yes" && (currentregimen=="Response")){document.getElementById("currentregimen_label").innerHTML="Field is required";currentregimen_chk=0;$('#collapsesectionA').collapse('show');}else{currentregimen_chk=1;document.getElementById("currentregimen_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion1=="Yes" && (nextappointmentdate=="")){document.getElementById("nextappointmentdate_label").innerHTML="Field is required";nextappointmentdate_chk=0;$('#collapsesectionA').collapse('show');}else{nextappointmentdate_chk=1;document.getElementById("nextappointmentdate_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion1=="Yes" && (refillduration=="Response")){document.getElementById("refillduration_label").innerHTML="Field is required";refillduration_chk=0;$('#collapsesectionA').collapse('show');}else{refillduration_chk=1;document.getElementById("refillduration_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion1=="Yes" && (artfacility=="Response")){document.getElementById("artfacility_label").innerHTML="Field is required";artfacility_chk=0;$('#collapsesectionA').collapse('show');}else{artfacility_chk=1;document.getElementById("artfacility_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion1=="Yes" && (responseQuestion2=="Response")){document.getElementById("csresponseQuestion2_label").innerHTML="Field is required";csresponseQuestion2_chk=0;$('#collapsesectionA').collapse('show');}else{csresponseQuestion2_chk=1;document.getElementById("csresponseQuestion2_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion2=="Yes" && missedarvreason==""){document.getElementById("missedarvreason_label").innerHTML="Field is required";missedarvreason_chk=0;$('#collapsesectionA').collapse('show');}else{missedarvreason_chk=1;document.getElementById("missedarvreason_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion3=="Response"){document.getElementById("csresponseQuestion3_label").innerHTML="Field is required";csresponseQuestion3_chk=0;$('#collapsesectionA').collapse('show');}else{csresponseQuestion3_chk=1;document.getElementById("csresponseQuestion3_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion4=="Response"){document.getElementById("csresponseQuestion4_label").innerHTML="Field is required";csresponseQuestion4_chk=0;$('#collapsesectionA').collapse('show');}else{csresponseQuestion4_chk=1;document.getElementById("csresponseQuestion4_label").innerHTML="";$('#collapsesectionA').collapse('hide');}
            if(responseQuestion1=="Yes" && responseQuestion5=="Response"){document.getElementById("csresponseQuestion5_label").innerHTML="Field is required";csresponseQuestion5_chk=0;$('#collapsesectionB').collapse('show');}else{csresponseQuestion5_chk=1;document.getElementById("csresponseQuestion5_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion5=="Yes" && lastviralloadsampledate==""){document.getElementById("lastviralloadsampledate_label").innerHTML="Field is required";lastviralloadsampledate_chk=0;$('#collapsesectionB').collapse('show');}else{lastviralloadsampledate_chk=1;document.getElementById("lastviralloadsampledate_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion5=="Yes" && responseQuestion6=="Response"){document.getElementById("csresponseQuestion6_label").innerHTML="Field is required";csresponseQuestion6_chk=0;$('#collapsesectionB').collapse('show');}else{csresponseQuestion6_chk=1;document.getElementById("csresponseQuestion6_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion6=="Yes" && viralloadtestresult==""){document.getElementById("viralloadtestresult_label").innerHTML="Field is required";viralloadtestresult_chk=0;$('#collapsesectionB').collapse('show');}else{viralloadtestresult_chk=1;document.getElementById("viralloadtestresult_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion6=="Yes" && viralloadtestresultdate==""){document.getElementById("viralloadtestresultdate_label").innerHTML="Field is required";viralloadtestresultdate_chk=0;$('#collapsesectionB').collapse('show');}else{viralloadtestresultdate_chk=1;document.getElementById("viralloadtestresultdate_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion6=="No" && whyviralloadnotdone==""){document.getElementById("whyviralloadnotdone_label").innerHTML="Field is required";whyviralloadnotdone_chk=0;$('#collapsesectionB').collapse('show');}else{whyviralloadnotdone_chk=1;document.getElementById("whyviralloadnotdone_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion7=="Response"){document.getElementById("csresponseQuestion7_label").innerHTML="Field is required";csresponseQuestion7_chk=0;$('#collapsesectionB').collapse('show');}else{csresponseQuestion7_chk=1;document.getElementById("csresponseQuestion7_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion5=="Yes" && responseQuestion8=="Response"){document.getElementById("csresponseQuestion8_label").innerHTML="Field is required";csresponseQuestion8_chk=0;$('#collapsesectionB').collapse('show');}else{csresponseQuestion8_chk=1;document.getElementById("csresponseQuestion8_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion8=="No" && responseQuestion9=="Response"){document.getElementById("csresponseQuestion9_label").innerHTML="Field is required";csresponseQuestion9_chk=0;$('#collapsesectionB').collapse('show');}else{csresponseQuestion9_chk=1;document.getElementById("csresponseQuestion9_label").innerHTML="";$('#collapsesectionB').collapse('hide');}
            if(responseQuestion9=="Yes" && viralloadresultaftereac==""){document.getElementById("viralloadresultaftereac_label").innerHTML="Field is required";viralloadresultaftereac_chk=0;$('#collapsesectionB').collapse('show');}else{viralloadresultaftereac_chk=1;document.getElementById("viralloadresultaftereac_label").innerHTML="";$('#collapsesectionB').collapse('hide');}

            if(responseQuestion10=="Response"){document.getElementById("csresponseQuestion10_label").innerHTML="Field is required";csresponseQuestion10_chk=0;$('#collapsesectionC').collapse('show');}else{csresponseQuestion10_chk=1;document.getElementById("csresponseQuestion10_label").innerHTML="";$('#collapsesectionC').collapse('hide');}
            if(responseQuestion11=="Response"){document.getElementById("csresponseQuestion11_label").innerHTML="Field is required";csresponseQuestion11_chk=0;$('#collapsesectionC').collapse('show');}else{csresponseQuestion11_chk=1;document.getElementById("csresponseQuestion11_label").innerHTML="";$('#collapsesectionC').collapse('hide');}
            if(responseQuestion12=="Response"){document.getElementById("csresponseQuestion12_label").innerHTML="Field is required";csresponseQuestion12_chk=0;$('#collapsesectionC').collapse('show');}else{csresponseQuestion12_chk=1;document.getElementById("csresponseQuestion12_label").innerHTML="";$('#collapsesectionC').collapse('hide');}
            if(responseQuestion13=="Response"){document.getElementById("csresponseQuestion13_label").innerHTML="Field is required";csresponseQuestion13_chk=0;$('#collapsesectionC').collapse('show');}else{csresponseQuestion13_chk=1;document.getElementById("csresponseQuestion13_label").innerHTML="";$('#collapsesectionC').collapse('hide');}
            if(responseQuestion14=="Response"){document.getElementById("csresponseQuestion14_label").innerHTML="Field is required";csresponseQuestion14_chk=0;$('#collapsesectionC').collapse('show');}else{csresponseQuestion14_chk=1;document.getElementById("csresponseQuestion14_label").innerHTML="";$('#collapsesectionC').collapse('hide');}
            if(responseQuestion15=="Response"){document.getElementById("csresponseQuestion15_label").innerHTML="Field is required";csresponseQuestion15_chk=0;$('#collapsesectionC').collapse('show');}else{csresponseQuestion15_chk=1;document.getElementById("csresponseQuestion15_label").innerHTML="";$('#collapsesectionC').collapse('hide');}
            if(responseQuestion15=="Yes" && tbreferraldate==""){document.getElementById("tbreferraldate_label").innerHTML="Field is required";tbreferraldate_chk=0;$('#collapsesectionC').collapse('show');}else{tbreferraldate_chk=1;document.getElementById("tbreferraldate_label").innerHTML="";$('#collapsesectionC').collapse('hide');}
            if(serviceprovidername==""){document.getElementById("serviceprovidername_label").innerHTML="Field is required";serviceprovidername_chk=0;$('#collapseServiceProviderSection').collapse('show');}else{serviceprovidername_chk=1;document.getElementById("serviceprovidername_label").innerHTML="";$('#collapseServiceProviderSection').collapse('hide');}
            if(serviceproviderdesignation==""){document.getElementById("serviceproviderdesignation_label").innerHTML="Field is required";serviceproviderdesignation_chk=0;$('#collapseServiceProviderSection').collapse('show');}else{serviceproviderdesignation_chk=1;document.getElementById("serviceproviderdesignation_label").innerHTML="";$('#collapseServiceProviderSection').collapse('hide');}
            if(serviceproviderphone==""){document.getElementById("serviceproviderphone_label").innerHTML="Field is required";serviceproviderphone_chk=0;$('#collapseServiceProviderSection').collapse('show');}else{serviceproviderphone_chk=1;document.getElementById("serviceproviderphone_label").innerHTML="";$('#collapseServiceProviderSection').collapse('hide');}
            if(datesigned==""){document.getElementById("datesigned_label").innerHTML="Field is required";datesigned_chk=0;$('#collapseServiceProviderSection').collapse('show');}else{datesigned_chk=1;document.getElementById("datesigned_label").innerHTML="";$('#collapseServiceProviderSection').collapse('hide');}

//Confirm validation and set validation status
    if(csresponseQuestion1_chk == 0 || 
        lastdrugpickupdate_chk == 0 || 
        currentregimen_chk == 0 || 
        nextappointmentdate_chk == 0 || 
        refillduration_chk == 0 || 
        artfacility_chk == 0 || 
        csresponseQuestion2_chk == 0 || 
        missedarvreason_chk == 0 || 
        csresponseQuestion3_chk == 0 || 
        csresponseQuestion4_chk == 0 || 
        csresponseQuestion5_chk == 0 || 
        lastviralloadsampledate_chk == 0 || 
        csresponseQuestion6_chk == 0 || 
        viralloadtestresult_chk == 0 || 
        viralloadtestresultdate_chk == 0 || 
        whyviralloadnotdone_chk == 0 || 
        csresponseQuestion7_chk == 0 || 
        csresponseQuestion8_chk == 0 || 
        csresponseQuestion9_chk == 0 || 
        viralloadresultaftereac_chk == 0 || 
        csresponseQuestion10_chk == 0 || 
        csresponseQuestion11_chk == 0 || 
        csresponseQuestion12_chk == 0 || 
        csresponseQuestion13_chk == 0 || 
        csresponseQuestion14_chk == 0 || 
        csresponseQuestion15_chk == 0 || 
        tbreferraldate_chk == 0 || 
        serviceprovidername_chk == 0 || 
        serviceproviderdesignation_chk == 0 || 
        serviceproviderphone_chk == 0 || 
        datesigned_chk == 0){
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
        createCareSupportChecklistRecord();
    }


    
}


function createCareSupportChecklistRecord(){

    $.ajax({
        url: 'db/createCareSupportChecklistRecord.php',
        type: 'post',
        data: "question1="+question1
        +"&responseQuestion1="+responseQuestion1
        +"&artfacility="+artfacility
        +"&lastdrugpickupdate="+lastdrugpickupdate
        +"&currentregimen="+currentregimen
        +"&refillduration="+refillduration
        +"&nextappointmentdate="+nextappointmentdate
        +"&question2="+question2
        +"&responseQuestion2="+responseQuestion2
        +"&missedarvreason="+missedarvreason
        +"&question3="+question3
        +"&responseQuestion3="+responseQuestion3
        +"&question4="+question4
        +"&responseQuestion4="+responseQuestion4
        +"&question5="+question5
        +"&responseQuestion5="+responseQuestion5
        +"&lastviralloadsampledate="+lastviralloadsampledate
        +"&question6="+question6
        +"&responseQuestion6="+responseQuestion6
        +"&viralloadtestresult="+viralloadtestresult
        +"&viralloadtestresultdate="+viralloadtestresultdate
        +"&whyviralloadnotdone="+whyviralloadnotdone
        +"&question7="+question7
        +"&responseQuestion7="+responseQuestion7
        +"&question8="+question8
        +"&responseQuestion8="+responseQuestion8
        +"&question9="+question9
        +"&responseQuestion9="+responseQuestion9
        +"&viralloadresultaftereac="+viralloadresultaftereac
        +"&question10="+question10
        +"&responseQuestion10="+responseQuestion10
        +"&question11="+question11
        +"&responseQuestion11="+responseQuestion11
        +"&question12="+question12
        +"&responseQuestion12="+responseQuestion12
        +"&question13="+question13
        +"&responseQuestion13="+responseQuestion13
        +"&question14="+question14
        +"&responseQuestion14="+responseQuestion14
        +"&question15="+question15
        +"&responseQuestion15="+responseQuestion15
        +"&tbreferraldate="+tbreferraldate
        +"&hh_unique_num="+hh_unique_num
        +"&vc_unique_id="+vcUniqueId
        +"&serviceprovidername="+serviceprovidername
        +"&serviceproviderdesignation="+serviceproviderdesignation
        +"&serviceproviderphone="+serviceproviderphone
        +"&datesigned="+datesigned,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Care & Support Checklist Created",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();

                //re-initialize table
               document.getElementById("entrycandsChecklistForm").reset();
               var careAndSupportTable = $('#careAndSupportTable').DataTable();
               careAndSupportTable.ajax.reload();
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "Error: Care & Support Checklist NOT created, Review Entry",
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
            else{
                Toastify({
                    text: response.status,
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













