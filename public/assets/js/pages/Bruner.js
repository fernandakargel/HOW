/**
 * 
 */

var urlservice = 'http://ws.pgestao';

BRNForm = {

	// Form settings
	formId : '',

	// Photo settings
	photoFieldID : '',
	callBackSubmit:'',
	photoPreview : '',
	photoB64Hiden : '',

	// Set photo preview and hidden base 64 image
	setPreview : function(input, preview, B64Hiden) {

		// Check if file exist
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				// check if div exist
				if ($(preview).length) {
					$(preview).attr('src', e.target.result);
				}
				// check if hidden field exist
				if ($(B64Hiden).length) {
					$(B64Hiden).val(e.target.result);
				}
			}

			reader.onerror = function(error) {
				console.log('Error: ', error);
			};

			reader.readAsDataURL(input.files[0]);
		}
	},

	setData : function(data) {

		var row = data;

		$.each(BRNForm.getFieldsType(), function(index, value) {
			
			if(value == "hidden" || value == "text" || value == "email" || value == "password")
				$(BRNForm.formId + " input[name='"+index+"']").val(row[index]);
			
			if(value == "radio") {
					field = $(BRNForm.formId +" input:radio[name="+index+"]");
					field.filter("[value="+row[index]+"]").prop('checked', true);
			}
			
			if(value == "checkbox") {
				field = $(BRNForm.formId +" input:checkbox[name="+index+"]");
				field.filter("[value="+row[index]+"]").prop('checked', true);
			}
			
			if( value == "select-one" ){
				var select = $(BRNForm.formId + ' select[name=\''+index+'\'] option[text="'+row[index]+'"]');
				
				if(select.hasClass("standardSelect")){
					$(BRNForm.formId + ' select[name=\''+index+'\']').trigger("chosen:updated");
				}

			}


		});
	},

	getFieldsType : function() {

		// Trata campos
		var form = $(BRNForm.formId).find(':input');
		var fields = {};

		$.map(form, function(n, i) {
			if (n.name)
				fields[n.name] = n.type;
		});

		return fields;
	},

	getData : function(name=false) {

		if(name)
			return $( BRNForm.formId + " input[name=\""+name+"\"]" ).val();
		
		
		// Trata campos
		var unindexed_array = $(BRNForm.formId).serializeArray();
		var fields = {};

		$.map(unindexed_array, function(n, i) {
			fields[n['name']] = n['value'];
		});

		return fields;
	},

	submit : function(data) {
		if(BRNForm.callBackSubmit)
			BRNForm.callBackSubmit(data);
		
	},

	reset : function() {
		$(BRNForm.formId)[0].reset();
	},

	init : function() {

		// photo preview
		$(BRNForm.photoFieldID).change(
				function() {
					BRNForm.setPreview(this, BRNForm.photoPreview,
							BRNForm.photoB64Hiden);
				});

		$(BRNForm.formId).submit(function(e) {
			e.preventDefault(); // Prevent the normal submission action
			BRNForm.submit(BRNForm.getData());
			return false; // don't submit
		});
		
		if(jQuery().chosen) {
			jQuery(".standardSelect").chosen({
				no_results_text : "Oops,não encontrado!",
				width : "100%"
			});
		}

	},

};

// Example starter JavaScript for disabling form submissions if there are
// invalid fields
(function() {
	'use strict';
	window.addEventListener('load', function() {
		// Fetch all the forms we want to apply custom Bootstrap validation
		// styles to
		var forms = document.getElementsByClassName('needs-validation');
		// Loop over them and prevent submission
		var validation = Array.prototype.filter.call(forms, function(form) {
			form.addEventListener('submit', function(event) {
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				}
				form.classList.add('was-validated');
			}, false);
		});
	}, false);
})();