function checkTreatmentNo(treatment_no){    
    treatment_no_check = /^([a-zA-Z0-9 -]+)$/;
    //console.log(treatment_no);
    isTreatmentNoOk =  treatment_no_check.test(treatment_no);
    return isTreatmentNoOk;
}
