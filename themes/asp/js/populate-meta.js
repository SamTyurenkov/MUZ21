function populate_meta_fields() {
	var dboptions = populatemeta;
	
	for (var i in dboptions) {
    if (dboptions.hasOwnProperty(i) && typeof(i) !== 'function') {
	try {
	var hasOption = document.getElementById(i).children[1].querySelector('option[value="' + dboptions[i] + '"]');
	if (hasOption || document.getElementById(i).children[1].tagName == 'INPUT')
	document.getElementById(i).children[1].value = dboptions[i];
		}
	catch(e) {
	console.log(e);		
		}
    }
	}

}
populate_meta_fields();