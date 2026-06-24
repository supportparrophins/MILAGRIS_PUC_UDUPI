    
    jQuery(document).ready(function(){
	
		//delete holiday
		jQuery(document).on("click", "#approveStaffLeave", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "updateStaffLeaveInfo",
				currentRow = $(this),
				remarks = $('#Remarks').val(); // Get the value of the remarks field
			
			var confirmation = confirm("Are you sure to approve this leave ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { 
					type:"Approve",
					row_id : row_id, 
					remarks: remarks // Include remarks in the data
				} 
				}).done(function(data){
					 
					$('#tr'+row_id).html('<b id="tr'+row_id+'" style="color:green">Approved</b>');
					if(data.status = true) { 
						alert("Leave Approved Successfully."); 
						window.location.reload();
					}
					else if(data.status = false) { alert("Leave Approve failed"); }
					else { alert("Access denied..!"); }
				});
			}
	
		});
		
		jQuery(document).on("click", "#rejectStaffLeave", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "updateStaffLeaveInfo",
				currentRow = $(this),
				remarks = $('#Remarks').val(); // Get the value of the remarks field
			
			var confirmation = confirm("Are you sure to reject this leave ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { 
					type:"Reject",
					row_id : row_id,
					remarks: remarks // Include remarks in the data
				 } 
				}).done(function(data){
					 
					$('#tr'+row_id).html('<b id="tr'+row_id+'" style="color:red">Rejected</b>');
					if(data.status = true) { 
						alert("Leave Rejected Successfully."); 
						window.location.reload();
					}
					else if(data.status = false) { alert("Leave Reject Failed"); }
					else { alert("Access denied..!"); }
				});
			}
	
		});
		
		
		jQuery(document).on("click", ".deleteAppliedLeave", function(){
				
	
	
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteAppliedLeave",
				currentRow = $(this);
			
			var confirmation = confirm("Are you sure to delete this Leave ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){
					 
					currentRow.parents('tr').remove();
					if(data.status = true) { 
						alert("Leave successfully deleted"); 
						window.location.reload();
					}
					else if(data.status = false) { alert("Leave deletion failed"); }
					else { alert("Access denied..!"); }
				});
			}
	
	
		
		});
	
		});