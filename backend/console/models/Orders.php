<?php

namespace app\console\models;

use Yii;

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
            [['user_phone', 'warehouse_id', 'items_count', 'status'], 'integer'],
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
}
