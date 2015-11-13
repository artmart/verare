<?php

/**
 * This is the model class for table "prices".
 *
 * The followings are the available columns in table 'prices':
 * @property integer $id
 * @property string $trade_date
 * @property integer $instrument_id
 * @property double $price
 * @property integer $is_current
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Instruments $instrument
 */
class Prices extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Prices the static model class
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
		return 'prices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trade_date, instrument_id, price, created_at', 'required'),
			array('instrument_id, is_current', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, trade_date, instrument_id, price, is_current, created_at', 'safe', 'on'=>'search'),
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
			'instrument' => array(self::BELONGS_TO, 'Instruments', 'instrument_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'trade_date' => 'Trade Date',
			'instrument_id' => 'Instrument',
			'price' => 'Price',
			'is_current' => 'Is Current',
			'created_at' => 'Created At',
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
		$criteria->compare('trade_date',$this->trade_date,true);
		$criteria->compare('instrument_id',$this->instrument_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('is_current',$this->is_current);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}