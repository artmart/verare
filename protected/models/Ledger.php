<?php

/**
 * This is the model class for table "ledger".
 *
 * The followings are the available columns in table 'ledger':
 * @property integer $id
 * @property string $trade_date
 * @property integer $instrument_id
 * @property integer $portfolio_id
 * @property double $nominal
 * @property double $price
 * @property integer $created_by
 * @property string $created_at
 * @property integer $trade_status_id
 * @property integer $confirmed_by
 * @property string $confirmed_at
 * @property integer $version_number
 * @property integer $document_id
 * @property string $custody_account
 * @property string $custody_comment
 * @property integer $account_number
 * @property integer $is_current
 *
 * The followings are the available model relations:
 * @property Documents $document
 * @property Instruments $instrument
 * @property Portfolios $portfolio
 * @property TradeStatus $tradeStatus
 * @property Users1 $createdBy
 * @property Users1 $confirmedBy
 */
class Ledger extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ledger the static model class
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
		return 'ledger';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trade_date, instrument_id, portfolio_id, nominal, price, created_by, created_at, trade_status_id, confirmed_by, confirmed_at, version_number, document_id, custody_account, custody_comment, account_number', 'required'),
			array('instrument_id, portfolio_id, created_by, trade_status_id, confirmed_by, version_number, document_id, account_number, is_current', 'numerical', 'integerOnly'=>true),
			array('nominal, price', 'numerical'),
			array('custody_account, custody_comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, trade_date, instrument_id, portfolio_id, nominal, price, created_by, created_at, trade_status_id, confirmed_by, confirmed_at, version_number, document_id, custody_account, custody_comment, account_number, is_current', 'safe', 'on'=>'search'),
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
			'document' => array(self::BELONGS_TO, 'Documents', 'document_id'),
			'instrument' => array(self::BELONGS_TO, 'Instruments', 'instrument_id'),
			'portfolio' => array(self::BELONGS_TO, 'Portfolios', 'portfolio_id'),
			'tradeStatus' => array(self::BELONGS_TO, 'TradeStatus', 'trade_status_id'),
			'createdBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
			'confirmedBy' => array(self::BELONGS_TO, 'Users', 'confirmed_by'),
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
			'portfolio_id' => 'Portfolio',
			'nominal' => 'Nominal',
			'price' => 'Price',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'trade_status_id' => 'Trade Status',
			'confirmed_by' => 'Confirmed By',
			'confirmed_at' => 'Confirmed At',
			'version_number' => 'Version Number',
			'document_id' => 'Document',
			'custody_account' => 'Custody Account',
			'custody_comment' => 'Custody Comment',
			'account_number' => 'Account Number',
			'is_current' => 'Is Current',
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
		$criteria->compare('portfolio_id',$this->portfolio_id);
		$criteria->compare('nominal',$this->nominal);
		$criteria->compare('price',$this->price);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('trade_status_id',$this->trade_status_id);
		$criteria->compare('confirmed_by',$this->confirmed_by);
		$criteria->compare('confirmed_at',$this->confirmed_at,true);
		$criteria->compare('version_number',$this->version_number);
		$criteria->compare('document_id',$this->document_id);
		$criteria->compare('custody_account',$this->custody_account,true);
		$criteria->compare('custody_comment',$this->custody_comment,true);
		$criteria->compare('account_number',$this->account_number);
		$criteria->compare('is_current',$this->is_current);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}