composer install
init 
create db 
common - config - main-local - set db conn 
yii migrate ( create default tables + orders )
yii order/update-net https://zelenka.ru/sample/orders.json
yii order/update-local sample/orders.json
yii order/info 75666
