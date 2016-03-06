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
 * @property double $total_nominal
 * @property string $file
 * @property string $trade_code
 */
class Ledger extends CActiveRecord
{
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
		//	array('trade_date, instrument_id, portfolio_id, nominal, price, created_by, created_at, trade_status_id, confirmed_by, confirmed_at, version_number, document_id, custody_account, custody_comment, account_number, file, trade_code', 'required'),
			array('instrument_id, portfolio_id, created_by, trade_status_id, confirmed_by, version_number, document_id, account_number, is_current', 'numerical', 'integerOnly'=>true),
			array('nominal, price, total_nominal', 'numerical'),
			array('custody_account, custody_comment', 'length', 'max'=>255),
			array('file', 'length', 'max'=>100),
			array('trade_code', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, trade_date, instrument_id, portfolio_id, nominal, price, created_by, created_at, trade_status_id, confirmed_by, confirmed_at, version_number, document_id, custody_account, custody_comment, account_number, is_current, total_nominal, file, trade_code', 'safe', 'on'=>'search'),
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
			'total_nominal' => 'Total Nominal',
			'file' => 'File',
			'trade_code' => 'Trade Code',
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
		$criteria->compare('total_nominal',$this->total_nominal);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('trade_code',$this->trade_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ledger the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
