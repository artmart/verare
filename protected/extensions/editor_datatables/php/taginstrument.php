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
Editor::inst( $db, 'tag_instrument', 'tag_instrument.id')
    ->fields(
        Field::inst( 'tag_instrument.id as id' ),
        Field::inst( 'tag_instrument.instrument_id' ),
        Field::inst( 'tag_instrument.client_id' ),
        Field::inst( 'tag_instrument.portfolio_id' ),
        Field::inst( 'tag_instrument.tag' ),
        Field::inst( 'tag_instrument.limit_min' ),
        Field::inst( 'tag_instrument.limit_max' )           
    )
    ->process( $_POST )
    ->json();
?>