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
    Editor::inst( $db, 'benchmark_components', 'id', $time, $client_id)
        ->fields(
            Field::inst( 'benchmark_components.benchmark_id' ),
            Field::inst( 'benchmark_components.instrument_id' )->validator( 'Validate::notEmpty' ),
            //Field::inst( 'benchmarks.name' )->validator( 'Validate::notEmpty' ),
            //Field::inst( 'benchmarks.client_id' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'benchmark_components.is_instrument_or_portfolio' ),
            Field::inst( 'benchmark_components.weight' ),
            Field::inst( 'benchmarks.benchmark_name' ),
            Field::inst( 'instruments.instrument' )
            //Field::inst( 'clients.id' ),
            //Field::inst( 'clients.client_name' ),
            //Field::inst( 'portfolios.portfolio' )  
    )   
        ->leftJoin( 'benchmarks', 'benchmarks.id', '=', 'benchmark_components.benchmark_id' )
        ->leftJoin( 'instruments', 'instruments.id', '=', 'benchmark_components.instrument_id' )          
       // ->where( 'benchmarks.client_id', $client_id )
        ->process( $_POST )
        ->json();  
?>