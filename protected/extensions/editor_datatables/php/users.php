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
Editor::inst( $db, 'users', 'id')
    ->fields(
        Field::inst( 'profiles.user_id as user_id' ),
        Field::inst( 'profiles.firstname as firstname' ),
        Field::inst( 'profiles.lastname as lastname' ),
        Field::inst( 'users.id as id' ),
        Field::inst( 'users.username as username' ),
        Field::inst( 'users.password as password' ),
        Field::inst( 'users.email as email' ),
        Field::inst( 'users.create_at as create_at' ),
        Field::inst( 'users.lastvisit_at as lastvisit_at' ),
        //Field::inst( 'users.superuser as superuser' ),
        Field::inst( 'users.status as status' ),
        Field::inst( 'users.user_role as user_role_id' ),
        Field::inst( 'users.default_portfolio_id as default_portfolio_id' ),
        Field::inst( 'users.default_start_date as default_start_date' ),
        Field::inst( 'users.default_end_date as default_end_date' ),
        Field::inst( 'users.client_id as client_id' ),
        Field::inst( 'clients.client_name as client_name' ),
        Field::inst( 'user_role.user_role as user_role' ),
        Field::inst( 'portfolios.portfolio as portfolio' )
        
        
            
    )
    ->leftJoin( 'profiles', 'profiles.user_id', '=', 'users.id' )
    ->leftJoin( 'clients', 'clients.id', '=', 'users.client_id' )  
    ->leftJoin( 'user_role', 'user_role.id', '=', 'users.user_role' )
    ->leftJoin( 'portfolios', 'portfolios.id', '=', 'users.default_portfolio_id' )         
    //->where( 'benchmarks.client_id', $client_id )
    ->process( $_POST )
    ->json();
?>