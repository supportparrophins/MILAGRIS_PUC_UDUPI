



$(document).ready(function(){







	jQuery(document).on("click", ".deleteStudent", function(){

			var row_id = $(this).data("row_id"),

				hitURL = baseURL + "deleteStudent",

				currentRow = $(this);



			var confirmation = confirm("Are you sure to delete this Student ?");



			if(confirmation)

			{

				jQuery.ajax({

				type : "POST",

				dataType : "json",

				url : hitURL,

				data : { row_id : row_id } 

				}).done(function(data){



					currentRow.parents('tr').remove();

					if(data.status = true) { alert("Student successfully deleted"); }

					else if(data.status = false) { alert("Student deletion failed"); }

					else { alert("Access denied..!"); }

				});

			}



		});

		jQuery(document).on("click", ".inactiveStudent", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "inactiveStudent",
				currentRow = $(this);
			
			var confirmation = confirm("Are you sure to Inactive this Student ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){
						
					currentRow.parents('tr').remove();
					if(data.status = true) { alert("Student successfully Inactivated"); 
				 window.location.reload();}
					else if(data.status = false) { alert("Student Inactivation failed"); }
					else { alert("Access denied..!"); }
				});
			}
	
	});

	jQuery(document).on("click", ".activeStudent", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "activeStudent",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to Active this Student ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Student successfully Activated"); 
			 window.location.reload();}
				else if(data.status = false) { alert("Student Activation failed"); }
				else { alert("Access denied..!"); }
			});
		}


	
	});

    



    



});