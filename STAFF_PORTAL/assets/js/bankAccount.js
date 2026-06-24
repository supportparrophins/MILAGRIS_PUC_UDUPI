jQuery(document).ready(function(){

	//delete fees structure
	jQuery(document).on("click", ".deleteAccount", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteAccount",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Account Info?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Account successfully deleted"); }
				else if(data.status = false) { alert("Account deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
    });
});