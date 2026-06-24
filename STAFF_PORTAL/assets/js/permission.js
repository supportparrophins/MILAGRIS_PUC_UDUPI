    

    jQuery(document).ready(function(){

	

        //delete holiday

        jQuery(document).on("click", "#approveStaffPermission", function(){

            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "updateStaffPermissionInfo",
                currentRow = $(this);
            var confirmation = confirm("Are you sure to approve this permission ?");
            if(confirmation) {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { 
                    type:"Approve",
                    row_id : row_id, 
                } 
                }).done(function(data){
                    $('#tr'+row_id).html('<b id="tr'+row_id+'" style="color:green">Approved</b>');
                    if(data.status = true) { 
                        alert("Permission Approved Successfully."); 
                        windows.location.reload();
                    }
                    else if(data.status = false) { alert("Permission Approve failed"); }
                    else { alert("Access denied..!"); }
                });
            }
        });

        

        jQuery(document).on("click", "#rejectStaffPermission", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "updateStaffPermissionInfo",
                currentRow = $(this);
            var confirmation = confirm("Are you sure to reject this Permission ?");

            if(confirmation){
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { 
                    type:"Reject",
                    row_id : row_id,
                 } 
                }).done(function(data){
                    $('#tr'+row_id).html('<b id="tr'+row_id+'" style="color:red">Rejected</b>');
                    if(data.status = true) { 
                        alert("Permission Rejected Successfully."); 
                        windows.location.reload();
                    }
                    else if(data.status = false) { alert("Permission Reject Failed"); }
                    else { alert("Access denied..!"); }
                });
            }
        });

        

        jQuery(document).on("click", "#deleteStaffPermission", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "updateStaffPermissionInfo",
                currentRow = $(this);
            var confirmation = confirm("Are you sure to delete this Permission ?");
            if(confirmation){
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { 
                    type:"Delete",
                    row_id : row_id,
                } 
                }).done(function(data){
                    currentRow.parents('tr').remove();
                    if(data.status = true) { 
                        alert("Permission Deleted Successfully.");
                        windows.location.reload();
                    }
                    else if(data.status = false) { alert("Permission Deletion Failed"); }
                    else { alert("Access denied..!"); }
                });
            }
        });

});