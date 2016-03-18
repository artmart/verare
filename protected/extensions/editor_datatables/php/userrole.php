<?php require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/DataTables.php');

    //Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Upload,
        DataTables\Editor\Validate;
      
   $user = Users::model()->findByPk(Yii::app()->user->id);
   $client_id = $user->client_id;

    //Build our Editor instance and process the data coming from _POST
    $time = date("fYhis");
   // $extension = end(explode('.', Upload::DB_FILE_NAME));
    Editor::inst( $db, 'user_role', 'id', $time, $client_id)
        ->fields(
            Field::inst( 'user_role.user_role as user_role_name' ),
            Field::inst( 'user_role.id' )->validator( 'Validate::notEmpty' )
            //Field::inst( 'benchmarks.name' )->validator( 'Validate::notEmpty' ),
            //Field::inst( 'benchmarks.client_id' )->validator( 'Validate::notEmpty' ),
            //Field::inst( 'user_role.portfolio_id' ),
            //Field::inst( 'user_role.benchmark_name as benchmark_name' ),
            //Field::inst( 'clients.id' ),
           // Field::inst( 'user_role.client_name' ),
            //Field::inst( 'user_role.portfolio' )  
    )   
       // ->leftJoin( 'clients', 'clients.id', '=', 'benchmarks.client_id' )
       // ->leftJoin( 'portfolios', 'portfolios.id', '=', 'benchmarks.portfolio_id' )          
       // ->where( 'benchmarks.client_id', $client_id )
        ->process( $_POST )
        ->json();  
?>