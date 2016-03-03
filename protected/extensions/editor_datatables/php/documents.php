<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');

    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;
 /*    
    //Build our Editor instance and process the data coming from _POST
    Editor::inst( $db, 'ledger' )
        ->fields(
            Field::inst( 'id' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'instrument_id' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'portfolio_id' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'nominal' ),
            Field::inst( 'created_by' ),
            Field::inst( 'created_at' ), 
            Field::inst( 'trade_status_id' ),
            Field::inst( 'version_number' ),
            Field::inst( 'document_id' ),
            Field::inst( 'custody_account' ),
            Field::inst( 'custody_comment' ),
            Field::inst( 'account_number' ),
            Field::inst( 'is_current' ),
            Field::inst( 'confirmed_at' ),
            Field::inst( 'confirmed_by' )
                ->validator( 'Validate::numeric' )
                ->setFormatter( 'Format::ifEmpty', null ),
            Field::inst( 'price' )
                ->validator( 'Validate::numeric' )
                ->setFormatter( 'Format::ifEmpty', null ),
            Field::inst( 'trade_date' )
                ->validator( 'Validate::dateFormat', array(
                    "format"  => Format::DATE_ISO_8601,
                    "message" => "Please enter a date in the format yyyy-mm-dd"
                ) )
                ->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
                ->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 )
        )
        ->process( $_POST )
        ->json();  
        
 */       
        
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'documents', 'documents.id')
    ->fields(
        Field::inst( 'documents.id as id' ),
        Field::inst( 'documents.document_name as document_name' ),
        Field::inst( 'documents.document_location_id as document_location_id' ),
        Field::inst( 'documents.document_type_id as document_type_id' ),
        Field::inst( 'documents.document_upload_date as document_upload_date' ),
        Field::inst( 'documents.is_current as is_current' )
      //  Field::inst( 'documents.created_at' ),
       // Field::inst( 'documents.instrument_group_id' )      
    )
   // ->leftJoin( 'instrument_types', 'instrument_types.id', '=', 'instruments.instrument_type_id' )
    //->leftJoin( 'instrument_groups', 'instrument_groups.id', '=', 'instruments.instrument_group_id' )
    ->process( $_POST )
    ->json();
?>