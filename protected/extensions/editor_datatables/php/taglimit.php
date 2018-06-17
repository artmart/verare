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
Editor::inst( $db, 'tag_limit', 'tag_limit.id')
    ->fields(
        Field::inst( 'tag_limit.id as id' ),
        Field::inst( 'tag_limit.client_id' ),
        Field::inst( 'tag_limit.portfolio_id' ),
        Field::inst( 'tag_limit.tag' ),
        Field::inst( 'tag_limit.limit_min' ),
        Field::inst( 'tag_limit.limit_max' )                   
    )
    ->process( $_POST )
    ->json();
?>