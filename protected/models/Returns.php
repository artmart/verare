<?php

/**
 * This is the model class for table "returns".
 *
 * The followings are the available columns in table 'returns':
 * @property integer $id
 * @property integer $instrument_id
 * @property string $trade_date
 * @property double $return
 */
class Returns extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Returns the static model class
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
		return 'returns';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instrument_id, trade_date, return', 'required'),
			array('instrument_id', 'numerical', 'integerOnly'=>true),
			array('return', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, instrument_id, trade_date, return', 'safe', 'on'=>'search'),
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
			'instrument_id' => 'Instrument',
			'trade_date' => 'Trade Date',
			'return' => 'Return',
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
		$criteria->compare('instrument_id',$this->instrument_id);
		$criteria->compare('trade_date',$this->trade_date,true);
		$criteria->compare('return',$this->return);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}