<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');
      require_once(Yii::app()->basePath . '/modules/user/UserModule.php');
    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;
        
        
       function passwordEncript( $editor,  $values) {   
        
            $password = $values['password'];
        
            $activkey = UserModule::encrypting(microtime().$password);
            $enc_password = UserModule::encrypting($password);
                    
                    $editor->field( 'activkey' )->setValue( $activkey );
                    $editor->field( 'password' )->setValue( $enc_password );             
            } 
    
    function editPassword( $editor, $id, $values ) { 
        
        $password = $values['password'];

        $current_user =  Users::model()->findByPk($id);
        
        $old_password = $current_user->password;
        //$enc_password = UserModule::encrypting($password);
        
        if($password !== $old_password){
            $activkey = UserModule::encrypting(microtime().$password);
            $enc_password = UserModule::encrypting($password);
                    
                    $editor->field( 'activkey' )->setValue( $activkey );
                    $editor->field( 'password' )->setValue( $enc_password ); 
                    
            }//else{
              //  $editor->field( 'password' )->setValue( $enc_password );
                //$editor->field( 'user_role' )->setValue( $current_user->user_role );
                //$editor->field( 'client_id' )->setValue( $current_user->client_id );
            //}
    } 
       
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'users', 'id')
    ->fields(
        Field::inst( 'profiles.user_id as user_id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'profiles.firstname as firstname' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'profiles.lastname as lastname' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'users.id as id' ),
        Field::inst( 'users.username as username' )->validator( function ( $val, $data, $opts ) {
            return strlen( $val ) <3 ?
            'Username must be at least 3 characters' :
            true;
            } ),
       // Field::inst( 'users.password as password' )->validator( 'Validate::notEmpty' ),
        
        /* 
        Field::inst( 'users.password as password' )->validator( function ( $val, $data, $opts ) {
            return strlen( $val ) <4 ?
            'Password must be at least 4 characters' :
            true;
            } ),
          */ 
        Field::inst( 'users.password as password' )->validator( function ( $val, $data, $opts ) {
            return !preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,128}$/', $val)?
            'Password must contain at least 6 characters of letters, numbers and at least one special character.' :
            true;
            } ),    
        
        Field::inst( 'users.activkey as activkey' ),
        Field::inst( 'users.email as email' )->validator( 'Validate::email', array('required' => true) ),
        Field::inst( 'users.create_at as create_at' ),
        Field::inst( 'users.lastvisit_at as lastvisit_at' ),
        //Field::inst( 'users.superuser as superuser' ),
        Field::inst( 'users.status as status' ),
        Field::inst( 'users.user_role' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'users.default_portfolio_id as default_portfolio_id' ),
        Field::inst( 'users.default_start_date as default_start_date' ),
        Field::inst( 'users.default_end_date as default_end_date' ),
        Field::inst( 'users.client_id' )->validator( 'Validate::notEmpty' ),
        Field::inst( 'users.accessable_portfolios as accessable_portfolios' ),
        Field::inst( 'clients.client_name' ),
        Field::inst( 'user_role.user_role as user_role_name' ),
        Field::inst( 'portfolios.portfolio as portfolio' )
  
    )
    
    ->on( 'preCreate', function ( $editor, $values ) {
                passwordEncript($editor, $values );
            } )
            
    ->on( 'preEdit', function ( $editor, $id, $values ) {
               editPassword( $editor, $id, $values );                    
            } )   
       
    ->leftJoin( 'profiles', 'profiles.user_id', '=', 'users.id' )
    ->leftJoin( 'clients', 'clients.id', '=', 'users.client_id' )  
    ->leftJoin( 'user_role', 'user_role.id', '=', 'users.user_role' )
    ->leftJoin( 'portfolios', 'portfolios.id', '=', 'users.default_portfolio_id' )         
    //->where( 'benchmarks.client_id', $client_id )
    ->process( $_POST )
    ->json();
?>