# フリマーケットアプリ

## 環境構築

### Docker ビルド

- git clone git@github.com:Yuuna-hh/test_contact.git
- docker-compose up -d --build

### Laravel セットアップ

- docker-compose exec php bash

- composer install  
  依存パッケージインストール

- cp .env.example .env  
  .env ファイル作成と以下のように編集

* DB_HOST=mysql
* DB_DATABASE=laravel_db
* DB_USERNAME=laravel_user
* DB_PASSWORD=laravel_pass

- php artisan key:generate  
  アプリケーションキー生成

- php artisan migrate
- php artisan db:seed  
  マイグレーションと初期データ投入

### トラブルシューティング

#### storage/logs の Permission denied が出る場合

エラー例：  
The stream or file "/var/www/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied

対処：

- docker-compose exec php bash
- chmod -R 777 storage bootstrap/cache

#### SQLSTATE[HY000] [2002] Connection refused が出る場合

エラー例：  
SQLSTATE[HY000] [2002] Connection refused

対処：.env を下記の内容にしているか確認

- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_PORT=3306
- DB_DATABASE=laravel_db
- DB_USERNAME=laravel_user
- DB_PASSWORD=laravel_pass

改善しない場合：

- docker-compose restart php

#### キャッシュのクリア（必要に応じて）

- docker-compose exec php bash
- php artisan config:clear
- php artisan cache:clear
- php artisan config:cache

## URL 一覧（開発環境）

- お問い合わせフォーム入力：http://localhost/
- お問い合わせ確認：http://localhost/confirm
- サンクスページ：http://localhost/thanks
- ユーザー登録：http://localhost/register
- ログイン：http://localhost/login
- 管理画面：http://localhost/admin
- phpMyAdmin：http://localhost:8080

/reset, /search, /export, /delete は画面表示を伴わない処理エンドポイントのため、画面として存在するのは上記のみです。

## 使用技術（実行環境）

- PHP 8.3.6
- Laravel 8.83.29
- MySQL 8.0.26
- nginx 1.21.1

## コーディング規約

本アプリケーションは COACHTECH が定める以下の PHP コーディング規約に基づいて開発しています。

- https://estra-inc.notion.site/1263a94a2aab4e3ab81bad77db1cf186

## ER 図
