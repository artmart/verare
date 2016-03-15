<style>
.datatable-scroll {
    overflow-x: auto;
    overflow-y: visible;
}

#example_length{
    float:left;
}
</style>
<?php
$this->breadcrumbs=['Counterparties'=>['admin'], 'Manage'];
$baseUrl = Yii::app()->theme->baseUrl;

//$access_level = 5;
$access_buttons = '';
$ledgar_access = '';
/*
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
*/
?>
<h1>Manage Counterparties</h1>
    
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
                <th>Counterparty</th>
                <th>Client</th>
                <th>Contact Person</th>
                <th>Contact Tel</th>
                <th>Contact Mail</th>
                <th>Address</th>
                <th>Document</th>
               <!-- <th>Is Current</th>-->
            </tr>
        </thead>
        <!--
        <tfoot>
            <tr>
                <th>name</th>
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



<script type="text/javascript" language="javascript" class="init">  
var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {

    editor = new $.fn.dataTable.Editor( {
        ajax: 'counterparties/counterparties',
        table: "#example",
        fields: [ 
            {
                label: "Counterparty:",
                name: "counterparties.name",
                "attr": {"class": "form-control"}
            },            
            {
                label: "Client:",
                name: "counterparties.client_id",
                type: "select",
                ipOpts: clientsLoader(),
                //className: 'full'
                "attr": {"class": "form-control"}
            },
            
            {
                label: "Contact Person:",
                name: "counterparties.contact_person",
                //type: "select",
                //ipOpts: portfolioLoader(),
                "attr": {"class": "form-control"}
            },
            
             {
                label: "Contact Tel:",
                name: "counterparties.contact_tel",
                "attr": {"class": "form-control"}
            }, {
                label: "Contact Mail:",
                name: "counterparties.contact_mail",
                "attr": {"class": "form-control"}
            }, 
            {
                label: "address:",
                name: "counterparties.address",
                type: "textarea",
                "attr": {"class": "form-control"}
            },
            {
                label: "Document:",
                name: "counterparties.file",
                type: "upload",              
                clearText: "Clear",
                noImageText: 'No Document',
                "attr": {"class": "form-control"}
            }
        ]
    } );
	
	
/*	
    editor2 = new $.fn.dataTable.Editor( {
        ajax: 'counterparties/counterparties',
        table: "#example",
        fields: [
            {
                label: "Trade Status:",
                name: "counterparties.trade_status_id",
                type: "select",
                ipOpts: tradestatusLoader(),
                //className: "form-control",
            }
        ]
    } );
*/
    //editor.hide('counterparties.trade_status_id');
    <?php /*if($ledger_status_change == 1) {?>
    $('#example').on( 'click', 'tbody td.editable', function (e){ 
		editor2.inline( this, { fieldName: 'counterparties.trade_status_id', onBlur: 'submit'});
	});
    


        
    <?php } */?>
        
   //editor.on( 'onInitEdit', function () {
   //editor.disable('ledger.trade_status_id');
   //} );
   
//  $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
//        $.fn.dataTable.table( {visible: true, api: true} ).columns.adjust();
//    } );
    
//$('#myTabs a').click(function (e) {
//  e.preventDefault()
//  $(this).tab('show')
//});
    
         
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
        bProcessing: true,
        sScrollX: "100%",
        sScrollXInner: "110%",
        bScrollCollapse: true,
        
        
        //colVis: { exclude: [ 1 ] },
        //dom: 'C&gt;"clear"&lt;lfrtip"clear"Bfrtip',
        ajax: "counterparties/counterparties",
        columns: [
            { data: "counterparties.name" },
            { data: "clients.client_name" },
            //{ data: "counterparties.portfolio" },
            { data: "counterparties.contact_person" },
            //{ data: "ledger.price", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
            { data: "counterparties.contact_tel" },
            { data: "counterparties.contact_mail" },
           // { data: "trade_status.trade_status", editField: "ledger.trade_status_id", className: 'editable'    },
            { data: "counterparties.address" },
            
            
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
        ],
        select: true,
    

        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor },
            <?php //echo $access_buttons; ?>
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

/*	
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
*/               


        $(tableTools.fnContainer()).appendTo('#example_wrapper .col-sm-6:eq(0)');
        
          table.buttons().container()
        .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
} );





  function SortByName(a, b){
    var aName = a.label.toLowerCase();
    var bName = b.label.toLowerCase();
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
  }

  function clientsLoader() {
    var instruments = [{'value': '0', 'label': '-- Select Client --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/clients/clients'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['client_name']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }
</script>