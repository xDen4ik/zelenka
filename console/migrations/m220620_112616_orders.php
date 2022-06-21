<?php

use yii\db\Migration;

/**
 * Class m220620_112616_orders
 */
class m220620_112616_orders extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('orders', [
			'id' => $this->primaryKey(),
			'user_name' => $this->string()->notNull(),
			'user_phone' => $this->string()->notNull(),
			'warehouse_id' => $this->integer()->notNull(),
			'items_count' => $this->integer(),
			'status' => $this->integer()->notNull(),
			'updated_at' => $this->dateTime(),
			'created_at' => $this->dateTime(),
		], $tableOptions);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m220620_112616_orders cannot be reverted.\n";

		return false;
	}

	/*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220620_112616_orders cannot be reverted.\n";

        return false;
    }
    */
}
