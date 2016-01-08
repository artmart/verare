<?php

/**
 * This is the model class for table "user_role".
 *
 * The followings are the available columns in table 'user_role':
 * @property integer $id
 * @property integer $trade_role
 * @property string $user_role
 * @property integer $trade_creation
 * @property integer $trade_confirmation
 * @property integer $trade_cancellation
 * @property integer $price_administration
 * @property integer $instrument_administration
 * @property integer $ledger_access_level
 * @property integer $users_access_level
 * @property integer $user_roles_access_level
 * @property integer $portfolios_access_level
 * @property integer $instruments_access_level
 * @property integer $counterparties_access_level
 * @property integer $documents_access_level
 * @property integer $prices_access_level
 * @property integer $audit_trails_access_level
 * @property integer $grouping_access_level
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
			array('trade_role, trade_creation, trade_confirmation, trade_cancellation, price_administration, instrument_administration, ledger_access_level, users_access_level, user_roles_access_level, portfolios_access_level, instruments_access_level, counterparties_access_level, documents_access_level, prices_access_level, audit_trails_access_level, grouping_access_level', 'numerical', 'integerOnly'=>true),
			array('user_role', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, trade_role, user_role, trade_creation, trade_confirmation, trade_cancellation, price_administration, instrument_administration, ledger_access_level, users_access_level, user_roles_access_level, portfolios_access_level, instruments_access_level, counterparties_access_level, documents_access_level, prices_access_level, audit_trails_access_level, grouping_access_level', 'safe', 'on'=>'search'),
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
			'trade_role' => 'Trade Role',
			'user_role' => 'User Role',
			'trade_creation' => 'Trade Creation',
			'trade_confirmation' => 'Trade Confirmation',
			'trade_cancellation' => 'Trade Cancellation',
			'price_administration' => 'Price Administration',
			'instrument_administration' => 'Instrument Administration',
			'ledger_access_level' => 'Ledger Access Level',
			'users_access_level' => 'Users Access Level',
			'user_roles_access_level' => 'User Roles Access Level',
			'portfolios_access_level' => 'Portfolios Access Level',
			'instruments_access_level' => 'Instruments Access Level',
			'counterparties_access_level' => 'Counterparties Access Level',
			'documents_access_level' => 'Documents Access Level',
			'prices_access_level' => 'Prices Access Level',
			'audit_trails_access_level' => 'Audit Trails Access Level',
			'grouping_access_level' => 'Grouping Access Level',
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
		$criteria->compare('trade_role',$this->trade_role);
		$criteria->compare('user_role',$this->user_role,true);
		$criteria->compare('trade_creation',$this->trade_creation);
		$criteria->compare('trade_confirmation',$this->trade_confirmation);
		$criteria->compare('trade_cancellation',$this->trade_cancellation);
		$criteria->compare('price_administration',$this->price_administration);
		$criteria->compare('instrument_administration',$this->instrument_administration);
		$criteria->compare('ledger_access_level',$this->ledger_access_level);
		$criteria->compare('users_access_level',$this->users_access_level);
		$criteria->compare('user_roles_access_level',$this->user_roles_access_level);
		$criteria->compare('portfolios_access_level',$this->portfolios_access_level);
		$criteria->compare('instruments_access_level',$this->instruments_access_level);
		$criteria->compare('counterparties_access_level',$this->counterparties_access_level);
		$criteria->compare('documents_access_level',$this->documents_access_level);
		$criteria->compare('prices_access_level',$this->prices_access_level);
		$criteria->compare('audit_trails_access_level',$this->audit_trails_access_level);
		$criteria->compare('grouping_access_level',$this->grouping_access_level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}