<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');

    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;
     
    //Build our Editor instance and process the data coming from _POST
    Editor::inst( $db, 'ledger', 'id')
        ->fields(
            Field::inst( 'instruments.instrument' ),
            Field::inst( 'portfolios.portfolio' ),
            Field::inst( 'prof1.lastname' ),
            Field::inst( 'prof1.firstname' ),
            Field::inst( 'prof2.lastname' ),
            Field::inst( 'prof2.firstname' ),
            Field::inst( 'trade_status.trade_status' ),
            Field::inst( 'ledger.id' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'ledger.instrument_id' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'ledger.portfolio_id' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'ledger.nominal' ),
            Field::inst( 'ledger.created_by' ),
            Field::inst( 'ledger.created_at' ), 
            Field::inst( 'ledger.trade_status_id' ),
            Field::inst( 'ledger.version_number' ),
            //Field::inst( 'ledger.document_id' ),
            Field::inst( 'ledger.custody_account' ),
            Field::inst( 'ledger.custody_comment' ),
            Field::inst( 'ledger.account_number' ),
            Field::inst( 'ledger.is_current' ),
            Field::inst( 'ledger.confirmed_at' ),
            Field::inst( 'ledger.document_id' )
            ->setFormatter( 'Format::ifEmpty', null )
            ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/uploads/__ID__.__EXTN__' )
                ->db( 'documents', 'file', array(
                    'document_name'    => Upload::DB_FILE_NAME,
                    'filesize'    => Upload::DB_FILE_SIZE,
                    'web_path'    => Upload::DB_WEB_PATH,
                    'system_path' => Upload::DB_SYSTEM_PATH
                ) )
                ->validator( function ( $file ) {
                    return $file['size'] >= 50000 ?
                        "Files must be smaller than 50K" :
                        null;
                } )
                ->allowedExtensions( [ 'png', 'jpg', 'gif', 'xlsx' ], "Please upload an image" )
            ), 
            
            Field::inst( 'documents.id' ),
            Field::inst( 'documents.document_name' ),
            Field::inst( 'documents.filesize' ),  
            Field::inst( 'documents.web_path' ),
            Field::inst( 'documents.system_path' ),
            Field::inst( 'documents.file' ),
                    
            
            Field::inst( 'ledger.confirmed_by' )
                ->validator( 'Validate::numeric' )
                ->setFormatter( 'Format::ifEmpty', null ),
            Field::inst( 'ledger.price' )
                ->validator( 'Validate::numeric' )
                ->setFormatter( 'Format::ifEmpty', null ),
            Field::inst( 'ledger.trade_date' )
                ->validator( 'Validate::dateFormat', array(
                    "format"  => Format::DATE_ISO_8601,
                    "message" => "Please enter a date in the format yyyy-mm-dd"
                ) )
                ->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
                ->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 )
        )
        ->leftJoin( 'instruments', 'instruments.id', '=', 'ledger.instrument_id' )
        ->leftJoin( 'portfolios', 'portfolios.id', '=', 'ledger.portfolio_id' )
        ->leftJoin( 'profiles as prof1', 'prof1.user_id', '=', 'ledger.created_by' )
        ->leftJoin( 'profiles as prof2', 'prof2.user_id', '=', 'ledger.confirmed_by' )
        ->leftJoin( 'trade_status', 'trade_status.id', '=', 'ledger.trade_status_id' )
        ->leftJoin( 'documents', 'documents.id', '=', 'ledger.document_id' )
        ->process( $_POST )
        ->json();  
?>