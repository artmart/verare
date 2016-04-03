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
Editor::inst( $db, 'instruments', 'instruments.id')
    ->fields(
        Field::inst( 'instrument_types.instrument_type' ),
        Field::inst( 'instrument_groups.group_name' ),
        Field::inst( 'instruments.id as id' ),
        Field::inst( 'instruments.instrument as instrument' ),
        Field::inst( 'instruments.instrument_type_id' ),
        Field::inst( 'instruments.is_current' ),
        Field::inst( 'instruments.created_at' ),
        Field::inst( 'instruments.isin' ),
        Field::inst( 'instruments.instrument_group_id' )      
    )
    ->leftJoin( 'instrument_types', 'instrument_types.id', '=', 'instruments.instrument_type_id' )
    ->leftJoin( 'instrument_groups', 'instrument_groups.id', '=', 'instruments.instrument_group_id' )
    ->process( $_POST )
    ->json();
?>