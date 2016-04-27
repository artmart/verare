<?php

/**
 * This is the model class for table "instruments".
 *
 * The followings are the available columns in table 'instruments':
 * @property integer $id
 * @property string $instrument
 * @property integer $instrument_type_id
 * @property string $fpml
 * @property integer $is_current
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property InstrumentTypes $instrumentType
 * @property Ledger[] $ledgers
 * @property Prices[] $prices
 * price_uploaded
 */
class Instruments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Instruments the static model class
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
		return 'instruments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('instrument, instrument_type_id, fpml, created_at', 'required'),
			array('instrument_type_id, is_current, price_uploaded', 'numerical', 'integerOnly'=>true),
			array('instrument', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, instrument, price_uploaded, instrument_type_id, fpml, is_current, created_at', 'safe', 'on'=>'search'),
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
			'instrumentType' => array(self::BELONGS_TO, 'InstrumentTypes', 'instrument_type_id'),
			'ledgers' => array(self::HAS_MANY, 'Ledger', 'instrument_id'),
			'prices' => array(self::HAS_MANY, 'Prices', 'instrument_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'instrument' => 'Instrument',
			'instrument_type_id' => 'Instrument Type',
			'fpml' => 'Fpml',
			'is_current' => 'Is Current',
			'created_at' => 'Created At',
            'price_uploaded' => 'price_uploaded',
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
		$criteria->compare('instrument',$this->instrument,true);
		$criteria->compare('instrument_type_id',$this->instrument_type_id);
		$criteria->compare('fpml',$this->fpml,true);
		$criteria->compare('is_current',$this->is_current);
		$criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('price_uploaded',$this->price_uploaded);
        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}