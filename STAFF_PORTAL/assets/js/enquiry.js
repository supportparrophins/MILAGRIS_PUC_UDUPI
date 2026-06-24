
	
jQuery(document).ready(function(){
    jQuery(document).on("click", ".deleteEnquiry", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteEnquiry",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this  Info?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Enquiry Info successfully deleted"); }
				else if(data.status = false) { alert("Enquiry Info deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
});