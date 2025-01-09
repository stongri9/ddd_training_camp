# DDD合宿用リポジトリ

# 環境構築手順
```
# リポジトリをクローン
git clone git@github.com:stongri9/ddd_training_camp.git

# リポジトリのディレクトリに移動
cd /path/to/ddd_training_camp

# 依存パッケージのインストール
composer install 
npm install

# コンテナを起動
./vendor/bin/sail up -d

# データベースのマイグレーション
./vendor/bin/sail artisan migrate

# ブラウザでアクセス
http://localhost
```

# テスト実行
```
php artisan test
```
