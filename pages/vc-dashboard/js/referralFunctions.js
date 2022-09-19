document.addEventListener('DOMContentLoaded', init);

function init(){
  function addRow() {
     var row = $('#tbl tbody tr:first').clone();
    row.find('input[type!=button]').val('');
    $('#tbl tbody').append(row);
 }
 function removeRow() {
  var row = $('tbody tr:first').clone();
  //row.find('input[type!=button]').val('');
  //$('#tbl tbody tr:last').remove();
  $(this).closest('tr').remove();
}

//$('#addRFRow').on('click', '.add-row', addRow);
document.getElementById("addRFRow").addEventListener('click',addRow,false)
$('#tbl').on('click', '.remove-row', removeRow);
 
//$('#tbl').on('change', 'input', function() {
//  if($(this).val() != '' &&
//     $(this).closest('tr').is(':last-child')) {
//    addRow();
//  }
//});

    //Call the submitForm Function to commit to DB all sample form values -- eid-reception-form
    document.getElementById("submitReferralForm").addEventListener('click',submitForm,false);

}
function submitForm(){

}