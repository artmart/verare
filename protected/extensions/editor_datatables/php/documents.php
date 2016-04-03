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
   
   function newdocument( $editor,  $values, $client_id) {    
        
                    $editor
                        ->field( 'client_id' )
                        ->setValue( $client_id );
                    
    } 
       
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'documents', 'documents.id', $client_id)
    ->fields(
        Field::inst( 'documents.id as id' ),
        Field::inst( 'documents.document_name as document_name' ),
        Field::inst( 'documents.document_location_id as document_location_id' ),
        Field::inst( 'documents.document_type_id as document_type_id' ),
        Field::inst( 'documents.document_upload_date as document_upload_date' ),
        Field::inst( 'documents.is_current as is_current' ),
        Field::inst( 'documents.client_id as client_id' )
        )
        
        ->on( 'preCreate', function ( $editor, $values ) {
                newdocument($editor, $values, $client_id );
            } )  
        ->on( 'preEdit', function ( $editor, $id, $values ) {
               newdocument( $editor, $values, $client_id );                    
            } ) 
       // Field::inst( 'documents.instrument_group_id' )      
    
   // ->leftJoin( 'instrument_types', 'instrument_types.id', '=', 'instruments.instrument_type_id' )
    //->leftJoin( 'instrument_groups', 'instrument_groups.id', '=', 'instruments.instrument_group_id' )
    ->where( 'client_id', $client_id )
    ->process( $_POST )
    ->json();
?>