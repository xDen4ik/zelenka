<?php

namespace console\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $user_name
 * @property int $user_phone
 * @property int $warehouse_id
 * @property int|null $items_count
 * @property int $status
 * @property string|null $updated_at
 * @property string|null $created_at
 */
class Orders extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'orders';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['user_name', 'user_phone', 'warehouse_id', 'status'], 'required'],
			[['warehouse_id', 'items_count', 'status'], 'integer'],
			[['updated_at', 'created_at'], 'safe'],
			[['user_name'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_name' => 'User Name',
			'user_phone' => 'User Phone',
			'warehouse_id' => 'Warehouse ID',
			'items_count' => 'Items Count',
			'status' => 'Status',
			'updated_at' => 'Updated At',
			'created_at' => 'Created At',
		];
	}

	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => date('Y-m-d H:i:s')
			],
		];
	}

	public static function saveOrders($orders)
	{
		$saved = 0;
		$error = 0;

		foreach ($orders as $order) {
			//here you can add a check for the existence of each parameter
			// save items_count 
			$order['items_count'] = count($order['items']);
			if (empty(trim($order['user_name']))) {
				$order['user_name'] = "Не указан";
			}
			// check if exist order
			$orderData = Orders::findOne($order['id']);
			// save if not exit
			if (!$orderData) {
				//save new order
				$orderData = new Orders();
				$orderData->id = intval($order['id']);
				$orderData->user_name = trim($order['user_name']);
				$orderData->user_phone = $order['user_phone'];
				$orderData->warehouse_id = intval($order['warehouse_id']);
				$orderData->items_count = $order['items_count'];
				$orderData->status = $order['status'];
			} else {
				// update data
				$orderData->id = intval($order['id']);
				$orderData->user_name = $order['user_name'];
				$orderData->user_phone = $order['user_phone'];
				$orderData->warehouse_id = intval($order['warehouse_id']);
				$orderData->items_count = count($order['items']);
				$orderData->status = $order['status'];
			}
			// validate and save
			if ($orderData->validate() && $orderData->save()) {
				$saved++;
			} else {
				$error++;
			}
		}

		return [$saved, $error];
	}
}
