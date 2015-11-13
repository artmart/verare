<?php

/**
 * This is the model class for table "instrument_types".
 *
 * The followings are the available columns in table 'instrument_types':
 * @property integer $id
 * @property string $instrument_type
 * @property string $currency
 * @property string $defaults
 *
 * The followings are the available model relations:
 * @property Instruments[] $instruments
 */
class InstrumentTypes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstrumentTypes the static model class
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
		return 'instrument_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instrument_type, currency, defaults', 'required'),
			array('instrument_type, currency', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, instrument_type, currency, defaults', 'safe', 'on'=>'search'),
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
			'instruments' => array(self::HAS_MANY, 'Instruments', 'instrument_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'instrument_type' => 'Instrument Type',
			'currency' => 'Currency',
			'defaults' => 'Defaults',
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
		$criteria->compare('instrument_type',$this->instrument_type,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('defaults',$this->defaults,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}