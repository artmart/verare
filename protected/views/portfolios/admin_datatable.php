<?php
$this->breadcrumbs=['Ledgers'=>['admin'], 'Manage'];

//$access_buttons = '{view} {update} {delete}';
$access_level = 5;
$access_buttons = '';
if(isset(Yii::app()->user->user_role)){
              $user_rols = UserRole::model()->findByPk(Yii::app()->user->user_role);
              if($user_rols){$access_level = $user_rols->ledger_access_level;}
}

switch ($access_level) {
    case 1:
    $this->menu=[
        	//array('label'=>'List Ledger', 'url'=>array('index')),
        	array('label'=>'Create Ledger', 'url'=>array('create')),
        ];
        break;
    case 2:
        $access_buttons = '{update}';
        break;
    case 3:
        $access_buttons = '{delete}';
        break;
    case 4:
        $access_buttons = '{view} {update} {delete}';
        $this->menu=[
        	//array('label'=>'List Ledger', 'url'=>array('index')),
        	array('label'=>'Create Ledger', 'url'=>array('create')),
        ];
        break;
} 


/*
$this->menu=[
	//array('label'=>'List Ledger', 'url'=>array('index')),
	array('label'=>'Create Ledger', 'url'=>array('create')),
];


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ledger-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<h1>Manage Portfolios</h1>

<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->
<?php

 //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array('model'=>$model,)); ?>
</div><!-- search-form -->

<?php 
/*
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ledger-grid',
    //'id'=>"example1",
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    //'htmlOptions'=>array('class'=>"table table-bordered table-hover"),
	'columns'=>array(
		//'id',
		'trade_date',
		'instrument_id',
		'portfolio_id',
		'nominal',
		'price',
		'created_by',
		//'created_at',
		'trade_status_id',
       /*
        array(
			'name' => 'trade_status_id',
            //'header' => 'trade_status_id',
			'type'=>'raw',
            //'template'=>'',
            'value'=>function($data){
				if($data->trade_status_id == 2){$access_buttons = '';}
                return $data->trade_status_id;
            },
			//'filter'=>CHtml::listData(Locations::model()->findAll(),'location_code', 'locations_name'),
            //'htmlOptions'=>array('width'=>'150px'),
			),
            *//*
		'confirmed_by',
		//'confirmed_at',
		'version_number',
		//'document_id',
		//'custody_account',
		//'custody_comment',
		//'account_number',
		//'is_current',
		
		[
			'class'=>'CButtonColumn',
            'template' => $access_buttons,
            'buttons'=>[
                        'update'=>['visible'=>'!($data->trade_status_id==2)'],
                        'delete'=>['visible'=>'!($data->trade_status_id==2)'],
                        'view'=>['visible'=>'!($data->trade_status_id==2)'],
                        ]  
            //'visible'=>'$data->trade_status_id!==2', 
		],
	),
)); 
*/
 $baseUrl = Yii::app()->theme->baseUrl;
?>

    <!--<link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/js/plugins/jQueryUI/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/js/plugins/jQueryUI/jquery.ui.datepicker.min.css">-->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css">
	<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.1.0/css/select.dataTables.min.css">-->
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

$(document).ready(function() {
    editor = new $.fn.dataTable.Editor( {
        ajax: 'portfolios/portfolios',
        table: "#example",
        fields: [  
            {
                label: "Portfolio:",
                name: "portfolio",
            },
            {
                label: "Description:",
                name: "description",
                type: "textarea"
            },           
            {
                label: "client:",
                name: "client_name",
                type: "select",
                ipOpts: clientLoader(),
            }, 
            {
                label: "Created At:",
                name: "created_at",
                type: "datetime"
            },
             {
                label: "Portfolio Type:",
                name: "portfolio_type",
                type: "select",
                ipOpts: portfoliotypeLoader(),
            },            
        ]
    } );
    
    $('#example').DataTable( {
        //dom: "Bfrtip",
        displayLength: 10,
        filter: true,
        paginate: true,
        sort: true,
        info: false,
        
        dom: '<"clear">&lt;<"clear">Bfrtip<"clear">', 
        //colVis: { exclude: [ 1 ] },
        //dom: 'C&gt;"clear"&lt;lfrtip"clear"Bfrtip',
        ajax: "portfolios/",
        columns: [
        /*
            { data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                return data.first_name+' '+data.last_name;
            } },
        */               
            { data: "id" },
            { data: "portfolio" },
            { data: "description" },
            { data: "client_name" },
            { data: "is_current" },
            //{ data: "ledger.price", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
            { data: "created_at" },
            { data: "portfolio_type" },            
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
    var path1 = '<?php echo Yii::app()->baseUrl.'/portfoliotypes/portfoliotypes'; ?>';
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

</script>
<!-- page script -->
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Portfolio Id</th>
                <th>Portfolio</th>
                <th>Description</th>
                <th>Client</th>
                <th>Is Current</th>
                <th>Created At</th>
                <th>Portfolio Type</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Portfolio Id</th>
                <th>Portfolio</th>
                <th>Description</th>
                <th>Client</th>
                <th>Is Current</th>
                <th>Created At</th>
                <th>Portfolio Type</th>
            </tr>
        </tfoot>
    </table>