$(document).ready(function(){
// code to get all records from table via select box
$("#listOfUsers").change(function() {
var id = $(this).find(":selected").val();
//var dataString = 'empid='+ id;
var dataString = 'intEmployeeId='+ id;
console.log("dataString: " + dataString);
$.ajax({
url: '../Management/getEmployeeToEdit.php',
dataType: "json",
data: dataString,
cache: false,
success: function(employeeData) {
    console.log("before if");
if(employeeData) {
    console.log("in if");
$("#employeeDataToEdit").show();
$("#firstName").text(employeeData.strFirstName);
$("#lastName").text(employeeData.strLastName);
$("#email").text(employeeData.strEmailAddress);
$("#intSecurityLevel").text(employeeData.intSecurityLevel);
$("#employeeDataToEdit").show();
} else {
    console.log("Fail");
$("#employeeDataToEdit").hide();
}
}
});
})
});