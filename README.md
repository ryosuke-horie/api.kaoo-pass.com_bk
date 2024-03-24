# mem-vision-serverless

## デプロイ方法
参考：https://forestbook-freelance.com/2021/03/12/serverless-framework-aws/
```
php artisan config:clear
php artisan config:cache
serverless deploy --aws-profile mem-vision-dev
```

## DB接続
ローカルで以下の実行が必須。
```
sudo apt-get update
sudo apt-get install php-pgsql
```
