
$(document).ready(function(){
	var addUserForm = $("#pushNotification");
	var validator = addUserForm.validate({
		rules:{
            subject :{ required : true },
            message :{ required : true },
		},
		messages:{
            subject :{ required : "This field is required" },		
            message :{ required : "This field is required" },			
		}
    });
    
});