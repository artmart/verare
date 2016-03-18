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
$this->breadcrumbs=['Users'=>['admin'], 'Manage'];
$baseUrl = Yii::app()->theme->baseUrl;
$baseUrl1 = Yii::app()->baseUrl;

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
<h1>Manage Users</h1>
    
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


<!--	<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">Add</button>-->

<table id="example"  class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Username</th>
                <th>E-mail</th>
                <th>Created</th>
                <th>Last Visit</th>
                <!--<th>Superuser</th>-->
                <th>Status</th>
                <th>User Role</th>
                <th>Default Portfolio</th>
                <th>Default Start Date</th>
                <th>Default End Date</th>
                <th>Client</th>
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

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h1 class="modal-title" id="myModalLabel">Velg vare</h1>
            </div>
            <div class="modal-body">
                
                <?php 
                $model = New User();
                //$this->renderPartial('/modules/user/views/admin/_form.php', array('model'=>$model)); 
                //$this->renderPartial('/user/admin/create', ['model'=>$model]);
                ?>
            
                <table class="display" id="PopupTable"></table>
 
                <input hidden id="No_" name="No_" readonly="readonly" style="width: 50px;" type="text" />
                <input hidden id="Description" name="Description" readonly="readonly" style="width: 100px;" type="text" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-lg" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <button id="buttonSave" type="button" class="btn btn-primary btn-lg" data-dismiss="modal" disabled onclick="CloseAndSave()"><span class=" glyphicon glyphicon-ok"></span></button>
            </div>
 
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript" class="init">  
var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {

    editor = new $.fn.dataTable.Editor( {
        ajax: 'users/users',
        table: "#example",
        fields: [ 
            {
                label: "Username:",
                name: "username",
                "attr": {"class": "form-control"}
            },  
            {
                label: "Password:",
                name: "password",
                "attr": {"class": "form-control"}
            }, 
            {
                label: "Email:",
                name: "email",
                "attr": {"class": "form-control"}
            },         
            {
                label: "User Role:",
                name: "user_role_id",
                type: "select",
                ipOpts: userroleLoader(),
                "attr": {"class": "form-control"}
            },
            {
                label: "Status:",
                name: "status",
                type: "select",
                ipOpts: statusLoader(),
                "attr": {"class": "form-control"}
            },
            {
                label: "Firstname:",
                name: "firstname",
                "attr": {"class": "form-control"}
            }, 
            {
                label: "Lastname:",
                name: "lastname",
                "attr": {"class": "form-control"}
            }, 
            
            /*
            
            {
                label: "Portfolio:",
                name: "portfolios.portfolio_id",
                type: "select",
                ipOpts: portfolioLoader(),
                "attr": {"class": "form-control"}
            },
            */
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
        //bProcessing: true,
        sScrollX: "100%",
        sScrollXInner: "110%",
        bScrollCollapse: true,
        
        
        //colVis: { exclude: [ 1 ] },
        //dom: 'C&gt;"clear"&lt;lfrtip"clear"Bfrtip',
        ajax: "users/users",
        columns: [
            { data: "id" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "username" },
            { data: "email"},
            { data: "create_at" },
            { data: "lastvisit_at" },
            //{ data: "superuser", editField: "ledger.trade_status_id", className: 'editable'    },
            //{ data: "superuser" },
            { data: "status",
             //   render: function(data, type, row) {
              //      return data.users.status == '1' ? 'Active' : 'Inactive';
                  //if(data.users.status == '1') {return 'Active';}
                  //if(data.users.status == '0') {return 'Inactive';}
                  //if(data.users.status == '-1') {return 'Banned';}
             //   }
             },
            { data: "user_role" },
            { data: "portfolio" },
            { data: "default_start_date" },
            { data: "default_end_date" },
            { data: "client_name" },           
        ],
        select: true,
    

        buttons: [
        
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            //{ extend: "remove", editor: editor },
        
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


/*
Field::inst( 'profiles.user_id as user_id' ),
Field::inst( 'profiles.firstname as firstname' ),
Field::inst( 'profiles.lastname as lastname' ),
Field::inst( 'users.id as id' ),
Field::inst( 'users.username as username' ),
Field::inst( 'users.password as password' ),
Field::inst( 'users.email as email' ),
Field::inst( 'users.create_at as create_at' ),
Field::inst( 'users.lastvisit_at as lastvisit_at' ),
Field::inst( 'users.superuser as superuser' ),
Field::inst( 'users.status as status' ),
Field::inst( 'users.user_role as user_role' ),
Field::inst( 'users.default_portfolio_id as default_portfolio_id' ),
Field::inst( 'users.default_start_date as default_start_date' ),
Field::inst( 'users.default_end_date as default_end_date' ),
Field::inst( 'users.client_id as client_id' )
*/



  function SortByName(a, b){
    var aName = a.label.toLowerCase();
    var bName = b.label.toLowerCase();
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
  }

  function userroleLoader() {
    var instruments = [{'value': '0', 'label': '-- Select User Role --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/userrole/userrole'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['user_role']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }
  
    function statusLoader() {
    //var instruments = [{'value': '0', 'label': '-- Select User Role --'}];
    var instruments = [{'value': '0', 'label': 'Inactive'}];
    instruments.push({'value': '1', 'label': 'Active'});
    //instruments.push({'value': '0', 'label': 'Inactive'});
    instruments.push({'value': '-1', 'label': 'Banned'});

    /*
    var path1 = '<?php //echo Yii::app()->baseUrl.'/userrole/userrole'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['user_role']
              };
              instruments.push(obj);
            }
        }
    });
    */
    return instruments.sort(SortByName);
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