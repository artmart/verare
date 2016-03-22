<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');

    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;
    $client_id = Yii::app()->user->getState('client_id');
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
Editor::inst( $db, 'portfolios', 'id', $client_id )
    ->fields(
        Field::inst( 'clients.client_name as client_name' ),
        Field::inst( 'portfolio_types.portfolio_type as portfolio_type' ),
    
        Field::inst( 'portfolios.id as id' ),
        Field::inst( 'portfolios.portfolio as portfolio' ),
        Field::inst( 'portfolios.client_id as client_id' ),
        Field::inst( 'portfolios.description as description' ),
        Field::inst( 'portfolios.is_current as is_current' ),
        Field::inst( 'portfolios.created_at as created_at' ),
        Field::inst( 'portfolios.type_id as type_id' )
    )
    ->leftJoin( 'clients', 'clients.id', '=', 'portfolios.client_id' )
    ->leftJoin( 'portfolio_types', 'portfolio_types.id', '=', 'portfolios.type_id' )
    ->where( 'portfolios.client_id', $client_id )
    ->process( $_POST )
    ->json();
?>