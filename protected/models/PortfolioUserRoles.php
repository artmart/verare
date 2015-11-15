<?php

/**
 * This is the model class for table "portfolio_user_roles".
 *
 * The followings are the available columns in table 'portfolio_user_roles':
 * @property integer $id
 * @property integer $portfolio_id
 * @property integer $user_id
 * @property integer $role_id
 * @property integer $created_by
 * @property integer $is_current
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Portfolios $portfolio
 * @property Users1 $user
 * @property Users1 $createdBy
 * @property UserRole $role
 */
class PortfolioUserRoles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PortfolioUserRoles the static model class
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
		return 'portfolio_user_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('portfolio_id, user_id, role_id, created_by', 'required'),
			array('portfolio_id, user_id, role_id, created_by, is_current', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, portfolio_id, user_id, role_id, created_by, is_current, created_at', 'safe', 'on'=>'search'),
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
			'portfolio' => array(self::BELONGS_TO, 'Portfolios', 'portfolio_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'createdBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
			'role' => array(self::BELONGS_TO, 'UserRole', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'portfolio_id' => 'Portfolio',
			'user_id' => 'User',
			'role_id' => 'Role',
			'created_by' => 'Created By',
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
		$criteria->compare('portfolio_id',$this->portfolio_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('is_current',$this->is_current);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}