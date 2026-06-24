jQuery(document).ready(function(){
    //delete a study metrial
    jQuery(document).on("click", ".deleteStudy", function(){
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteStudyMaterials",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Study Material?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Study Material successfully deleted"); }
                else if(data.status = false) { alert("Study Material deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

    jQuery(document).on("click", ".deleteOnlineClass", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteOnlineClass",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Online Class Link ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Online Class Link successfully deleted"); }
				else if(data.status = false) { alert("Online Class Link deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
    });
    
    jQuery(document).on("click", ".deleteYoutube", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteYoutube",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Video Link ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Video Link successfully deleted"); }
				else if(data.status = false) { alert("Video Link deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
});