<?php

/**
 * This is the model class for table "audit_trails".
 *
 * The followings are the available columns in table 'audit_trails':
 * @property integer $id
 * @property integer $table_id
 * @property string $reverse_sql
 * @property integer $created_by
 * @property string $created_at
 * @property integer $is_current
 *
 * The followings are the available model relations:
 * @property AuditTables $table
 * @property Users1 $createdBy
 */
class AuditTrails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AuditTrails the static model class
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
		return 'audit_trails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('table_id, reverse_sql, created_by, created_at', 'required'),
			array('table_id, created_by, is_current', 'numerical', 'integerOnly'=>true),
			array('reverse_sql', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, table_id, reverse_sql, created_by, created_at, is_current', 'safe', 'on'=>'search'),
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
			'table' => array(self::BELONGS_TO, 'AuditTables', 'table_id'),
			'createdBy' => array(self::BELONGS_TO, 'Users1', 'created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'table_id' => 'Table',
			'reverse_sql' => 'Reverse Sql',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
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
		$criteria->compare('table_id',$this->table_id);
		$criteria->compare('reverse_sql',$this->reverse_sql,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('is_current',$this->is_current);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}