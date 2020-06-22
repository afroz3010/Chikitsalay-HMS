// function phoneNumberCheck(phoneNumber) {
//     var regEx = ^\+{ 0, 2}([\-\. ]) ? (\(?\d{ 0, 3 } \))?([\-\. ]) ?\(?\d{ 0, 3 } \)?([\-\. ]) ?\d{ 3 } ([\-\. ]) ?\d{ 4 };
//     if (phoneNumber.value.match(regEx)) {
//         return true;
//     }
//     else {
//         alert("Please enter a valid phone number.");
//         return false;
//     }
// }
// function adharNumberCheck(adhar) {
//     var adharcard = /^\d{12}$/;
//     var adharsixteendigit = /^\d{16}$/;
//     if (adhar != '') {
//         if (!adhar.match(adharcard)) {
//             alert("Invalid Aadhar Number");
//             return false;
//         }
//     }
//     if (adhar != '') {
//         if (!adhar.match(adharsixteendigit)) {
//             alert("Invalid Aadhar Number");
//             return false;
//         }
//     }
// }

// $('#adhar').on('keypress change', function () {
//     $(this).val(function (index, value) {
//         return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
//     });
// });
$('#number').on('keyup', function (e) {
    var val = $(this).val();
    var newval = '';
    val = val.replace(/\s/g, '');
    for (var i = 0; i < val.length; i++) {
        if (i % 4 == 0 && i > 0) newval = newval.concat(' ');
        newval = newval.concat(val[i]);
    }
    $(this).val(newval);
});



function displayRadioValue() {
    var remp="";
    var remp1 = document.getElementById('remp1').value;
    var remp2 = document.getElementById('remp2').value;
    
    if (document.getElementById('remp1').checked){
        document.getElementById("rail").style.display = "block";
    }
    if (document.getElementById('remp2').checked){
        document.getElementById("rail").style.display = "none";
    }
} 

function displayRadioValueEdit() {
    var remp="";
    var remp1 = document.getElementById('remp1edit').value;
    var remp2 = document.getElementById('remp2edit').value;
    
    if (document.getElementById('remp1edit').checked){
        document.getElementById("railedit").style.display = "block";
    }
    if (document.getElementById('remp2edit').checked){
        document.getElementById("railedit").style.display = "none";
    }
} 



function displayCough() {
    
    if (document.getElementById('cough1').checked){
        document.getElementById("displayCough").style.display = "block";
    }
    if (document.getElementById('cough2').checked){
        document.getElementById("displayCough").style.display = "none";
    }
} 

function displaySOB() {
    
    if (document.getElementById('sob1').checked){
        document.getElementById("displaySOB").style.display = "block";
    }
    if (document.getElementById('sob2').checked){
        document.getElementById("displaySOB").style.display = "none";
    }
}
function displayFever() {
    
    if (document.getElementById('fever1').checked){
        document.getElementById("displayFever").style.display = "block";
    }
    if (document.getElementById('fever2').checked){
        document.getElementById("displayFever").style.display = "none";
    }
}

function displayCold() {

    if (document.getElementById('cold1').checked) {
        document.getElementById("displayCold").style.display = "block";
    }
    else if (document.getElementById('cold2').checked) {
        document.getElementById("displayCold").style.display = "none";
    }
} 
function displayInPatient() {

    if (document.getElementById('InPatient1').checked) {
        document.getElementById("displayInPatient").style.display = "none";
    }
    else if (document.getElementById('InPatient2').checked) {
        document.getElementById("displayInPatient").style.display = "block";
    }
} 