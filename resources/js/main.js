function check_group_number(group_number) {
	if(group_number) {
		if(group_number.length == 3) {
			response_div.children(".loading").show();
			response_div.children(".message").html("");
		
			$.get("status-checker.php?json&group-number="+group_number, function(response) {
				response_div.children(".loading").hide();
				response = JSON.parse(response);
				response_div.children(".message").html(JSON.stringify(response, null, 2));
				if(response.match == "true") {
					console.log(response.match_info);
				} else {
					console.log("false");
				}
			});
		} else {
			response_div.children(".loading").hide();
			response_div.children(".message").html("");
		}
	} else {
		response_div.children(".message").html("");
	}
}

$(document).ready(function() {
	response_div = $("#response");
	too_short_error_message = "Sorry, group numbers need to be 3 digits..."
	
	// perform query on values loaded with page
	check_group_number($(".digit[data-digit-index=1]").val()+$(".digit[data-digit-index=2]").val()+$(".digit[data-digit-index=3]").val());
	
	// if the first digit field is empty
	if($(".digit[data-digit-index=1]").val() == "") {
		// auto-focus the first digit field
		$(".digit[data-digit-index=1]").focus().select();
	}
	
	$(".digit").keyup(function(key) {
		// update URL to include digits
		window.history.pushState("", "", "?group-number="+$(".digit[data-digit-index=1]").val()+$(".digit[data-digit-index=2]").val()+$(".digit[data-digit-index=3]").val());
		
		if(
			$(this).val() != "" && // digit field is empty
			key.which >= 48 && key.which <= 57 && // is number
			key.which != 9 && // is not TAB key
			key.which != 17 && // is not CTRL key
			key.which != 16 && // is not SHIFT key
			key.which != 91 && // is not CMD key
			key.which != 18 // is not OPTION key
		) {
			// if it is the first or second digit field
			if(parseInt($(this).attr("data-digit-index")) < 3) {
				next_digit = parseInt($(this).attr("data-digit-index"))+1; // find next digit fiend
				$(".digit[data-digit-index="+next_digit+"]").focus(); // focus next digit field
			}

			// if all digit fields are not empty
			if($(".digit[data-digit-index=1]").val() != "" && $(".digit[data-digit-index=2]").val() != "" && $(".digit[data-digit-index=3]").val() != "") {
				// if this digit field is the last, remove focus
				if($(this).attr("data-digit-index") == 3) {
					$(".digit[data-digit-index=3]").blur();
				}
				// combine digits and perform query
				check_group_number($(".digit[data-digit-index=1]").val()+$(".digit[data-digit-index=2]").val()+$(".digit[data-digit-index=3]").val());
			}
		}
		
		// if digit field is empty and DELETE key is pressed
		if($(this).val() == "" && key.which == 8) {
			// if it is not the first digit field
			if(parseInt($(this).attr("data-digit-index")) >= 1) {
				previous_digit = parseInt($(this).attr("data-digit-index"))-1; // find previous digit field
				// if the previous digit field index is not empty
				if($(".digit[data-digit-index="+previous_digit+"]").val() != "") {
					$(".digit[data-digit-index="+previous_digit+"]").focus(); // focus previous digit field
				}
			}
		}
	}).keypress(function(key) {
		// if key pressed is not a number, don't do anything
		if((key.which < 48 || key.which > 57)) {
			key.preventDefault();
		}
	}).focus(function () {
		$(this).select();
	}).click(function () {
		$(this).select();
	});

});