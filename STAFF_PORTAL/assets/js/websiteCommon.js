jQuery(document).on("click", ".disableAnnouncement", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "enableAnnouncement",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to enable this Announcement ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				location.reload();
				if(data.status = true) { alert("Announcement successfully Enabled"); }
				else if(data.status = false) { alert("Failed to enable"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".enableAnnouncement", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "disableAnnouncement",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to disable this Announcement ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				location.reload();
				if(data.status = true) { alert("Announcement successfully Disabled"); }
				else if(data.status = false) { alert("Failed to disable"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	// Websiite News
	jQuery(document).on("click", ".disableNews", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "enableNews",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to enable this News ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("News successfully Enabled"); 
				window.location.reload();
			}
				else if(data.status = false) { alert("Failed to Enabled"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".enableNews", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "disableNews",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to disable this News ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("News successfully Disabled"); 
				window.location.reload();
			}
				else if(data.status = false) { alert("Failed to Disable"); }
				else { alert("Access denied..!"); }
			});
		}
	});


	jQuery(document).on("click", ".disableEvent", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "enableEvent",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to enable this Event ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				location.reload();
				if(data.status = true) { alert("Event successfully Enabled"); }
				else if(data.status = false) { alert("Failed to enable"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".enableEvent", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "disableEvent",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to disable this Event ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				location.reload();
				if(data.status = true) { alert("Event successfully Disabled"); }
				else if(data.status = false) { alert("Failed to disable"); }
				else { alert("Access denied..!"); }
			});
		}
	});