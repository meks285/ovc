document.addEventListener('DOMContentLoaded', init);
function init(){

    services = []
    document.querySelector('#services_table').onclick = function(ev) {
        if(ev.target.value && ev.target.checked == true) {
            services.push(ev.target.value);
        }
        else if(ev.target.value && ev.target.checked == false){
            const index = services.indexOf(ev.target.value);
            services.splice(index,1);
        }
        console.log(services)
      }

      document.getElementById("submitVCServicesForm").addEventListener('click', validateServiceBreakdown, false);

}

function validateServiceBreakdown(){
    var service_date = document.getElementById("service_date").value;
    var vc_unique_id = document.getElementById("vc_unique_id_for_service").innerText;
    var checked_services = []
    $("input[name='availableservices[]']:checked").each(function ()
    {
        checked_services.push($(this).val());
    });
    availableservices = checked_services.toString();


        //Check for Validation and Missed Entries
        if(service_date==""){document.getElementById("service_date_label").innerHTML="Field is required";service_date_chk=0;$('#collapseServiceDate').collapse('show');}else{service_date_chk=1;document.getElementById("vc_unique_id_label").innerHTML="";$('#collapseServiceDate').collapse('hide');}
        //if(vc_unique_id==""){document.getElementById("vc_unique_id_for_service").innerText="Field is required";vc_unique_id_chk=0;$('#collapsegeneralInformation').collapse('show');}else{vc_unique_id_chk=1;document.getElementById("vc_unique_id_for_service").innerText="";$('#collapsegeneralInformation').collapse('hide');}
        if(availableservices==""){document.getElementById("availableservices_label").innerHTML="Table is required";availableservices_chk=0;$('#collapseavailableServices').collapse('show');}else{availableservices_chk=1;document.getElementById("availableservices_label").innerHTML="";$('#collapseavailableServices').collapse('hide');}
   
   
//Confirm validation and set validation status
    if(service_date_chk == 0 || availableservices_chk == 0){
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
        submitVCServicesForm();
    }
}

function submitVCServicesForm(ev){
    //ev.preventDefault();

    let services_length = services.length;
    for(let i = 0; i < services_length; i++){
        if(services[i] == 'Medical Care' || services[i] == 'Re-settlement/Shelter' || services[i] == 'Water, Sanitation/Hygiene' || services[i] == 'Psychosocial Support'){
            domain = 'MIGRATION';
        }  
        else if(services[i] == 'COVID Services' ||services[i] == 'Drugs' ||services[i] == 'Wasting/Edema' ||services[i] == 'Severe Acute Malnutrition (SAM)' ||services[i] == 'Food and Nutrition Supplement' ||services[i] == 'Water Treatment'||services[i] == 'Insecticide Treated Net'||services[i] == 'Adolescent HIV Prevention and SRH Services'||services[i] == 'Growth Monitoring'||services[i] == 'Nutrition Assessment, Counseling and Support (NACS)'||services[i] == 'Food Package(s)/Nutritional Supplement'||services[i] == 'Community TB Symptom Screening'||services[i] == 'Structured PLHA Support Group'||services[i] == 'ART Adherence Support (Including transportation support)'||services[i] == 'Age appropriate HIV treatment literacy (for CLHIV)'||services[i] == 'Age appropriate counselling and HIV Disclosure support'||services[i] == 'HIV services referral - HTS/EID/ART/PMTCT/VL/TB/STIs'||services[i] == 'Community HIV Services - HTS'||services[i] == 'Water, Sanitation and Hygiene Services (WASH) messaging'||services[i] == 'Household health insurance coverage'||services[i] == 'Insecticide Treated Bed Nets'||services[i] == 'Health Education'){
            domain = 'HEALTHY';
        }           
        else if(services[i] == 'Safe shelter-related repair or construction' ||services[i] == 'Short term emergency cash support' ||services[i] == 'Savings group (SILC, VLSA etc)' ||services[i] == 'Cash transfer scheme' ||services[i] == 'Agricultural inputs/value chain' ||services[i] == 'Vocational/Apprenticeship training' ||services[i] == 'Access to Microfinance' ||services[i] == 'Financial Education'){
            domain = 'STABLE';
        }           
        else if(services[i] == 'School Performance Assessment' ||services[i] == 'Assistance/Support with Homework' ||services[i] == 'Provision of school materials/uniform' ||services[i] == 'Waiver of school fees'){
            domain = 'SCHOOLED';
        }   
        else if(services[i] == 'Participated in evidence-based intervention on preventing HIV and sexual violence' ||services[i] == 'Child abuse case report to police/local authority' ||services[i] == 'Post GBV Care' ||services[i] == 'Birth registration' ||services[i] == 'Succession plan' ||services[i] == 'Legal services (eg. received for GBV, Trafficking, exploitation, maltreatment)' ||services[i] == 'Life skills support' ||services[i] == 'Structured safe spaces intervention' ||services[i] == 'Recreational activity (e.g., kids and youth clubs)' ||services[i] == 'Post-violence trauma counselling from a trained provider' ||services[i] == 'Emergency shelter/care facility' ||services[i] == 'Clothing support' ||services[i] == 'Structured PSS related to family conflict mitigation'){
            domain = 'SAFE';
        }   
        service_single = services[i];
        vc_unique_id = document.getElementById("vc_unique_id_for_service").innerText;
        createServiceBreakdown(domain,service_single,vc_unique_id);
    }

}

function createServiceBreakdown(domain, service,unique_id){
    var service_date = document.getElementById("service_date").value;
    var category = 'VC';
    $.ajax({
        url: 'db/createServiceBreakdown.php',
        type: 'post',
        data: "domain="+domain+"&service="+service+"&unique_id="+unique_id+"&service_date="+service_date+"&category="+category+"&householdUniqueId="+householdUniqueId,  

        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "Service: "+domain+": "+service+" Added Successfully",
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
                    text: "Error: Service: "+domain+": "+service+" NOT Added",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 20000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "Error: Service: "+domain+": "+service+"; For Client: "+unique_id+" on Date: "+service_date+" Already exists",
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