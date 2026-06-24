$(document).ready(function(){
    
    var loginMeForm = $("#login");
    
    var validator = loginMeForm.validate({
        
        rules:{
            username :{ required : true },
            password :{ required : true }
           
        },
        messages:{
            username :{ required : "Student ID is required" },
            password :{ required : "Password is required" }
        }
    });
});