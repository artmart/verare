<?php
$this->breadcrumbs=['Ledgers'=>['admin'], 'Manage'];
$baseUrl = Yii::app()->theme->baseUrl;

   // foreach(Yii::app()->user->getFlashes() as $key => $message) {
    //    echo '<div class="alert alert-info span5"><div class="flash-' . $key . '">' . $message . "</div></div>\n";
   // }

//var_dump(Yii::app()->user->getState('user_role_id'));
//exit;

$id = Yii::app()->user->id;
$user_data = Users::model()->findByPk($id); 

$user_role_id = $user_data->user_role; // Yii::app()->user->getState('user_role');


//$access_level = 5;
$access_buttons = '';
$ledgar_access = '';
if($user_role_id>0){
              $user_rols = UserRole::model()->findByPk($user_role_id);
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
?>
<h1>Manage Ledgers</h1>
  
  <div id="recalculate_status"><strong>Last Returns Recalculation: </strong>
     <?php $client = Clients::model()->findByPk($user_data->client_id);
        echo $client->last_recalculation;
     ?>
  </div>
   
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- page script    class="display"-->
            <table id="example"  class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
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
                            <th>Currency</th>
                            <th>Note</th>
                            <th>Trade Code</th>
                            <th>Amount</th>
                            <th>Document</th>
                           <!-- <th>Is Current</th>-->
                        </tr>
                    </thead>
                    <!--
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
                           <th>Is Current</th>
                        </tr>
                    </tfoot>-->
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo Yii::app()->theme->baseUrl;?>/img/demo_wait.gif' width="64" height="64" /><br />Loading..</div>

<?php 
      $confirmed_at = date("Y-m-d h:i:sa");
      $confirmed_by = Yii::app()->user->id;
?>

<script type="text/javascript" language="javascript" class="init">  
var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {

    editor = new $.fn.dataTable.Editor( {
        ajax: 'ledger/ledger',
        table: "#example",
        fields: [             
            {
                label: "Instrument:",
                name: "ledger.instrument_id",
                type: "select",
                //multiple: true,
                ipOpts: instrumentsLoader(),
                //className: 'full'
                "attr": {"class": "form-control"}
            },
            {
                label: "Trade Date:",
                name: "ledger.trade_date",
                type: "datetime",
                "attr": {"class": "form-control"}
            },
            {
                label: "Portfolio:",
                name: "ledger.portfolio_id",
                type: "select",
                ipOpts: portfolioLoader(),
                "attr": {"class": "form-control"}
            },
            
             {
                label: "Nominal:",
                name: "ledger.nominal",
                "attr": {"class": "form-control"}
            }, 
            {
                label: "Price:",
                name: "ledger.price",
                "attr": {"class": "form-control"}
            },
            {
                label: "Currency:",
                name: "ledger.currency",
                type: "select",
                ipOpts: currencyLoader(),
                "attr": {"class": "form-control"}
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
                type: "hidden",
                def: "<?php //echo $confirmed_at;?>"
            },
             {
                label: "Confirmed By:",
                name: "ledger.confirmed_by",
                type: "hidden",
                def: "<?php //echo $confirmed_by;?>"
            },*/
            {
                label: "Note:",
                name: "ledger.note",
                type: "textarea",
                "attr": {"class": "form-control"}
            },
            
            
             {
                label: "is_current",
                name: "ledger.is_current",
                type: "hidden",
                "attr": {"class": "form-control"}
            },
            /*
            {
                label: "document_type_id",
                name: "documents.document_type_id",
                type: "hidden",
                def: 1
            },
            */
            {
                label: "Trade Status:",
                name: "ledger.trade_status_id",
                type: "select",
                //type: "hidden",
                //type: "readonly",
                ipOpts: tradestatusLoader(),
                "attr": {"class": "form-control"}
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
                noImageText: 'No Document',
                "attr": {"class": "form-control"}
            }
        ]
    } );
	
    editor2 = new $.fn.dataTable.Editor( {
        ajax: 'ledger/ledger',
        table: "#example",
        fields: [
            {
                label: "Trade Status:",
                name: "ledger.trade_status_id",
                type: "select",
                ipOpts: tradestatusLoader(),
                //className: "form-control",
            }
        ]
    } );

    editor.hide('ledger.trade_status_id');
    <?php if($ledger_status_change == 1) {?>
    $('#example').on( 'click', 'tbody td.editable', function (e){ 
		editor2.inline( this, { fieldName: 'ledger.trade_status_id', onBlur: 'submit'});
	});
    
editor.on('submitSuccess', function(e, json, data) {
        var user_role = <?php echo $user_data->user_role; ?>;
        var step_completed = <?php echo $user_data->step_completed; ?>;
        if( user_role == 2 && step_completed < 5){window.location = "<?php echo Yii::app()->baseUrl;?>/site/admin";}
        });

        
    <?php }?>
    
         
var table = $('#example').DataTable( {
    
        renderer: "bootstrap",
        //dom: '<"clear">&lt;<"clear">Bfrtip<"clear">',
        //"Dom": '<"H"lfr>t<"F"ip>' ,
        //sDom: 'lfrtip',
        
        dom: 'lBfrtip',
        displayLength: 10,
        filter: true,
        paginate: true,
        sort:true,
        //bsort: true,
        //'bSortable' : true,
        info: false,
        //scrollX: '100%',
        //scrollCollapse: true,
        //paging:         false,
        //"bPaginate": true,
        //"bSort": true,
        //"bFilter": false,
        bJQueryUI: false,
        bProcessing: false,
        sScrollX: "100%",
        sScrollXInner: "110%",
        bScrollCollapse: true,
        
        
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
            { data: "ledger.price" },
            //{ data: "ledger.price", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
            { data: "ledger.created_at" },
            { data: "prof1.firstname" },
            { data: "prof2.firstname" },
            { data: "ledger.confirmed_at" },
            //{ data: "ledger.document_id" },
            { data: "trade_status.trade_status", editField: "ledger.trade_status_id", className: 'editable'    },
            { data: "ledger.currency" },
           // { data: "documents.file" },
            { data: "ledger.note" },
            { data: "trade_code" },
            {
                data: null,
                render: function(data, type, row) {
                  return data.ledger.price * data.ledger.nominal;
                }
            },
            {
                data: "documents",
                defaultContent: '',
                render: function(data, type, row) {
                    if(data.document_name){
                       return "<a href='../uploads/"+data.file +"."+data.extension+"' target='_Blank'>"+ data.file+"."+data.extension+"</a>";
                    }else{
                        return null;
                    }
                 }
              },            
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
            {
                text: 'Recalculate Returns',
                action: function ( e, dt, node, config ) {
                    //alert( dt );
                    $("#wait").css("display", "block");
                    $.ajax({
            			type: 'post',
            			url: '<?php echo Yii::app()->baseUrl;?>/portfolioReturns/recalculateReturns',
            			data: {
            			// app_id: '<?php //echo $app_id;?>', 
            			},
            			success: function (response) {
            			     $( '#recalculate_status' ).html(response);
                             $("#wait").css("display", "none");
            			}
            		   }); 
                }
            },
            
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

} );


  function SortByName(a, b){
    var aName = a.label.toLowerCase();
    var bName = b.label.toLowerCase();
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
  }

  function instrumentsLoader() {
    var instruments = [{'value': '0', 'label': '-- Select instrument --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/instruments/instrumentswithprices'; ?>';
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
    var path1 = '<?php echo Yii::app()->baseUrl.'/tradeStatus/tradestatus'; ?>';
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
  
  function currencyLoader(){
    var instruments = [{'value': '0', 'label': '-- Select Currency --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/currencies/currencies'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['currency'],
                "label" : data[a]['currency']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }
  
</script>
