<?php

/**
 * This is the model class for table "currency_rates".
 *
 * The followings are the available columns in table 'currency_rates':
 * @property integer $id
 * @property string $day
 * @property double $USD
 * @property double $EUR
 * @property double $JPY
 * @property double $GBP
 * @property double $AUD
 * @property double $CHF
 * @property double $CAD
 * @property double $MXN
 * @property double $CNY
 * @property double $CNH
 * @property double $NZD
 * @property double $SEK
 * @property double $RUB
 * @property double $DKK
 * @property double $NOK
 * @property double $HKD
 * @property double $SGD
 * @property double $TRY
 * @property double $KRW
 * @property double $ZAR
 * @property double $BRL
 * @property double $INR
 */
class CurrencyRates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'currency_rates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('day', 'required'),
			array('USD, EUR, JPY, GBP, AUD, CHF, CAD, MXN, CNY, CNH, NZD, SEK, RUB, DKK, NOK, HKD, SGD, TRY, KRW, ZAR, BRL, INR', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, day, USD, EUR, JPY, GBP, AUD, CHF, CAD, MXN, CNY, CNH, NZD, SEK, RUB, DKK, NOK, HKD, SGD, TRY, KRW, ZAR, BRL, INR', 'safe', 'on'=>'search'),
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
			'day' => 'Day',
			'USD' => 'Usd',
			'EUR' => 'Eur',
			'JPY' => 'Jpy',
			'GBP' => 'Gbp',
			'AUD' => 'Aud',
			'CHF' => 'Chf',
			'CAD' => 'Cad',
			'MXN' => 'Mxn',
			'CNY' => 'Cny',
			'CNH' => 'Cnh',
			'NZD' => 'Nzd',
			'SEK' => 'Sek',
			'RUB' => 'Rub',
			'DKK' => 'Dkk',
			'NOK' => 'Nok',
			'HKD' => 'Hkd',
			'SGD' => 'Sgd',
			'TRY' => 'Try',
			'KRW' => 'Krw',
			'ZAR' => 'Zar',
			'BRL' => 'Brl',
			'INR' => 'Inr',
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
		$criteria->compare('day',$this->day,true);
		$criteria->compare('USD',$this->USD);
		$criteria->compare('EUR',$this->EUR);
		$criteria->compare('JPY',$this->JPY);
		$criteria->compare('GBP',$this->GBP);
		$criteria->compare('AUD',$this->AUD);
		$criteria->compare('CHF',$this->CHF);
		$criteria->compare('CAD',$this->CAD);
		$criteria->compare('MXN',$this->MXN);
		$criteria->compare('CNY',$this->CNY);
		$criteria->compare('CNH',$this->CNH);
		$criteria->compare('NZD',$this->NZD);
		$criteria->compare('SEK',$this->SEK);
		$criteria->compare('RUB',$this->RUB);
		$criteria->compare('DKK',$this->DKK);
		$criteria->compare('NOK',$this->NOK);
		$criteria->compare('HKD',$this->HKD);
		$criteria->compare('SGD',$this->SGD);
		$criteria->compare('TRY',$this->TRY);
		$criteria->compare('KRW',$this->KRW);
		$criteria->compare('ZAR',$this->ZAR);
		$criteria->compare('BRL',$this->BRL);
		$criteria->compare('INR',$this->INR);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CurrencyRates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
