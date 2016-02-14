<?php

/**
 * This is the model class for table "portfolio_types".
 *
 * The followings are the available columns in table 'portfolio_types':
 * @property integer $id
 * @property string $portfolio_type
 * @property double $allocation_min
 * @property double $allocation_max
 * @property double $allocation_normal
 */
class PortfolioTypes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'portfolio_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('portfolio_type, allocation_min, allocation_max, allocation_normal', 'required'),
			array('allocation_min, allocation_max, allocation_normal', 'numerical'),
			array('portfolio_type', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, portfolio_type, allocation_min, allocation_max, allocation_normal', 'safe', 'on'=>'search'),
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
			'portfolio_type' => 'Portfolio Type',
			'allocation_min' => 'Allocation Min',
			'allocation_max' => 'Allocation Max',
			'allocation_normal' => 'Allocation Normal',
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
		$criteria->compare('portfolio_type',$this->portfolio_type,true);
		$criteria->compare('allocation_min',$this->allocation_min);
		$criteria->compare('allocation_max',$this->allocation_max);
		$criteria->compare('allocation_normal',$this->allocation_normal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PortfolioTypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}