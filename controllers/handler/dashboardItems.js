document.addEventListener('DOMContentLoaded', init);

function init(){    
    $.ajax({
        url: './controllers/db/getCboInformation.php',
        type: 'post',
        data: "cbo_id="+cbo_id,  
        dataType: 'json',
        success: function(response){ 
          if(response.status=="success"){
            Toastify({
                text: "CBO: "+response.cbo_name,
                style: {
                  background: "linear-gradient(to right, #DC3545, #866EC7)",
                },
                close: true,
                duration: 10000
                }).showToast();
                document.getElementById("dashboard_cbo_name").innerText=response.cbo_name;
            }
            else if(response.status=="failure"){
                Toastify({
                    text: "CBO Data not found",
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
