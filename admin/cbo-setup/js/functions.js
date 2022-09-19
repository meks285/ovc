document.addEventListener('DOMContentLoaded', init);

function init(){

    document.getElementById("buttonSubmit").addEventListener('click',submitForm,false);
    
}

function submitForm(ev){
    ev.preventDefault();
    cbo_name = document.getElementById("cbo_name").value;
    cbo_code = document.getElementById("cbo_code").value;
    cbo_details = document.getElementById("cbo_details").value;


        //Check for Validation and Missed Entries
        if(cbo_name==""){document.getElementById("cbo_name_label").innerHTML="Field is required";cbo_name_chk=0;}else{cbo_name_chk=1;document.getElementById("cbo_name_label").innerHTML="";}
        if(cbo_code==""){document.getElementById("cbo_code_label").innerHTML="Field is required";cbo_code_chk=0;}else{cbo_code_chk=1;document.getElementById("cbo_code_label").innerHTML="";}
        if(cbo_details==""){document.getElementById("cbo_details_label").innerHTML="Field is required";cbo_details_chk=0;}else{cbo_details_chk=1;document.getElementById("cbo_details_label").innerHTML="";}
   
   
//Confirm validation and set validation status
    if(cbo_name_chk == 0 || cbo_code_chk == 0 ||cbo_details_chk == 0){
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
        createCbo();
    }
}

function createCbo(){

    $.ajax({
        url: 'db/createCbo.php',
        type: 'post',
        data: "cbo_name="+cbo_name+"&cbo_code="+cbo_code+"&cbo_details="+cbo_details,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "CBO Created Successfully",
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();
                document.getElementById("cbo_name").value='';
                document.getElementById("cbo_code").value='';
                document.getElementById("cbo_details").value='';
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "CBO Not Created, Review Entry",
                    style: {
                      background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                }).showToast();        
            }
            else if(response.status=="exists"){
                Toastify({
                    text: "CBO already exists, Please review",
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