<?php

/**
 * This is the model class for table "counterparties".
 *
 * The followings are the available columns in table 'counterparties':
 * @property integer $id
 * @property string $name
 * @property string $contact_info
 * @property integer $company_id
 * @property string $documents
 */
class Counterparties extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Counterparties the static model class
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
		return 'counterparties';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('company_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('contact_info', 'length', 'max'=>255),
			array('documents', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, contact_info, company_id, documents', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'contact_info' => 'Contact Info',
			'company_id' => 'Company',
			'documents' => 'Documents',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('contact_info',$this->contact_info,true);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('documents',$this->documents,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}