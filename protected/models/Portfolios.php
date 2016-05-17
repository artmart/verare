<?php

/**
 * This is the model class for table "portfolios".
 *
 * The followings are the available columns in table 'portfolios':
 * @property integer $id
 * @property integer $client_id
 * @property string $portfolio
 * @property string $description
 * @property integer $is_current
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Ledger[] $ledgers
 * @property PortfolioUserRoles[] $portfolioUserRoles
 * @property Clients $client
 * type_id
 * currency
 */
class Portfolios extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Portfolios the static model class
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
		return 'portfolios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id, portfolio, description, created_at, currency', 'required'),
			array('client_id, is_current, type_id', 'numerical', 'integerOnly'=>true),
			array('portfolio', 'length', 'max'=>255),
            array('currency', 'length', 'max'=>10),
            
            
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, currency, type_id, client_id, portfolio, description, is_current, created_at', 'safe', 'on'=>'search'),
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
			'ledgers' => array(self::HAS_MANY, 'Ledger', 'portfolio_id'),
			'portfolioUserRoles' => array(self::HAS_MANY, 'PortfolioUserRoles', 'portfolio_id'),
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_id' => 'Client',
			'portfolio' => 'Portfolio',
			'description' => 'Description',
			'is_current' => 'Is Current',
			'created_at' => 'Created At',
            'type_id' => 'Type Id',
            'currency' => 'currency',
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
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('portfolio',$this->portfolio,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_current',$this->is_current);
		$criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('type_id',$this->type_id);
        $criteria->compare('currency',$this->currency);
        
  
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}