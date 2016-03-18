<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');

    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;
        
        
       function newProfile( $editor,  $values) {   
        
        $lastname = $values['lastname'];
        $firstname = $values['firstname'];
        
        $profiles = New Profile;
        
        $profiles->lastname = $lastname;
        $profiles->firstname = $firstname;
        $profiles->save();
        

                    $editor
                        ->field( 'id' )
                        ->setValue( $profiles->user_id );
                    
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
       
       
       
   function profileCreate( $db, $action, $id, $values ){
        $user_id = $id;
        $lastname = $values['lastname'];
        $firstname = $values['firstname'];
        
        $profiles = New Profiles;
        
        $profiles->user_id = $id;
        $profiles->lastname = $lastname;
        $profiles->firstname = $firstname;
        $profiles->save();
        
        /*
        $model->activkey=UserModule::encrypting(microtime().$model->password);
						$model->password=UserModule::encrypting($model->password);
        
    
        $db->insert( 'profiles', array(
            'user_id'   => $user_id,
            'lastname' => $lastname,
            'firstname' => $firstname
        ) );*/
    } 
    
   function profileUpdate( $db, $action, $id, $values ){
        $user_id = $id;
        $lastname = $values['lastname'];
        $firstname = $values['firstname'];

        $profiles =  Profiles::model()->findByPk($id);
        
        $profiles->lastname = $lastname;
        $profiles->firstname = $firstname;
        $profiles->save();
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
    
    /*
    ->on( 'preCreate', function ( $editor, $values ) {
                newProfile($editor, $values );
            } )  
    
     ->on( 'preCreate', function ( $editor, $values ) {
                newledger($editor, $values );
            } )  
        ->on( 'preEdit', function ( $editor, $id, $values ) {
               editledger( $editor, $id, $values );                    
            } ) 
   
    
    
    ->on( 'postCreate', function ( $editor, $id, $values, $row ) {
        profileCreate( $editor->db(), 'create', $id, $values );
    } )
    ->on( 'postEdit', function ( $editor, $id, $values, $row ) {
        profileUpdate( $editor->db(), 'edit', $id, $values );
    } )
 */
    
    ->leftJoin( 'profiles', 'profiles.user_id', '=', 'users.id' )
    ->leftJoin( 'clients', 'clients.id', '=', 'users.client_id' )  
    ->leftJoin( 'user_role', 'user_role.id', '=', 'users.user_role' )
    ->leftJoin( 'portfolios', 'portfolios.id', '=', 'users.default_portfolio_id' )         
    //->where( 'benchmarks.client_id', $client_id )
    ->process( $_POST )
    ->json();
?>