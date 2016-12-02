<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');

    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'trade_types', 'id')
    ->fields(
        Field::inst( 'id' ),
        Field::inst( 'trade_type' )
    )
    ->process( $_POST )
    ->json();
?>