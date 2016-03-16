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
/*
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
*/
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
<h1>Manage Benchmark Components</h1>
    
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
                <th>Instrument</th>
                <!--<th>Is Instrument or Portfolio</th>-->
                <th>Weight</th>
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
        ajax: 'benchmarkcomponents/benchmarkcomponents',
        table: "#example",
        fields: [ 
            {
                label: "Benchmark:",
                name: "benchmark_components.benchmark_id",
                type: "select",
                ipOpts: benchmarksLoader(),
                "attr": {"class": "form-control"}
            },            
            {
                label: "Instrument:",
                name: "benchmark_components.instrument_id",
                type: "select",
                ipOpts: instrumentsLoader(),
                //className: 'full'
                "attr": {"class": "form-control"}
            },
         
         /*   {
                label: "Is Instrument or Portfolio:",
                name: "benchmark_components.is_instrument_or_portfolio",
                //type: "select",
                //ipOpts: portfolioLoader(),
                "attr": {"class": "form-control"}
            },
          */
            {
                label: "Weight:",
                name: "benchmark_components.weight",
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
        ajax: "benchmarkcomponents/benchmarkcomponents",
        columns: [
            { data: "benchmarks.benchmark_name" },
            { data: "instruments.instrument" },
            //{ data: "benchmark_components.is_instrument_or_portfolio" },
           /* { data: "benchmark_components.is_instrument_or_portfolio", render: function ( data, type, row ) {
                if(data.is_instrument_or_portfolio === '0'){return 'Yes';}else{return 'No';}
                //return data.first_name+' '+data.last_name;
                }
            },*/
            { data: "benchmark_components.weight" },     
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

  function benchmarksLoader() {
    var benchmarks = [{'value': '0', 'label': '-- Select Benchmark --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/benchmarks/benchmarks'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['benchmark_name']
              };
              benchmarks.push(obj);
            }
        }
    });
    return benchmarks.sort(SortByName);
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
</script>