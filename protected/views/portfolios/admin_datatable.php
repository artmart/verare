<?php
$this->breadcrumbs=['Ledgers'=>['admin'], 'Manage'];

$id = Yii::app()->user->id;
$user_data = Users::model()->findByPk($id); 
$client_id = $user_data->client_id;

//$access_buttons = '{view} {update} {delete}';
//$access_level = 5;
//$access_buttons = '';
//if(isset(Yii::app()->user->user_role)){
              //$user_rols = UserRole::model()->findByPk(Yii::app()->user->user_role);
              //if($user_rols){$access_level = $user_rols->ledger_access_level;}
//}
?>

<h1>Manage Portfolios</h1>

<?php

 //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array('model'=>$model,)); ?>
</div><!-- search-form -->

<?php 

 $baseUrl = Yii::app()->theme->baseUrl;
?>

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
                                <th>Portfolio Id</th>
                                <th>Parrent Portfolio</th>
                                <th>Portfolio</th>
                                <th>Description</th>
                                <th>Client</th>
                                <th>Is Current</th>
                                <th>Created At</th>
                                <th>Benchmark</th>
                                <th>Allocation Min</th>
                                <th>Allocation Max</th>
                                <th>Allocation Normal</th>
                                <!--<th>Portfolio Type</th>-->
                            </tr>
                        </thead>
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
//var parrent_ports;// = portfolioLoader();
$(document).ready(function() {
    editor = new $.fn.dataTable.Editor( {
        ajax: 'portfolios/portfolios',
        table: "#example",
        fields: [ 
            {
                label: "Parrent Portfolio:",
                name: "parrent_portfolio",
                id: "parrent_portfolio",
                type: "select",
                options: portfolioLoader(),
                //ipOpts: portfolioLoader(),
                "attr": {"class": "form-control"}
            },         
            {
                label: "Portfolio:",
                name: "portfolio",
                "attr": {"class": "form-control"}
            },
            {
                label: "Description:",
                name: "description",
                type: "textarea",
                "attr": {"class": "form-control"}
            },
            
            <?php if($user_data->user_role==1){ ?>       
            {
                label: "Client:",
                name: "client_id",
                type: "select",
                ipOpts: clientLoader(),
                "attr": {"class": "form-control"}
            }, 
            
            <?php }else{ ?>
            
            {
                label: "Client:",
                name: "client_id",
                type: "hidden",
                def: "<?php echo $client_id;?>"
            },
            
            <?php } ?>
            
            {
                label: "Created At:",
                name: "created_at",
                type: "datetime",
                "attr": {"class": "form-control"}
            },
            
            {
                label: "Benchmark:",
                name: "benchmark_id",
                type: "select",
                ipOpts: benchmarksLoader(),
                "attr": {"class": "form-control"}
            },
            {
                label: "Allocation Min:",
                name: "allocation_min",
                "attr": {"class": "form-control"}
            },
            {
                label: "Allocation Max:",
                name: "allocation_max",
                "attr": {"class": "form-control"}
            },
            {
                label: "Allocation Normal:",
                name: "allocation_normal",
                "attr": {"class": "form-control"}
            },
            /*
             {
                label: "Portfolio Type:",
                name: "type_id",
                type: "select",
                ipOpts: portfoliotypeLoader(),
                "attr": {"class": "form-control"}
            }, 
            */           
        ]
    } );
    
    
    editor.on('submitSuccess', function(e, json, data) {
        var user_role = <?php echo $user_data->user_role; ?>;
        var step_completed = <?php echo $user_data->step_completed; ?>;
        if( user_role == 2 && step_completed < 4){
            
        window.location = "<?php echo Yii::app()->baseUrl;?>/site/admin";
        }else{
            window.location = "<?php echo Yii::app()->baseUrl;?>/portfolios/admin";
        }
        });
    
        
   var table =  $('#example').DataTable( {
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
        ajax: "portfolios/portfolios",
        columns: [
        /*
            { data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                return data.first_name+' '+data.last_name;
            } },
        */               
            { data: "id" },
            { data: "parrent_portfolio1" },
            { data: "portfolio" },
            { data: "description" },
            { data: "client_name" },
            { data: "is_current" },
            //{ data: "ledger.price", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
            { data: "created_at" },
            { data: "benchmark_name" },
            { data: "allocation_min" },
            { data: "allocation_max" },
            { data: "allocation_normal" },
            //{ data: "portfolio_type" },         
                       
        ],
        select: true,
        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor },
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
            
        ]
    } );
    

} );

  function SortByName(a, b){
    var aName = a.label.toLowerCase();
    var bName = b.label.toLowerCase();
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
  }

  function clientLoader() {
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
  
  function portfoliotypeLoader() {
    var instruments = [{'value': '0', 'label': '-- Select Portfolio Type --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/portfolioTypes/portfoliotypes'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['portfolio_type']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }
  
  function iscurrentLoader(){
    var instruments = [{'value': '0', 'label': 'No'}];

    return instruments.sort(SortByName);
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
 

 
 
 //DTE_Field_parrent_portfolio 
  
 $('#parrent_portfolio').change(function() {
table.ajax.reload();
} );       



//$('#parrent_portfolio').on('click', function() {
//  var parrent_ports;  
    $("body").on("click", "#parrent_portfolio", function(){
    //alert('aaa');
    /*
    var parrent_ports = [{'value': '0', 'label': '-- Select Parrent Portfolio --'}];
    var path1 = '<?php //echo Yii::app()->baseUrl.'/portfolios/portfolios'; ?>';
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
              parrent_ports.push(obj);
            }
            
            
        }
    });
    */
    //var aaaa  = portfolioLoader();
   // $("#parrent_portfolio").html(aaaa);
    //return parrent_ports.sort(SortByName);
//return  portfolioLoader();
      //document.getElementById("parrent_portfolio").innerHTML = parrent_ports.sort(SortByName);   
    // portfolioLoader();   
     table.ajax.reload();
    });
    
    
 /*   
editor.on('onInitCreate onInitEdit', function () {
editor.field('parrent_portfolio').update(
portfolioLoader()
);
} );
 */ 
    function portfolioLoader() {
    var instruments = [{'value': '0', 'label': '-- Select Parrent Portfolio --'}];
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
