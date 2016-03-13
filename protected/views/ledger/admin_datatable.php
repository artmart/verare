<style>
.btnDeleteRow
{
display:none;
} 
</style>
<?php
$this->breadcrumbs=['Ledgers'=>['admin'], 'Manage'];
$baseUrl = Yii::app()->theme->baseUrl;

//$access_level = 5;
$access_buttons = '';
$ledgar_access = '';
if(isset(Yii::app()->user->user_role)){
              $user_rols = UserRole::model()->findByPk(Yii::app()->user->user_role);
              if($user_rols){
                //$access_level = json_decode($user_rols->ledger_access_level);
               
                  $ledger_create = 0;
                  $ledger_edit = 0;
                  $ledger_delete = 0;
                  $ledger_status_change = 0;
                  if(isset($user_rols->ledger_access_level) && $user_rols->ledger_access_level !== ''){
                    $ledgar_access = json_decode($user_rols->ledger_access_level);
                  
                  $ledger_create = $ledgar_access->create;
                  $ledger_edit = $ledgar_access->edit;
                  $ledger_delete = $ledgar_access->delete;
                  $ledger_status_change = $ledgar_access->status_change;
                  }
                }
}
$access_buttons = '';

if($ledger_create == 1){$access_buttons .= '{ extend: "create", editor: editor }, ';}
if($ledger_edit == 1){$access_buttons .= '{ extend: "edit",   editor: editor }, ';}
if($ledger_delete == 1){$access_buttons .= '{
                                                extend: "selectedSingle",
                                                text: "Delete",
                                                action: function ( e, dt, node, config ) {
                                                    editor
                                                        .edit( table.row( { selected: true } ).index(), false )
                                                        .set( "ledger.is_current", 0 )
                                                        .submit();
                                                }
                                            }, '; 
                                            }   
                                            
                                                                               
//if($ledger_edit == 1){$access_buttons .= '{ extend: "edit",   editor: editor }';}

/*
switch ($access_level) {
    case 1:
        $access_buttons = '{ extend: "create", editor: editor }';
        break;
    case 2:
        $access_buttons = '{ extend: "edit",   editor: editor }';
        break;
    case 3:
        $access_buttons = '{ extend: "remove", editor: editor }, 
                            {
                                extend: "selectedSingle",
                                text: "Delete",
                                action: function ( e, dt, node, config ) {
                                    editor
                                        .edit( table.row( { selected: true } ).index(), false )
                                        .set( "ledger.is_current", 0 )
                                        .submit();
                                }
                            },';
            
        break;
    case 4:
        $access_buttons = '{ extend: "create", editor: editor }, 
                           { extend: "edit",   editor: editor },
                           {
                                extend: "selectedSingle",
                                text: "Delete",
                                action: function ( e, dt, node, config ) {
                                    editor
                                        .edit( table.row( { selected: true } ).index(), false )
                                        .set( "ledger.is_current", 0 )
                                        .submit();
                                }
                            }';
        break;
} 
*/
?>
<h1>Manage Ledgers</h1>

    <!--<link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/js/plugins/jQueryUI/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/js/plugins/jQueryUI/jquery.ui.datepicker.min.css">-->
    
    <link rel="stylesheet" href="<?php echo $baseUrl;?>/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.1.0/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/editor_datatables/css/editor.dataTables.min.css">
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/editor_datatables/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/editor_datatables/css/buttons.dataTables.min.css"> -->  

    <!-- jQuery UI 1.10.3 
    <script src="<?php //echo $baseUrl;?>/js/plugins/jQueryUI/jquery-ui-1.10.3.min.js"></script>
    <script src="<?php //echo $baseUrl;?>/js/plugins/jQueryUI/jquery.ui.datepicker.min.js"></script>-->
    
	<!--<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>-->
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.1.0/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.1.0/js/dataTables.select.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/dataTables.editor.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/examples/resources/demo.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/examples/resources/editor-demo.js"></script>
    
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/dataTables.colVis.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/dataTables.buttons.min.js"></script>
    
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/buttons.html5.min.js"></script>
    
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/buttons.colVis.min.js"></script>
	
<script type="text/javascript" language="javascript" class="init">  
var editor; // use a global for the submit and return data rendering in the examples

(function($){
$(document).ready(function() {
    editor = new $.fn.dataTable.Editor( {
        ajax: 'ledger/ledger',
        table: "#example",
        fields: [             
            {
                label: "Instrument:",
                name: "ledger.instrument_id",
                type: "select",
                ipOpts: instrumentsLoader(),
                className: 'full'
            },
            {
                label: "Trade Date:",
                name: "ledger.trade_date",
                type: "datetime"
            },
            {
                label: "Portfolio:",
                name: "ledger.portfolio_id",
                type: "select",
                ipOpts: portfolioLoader(),
                className: "form-control",
            },
            
             {
                label: "Nominal:",
                name: "ledger.nominal"
            }, {
                label: "Price:",
                name: "ledger.price"
            }, 
             /*{
                label: "Created At:",
                name: "ledger.created_at",
                type: "datetime"
            },
            {
                label: "Created By:",
                name: "ledger.created_by",
                type: "select",
                ipOpts: userLoader(),
            },
            {
                label: "Confirmed At:",
                name: "ledger.confirmed_at",
                type: "datetime"
            },
             {
                label: "Confirmed By:",
                name: "ledger.confirmed_by",
                type: "select",
                ipOpts: userLoader(),
            },*/
            {
                label: "Note:",
                name: "ledger.note",
                type: "textarea"
            },
            
            
             {
                label: "is_current",
                name: "ledger.is_current",
                type: "hidden",
            },
            
            
            {
                label: "Trade Status:",
                name: "ledger.trade_status_id",
                type: "select",
                //type: "hidden",
                //type: "readonly",
                ipOpts: tradestatusLoader(),
                className: "form-control",
            },
            {
                label: "Document:",
                name: "ledger.file",
                type: "upload",
               // display: function ( file_id ) {
               //     return table.file( 'documents', file_id ).document_name;
              //  },
               //display: function ( val, row ) {
                //  return val && row.ledger.file ?
                //      row.ledger.file :
                //      'No confirmation';
               // }
              
                clearText: "Clear",
                noImageText: 'No Document'
            }
        ]
    } );
  
  
    
  
    editor.hide('ledger.trade_status_id');
    <?php //if($ledger_status_change == 1) {?>
    $('#example').on( 'click', 'tbody td.editable', function (e){ 
        //var buttons = table.buttons( ['.edit', '.delete'] );
        //var buttons = table.buttons( ['.edit', '.delete'] );
    if(table.cell( this ).data() === 'Pending'){
        editor.show('ledger.trade_status_id');
        editor.inline( this, { fieldName: 'ledger.trade_status_id', onBlur: 'submit'});
        
        //table.button( '.buttons-edit' ).enable();
        }else{
            editor.hide('ledger.trade_status_id');
            //table.button( '.buttons-edit' ).disable();
        }
        
        });
        
        


        
    <?php //}?>
        
   //editor.on( 'onInitEdit', function () {
   //editor.disable('ledger.trade_status_id');
   //} );
         
var table = $('#example').DataTable( {
        //dom: "Bfrtip",
        displayLength: 10,
        filter: true,
        paginate: true,
        sort: true,
        info: false,
        
        dom: '<"clear">&lt;<"clear">Bfrtip<"clear">', 
        //colVis: { exclude: [ 1 ] },
        //dom: 'C&gt;"clear"&lt;lfrtip"clear"Bfrtip',
        ajax: "ledger/ledger",
        columns: [
        /*
            { data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                return data.first_name+' '+data.last_name;
            } },
        */
            { data: "ledger.trade_date" },
            //{ data: "ledger.instrument_id" },
            { data: "instruments.instrument" },
            //{ data: "ledger.portfolio_id" },
            { data: "portfolios.portfolio" },
            { data: "ledger.nominal" },
            { data: "ledger.price", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
            { data: "ledger.created_at" },
            { data: "prof1.firstname" },
            { data: "prof2.firstname" },
            { data: "ledger.confirmed_at" },
            //{ data: "ledger.document_id" },
            { data: "trade_status.trade_status", editField: "ledger.trade_status_id", className: 'editable'    },
           // { data: "documents.file" },
            { data: "ledger.note" },
            
            
            {
                data: "documents",
                defaultContent: '',
                render: function(data, type, row) {
                    if(data.document_name){
                       return "<a href='../uploads/"+data.file +"."+data.extension+"' target='_Blank'>"+ data.file+"."+data.extension+"</a>";
                    }else{
                        return null;
                    }
                 // return data.document_name ? "<a href='../uploads/"+data.file +"."+data.extension+"' target='_Blank'>"+ data.file+"."+data.extension+"</a>": null; // data.file +"."+data.extension: null; // '<a href="/uploads/' + data.file +"."+data.extension '" onclick="window.open(this.href, \'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=1\'); return false;">' + data.document_name + '</a>' : null;
                
                
                }
              },
            
            
            /*
            {
                data: "ledger.document_id",
                render: function ( file_id ) {
                    return file_id ?
                        '<img src="'+table.file( 'documents', file_id ).web_path+'"/>' :
                        null;
                },
                defaultContent: "No Document",
                title: "Document"
            },
            */
            
        ],
        select: true,


        buttons: [
            /*{ extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor },*/
            <?php echo $access_buttons; ?>
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            { extend: 'colvis', collectionLayout: 'fixed two-column',},
            
        ],
                
    } ); 
    
      table.on( 'select', function ( e, dt, type, indexes ) {
		if ( type === 'row' ) {
			var data = table.cells(indexes,9).data(); // table.rows( indexes ).data().pluck( 'trade_status.trade_status' );
                        
			if( data[0] == 'Pending')
			{             
				table.button( '.buttons-edit' ).enable();
				table.button( '.buttons-selected-single' ).enable();
			}
			else
			{
				table.button( '.buttons-edit' ).disable();
				table.button( '.buttons-selected-single' ).disable();
			}
		}
	} );
               
         table.buttons().container()
        .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
} );

}(jQuery));



  function SortByName(a, b){
    var aName = a.label.toLowerCase();
    var bName = b.label.toLowerCase();
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
  }

  function instrumentsLoader() {
    var instruments = [{'value': '0', 'label': '-- Select instrument --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/instruments/instruments'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['instrument']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }
  
  function portfolioLoader() {
    var instruments = [{'value': '0', 'label': '-- Select Portfolio --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/portfolios/portfolios'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['portfolio']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }
  
  function userLoader(){
    var instruments = [{'value': '0', 'label': '-- Select User --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/users/users'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['user_id'],
                "label" : data[a]['firstname']+" "+data[a]['lastname']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }
  
  function tradestatusLoader(){
    var instruments = [{'value': '0', 'label': '-- Select Trade Status --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/tradestatus/tradestatus'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['trade_status']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }



</script>
<!-- page script    class="display"-->
<table id="example"  class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Trade Date</th>
                <th>Instrument</th>
                <th>Portfolio</th>
                <th>Nominal</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Created By</th>
                <th>Confirmed By</th>
                <th>Confirmed At</th>
                <th>Trade Status</th>
                <th>Note</th>
                <th>Document</th>
               <!-- <th>Is Current</th>-->
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Trade Date</th>
                <th>Instrument</th>
                <th>Portfolio</th>
                <th>Nominal</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Created By</th>
                <th>Confirmed By</th>
                <th>Confirmed At</th>
                <th>Trade Status</th>
                <th>Note</th>
                <th>Document</th>
                <!--<th>Is Current</th>-->
            </tr>
        </tfoot>
    </table>