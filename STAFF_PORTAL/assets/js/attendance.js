

jQuery(document).ready(function(){

	//delete staff attendance
	jQuery(document).on("click", ".deleteStaffAttendance", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteStaffAttendance",
			currentRow = $(this);
		var confirmation = confirm("Are you sure to delete this Attendance ?");

		if(confirmation){
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){

				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Attendance successfully deleted"); }
				else if(data.status = false) { alert("Attendance deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

		
	// student attendance
	jQuery(document).on("click", ".deleteStudentAttendance", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteStudentAttendance",
			currentRow = $(this);
		var confirmation = confirm("Are you sure to delete this Attendance ?");
		if(confirmation) {
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Attendance successfully deleted"); }
				else if(data.status = false) { alert("Attendance deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	
	// student attendance
	jQuery(document).on("click", ".deleteClassCompleted", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteClassCompleted",
			currentRow = $(this);
		var confirmation = confirm("Are you sure to delete this Class Detail?");
		if(confirmation) {
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Class successfully deleted"); }
				else if(data.status = false) { alert("Class deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

});