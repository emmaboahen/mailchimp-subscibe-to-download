jQuery(document).ready(function ($) {
    $(".mcsd_download_btn").on('click',function () {
        var formid = $(this).attr('id');

		//setting global js variables for subscribe activity
		window.mcsd_foorm_id = formid;
		window.mcsd_response_div=$('#mcsd_feedback_msg_' + formid);
		window.mcsd_response_div.css('color', '#000');
		window.mcsd_response_div.text("");
		window.mcsd_submit_btn = $(this);
		window.mcsd_dlink =$('#dlk_' + formid).val();
		window.succtc = $('#succtc' + formid).val();//success text color value
		window.errtc =$('#errtc' + formid).val();//error text color value
		
        var $form = $('#mcsd_form_' + formid);
        if ($form.length > 0) {
            validateAndSubmitForm($form);
        }

    });

});

function validateAndSubmitForm($form) { //function to validate subscriber inputs and finally submit to mailchimp
    $form.validate({
        rules: {
            FNAME: "required",
            EMAIL: {
                required: true,
                email: true
            },
        },
        messages: {
            FNAME: "Please enter your name",
            EMAIL: "Please enter a valid email address",
        },
        submitHandler: function (form) {
			
			var serializedFormData =jQuery("#" + form.id).serializeArray();

    		var formDataInJson = jQFormSerializeArrToJson(serializedFormData);

			var dataToSend = {
				email_address: formDataInJson.EMAIL,
				status: 'subscribed',
				merge_fields: formDataInJson
			}
			var finalData = JSON.stringify(dataToSend);
            registerSubscriber(finalData);
            return false;
        }
    });
}


function registerSubscriber(serializedDataInJson) { //function to save subscriber details in mailchimp list
    jQuery.ajax({
        type: 'POST',
        url: 'https://cors-anywhere.gopeartech.workers.dev/?' + mcsd_ajax_object.ajax_url, //using cors proxy since mailchimp does not support cors
        data: serializedDataInJson,
        beforeSend: function (request) {
            request.setRequestHeader("Authorization", "Bearer " + mcsd_ajax_object.api_key);
			window.mcsd_submit_btn.children("i").show(); //show loading icon on button when submitting
        },
		complete: function (data) {
      		window.mcsd_submit_btn.children("i").hide(); //hide loading icon after submission complete
     	},
        cache: false,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        error: function (err) { 
			switch(err.status){
				case 400:
					if(err.responseJSON.title=="Member Exists" && window.mcsd_dlink){ //download pdf for person if already a member
						showSuccessResponseInUi();
						downloadFile(window.mcsd_dlink);//begin download if download link is set
					}else{
						showErrorResponseInUi(err.responseJSON.detail);
					}
						
					jQuery("#mcsd_form_" + window.mcsd_foorm_id).find("input[type=text], select").val("");	
					break;
				default:
					showErrorResponseInUi();	
					break;
					
			}
		},
        success: function (data) {
            if (data.status != "subscribed") {
                // Something went wrong, do something to notify the user.
                showErrorResponseInUi();
            } else {
                // It worked, carry on...
   					showSuccessResponseInUi();
					downloadFile(window.mcsd_dlink);
					jQuery("#mcsd_form_" + window.mcsd_foorm_id).find("input[type=text], select").val("");	
            }
        }
    });

}

function jQFormSerializeArrToJson(formSerializeArr) { //function to convert serialized form data to json object
    var jsonObj = {};
    jQuery.map(formSerializeArr, function (n, i) {
        jsonObj[n.name] = n.value;
    });

    return jsonObj;
}

function downloadFile(fileLink){ //function to download file using ajax
	jQuery.ajax({
        url: fileLink,
        method: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = Date.now()+'.pdf'; //get current datetime value and use as your pdf name
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        }
    });
}

function showSuccessResponseInUi(){
	 if(window.succtc){//if success text color is set, use it
	 	window.mcsd_response_div.css('color', window.succtc);
	 }
	 window.mcsd_response_div.text("Thank you. Your download will begin shortly!"); 
}

function showErrorResponseInUi(resp="Could not connect to the registration server. Please try again later."){
	 if(window.errtc){//if error text color is set, use error text color(errtc) for your feeback text
        window.mcsd_response_div.css('color',window.errtc);
	 }
	window.mcsd_response_div.text(resp);
}







