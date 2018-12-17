<?php

/**
 * @property integer $id
 * @property integer $order_id
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property double $delivery_price
 * @property string $separate_delivery
 * @property string $zipcode
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $apartment
 * @property integer $paid
 *
 * @property Order $order
 * @property Delivery $delivety
 */

use yupe\widgets\YPurifier;

class OrderDelivery extends \yupe\models\YModel
{

    /**
     *
     */
    const SCENARIO_USER = 'front';
    /**
     *
     */
    const SCENARIO_ADMIN = 'admin';

    /**
     *
     */
    const PAID_STATUS_NOT_PAID = 0;
    /**
     *
     */
    const PAID_STATUS_PAID = 1;


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_order_delivery}}';
    }

    /**
     * @param null|string $className
     * @return $this
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['order_id', 'required'],
            ['zipcode, country, city, street, house, apartment', 'filter', 'filter' => 'trim'],
            ['zipcode, country, city, street, house, apartment ', 'filter', 'filter' => [new YPurifier(), 'purify']],
            [
                'order_id, delivery_id, separate_delivery, numerical, paid',
                'integerOnly' => true,
            ],
            ['delivery_price', 'store\components\validators\NumberValidator'],
            [
                'paid, separate_delivery',
                'unsafe',
                'on' => self::SCENARIO_USER,
            ],

            ['delivery_name', 'length', 'max' => 511],
            ['zipcode', 'length', 'max' => 30],
            ['house', 'length', 'max' => 50],
            ['country', 'length', 'max' => 150],
            ['apartment', 'length', 'max' => 10],
            [
                'id, delivery_id, delivery_price, paid, separate_delivery ',
                'safe',
                'on' => 'search',
            ]

        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'order' => [self::BELONGS_TO, 'Order', 'order_id'],
            'delivery' => [self::BELONGS_TO, 'Delivery', 'delivery_id'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [

            'delivery_id' => Yii::t('OrderModule.order', 'Delivery method'),
            'delivery_price' => Yii::t('OrderModule.order', 'Delivery price'),
            'separate_delivery' => Yii::t('OrderModule.order', 'Separate delivery payment'),
            'zipcode' => Yii::t('OrderModule.order', 'Zipcode'),
            'country' => Yii::t('OrderModule.order', 'Country'),
            'city' => Yii::t('OrderModule.order', 'City'),
            'street' => Yii::t('OrderModule.order', 'Street'),
            'house' => Yii::t('OrderModule.order', 'House'),
            'apartment' => Yii::t('OrderModule.order', 'Apartment'),

        ];
    }


    /**
     * @return array
     */
    public function getPaidStatusList()
    {
        return [
            self::PAID_STATUS_PAID => Yii::t("OrderModule.order", 'Paid'),
            self::PAID_STATUS_NOT_PAID => Yii::t("OrderModule.order", 'Not paid'),
        ];
    }

    /**
     * @return string
     */
    public function getPaidStatus()
    {
        $data = $this->getPaidStatusList();

        return isset($data[$this->paid]) ? $data[$this->paid] : Yii::t("OrderModule.order", '*unknown*');
    }
}
