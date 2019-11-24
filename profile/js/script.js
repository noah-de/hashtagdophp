$(function() {
	$('[data-toggle="tooltip"]').tooltip();

	$('#editable_content').toggle();

	$('#edit, #save').click(function () {
		$('.profile_content').toggle();
	});

	let tooltipTitles = {
		"preferred_name_privacy": [
			"Turn off to prevent others from seeing your preferred name",
			"Turn on to allow others to see your preferred name"
		],
		"phone_num_privacy": [
			"Turn off to prevent others from seeing your phone number",
			"Turn on to allow others to see your phone number"
		],
		"alt_email_privacy": [
			"Turn off to prevent others from seeing your alternate email",
			"Turn on to allow others to see your alternate email"
		],
		"profile_pic_privacy": [
			"Turn off to prevent others from seeing your profile picture",
			"Turn on to allow others to see your profile picture"
		],
		"name_privacy": [
			"Turn off to prevent others from seeing your name",
			"Turn on to allow others to see your name"
		],
		"year_privacy": [
			"Turn off to prevent others from seeing your academic year",
			"Turn on to allow others to see your academic year"
		],
		"email_privacy": [
			"Turn off to prevent others from seeing your Westmont email",
			"Turn on to allow others to see your Westmont email"
		],
		"ms_num_privacy": [
			"Turn off to prevent others from seeing your MS#",
			"Turn on to allow others to see your MS#"
		],
		"searched_num_privacy": [
			"Turn off to prevent others from seeing how many times you've been searched",
			"Turn on to allow others to see how many times you've been searched"
		],
		"roommates_privacy": [
			"Turn off to prevent others from seeing your roommates",
			"Turn on to allow others to see your roommates"
		],
		"dorm_privacy": [
			"Turn off to prevent others from seeing your dorm",
			"Turn on to allow others to see your dorm"
		]
	};

	$('[data-toggle="tooltip"]').each(function () {
		var forKey = $(this).attr('for');
		var privacyState = $('#' + forKey).is(':checked');
		var tooltipTitle = (privacyState) ? tooltipTitles[forKey][0] : tooltipTitles[forKey][1];

		$(this).attr('data-original-title', tooltipTitle);
	});

	$('.privacy').change(function () {
		var idKey = $(this).attr('id');
		console.log({'idKey': idKey});
		var privacyState = $(this).is(':checked');
		var tooltipTitle = (privacyState) ? tooltipTitles[idKey][0] : tooltipTitles[idKey][1];
		var forAttrSel = '[for=\"' + idKey + '\"';

		$(forAttrSel).attr('data-original-title', tooltipTitle);
		$(forAttrSel).tooltip('hide');
	});
});
