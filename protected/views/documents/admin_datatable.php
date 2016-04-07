<?php 
    $this->breadcrumbs=['Documents'=>['admin'], 'Manage']; 
    
    $user = Users::model()->findByPk(Yii::app()->user->id);
    $client_id = $user->client_id; 
    
    $baseUrl = Yii::app()->theme->baseUrl;
?>

<h1>Manage Documents</h1>

<script type="text/javascript" language="javascript" class="init">  
       
var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
    editor = new $.fn.dataTable.Editor( {
        ajax: 'documents/documents',
        table: "#example",
        fields: [            
           // {
           //     label: "ID:",
           //     name: "id",
           // },
           /* 
            {
                label: "Document Name:",
                name: "document_name",
            },
            */
            /*
            {
                label: "Is Current:",
                name: "is_current"
               // type: "select",
                //ipOpts: iscurrentLoader(),
            },
            */
            /*  
            {
                label: "Document Location:",
                name: "document_location_id",
               // type: "select",
              //  ipOpts: instrumenttypeLoader(),
            },
            */
            {
                label: "Upload Date:",
                name: "document_upload_date",
                type: "datetime"
            },
            
            {
                label: "Document:",
                name: "documents.file",
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
            },
             /*
             {
                label: "Document Type:",
                name: "document_type_id",
               // type: "select",
              //  ipOpts: instrumentgroupLoader(),
            },
            
            {
                label: "client_id:",
                name: "client_id",
                type: "hidden",
                //def: "<?php //echo $client_id;?>"
              //  ipOpts: instrumentgroupLoader(),
            },
            */
            {
                label: "Client:",
                name: "client_id",
                type: "hidden",
                def: "<?php echo $client_id;?>"
                //type: "select",
                //ipOpts: clientsLoader(),
                //"attr": {"class": "form-control"}
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
        ajax: "documents/",
        columns: [
        /*
            { data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                return data.first_name+' '+data.last_name;
            } },
        */                     
            { data: "id" },
            { data: "document_name" },
            
            {
                data: "documents",
                defaultContent: "No file",
                render: function(data, type, row) {
                    if(data.file){
                       return "<a href='../uploads/"+data.file +"."+data.extension+"' target='_Blank'>"+ data.file+"."+data.extension+"</a>";
                    }else{
                        return null;
                    }
                 // return data.document_name ? "<a href='../uploads/"+data.file +"."+data.extension+"' target='_Blank'>"+ data.file+"."+data.extension+"</a>": null; // data.file +"."+data.extension: null; // '<a href="/uploads/' + data.file +"."+data.extension '" onclick="window.open(this.href, \'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=1\'); return false;">' + data.document_name + '</a>' : null;
                
                
                }
              },
              
              /*
              {
                data: "image",
                render: function ( file_id ) {
                    return file_id ?
                        '<img src="'+table.file( 'files', file_id ).web_path+'"/>' :
                        null;
                },
                defaultContent: "No image",
                title: "Image"
            }
            */
            
            
            //{ data: "document_location_id" },
            //{ data: "is_current" },
            
            //{ data: "ledger.price", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
            { data: "document_upload_date" },
            //{ data: "document_type_id" }, 
            //{ data: "client_id" },           
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

  function instrumenttypeLoader() {
    var instruments = [{'value': '0', 'label': '-- Select Instrument Type --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/instrumenttypes/instrumenttypes'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['instrument_type']
              };
              instruments.push(obj);
            }
        }
    });
    return instruments.sort(SortByName);
  }
  
  function instrumentgroupLoader() {
    var instruments = [{'value': '0', 'label': '-- Select Instrument Group --'}];
    var path1 = '<?php echo Yii::app()->baseUrl.'/instrumentGroups/instrumentgroups'; ?>';
    $.ajax({
        url: path1,
        async: false,
        dataType: 'json',
        success: function (json) {
          var data = json.data;
            for(var a=0; a<data.length; a++) {
              obj = {
                "value" : data[a]['id'],
                "label" : data[a]['group_name']
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
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Document Original Name</th>
                <th>File Name</th>
                <!--<th>Document Location</th>
                <th>Is Current</th>-->
                <th>Upload Date</th>
                <!--<th>Document Type</th>
                <th>client_id</th>-->
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Document Original Name</th>
                <th>File Name</th>
                <!--<th>Document Location</th>
                <th>Is Current</th>-->
                <th>Upload Date</th>
                <!--<th>Document Type</th>
                <th>client_id</th>-->
            </tr>
        </tfoot>
    </table>