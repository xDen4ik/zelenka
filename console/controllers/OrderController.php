<?php

namespace console\controllers;

use console\models\Orders;
use console\models\Validation;

class OrderController extends \yii\console\Controller
{
	public function actionUpdateNet($url = "")
	{
		//Validation
		if (empty($url)) {
			echo ('Ссылка не указана');
			return 1;
		}

		if (!Validation::url_exists($url)) {
			echo ('Ссылка не работает');
			return 1;
		}

		if (!Validation::isJson(file_get_contents($url))) {
			echo "Файл не в json формате";
			return 1;
		}

		$result = json_decode(file_get_contents($url), true);

		if (!isset($result['orders']) || empty($result['orders'])) {
			echo "Заказов нет";
			return 1;
		}

		$orders = $result['orders'];

		$save = Orders::saveOrders($orders);

		echo ('Всего заказов: ' . count($orders) . PHP_EOL);
		echo ('Сохраненные/обновленные заказы: ' . $save[0] . PHP_EOL);
		echo ('Не удалось сохранить/обновить: ' . $save[1] . PHP_EOL);
	}

	public function actionUpdateLocal($path = "")
	{
		//Validation
		if (empty($path)) {
			echo ('Путь к файлу не указан');
			return 1;
		}

		if (!Validation::file_exist($path)) {
			echo "Файл не существует";
			return 1;
		}

		if (!Validation::isJson(file_get_contents($path))) {
			echo "Файл не в json формате";
			return 1;
		}

		$result = json_decode(file_get_contents($path), true);

		if (!isset($result['orders']) || empty($result['orders'])) {
			echo "Заказов нет";
			return 1;
		}

		$orders = $result['orders'];

		$save = Orders::saveOrders($orders);


		echo ('Всего заказов: ' . count($orders) . PHP_EOL);
		echo ('Сохраненные/обновленные заказы: ' . $save[0] . PHP_EOL);
		echo ('Не удалось сохранить/обновить: ' . $save[1] . PHP_EOL);
	}

	public function actionInfo($id)
	{
		$id = intval($id);

		$find = Orders::find($id)->where(['id' => $id])->asArray()->one();

		// Exist check
		if (!$find) {
			echo ('Заказ не найден!');
			die();
		}

		echo (json_encode($find, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
}
