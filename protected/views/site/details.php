<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
<!--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>-->

<?php 

    //if(isset($_POST['start_date'])){$start_date = date_format(date_create($_POST['start_date']),"Y-m-d");}
    //if(isset($_POST['end_date'])){$end_date = date_format(date_create($_POST['end_date']),"Y-m-d");}
?>

<h3> <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>

<!-- Content Header (Page header) -->

<section class="content-header">
  <h1 class="span1">Details</h1>
</section>

        <!-- Main content -->
        <section class="content">
         
        	  
          <div class="row">
            <div class="col-md-12">
              <div class="box box">
			  
                <div class="box-header with-border">
                  <h3 class="box-title">Portfolios</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
				
				
                <div class="box-body">
                <div id="results-view"></div>
                
                 <!-- <div class="row">-->
                    <div class="col-md-12">
					

					  
                    </div><!-- /.col -->
       
                </div><!-- ./box-body -->
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>

		
<script>
$(document).ready(function ($) {
          resultsload();
          });


    function resultsload(){
    	$.ajax({
    			type: 'post',
    			url: '<?php echo Yii::app()->baseUrl.'/site/resultsload'; ?>',
    			data: {
    			//media_type:$('#media_type').val(),
                //supermarket_bar:$('#supermarket_bar').val(),
                //dt: n - $('#sel_Period1').val()+"-"+$('#sel_Period2').val(), 'show_queries':show_queries
    			},
    			success: function (response) {
    			     $( '#results-view' ).html(response);
    			}
    		   });
    }


    function instrumentsresultsload(){
    	$.ajax({
    			type: 'post',
    			url: '<?php echo Yii::app()->baseUrl.'/site/instrumentsresultsload'; ?>',
    			data: {
    			//media_type:$('#media_type').val(),
                //supermarket_bar:$('#supermarket_bar').val(),
                //dt: n - $('#sel_Period1').val()+"-"+$('#sel_Period2').val(), 'show_queries':show_queries
    			},
    			success: function (response) {
    			     $( '#results-view' ).html(response);
    			}
    		   });
    }


/*
function fnFormatDetails(table_id, html) {
    var sOut = "<table id=\"exampleTable_" + table_id + "\">";
    sOut += html;
    sOut += "</table>";
    return sOut;
}



var iTableCounter = 1;
    var oTable;
    var oInnerTable;
    var TableHtml;
    var TableHtml1;

    //Run On HTML Build
    $(document).ready(function () {
        TableHtml = $("#exampleTable").html();
        //TableHtml1 = $("#exampleTable_" + iTableCounter).html();


        //Insert a 'details' column to the table
        var nCloneTh = document.createElement('th');
        var nCloneTd = document.createElement('td');
        nCloneTd.innerHTML = '<img src="http://i.imgur.com/SD7Dz.png">';
        nCloneTd.className = "center";

        $('#exampleTable thead tr').each(function () {
            this.insertBefore(nCloneTh, this.childNodes[0]);
        });

        $('#exampleTable tbody tr').each(function () {
            this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });

        //Initialse DataTables, with no sorting on the 'details' column
        var oTable = $('#exampleTable').dataTable({
            
            
            "bJQueryUI": false,
            //"sPaginationType": "full_numbers",
            "aoColumnDefs": [
            { "bSortable": false, "aTargets": [0] }
        ],
           // "aaSorting": [[1, 'asc']]
        });

        /* Add event listener for opening and closing details
        * Note that the indicator for showing which row is open is not controlled by DataTables,
        * rather it is done here
        */
        
        /*
        $('#exampleTable tbody td img').on('click', function () {
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */   /*
                this.src = "http://i.imgur.com/SD7Dz.png";
                oTable.fnClose(nTr);
            }
            else {
                /* Open this row */    /*
                var tab_num = $(this).closest("tr").index()+1;
                //alert($(this).closest("tr").index()+1);
                this.src = "http://i.imgur.com/d4ICC.png";
                oTable.fnOpen(nTr, fnFormatDetails(iTableCounter, $("#exampleTable_" + tab_num).html()), 'details');
                oInnerTable = $("#exampleTable_" + iTableCounter).dataTable({
                    "bJQueryUI": false,
                    //"sPaginationType": "full_numbers"
                });
                //iTableCounter = iTableCounter + 1;
            }
        });

    });
    
    */
 
</script>	

