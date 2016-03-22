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
    Editor::inst( $db, 'benchmarks', 'id', $time, $client_id)
        ->fields(
            Field::inst( 'benchmarks.client_id' ),
            Field::inst( 'benchmarks.id' ),//->validator( 'Validate::notEmpty' ),
            //Field::inst( 'benchmarks.name' )->validator( 'Validate::notEmpty' ),
            //Field::inst( 'benchmarks.client_id' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'benchmarks.portfolio_id' ),
            Field::inst( 'benchmarks.benchmark_name as benchmark_name' ),
            //Field::inst( 'clients.id' ),
            Field::inst( 'clients.client_name' ),
            Field::inst( 'portfolios.portfolio' )  
    )   
        ->leftJoin( 'clients', 'clients.id', '=', 'benchmarks.client_id' )
        ->leftJoin( 'portfolios', 'portfolios.id', '=', 'benchmarks.portfolio_id' )          
        ->where( 'benchmarks.client_id', $client_id )
        ->process( $_POST )
        ->json();  
?>