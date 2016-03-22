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
$counterpart_access = '';

if(isset(Yii::app()->user->user_role)){
              $user_rols = UserRole::model()->findByPk(Yii::app()->user->user_role);
              if($user_rols){
                //$access_level = json_decode($user_rols->counterparties_access_level);
               
                  $counterpart_create = 0;
                  $counterpart_edit = 0;
                  $counterpart_delete = 0;
                  //$counterpart_status_change = 0;
                  if(isset($user_rols->counterparties_access_level) && $user_rols->counterparties_access_level !== ''){
                    $counterpart_access = json_decode($user_rols->counterparties_access_level);
                  
                  $counterpart_create = $counterpart_access->create;
                  $counterpart_edit = $counterpart_access->edit;
                  $counterpart_delete = $counterpart_access->delete;
                  //$counterpart_status_change = $counterpart_access->status_change;
                  }
                }
}
$access_buttons = '';

if($counterpart_create == 1){$access_buttons .= '{ extend: "create", editor: editor }, ';}
if($counterpart_edit == 1){$access_buttons .= '{ extend: "edit",   editor: editor }, ';}
if($counterpart_delete == 1){$access_buttons .= ' { extend: "remove", editor: editor }, ';}
/*
if($counterpart_delete == 1){$access_buttons .= '{
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
<h1>Manage Benchmarks</h1>
    
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
                <th>Benchmark</th>
                <th>Client</th>
                <th>Portfolio</th>
            </tr>
        </thead>
        <!--
        <tfoot>
            <tr>
                <th>Benchmark</th>
                <th>Client</th>
                <th>Portfolio</th>
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
        ajax: 'benchmarks/benchmarks',
        table: "#example",
        fields: [ 
            {
                label: "Benchmark Name:",
                name: "benchmark_name",
                "attr": {"class": "form-control"}
            },            
            {
                label: "Client:",
                name: "benchmarks.client_id",
                type: "select",
                ipOpts: clientsLoader(),
                //className: 'full'
                "attr": {"class": "form-control"}
            },
            {
                label: "Portfolio:",
                name: "benchmarks.portfolio_id",
                type: "select",
                ipOpts: portfolioLoader(),
                "attr": {"class": "form-control"}
            },
        ]
    } );
	   
         
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
        ajax: "benchmarks/benchmarks",
        columns: [
            { data: "benchmark_name" },
            { data: "clients.client_name" },
            //{ data: "counterparties.portfolio" },
            { data: "portfolios.portfolio" },
            //{ data: "ledger.price", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
            //{ data: "benchmarks.contact_tel" },
            //{ data: "benchmarks.contact_mail" },
           // { data: "trade_status.trade_status", editField: "ledger.trade_status_id", className: 'editable'    },
            //{ data: "benchmarks.address" },
            
           
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
</script>