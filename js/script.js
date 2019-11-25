$(function() {
	let dormSections = {
		"Clark": [
			"C",
			"D",
			"E",
			"G",
			"H",
			"J",
			"K",
			"L",
			"M",
			"P",
			"Q",
			"R",
			"S"
		],
		"Page": [
			"B",
			"C"
		],
		"Emerson": [
			1,
			2,
			3,
			4
		],
		"Armington": [
			"A",
			"B",
			"D",
			"E"
		],
		"Van Kampen": [
			"A",
			"B",
			"C",
			"D",
			"F",
			"G",
			"H",
			"I",
			"K",
			"L",
			"M",
			"N",
			"O",
			"P",
			"Q",
			"R",
			"S",
			"T"
		],
		"GLC": [
			"North",
			"South"
		],
		"Off Campus": []
	};
	
	$('#adv_dorm').change(function () {
		$('#adv_section').html('');
		var dorm = this.value;
		$('#adv_section').append("<option selected=\"selected\" disabled>Pick a section</option>");
		
		for (var i = 0; i < dormSections[dorm].length; i++) {
			$('#adv_section').append("<option value=\"" + dormSections[dorm][i] + "\">" + dormSections[dorm][i] + "</option>");
		}
	});
});

