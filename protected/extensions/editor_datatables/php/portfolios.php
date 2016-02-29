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
Editor::inst( $db, 'portfolios')
    ->fields(
        Field::inst( 'id' ),
        Field::inst( 'portfolio' )
    )
    ->process( $_POST )
    ->json();
?>