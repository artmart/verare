<?php
$this->breadcrumbs=['Users'=>['admin'], 'Manage'];
$baseUrl = Yii::app()->theme->baseUrl;
$baseUrl1 = Yii::app()->baseUrl;


//var_dump(Yii::app()->user->getState('user_role_id'));
//$access_level = 5;
/*
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
                <!--<th>ID</th>-->
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


<script type="text/javascript" language="javascript" class="init">  
var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {

    editor = new $.fn.dataTable.Editor( {
        ajax: 'users/users',
        table: "#example",
        fields: [ 
             {
                label: "id",
                name: "id",
                type: "hidden"
            },
            {
                label: "Username:",
                name: "username",
                "attr": {"class": "form-control"}
            },  
            {
                label: "Password:",
                name: "password",
                "type": "password",
                "attr": {"class": "form-control"}
            }, 
            {
                label: "Email:",
                name: "email",
                "attr": {"class": "form-control"}
            },         
            {
                label: "User Role:",
                name: "users.user_role",
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
            {
                label: "Client:",
                name: "users.client_id",
                type: "select",
                ipOpts: clientsLoader(),
                "attr": {"class": "form-control"}
            },
            {
                "label": "Portfolios",
                "name": "accessable_portfolios",
                "type": "checkbox",
                "separator": ",",
                ipOpts: portfoliosloader(),
            },
            /*
            {
                label: "Default Portfolio:",
                name: "default_portfolio_id",
                type: "select",
                ipOpts: portfoliosloader(),
                "attr": {"class": "form-control"}
            },            
            {
                label: "Start Date:",
                name: "default_start_date",
                type: "datetime",
                "attr": {"class": "form-control"}
            },
            {
                label: "End Date:",
                name: "default_end_date",
                type: "datetime",
                "attr": {"class": "form-control"}
            },
            */
            
        ]
    } );
// "<a href='../uploads/"+data.file +"."+data.extension+"' target='_Blank'>"+ data.file+"."+data.extension+"</a>";
                       
                       	   
         
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
            //{ data: "id" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "username" },
            //{ data: "email"},
            
            {
                data: "email",
                defaultContent: "",
                render: function(data, type, row) {
                    if(data){
                       return "<a href='mailto:"+data+"?Subject='Hello again' target='_top'>"+data+"</a>";
                    }else{
                        return null;
                    }
                }
              },
            
            { data: "create_at" },
            { data: "lastvisit_at" },
            //{ data: "superuser", editField: "ledger.trade_status_id", className: 'editable'    },
            //{ data: "superuser" },
            { data: "status",
                render: function(data, type, row) {
                  if(data == '1') {return 'Active';}
                  if(data == '0') {return 'Inactive';}
                  if(data == '-1') {return 'Banned';}
                }
             },
            { data: "user_role_name" },
            { data: "portfolio" },
            { data: "default_start_date" },
            { data: "default_end_date" },
            { data: "clients.client_name" },           
        ],
        select: true,
    

        buttons: [
        
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            //{ extend: "remove", editor: editor },
            
            {
                extend: "selectedSingle",
                text: "Delete",
                action: function ( e, dt, node, config ) {
                    editor
                        .edit( table.row( { selected: true } ).index(), false )
                        .set( "status", 0 )
                        .submit();
                }
            },
        
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
  
    function userroleLoader() {
    var instruments = [{'value': '0', 'label': '-- Select User Role --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/userRole/userrole'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['user_role_id'],
                "label" : data[a]['user_role_name1']
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
  
  
    function portfoliosloader() {
    var instruments = [];// = [{'value': '0', 'label': '-- Select Portfolio --'}];
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