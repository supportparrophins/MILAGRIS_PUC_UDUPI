

$(document).ready(function(){

    



	

	jQuery(document).on("click", "#approveAdmission", function(){

		var application_number = $(this).data("application_number"),

			hitURL = baseURL + "updateApplicationStatus",

			currentRow = $(this);

		var confirmation = confirm("Are you sure to approve this Student Admission ?");

		if(confirmation) {

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { 

                type:"Approve",

                application_number : application_number, 

            } 



			}).done(function(data){

				//  $('#tr'+application_number).html('<b id="tr'+application_number+'" style="color:green">Approved</b>');

				if(data.status = true) { 

					alert("Admission Approved Successfully."); 

					window.location.reload();  }

				else if(data.status = false) { alert("Admission Approve failed"); }

				else { alert("Access denied..!"); }

			});

		}

    });



    



    jQuery(document).on("click", "#rejectAdmission", function(){

		var application_number = $(this).data("application_number"),

			hitURL = baseURL + "updateApplicationStatus",

            currentRow = $(this);

		var confirmation = confirm("Are you sure to reject this Student Admission ?");

		if(confirmation) {

			jQuery.ajax({

                type : "POST",

                dataType : "json",

                url : hitURL,

                data : { 

                    type:"Reject",

                    application_number : application_number,

                }



			}).done(function(data){

				// $('#tr'+row_id).html('<b id="tr'+row_id+'" style="color:red">Rejected</b>');

				if(data.status = true) { 

					alert("Admission Rejected Successfully.");

					window.location.reload();  }

				else if(data.status = false) { alert("Admission Reject Failed"); }

				else { alert("Access denied..!"); }

			});

		}

    });

    

    

	jQuery(document).on("click", ".deleteStudentApplication", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteStudentApplication",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Admission Info?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Admission Info successfully deleted"); }

				else if(data.status = false) { alert("Failed to Delete"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	jQuery(document).on("click", ".applicationPaymentComplete", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "applicationPaymentComplete",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure that Student Application Payment Completed?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Application successfully Updated"); }

				else if(data.status = false) { alert("Failed to Update"); }

				else { alert("Access denied..!"); }

			});

		}

	});

    

});