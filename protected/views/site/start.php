<style>
ol.progtrckr {
        display: table;
        list-style-type: none;
        margin: 0;
        padding: 0;
        table-layout: fixed;
        width: 100%;
    }
    ol.progtrckr li {
        display: table-cell;
        text-align: center;
        line-height: 3em;
    }
/*
    ol.progtrckr[data-progtrckr-steps="2"] li { width: 35%; }
    ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
    ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
    ol.progtrckr[data-progtrckr-steps="5"] li { width: 33%; }
    ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
    ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
    ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
    ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }
*/
    ol.progtrckr li.progtrckr-done {
        color: black;
        border-bottom: 4px solid yellowgreen;
    }
    ol.progtrckr li.progtrckr-todo {
        color: silver; 
        border-bottom: 4px solid silver;
    }

    ol.progtrckr li:after {
        content: "\00a0\00a0";
    }
    ol.progtrckr li:before {
        position: relative;
        bottom: -2.5em;
        float: left;
        left: 50%;
        line-height: 1em;
    }
    ol.progtrckr li.progtrckr-done:before {
        content: "\2713";
        color: white;
        background-color: yellowgreen;
        height: 1.2em;
        width: 1.2em;
        line-height: 1.2em;
        border: none;
        border-radius: 1.2em;
    }
    ol.progtrckr li.progtrckr-todo:before {
        content: "\039F";
        color: silver;
        background-color: white;
        font-size: 1.5em;
        bottom: -1.6em;
    }

</style>


<?php $this->pageTitle=Yii::app()->name; ?>

<h3> <i>Profile completion steps.<?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>

</br>
</br>

<ol class="progtrckr" data-progtrckr-steps="5">
    <?php 
    //Benchmark creation step//
    if($step_completed == 0){ ?>
    <li class="progtrckr-todo"><?php  echo CHtml::link('Upload Prices',array('/uploads/fullupload')); ?></li>
    <li class="progtrckr-todo">Add Benchmark</li>
    <li class="progtrckr-todo">Add Benchmark Components</li>
    <li class="progtrckr-todo">Add Portfolio</li>
    <li class="progtrckr-todo">Add Trade</li>
    <?php } 
    
     
    //Benchmark creation step//
    if($step_completed == 1){ ?>
    <li class="progtrckr-done"><?php  echo CHtml::link('Upload Prices',array('/uploads/fullupload')); ?></li>
    <li class="progtrckr-todo"><?php  echo CHtml::link('Add Benchmark',array('/benchmarks/admin')); ?></li>
    <li class="progtrckr-todo">Add Benchmark Components</li>
    <li class="progtrckr-todo">Add Portfolio</li>
    <li class="progtrckr-todo">Add Trade</li>
    <?php } 
    
    if($step_completed == 2){ 
        //Benchmark component creation step//
    ?>
    <li class="progtrckr-done"><?php  echo CHtml::link('Upload Prices',array('/uploads/fullupload')); ?></li>
    <li class="progtrckr-done"><?php  echo CHtml::link('Add Benchmark',array('/benchmarks/admin')); ?></li>
    <li class="progtrckr-todo"><?php  echo CHtml::link('Add Benchmark Components',array('/benchmarkComponents/admin')); ?></li>
    <li class="progtrckr-todo">Add Portfolio</li>
    <li class="progtrckr-todo">Add Trade</li>
    <?php } 
   
   //portfolio creation step//
    if($step_completed ==3){ 
    ?>
        <li class="progtrckr-done"><?php  echo CHtml::link('Upload Prices',array('/uploads/fullupload')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Benchmark',array('/benchmarks/admin')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Benchmark Components',array('/benchmarkComponents/admin')); ?></li>
        <li class="progtrckr-todo"><?php  echo CHtml::link('Add Portfolio',array('/portfolios/admin')); ?></li>
        <li class="progtrckr-todo">Add Trade</li>
    <?php } 
        if($step_completed == 4){ 
    ?>
        <li class="progtrckr-done"><?php  echo CHtml::link('Upload Prices',array('/uploads/fullupload')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Benchmark',array('/benchmarks/admin')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Benchmark Components',array('/benchmarkComponents/admin')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Portfolio',array('/portfolios/admin')); ?></li>
        <li class="progtrckr-todo"><?php  echo CHtml::link('Add Trade',array('/ledger/admin')); ?></li>
    <?php } 
        if($step_completed == 5){ 
    ?>
        <li class="progtrckr-done"><?php  echo CHtml::link('Upload Prices',array('/uploads/fullupload')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Benchmark',array('/benchmarks/admin')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Benchmark Components',array('/benchmarkComponents/admin')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Portfolio',array('/portfolios/admin')); ?></li>
        <li class="progtrckr-done"><?php  echo CHtml::link('Add Trade',array('/ledger/admin')); ?></li>
    
    <?php } ?>
</ol>

<?php

if(Yii::app()->user->isAdmin())
            {
 ?>  

 
                    
<?php            }
?>