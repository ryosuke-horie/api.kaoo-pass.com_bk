# mem-vision-serverless

## デプロイ方法
参考：https://forestbook-freelance.com/2021/03/12/serverless-framework-aws/
configは自動でserverlessFrameworkが読み込むようで、そうしないと画像のアップ処理等でキーのエラーが起きる。
```
rm -rf vendor/
composer install --prefer-dist --optimize-autoloader --no-dev
serverless deploy --aws-profile mem-vision-dev
```

## DB接続
ローカルで以下の実行が必須。
```
sudo apt-get update
sudo apt-get install php-pgsql
```
