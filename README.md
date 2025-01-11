# DDD合宿用リポジトリ
## 概要
DDDを駆使して勤怠管理システムを作成する

## 機能一覧（ざっくり）
- 勤怠管理
- アカウント管理
- シフト表自動生成

## 技術スタック
- Laravel 11.x
- PHP 8.4
- MySQL 8.0
- Docker
- Docker Compose
- PHPUnit

## ブランチ戦略
- GitHub Flowを採用
- developブランチをベースにfeatureブランチを作成
    - ブランチ名は`feature/hoge`
    - 自分のユーザー名とかは特にいらない
- 作業が終わったらdevelopにPRを作成
    - 承認があるまでマージしない
- PRがマージされたらdevelopブランチをmainブランチにマージ
- マージしたら https://github.com/stongri9/ddd_training_camp/releases/new でリリースを作成
    - リリースバージョンは`0.x.x`（メジャーバージョンは上げない）
    - 機能開発リリースは `0.X.0` 
    - バグ修正リリースは `0.0.X`

## 初回環境構築手順
```
# リポジトリをクローン
git clone git@github.com:stongri9/ddd_training_camp.git

# リポジトリのディレクトリに移動
cd /path/to/ddd_training_camp

# envファイルをコピー
cp -p .env.example .env

# 依存パッケージのインストール
composer install 
npm install

# app_keyを生成
./vendor/bin/sail artisan key:generate

# コンテナを起動
./vendor/bin/sail up -d

# データベースのマイグレーション
./vendor/bin/sail artisan migrate

# ブラウザでアクセス
http://localhost
```

## テスト実行
```
php artisan test
```
