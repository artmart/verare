<?php

/**
 * This is the model class for table "documents".
 *
 * The followings are the available columns in table 'documents':
 * @property integer $id
 * @property string $document_name
 * @property integer $document_location_id
 * @property integer $document_type_id
 * @property string $document_upload_date
 * @property integer $is_current
 *
 * The followings are the available model relations:
 * @property DocumentLocations $documentLocation
 * @property DocumentTypes $documentType
 * @property Ledger[] $ledgers
 */
class Documents extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Documents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'documents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('document_name, document_location_id, document_type_id, document_upload_date', 'required'),
			array('document_location_id, document_type_id, is_current', 'numerical', 'integerOnly'=>true),
			array('document_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, document_name, document_location_id, document_type_id, document_upload_date, is_current', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'documentLocation' => array(self::BELONGS_TO, 'DocumentLocations', 'document_location_id'),
			'documentType' => array(self::BELONGS_TO, 'DocumentTypes', 'document_type_id'),
			'ledgers' => array(self::HAS_MANY, 'Ledger', 'document_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'document_name' => 'Document Name',
			'document_location_id' => 'Document Location',
			'document_type_id' => 'Document Type',
			'document_upload_date' => 'Document Upload Date',
			'is_current' => 'Is Current',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('document_name',$this->document_name,true);
		$criteria->compare('document_location_id',$this->document_location_id);
		$criteria->compare('document_type_id',$this->document_type_id);
		$criteria->compare('document_upload_date',$this->document_upload_date,true);
		$criteria->compare('is_current',$this->is_current);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}