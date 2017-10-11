jQuery(document).ready(function ($) {
	
	//"Accordion" functionality for clients page
	$(".client-title-holder.cth-has-tasks").click(function(){
		$(this).next( ".client-task-holder" ).toggle(200);
	});
	
	//Timesheet Admin section
	jQuery(document).ready(function ($) {
		//remove duplicates
		jQuery(".entry-owner option").each(function(){
		$(this).siblings("[value='"+ this.value+"']").remove();
		});
		//remove on change
		$( ".entry-owner" ).change(function() {
			entry_owner_change_handler();
		});
		$( ".entry-client" ).change(function() {
			entry_owner_change_handler();
		});
		//orderby Date (timestamp)
		$(".timesheet-holder .timesheet-item").sort(function(a, b) {
		  return parseInt(a.id) - parseInt(b.id);
		}).each(function() {
		  var elem = $(this);
		  elem.remove();
		  $(elem).prependTo(".timesheet-holder");
		});
		//datepicker
		$( ".timesheet-date-picker" ).change(function() {
			entry_owner_change_handler();
		});
		//main worker function
		function entry_owner_change_handler() {
			//username change
			var entry_owner = $(".entry-owner option:selected").text();
			$('.timesheet-item').each(function() {
				if ($(this).hasClass('timesheet-owner-' + entry_owner)) { //user selected
					if ($('.timesheet-date-picker').val() == "") { //no date picked
						if ($(this).find(".columns:first-child").text() !== $('.entry-client option:selected').text() && $('.entry-client option:selected').text() != "")
							$(this).hide();
						else
							$(this).show(); //no client selected
					}
					else { //date picked
							if ($(this).find(".columns:nth-child(2)").text() !== $('.timesheet-date-picker').val()) {
								$(this).hide();
							}
							else {
							if ($(this).find(".columns:first-child").text() !== $('.entry-client option:selected').text() && $('.entry-client option:selected').text() != "")
								$(this).hide();
							else
								$(this).show(); //no client selected
							}
					}
				}
				else { 
					$(this).hide();
				}
				if (entry_owner == "") { //no users selected
					if ($('.timesheet-date-picker').val() == "") { //no date picked
						if ($(this).find(".columns:first-child").text() !== $('.entry-client option:selected').text() && $('.entry-client option:selected').text() != "")
							$(this).hide();
						else
							$(this).show();
					}
					//datepicker
					else {
							if ($(this).find(".columns:nth-child(2)").text() !== $('.timesheet-date-picker').val() && $('.timesheet-date-picker').val() != "") {
								$(this).hide();
							}
							else {
							if ($(this).find(".columns:first-child").text() !== $('.entry-client option:selected').text() && $('.entry-client option:selected').text() != "")
								$(this).hide();
							else
								$(this).show(); //no client selected
							}
					}
				}
			});
		}
		$("button.timesheet-del-entry").click(function(){
			var get_the_id_to_delete = $(this).attr('id');
			var gtitd_final = get_the_id_to_delete.substring(get_the_id_to_delete.lastIndexOf("-") + 1);
		  $.ajax({
			method: 'get',
			//url: 'index.php',
			data: {
			  'delGFFromID': gtitd_final,
			  'ajax': true
			},
			success: function(data) {
			  alert("Entry removed.");
			  location.reload();
			}
		  });
		});
	});
	
});