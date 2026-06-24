$('document').ready(function(){
var password = document.getElementById("password")
, confirm_password = document.getElementById("cpassword");

function validatePassword(){
	if(password.value.length < 6) {
        password.setCustomValidity("Password must be at least 6 characters long.");
	}else{
		password.setCustomValidity('');
	}
	
	if(password.value != confirm_password.value) {
		confirm_password.setCustomValidity("Password Mismatch! Enter Correct Password.");
	} else {
		confirm_password.setCustomValidity('');
	}
}
password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
});
