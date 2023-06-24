/**
 * 
 */

$(document)
		.ready(
				function() {
					$('.alert').hide();
					BRNForm.formId = "#frmLogin";
					BRNForm.callBackSubmit = function(data) {

						console.log(data);

						if (data["remember"] > 0) {
							Cookies.set('apppg.log', {
								mail : data["mail"],
								remember : 1
							});
						}

						if (!data["remember"]) {
							Cookies.remove('apppg.log');
						}

						if (data["mail"] != "" && data["password"] != "") {
							$
									.ajax({
										url : urlservice + "/system/login",
										method : "POST",
										data : data,
										statusCode : {
											401 : function(response) {
												$('.alert').show();
											},
											404 : function(response) {
												$('.alert #msg')
														.text(
																"[404] Serviço indisponível, tente mais tarde.");
												$('.alert').show();
											},
											500 : function(response) {
												$('.alert #msg')
														.text(
																"[500] Serviço indisponível, tente mais tarde.");
												$('.alert').show();
											}
										},
										success : function(response) {
											$('.alert').hide();
											if (response.data == "") {
												$('.alert #msg')
														.text(
																"[***] Serviço indisponível, tente mais tarde.");
												$('.alert').show();
												return false;
											}

											data = response.data;
											console.log(data);

											if (data.status == 0) {
												$('.alert #msg')
														.text(
																"[#00] Conta temporáriamente bloqueada.");
												$('.alert').show();
												return false;
											}

											if (data.status == 2) {
												$('.alert #msg')
														.text(
																"[#02] Verifique seu e-mail e valide sua conta.");
												$('.alert').show();
												return false;
											}

											if (data.status == 3) {
												$('.alert #msg')
														.text(
																"[#03] Sua conta expirou, contacte o gestor do serviço em sua empresa.");
												$('.alert').show();
												return false;
											}

											Cookies.set('apppg.usr', data);

											window.location
													.replace("index.html");
										},
									});

						}
					};

					if (Cookies.getJSON("apppg.log"))
						BRNForm.setData(Cookies.getJSON("apppg.log"));

					BRNForm.init();

				});
