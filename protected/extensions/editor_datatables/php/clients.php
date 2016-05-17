<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');

    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;
        
        
    function createReturnsTable( $id, $values ){
        $table_name = "client_".$id. "_inst_returns";
        Yii::app()->db->createCommand("CREATE TABLE $table_name (`id` INT(11) NOT NULL AUTO_INCREMENT, 
                                                                      
                                                                    	`instrument_id` INT(11) NOT NULL,
                                                                    	`trade_date` DATE NOT NULL,                                                                       
                                                                        `USD` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`EUR` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`JPY` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`GBP` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`AUD` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`CHF` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`CAD` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`MXN` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`CNY` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`CNH` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`NZD` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`SEK` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`RUB` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`DKK` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`NOK` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`HKD` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`SGD` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`TRY` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`KRW` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`ZAR` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`BRL` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                    	`INR` FLOAT(9,7) NOT NULL DEFAULT '1',
                                                                                                                                    
                                                                      PRIMARY KEY (`id`)
                                                                    ) ENGINE=INNODB DEFAULT CHARSET=utf8;")->execute();
    }    
    
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
Editor::inst( $db, 'clients', 'id')
    ->fields(
        Field::inst( 'id' ),
        Field::inst( 'client_name' )->validator( 'Validate::notEmpty' )
    )
    
    ->on( 'postCreate', function ( $editor, $id, $values, $row ) {
            createReturnsTable( $id, $values );
        } )
                
       // ->on( 'postRemove', function ( $editor, $id, $values ) {
       //         portfolioUpdate( $id, $values );
       // } ) 
    
    
    ->process( $_POST )
    ->json();
?>