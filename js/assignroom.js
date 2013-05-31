$(window)
		.load(
				function() {
					$(".roomlist-yes, .roomlist-no").sortable({
						items : "li:not(.not-selectable)",
						placeholder : "ui-state-highlight",
						connectWith : ".connectedRoomlist"
					}).disableSelection();
					$("li.muusatip").tooltip({
						content : function() {
							return $(this).prop('title');
						}
					});
					$("#submitRooms").button().click(function() {
						submit();
						return false;
					});
					$("#backDetails")
							.button({
								icons : {
									primary : "ui-icon-triangle-1-w"
								}
							})
							.click(
									function() {
										window.location.href = "http://muusa.org/index.php/admin/database/campers";
										return false;
									});
				});

function submit() {
	$("#muusaApp div.room").each(function() {
		var roomid = $("select.roomlist", $(this)).val();
		$(".roomlist-yes li", $(this)).each(function(index, val) {
			addHidden("fiscalyear-roomid-" + $(this).val(), roomid);
		});
	});
	$("#muusaApp").closest("form").submit();
}

function addHidden(fieldname, fieldvalue) {
	$("<input>").attr({
		type : "hidden",
		name : fieldname,
		value : fieldvalue
	}).appendTo("#muusaApp");
}