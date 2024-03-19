# mem-vision-serverless

## デプロイ方法
参考：https://forestbook-freelance.com/2021/03/12/serverless-framework-aws/
serverless deploy --aws-profile mem-vision-dev

## 初期アクセス
フロント：https://d7hdiox79hjvb.cloudfront.net/
バックエンド：https://ject1xt608.execute-api.ap-northeast-1.amazonaws.com

## DB接続
ローカルで以下の実行が必須。
```
sudo apt-get update
sudo apt-get install php-pgsql
```

## API エンドポイント（暫定）
https://ject1xt608.execute-api.ap-northeast-1.amazonaws.com/api/
