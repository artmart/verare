<?php

/**
 * This is the model class for table "benchmark_components".
 *
 * The followings are the available columns in table 'benchmark_components':
 * @property integer $id
 * @property integer $benchmark_id
 * @property integer $instrument_id
 * @property integer $is_instrument_or_portfolio
 * @property integer $weight
 *
 * The followings are the available model relations:
 * @property Benchmarks $benchmark
 * @property Instruments $instrument
 */
class BenchmarkComponents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'benchmark_components';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('benchmark_id, instrument_id', 'required'),
			array('benchmark_id, instrument_id, is_instrument_or_portfolio, weight', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, benchmark_id, instrument_id, is_instrument_or_portfolio, weight', 'safe', 'on'=>'search'),
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
			'benchmark' => array(self::BELONGS_TO, 'Benchmarks', 'benchmark_id'),
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
			'benchmark_id' => 'Benchmark',
			'instrument_id' => 'Instrument',
			'is_instrument_or_portfolio' => 'Is Instrument Or Portfolio',
			'weight' => 'Weight',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('benchmark_id',$this->benchmark_id);
		$criteria->compare('instrument_id',$this->instrument_id);
		$criteria->compare('is_instrument_or_portfolio',$this->is_instrument_or_portfolio);
		$criteria->compare('weight',$this->weight);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BenchmarkComponents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
