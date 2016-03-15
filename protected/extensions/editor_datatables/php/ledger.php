<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');

    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;
    
    //function existingtrades($trade_date, $instrument_id, $portfolio_id){return Ledger::model()->findAllByAttributes(['trade_date'=>$trade_date,'instrument_id'=>$instrument_id, 'portfolio_id' =>$portfolio_id]);}
   //$user_id = Yii::app()->user->id;
   
   $user = Users::model()->findByPk(Yii::app()->user->id);
   $client_id = $user->client_id;
   
   function newledger( $editor,  $values) {    
        $trade_date = $values['ledger']['trade_date'];
        $instrument_id = $values['ledger']['instrument_id'];
        $portfolio_id = $values['ledger']['portfolio_id'];
        
        $user_id = Yii::app()->user->id;
        $user = Users::model()->findByPk($user_id);
        $client_id = $user->client_id;
            
       $existing_trades = Ledger::model()->findAllByAttributes(['trade_date'=>$trade_date,'instrument_id'=>$instrument_id, 'portfolio_id' =>$portfolio_id]);
       //  $editor->db()->select( 'ledger', "*", "trade_date= '$trade_date' and instrument_id = '$instrument_id' and portfolio_id = '$portfolio_id'", null );
        if($existing_trades && count($existing_trades)>0){
                    $trade_code = $existing_trades[0]->trade_code;
                    $editor
                        ->field( 'trade_code' )
                        ->setValue( $trade_code );
                    $editor
                        ->field( 'ledger.client_id' )
                        ->setValue( $client_id );
                    $editor
                        ->field( 'ledger.trade_status_id' )
                        ->setValue( 1 );  
                    $editor
                        ->field( 'ledger.created_by' )
                        ->setValue( $user_id );
                    $editor
                        ->field( 'ledger.is_current' )
                        ->setValue( 1 );                      
                }else{
                        $trade_code = 'TMS'.date("Yhis");
                        $editor
                            ->field( 'trade_code' )
                            ->setValue( $trade_code );
                        $editor
                            ->field( 'ledger.client_id' )
                            ->setValue( $client_id );
                        $editor
                            ->field( 'ledger.trade_status_id' )
                            ->setValue( 1 ); 
                        $editor
                            ->field( 'ledger.created_by' )
                            ->setValue( $user_id ); 
                        $editor
                            ->field( 'ledger.is_current' )
                            ->setValue( 1 );
                        }
    } 
    
    function editledger ( $editor, $id, $values ) {                

        $existing_trades =  Ledger::model()->findByPk($id);
        
        if(isset($values['ledger']['trade_date'])){$trade_date = $values['ledger']['trade_date'];}else{$trade_date = $existing_trades->trade_date;}
        if(isset($values['ledger']['instrument_id'])){$instrument_id = $values['ledger']['instrument_id'];}else{$instrument_id = $existing_trades->instrument_id;}
        if(isset($values['ledger']['portfolio_id'])){$portfolio_id = $values['ledger']['portfolio_id'];}else{$portfolio_id = $existing_trades->portfolio_id;}
        if(isset($values['ledger']['nominal'])){$nominal = $values['ledger']['nominal'];}else{$nominal = $existing_trades->nominal;}
        if(isset($values['ledger']['price'])){$price = $values['ledger']['price'];}else{$price = $existing_trades->price;}

        if(isset($values['ledger']['note'])){$note = $values['ledger']['note'];}else{$note = $existing_trades->note;}
        if(isset($values['ledger']['file'])){$file = $values['ledger']['file'];}else{$file = $existing_trades->file;}        
        
        
        if(isset($values['ledger']['trade_status_id'])){$trade_status_id = $values['ledger']['trade_status_id'];}else{$trade_status_id = $existing_trades->trade_status_id;}
        if(isset($values['ledger']['is_current'])){$is_current = $values['ledger']['is_current'];}else{$is_current = $existing_trades->is_current;}
        $trade_code = $existing_trades->trade_code;
        
        if( 
            (isset($values['ledger']['trade_date']) && $existing_trades->trade_date !== $values['ledger']['trade_date']) ||
            (isset($values['ledger']['instrument_id']) && $existing_trades->instrument_id !== $values['ledger']['instrument_id']) ||
            (isset($values['ledger']['portfolio_id']) && $existing_trades->portfolio_id !== $values['ledger']['portfolio_id']) ||
            (isset($values['ledger']['nominal']) && $existing_trades->nominal !== $values['ledger']['nominal']) ||
            (isset($values['ledger']['price']) && $existing_trades->price !== $values['ledger']['price'])        
          )
          {    
                $user_id = Yii::app()->user->id;
                $user = Users::model()->findByPk($user_id);
                $client_id = $user->client_id;
            
                $new_trade = New Ledger();
                $new_trade->trade_date=$trade_date; //$values['ledger']['trade_date'];
                $new_trade->instrument_id=$instrument_id; //$values['ledger']['instrument_id'];
                $new_trade->portfolio_id=$portfolio_id; //$values['ledger']['portfolio_id'];
                $new_trade->nominal=$nominal; //$values['ledger']['nominal'];
                $new_trade->price=$price; //$values['ledger']['price'];
                $new_trade->created_by= $user_id;
                $new_trade->trade_status_id= $trade_status_id;// $values['ledger']['trade_status_id'];
                //'confirmed_by' =>$values['ledger']['confirmed_by'],
                //'confirmed_at' =>$values['ledger']['confirmed_at'], 
                //'file'=>$values['ledger']['file'],
                $new_trade->client_id= $client_id;
                $new_trade->trade_code=$trade_code;
                
                $new_trade->note=$note;
                $new_trade->file=$file;
                
                $new_trade->save();
                //var_dump($new_trade->getErrors());
                //exit;
                
                $editor->field( 'ledger.is_current' )->setValue( 0 );
                $editor->field( 'ledger.trade_status_id' )->setValue( $existing_trades->trade_status_id );
                $editor->field( 'ledger.trade_date' )->setValue( $existing_trades->trade_date );
                $editor->field( 'ledger.instrument_id' )->setValue( $existing_trades->instrument_id );
                $editor->field( 'ledger.portfolio_id' )->setValue( $existing_trades->portfolio_id );
                $editor->field( 'ledger.nominal' )->setValue( $existing_trades->nominal );
                $editor->field( 'ledger.price' )->setValue( $existing_trades->price ); 
                $editor->field( 'trade_code' )->setValue( $trade_code ); 
          }else{
                $editor
                    ->field( 'ledger.trade_status_id' )
                    ->setValue( $trade_status_id );
                $editor
                    ->field( 'ledger.is_current' )
                    ->setValue( $is_current );
                $editor
                    ->field( 'trade_code' )
                    ->setValue( $trade_code );
          }
    } 
     
     
    //Build our Editor instance and process the data coming from _POST
    $time = date("fYhis");
   // $extension = end(explode('.', Upload::DB_FILE_NAME));
    Editor::inst( $db, 'ledger', 'id', $time, $client_id)
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
            Field::inst( 'ledger.client_id' ),
            Field::inst( 'ledger.trade_code as trade_code' ),
            Field::inst( 'ledger.note' ),
            Field::inst( 'ledger.file' )
            ->setFormatter( 'Format::ifEmpty', null )
            ->upload( Upload::inst( 'uploads/'.$time.'.__EXTN__' )
                ->db( 'documents', 'file', array(
                    'document_name' => Upload::DB_FILE_NAME,
                    'filesize'    => Upload::DB_FILE_SIZE,
                    'web_path'    => Upload::DB_WEB_PATH,
                    'system_path' => Upload::DB_SYSTEM_PATH,
                    'extension'=>Upload::DB_EXTN,
                    'file'=>$time
                ) )
                ->validator( function ( $file ) {
                    return $file['size'] >= 250000 ?
                        "Files must be smaller than 250KB" :
                        null;
                } )
                ->allowedExtensions( [ 'png', 'jpg', 'gif', 'xlsx', 'pdf', 'doc', 'xls', 'docx' ], "Please upload document with correct format" )
            ), 
            Field::inst( 'documents.id' ),
            Field::inst( 'documents.document_name' ),
            Field::inst( 'documents.filesize' ),  
            Field::inst( 'documents.web_path' ),
            Field::inst( 'documents.system_path' ),
            Field::inst( 'documents.file' ),
            Field::inst( 'documents.extension' ),
                    
            
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
         
        ->on( 'preCreate', function ( $editor, $values ) {
                newledger($editor, $values );
            } )  
        ->on( 'preEdit', function ( $editor, $id, $values ) {
               editledger( $editor, $id, $values );                    
            } ) 
                    
        ->leftJoin( 'instruments', 'instruments.id', '=', 'ledger.instrument_id' )
        ->leftJoin( 'portfolios', 'portfolios.id', '=', 'ledger.portfolio_id' )
        ->leftJoin( 'profiles as prof1', 'prof1.user_id', '=', 'ledger.created_by' )
        ->leftJoin( 'profiles as prof2', 'prof2.user_id', '=', 'ledger.confirmed_by' )
        ->leftJoin( 'trade_status', 'trade_status.id', '=', 'ledger.trade_status_id' )
       // ->leftJoin( 'users', 'users.client_id', '=', 'ledger.client_id' )
        ->leftJoin( 'documents', 'documents.id', '=', 'ledger.file' )
        ->where( 'ledger.client_id', $client_id )
        ->where( 'ledger.is_current', 1 )
        ->process( $_POST )
        ->json();  
?>