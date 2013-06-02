var form_id = 'form#form';
formAjax = function () {
	$.php(url, $(form_id).formToArray(true));
	return false;
    
	// do an ajax post request
	$.ajax({
		// AJAX-specified URL
		url: url,
		// JSON
		type: "POST",
		data: $(form_id).formToArray(true),
		dataType : "json",
       
		/* Handlers */       
		// Handle the beforeSend event
		beforeSend: function(){
			return php.beforeSend();
		},
		// Handle the success event
		success: function(data, textStatus){   
			return php.success(data, textStatus);
		},
		// Handle the error event
		error: function (xmlEr, typeEr, except) {
			return php.error(xmlEr, typeEr, except);                  
		},
		// Handle the complete event
		complete: function (XMLHttpRequest, textStatus) {              
			return php.complete(XMLHttpRequest, textStatus);
		}
	});
	return false;
}
