document.addEventListener('DOMContentLoaded', init);

function init(){

  //Call the submitForm Function to commit to DB all sample form values -- vl-reception-form
  document.getElementById("buttonSubmit").addEventListener('click',submitForm,false);
}


function submitForm(ev){
    ev.preventDefault();

    state = document.getElementById("state").value;
    lga = document.getElementById("lga").value;
    cbo_code = document.getElementById("cbo_code").value;
    username = document.getElementById("username").value;
    firstname = document.getElementById("firstname").value;
    lastname = document.getElementById("lastname").value;
    email = document.getElementById("email").value;
    phonenumber = document.getElementById("phonenumber").value;
    role = document.getElementById("role").value;
    password = document.getElementById("password").value;
    rpt_password = document.getElementById("rpt_password").value;





        //Check for Validation and Missed Entries
        if(state=="" || state=="Select State"){document.getElementById("state_label").innerHTML="Field is required";state_chk=0;}else{state_chk=1;document.getElementById("state_label").innerHTML="";}
        if(lga=="" || lga=="Select LGA"){document.getElementById("lga_label").innerHTML="Field is required";lga_chk=0;}else{lga_chk=1;document.getElementById("lga_label").innerHTML="";}
        if(cbo_code==""){document.getElementById("cbo_code_label").innerHTML="Field is required";cbo_code_chk=0;}else{cbo_code_chk=1;document.getElementById("cbo_code_label").innerHTML="";}
        if(username==""){document.getElementById("username_label").innerHTML="Field is required";username_chk=0;}else{username_chk=1;document.getElementById("username_label").innerHTML="";}
        if(firstname==""){document.getElementById("firstname_label").innerHTML="Field is required";firstname_chk=0;}else{firstname_chk=1;document.getElementById("firstname_label").innerHTML="";}
        if(lastname==""){document.getElementById("lastname_label").innerHTML="Field is required";lastname_chk=0;}else{lastname_chk=1;document.getElementById("lastname_label").innerHTML="";}
        if(phonenumber==""){document.getElementById("phonenumber_label").innerHTML="Field is required";phonenumber_chk=0;}else{phonenumber_chk=1;document.getElementById("phonenumber_label").innerHTML="";} 
        if(role==""){document.getElementById("role_label").innerHTML="Field is required";role_chk=0;}else{role_chk=1;document.getElementById("role_label").innerHTML="";}
        if(email==""){document.getElementById("email_chk_label").innerHTML="Field is required";email_chk=0;}else{email_chk=1;document.getElementById("email_chk_label").innerHTML="";}
        if(password==""){document.getElementById("password_label").innerHTML="Field is required";password_chk=0;}else{password_chk=1;document.getElementById("password_label").innerHTML="";}
   
   
   
//Confirm validation and set validation status
        if(state_chk == 0 ||lga_chk == 0 ||cbo_code_chk == 0 ||username_chk == 0 ||firstname_chk == 0 ||lastname_chk == 0 ||phonenumber_chk == 0  ||role_chk == 0  ||email_chk == 0  ||password_chk == 0  ){
            validation_state = 'failed';
                    Toastify({
                    text: "Validation Failed, Form not Submitted",
                    style: {
                    background: "linear-gradient(to right, #DC3545, #DC3545)",
                    },
                    close: true,
                    duration: 10000
                    }).showToast();
        }
        else if(password != rpt_password){
            Toastify({
                text: "Validation Failed, Password Mismatch",
                style: {
                background: "linear-gradient(to right, #DC3545, #DC3545)",
                },
                close: true,
                duration: 10000
                }).showToast();        
            }
        else{
            createUserRecord();
        }
}

function createUserRecord(){

    $.ajax({
        url: 'db/createUserRecord.php',
        type: 'post',
        data: "cbo_code="+cbo_code+"&username="+username+"&state="+state+"&lga="+lga+"&firstname="+firstname+"&lastname="+lastname+"&phonenumber="+phonenumber+"&role="+role+"&email="+email+"&password="+password,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "User Created",
                style: {
                background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();   
                
                //Clear Form Elements
                document.getElementById("state").value="";
                document.getElementById("lga").value="";
                document.getElementById("cbo_code").value="";
                document.getElementById("username").value="";
                document.getElementById("firstname").value="";
                document.getElementById("lastname").value="";
                document.getElementById("email").value="";
                document.getElementById("phonenumber").value="";
                document.getElementById("role").value="";
                document.getElementById("password").value="";
                document.getElementById("rpt_password").value="";                

                
            }
        else if(response.status=="failure"){
            Toastify({
                text: "Error: User not created",
                style: {
                background: "linear-gradient(to right, #DC3545, #DC3545)",
                },
                close: true,
                duration: 10000
                }).showToast();        
            }
        else if(response.status=="exists"){
            Toastify({
                text: "Alert: This User already exists",
                style: {
                background: "linear-gradient(to right, #DC3545, #DC3545)",
                },
                close: true,
                duration: 10000
                }).showToast();        
            }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        Toastify({
            text:"Error: " + errorThrown+XMLHttpRequest+"Status: " + textStatus,
            style: {
            background: "linear-gradient(to right, #DC3545, #866EC7)",
            },
            close: true,
            duration: 10000
            }).showToast();            
    }  	
  })
}