jQuery(document)
		.ready(
				function($) {
					$(".roomlist-yes, .roomlist-no").sortable({
						items : "li:not(.not-selectable)",
						placeholder : "ui-state-highlight",
						connectWith : ".connectedRoomlist"
					}).disableSelection();
					$("li.muusatip").tooltip({
						content : function() {
							return jQuery(this).prop('title');
						}
					});
					$("#submitRooms").button().click(function() {
						submit();
						return false;
					});
				});

function submit() {
	jQuery("#muusaApp div.room").each(function() {
		var roomid = jQuery("select.roomlist", $(this)).val();
		jQuery(".roomlist-yes li", $(this)).each(function(index, val) {
			addHidden("yearattending-roomid-" + jQuery(this).val(), roomid);
		});
	});
	$("#muusaApp").closest("form").submit();
}

function addHidden(fieldname, fieldvalue) {
	jQuery("<input>").attr({
		type : "hidden",
		name : fieldname,
		value : fieldvalue
	}).appendTo("#muusaApp");
}