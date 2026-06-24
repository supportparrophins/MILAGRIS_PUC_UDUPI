
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteClassInfo", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteClassInfo",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Subject ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){

				
				// currentRow.parents('tr').remove();
				if(data.status = true) { alert("Subject successfully deleted");
				window.location.reload();
			}
				else if(data.status = false) { alert("Subject deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
    });
    
});