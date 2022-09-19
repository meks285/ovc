$(document).ready(function(){
    var state_select = document.getElementById("state");
    var lga_select = document.getElementById("lga");
    var wards = document.getElementById("ward");
    state_select.addEventListener("change", getLgaList);
    lga_select.addEventListener("change", getWardsList);

    function getLgaList(){
        var state_name = state_select.options[state_select.selectedIndex].value;
        var xhr = new XMLHttpRequest();
        var url = './db/getAllData.php?state=' + state_name;
        // open function
        xhr.open('GET', url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        // check response is ready with response states = 4
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                var text = xhr.responseText;
                //console.log('response from getAllData.php : ' + xhr.responseText);
                var lga_select = document.getElementById("lga");
                var ward_select = document.getElementById("ward");

                lga_select.innerHTML = text;
                ward_select.innerHTML = '<option disabled selected>Select ward</option>';
                lga_select.style.display='inline';
                ward.style.display='inline';
            }
        }

        xhr.send();    
    }
    function getWardsList(){
        var lga_name = lga_select.options[lga_select.selectedIndex].value;
        var xhr = new XMLHttpRequest();
        var url = './db/getAllData.php?lga=' + lga_name;
        // open function
        xhr.open('GET', url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        // check response is ready with response states = 4
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                var text = xhr.responseText;
                //console.log('response from getAllData.php : ' + xhr.responseText);
                var ward_select = document.getElementById("ward");
                ward_select.innerHTML = text;
                ward_select.style.display='inline';
            }
        }

        xhr.send();      
    }

})