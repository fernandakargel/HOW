/**
 * 
 */
$(document).ready(function() {

	var table = $('#-table').DataTable({
		select : true,
		"language" : {
			"url" : "../assets/js/lib/data-table/Portuguese.json"
		},
		"ajax" : "http://app.pgestao/",
		"columns" : [ {
			"data" : "name"
		}, {
			"data" : "gender"
		}, {
			"data" : "role"
		}, {
			"data" : "department"
		} ],

		dom : 'Bfrtip',

		buttons : [ {
			text : '<span class="fa fa-plus"></span> Adicionar',
			tag : 'button',
			action : function(e, dt, node, config) {
				Page.btAdd(e, dt, node, config);
			},
			className : "btn-success",
			enabled : true
		}, {
			text : '<span class="fa fa-edit"></span> Editar',
			action : function(e, dt, node, config) {
				Page.btEdit(e, dt, node, config);
			},
			className : "btn-primary",
			enabled : false
		}, {
			text : '<span class="fa fa-trash-o"></span> Excluir',
			action : function(e, dt, node, config) {
				Page.btDel(e, dt, node, config);
			},
			className : "btn-danger",
			enabled : false
		} ]

	});

	Page.table = table;
	Page.init();

});

var Page = {

	// DataTables Object
	table : "",

	// Edit button
	btEdit : function(e, dt, node, config) {
		node.attr("data-toggle", "modal");
		node.attr("data-target", "#addmodal");

		var reg = dt.row({
			selected : true
		}).data();

		BRNForm.formId = "#frmAdd";
		BRNForm.photoFieldID = "#photo-file";
		BRNForm.photoPreview = "#photo-view";
		BRNForm.photoB64Hiden = "#photo";
		Page.selects();
		BRNForm.setData(reg);
		BRNForm.init();
		$(BRNForm.formId + " #photo-view").attr("src",$(BRNForm.formId + " #photo").val());
		
	},

	// Add butoo
	btAdd : function(e, dt, node, config) {
		node.attr("data-toggle", "modal");
		node.attr("data-target", "#addmodal");

		BRNForm.formId = "#frmAdd";
		BRNForm.photoFieldID = "#photo-file";
		BRNForm.photoPreview = "#photo-view";
		BRNForm.photoB64Hiden = "#photo";
		Page.selects();
		BRNForm.reset();
		BRNForm.init();
	},

	// Delete button
	btDel : function(e, dt, node, config) {
		var selectedRows = Page.table.rows({
			selected : true
		}).count();

		var reg = dt.rows({
			selected : true
		}).data();

		var ids = {};
		$("#dellmodal #dellist li").remove();
		$.each(reg, function(index, element) {
			ids[index] = element.id;
			$("#dellmodal #dellist").append("<li>"+element.name+" - "+element.role+"</li>");
		});
		
		node.attr("data-toggle", "modal");
		node.attr("data-target", "#dellmodal");

	},
	
	
	selects : function() {
		Page.selectDepartment();
	},

	selectDepartment : function() {
		$.ajax({
			type : 'GET',
			url : "http://app.pgestao/department.php",
			data : {
				get_param : 'data'
			},
			dataType : 'json',
			success : function(data) {
				$.each(data, function(index, element) {
					
					var department = $(BRNForm.formId + " select[name=\"department\"]");

					department
					    .find('option')
					    .remove()
					    .end()
					    .append('<option value="0">Selecione o departamento...</option>')
					    .val('whatever')
					;
					
					$.each(element, function(index, element) {
						if ($(BRNForm.formId + " select[name=\"department\"] option[value='"
								+ element.name + "']").length < 1) {
							$(BRNForm.formId + " select[name=\"department\"]").append(
									$('<option>', {
										value : element.id,
										text : element.name
									}));
						}
						
						$(BRNForm.formId 	+ " select[name=\"department\"]").trigger("chosen:updated");
						
					});
				});
			}
		});
		
		
		$(BRNForm.formId + " select[name=\"department\"]").on('change', function() {
			Page.selectRole();
		})
	},
	
	selectRole : function(department = false) {
		
		if(department === false)
		    var department = $(BRNForm.formId + " select[name=\"department\"]").find(":selected").val();
		
		$.ajax({
			type : 'GET',
			url : "http://app.pgestao/role.php?department="+department,
			data : {
				get_param : 'data'
			},
			dataType : 'json',
			success : function(data) {
				$.each(data, function(index, element) {
					
					$(BRNForm.formId + " select[name=\"role\"]")
					    .find('option')
					    .remove()
					    .end()
					    .append('<option value="0">Selecione a função...</option>')
					    .val('whatever')
					;

					$.each(element, function(index, element) {
						if ($(BRNForm.formId + " select[name=\"role\"] option[value='"
								+ element.name + "']").length < 1) {
							$(BRNForm.formId + " select[name=\"role\"]").append(
									$('<option>', {
										value : element.id,
										text : element.name
									}));
						}
						
						$(BRNForm.formId + " select[name=\"role\"]").trigger("chosen:updated");
						
					});
				});
			}
		});				
	},
	

	// Init object
	init : function() {

		Page.table.on('select', function() {
			var selectedRows = Page.table.rows({
				selected : true
			}).count();

			Page.table.button(1).enable(selectedRows === 1);
			Page.table.button(2).enable(selectedRows > 0);
		});

		Page.table.on('deselect', function() {
			var selectedRows = Page.table.rows({
				selected : true
			}).count();

			Page.table.button(1).enable(selectedRows === 1);
			Page.table.button(2).enable(selectedRows > 0);
		});
	}
}