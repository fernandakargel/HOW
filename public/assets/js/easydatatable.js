/**
 * 
 */

//Configuração dos botões padrão
if(typeof dataTableButtons === 'undefined') {
	
	var dataTableButtons = [ {
	            text : '<span class="fa fa-plus"></span> Adicionar',
	            tag : 'button',
	            action : function(e, dt, node, config) {
	                EasyDataTable.btAdd(e, dt, node, config);
	            },
	            className : "btn-success",
	            enabled : true
	        }, {
	            text : '<span class="fa fa-edit"></span> Editar',
	            action : function(e, dt, node, config) {
	                EasyDataTable.btEdit(e, dt, node, config);
	            },
	            className : "btn-primary",
	            enabled : false
	            }, {
	                text : '<span class="fa fa-trash-o"></span> Excluir',
	                action : function(e, dt, node, config) {
	                    EasyDataTable.btDel(e, dt, node, config);
	                },
	                className : "btn-danger",
	                enabled : false
	            } ];
}



var EasyDataTable = {
    
//    PK or ky field
    pk : "id",
    
//    URL for add new
    addPath : window.location.href.replace('#', '').replace(/\/$/, "") + "/form", 
    
//    URL for edit
    editPath :  window.location.href.replace('#', '').replace(/\/$/, "") +"/form/",
    
//    URL for delete
    delPath :  window.location.href.replace('#', '').replace(/\/$/, "") +"/del/",
    
    
//     DataTables Object
    table : $(dataTable).DataTable( {
        select : true,
        "language" : {
        "url" : "./assets/js/lib/data-table/Portuguese.json"
        },
        "columnDefs": [{
        "defaultContent": "-",
        "targets": "_all"
        }],
        data: dataSet,
        columns: columns,
        dom : 'Bfrtip',
        
        buttons : dataTableButtons,
    } ),
    

//     Init object
    init : function() {
        
        EasyDataTable.table.on('select', function() {
            var selectedRows = EasyDataTable.table.rows({
                selected : true
            }).count();
            
            EasyDataTable.table.button(1).enable(selectedRows === 1);
            EasyDataTable.table.button(2).enable(selectedRows > 0);
        });
            
            EasyDataTable.table.on('deselect', function() {
                var selectedRows = EasyDataTable.table.rows({
                    selected : true
                }).count();
                
                EasyDataTable.table.button(1).enable(selectedRows === 1);
                EasyDataTable.table.button(2).enable(selectedRows > 0);
            });
    },
    
//    Ação do botão adicionar
    btAdd : function(e, dt, node, config) {
        window.location.href = EasyDataTable.addPath;
    },
  
//  Ação do botão editar    
    btEdit : function(e, dt, node, config) {
        
        var reg = dt.rows({
            selected : true
        }).data();
        
        window.location.href = EasyDataTable.editPath+reg[0][EasyDataTable.pk];
    },

//  Ação do botão excluir   
    btDel : function(e, dt, node, config) {
        
        var reg = dt.rows({
            selected : true
        }).data();
            
        var ids = {};
        $.each(reg, function(index, element) {
            ids[index] = element[EasyDataTable.pk];
        });
             
        if( confirm("Deseja realmente excluir esta informação?")){
            window.location.href = EasyDataTable.delPath+JSON.stringify(ids);
        }
    },
}