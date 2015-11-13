<?php

/**
 * This is the model class for table "user_role".
 *
 * The followings are the available columns in table 'user_role':
 * @property integer $id
 * @property string $user_role
 * @property integer $trade_creation
 * @property integer $trade_confirmation
 * @property integer $trade_cancellation
 * @property integer $price_administration
 * @property integer $instrument_administration
 *
 * The followings are the available model relations:
 * @property PortfolioUserRoles[] $portfolioUserRoles
 */
class UserRole extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserRole the static model class
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
		return 'user_role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_role', 'required'),
			array('trade_creation, trade_confirmation, trade_cancellation, price_administration, instrument_administration', 'numerical', 'integerOnly'=>true),
			array('user_role', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_role, trade_creation, trade_confirmation, trade_cancellation, price_administration, instrument_administration', 'safe', 'on'=>'search'),
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
			'portfolioUserRoles' => array(self::HAS_MANY, 'PortfolioUserRoles', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_role' => 'User Role',
			'trade_creation' => 'Trade Creation',
			'trade_confirmation' => 'Trade Confirmation',
			'trade_cancellation' => 'Trade Cancellation',
			'price_administration' => 'Price Administration',
			'instrument_administration' => 'Instrument Administration',
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
		$criteria->compare('user_role',$this->user_role,true);
		$criteria->compare('trade_creation',$this->trade_creation);
		$criteria->compare('trade_confirmation',$this->trade_confirmation);
		$criteria->compare('trade_cancellation',$this->trade_cancellation);
		$criteria->compare('price_administration',$this->price_administration);
		$criteria->compare('instrument_administration',$this->instrument_administration);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}