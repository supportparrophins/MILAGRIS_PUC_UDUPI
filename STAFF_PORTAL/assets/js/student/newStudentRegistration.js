$(document).ready(function(){

	var userRegister = $("#newUserRegistration");
	var validator = userRegister.validate({
		rules:{
			student_id :{ required : true },
			dob : { required : true },
			password : { minlength: 6, required : true,  },
			cpassword : {required : true, equalTo: "#password"}
		},
		messages:{
			student_id :{ required : "Student ID field is required" },
			dob : { required : "Date of Birth field is required" },
			password : { required : "Password field is required" },
			cpassword : { required : "Re-type Password field is required", equalTo: "Password mismatch!" }
		}
	});
});
