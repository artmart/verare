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
    //$client_id = Yii::app()->user->getState('client_id');
    
    
       function userupdate(){
        $user_data = Users::model()->findByPk(Yii::app()->user->id);
                        
        $step_completed = $user_data->step_completed;

        if($user_data->user_role == 2 && $step_completed < 5){
            
            $user_data->step_completed = 4;
            $user_data->save();
            //$this->redirect(Yii::app()->baseUrl.'/site/admin');
            $baseUrl = Yii::app()->baseUrl;
            //Yii::app()->request->redirect($baseUrl.'/site/admin');
            //echo "<script>window.location.href ='".$baseUrl."/site/admin';</script>";
            //return false; 

        }//else{ $this->render('overview', ['user_data' => $user_data]); }
    }
    

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
        Field::inst( 'portfolios.benchmark_id as benchmark_id' ),
        Field::inst( 'portfolios.allocation_min as allocation_min' ),
        Field::inst( 'portfolios.allocation_max as allocation_max' ),
        Field::inst( 'portfolios.allocation_normal as allocation_normal' ),
        Field::inst( 'benchmarks.benchmark_name as benchmark_name' ),
        Field::inst( 'portfolios.type_id as type_id' )
    )
    
    ->on( 'postCreate', function () {
                userupdate();
            } )
    
    ->leftJoin( 'clients', 'clients.id', '=', 'portfolios.client_id' )
    ->leftJoin( 'portfolio_types', 'portfolio_types.id', '=', 'portfolios.type_id' )
    ->leftJoin( 'benchmarks', 'benchmarks.id', '=', 'portfolios.benchmark_id' )
    ->where( 'portfolios.client_id', $client_id )
    ->process( $_POST )
    ->json();
?>