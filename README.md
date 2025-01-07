# rese-second
飲食店予約サービス
![スクリーンショット 2024-05-22 112506](https://github.com/9136424556/rese/assets/151130944/c34564b8-41cd-434e-8af4-72873df14954)

## 作成した目的
外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。

## アプリケーションURL
localhost 店舗一覧ページ
localhost/login ログイン画面
localhost/register 会員登録画面
localhost/thanks 会員登録完了画面
localhost/detail　店舗詳細ページ
localhost/done  予約完了画面
localhost/menu メニュー

## 機能一覧
ー　会員登録
ー　ログイン
ー　ログアウト
ー　ユーザー情報取得
ー　ユーザー飲食店予約情報取得
ー　飲食店一覧取得
ー　飲食店詳細取得
### 以下の機能を追加
ー　口コミ機能
ー　CSVインポート機能
ー　店舗一覧ソート機能
## 使用技術
・Laravel 8.83.27  
・nginx 1.21.1  
・PHP 8.1.30  
・Mysql 15.1  
・Docker 27.2.0  

## テーブル設計
![スクリーンショット 2024-05-22 195047](https://github.com/9136424556/rese/assets/151130944/b88f424c-4f05-481b-8dea-cf51ae23368d)　
## ER図
![スクリーンショット 2024-05-22 195155](https://github.com/9136424556/rese/assets/151130944/d430afb5-701d-4e61-b365-e543f268a0b4)

# 環境構築
## 1 Gitファイルをクローンする
git clone git@github.com:9136424556/rese-second
## 2 Dokerコンテナを作成する
docker-compose up -d --build

## 3 Laravelパッケージをインストールする
docker-compose exec php bash
でPHPコンテナにログインし
composer install

## 4 .envファイルを作成する
PHPコンテナにログインした状態で
cp .env.example .env
作成した.envファイルの該当欄を下記のように変更  
DB_HOST=mysql  
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass  

## 5 テーブルの作成
docker-compose exec php bash
でPHPコンテナにログインし(ログインしたままであれば上記コマンドは実行しなくて良いです。)
php artisan migrate

## 6 ダミーデータ作成
PHPコンテナにログインした状態で
php artisan db:seed

## 7 アプリケーション起動キーの作成
PHPコンテナにログインした状態で
php artisan key:generate  

## CSVインポート機能を使用する際の注意事項
 ・ファイル形式: UTF-8でエンコードされたcsvファイルであること。  
 ・カラム順序:  
#### 1.店の名前(50文字以内)   
#### 2.地域名: 「東京都」、「大阪府」、「福岡県」のいずれかを入力  
#### 3.ジャンル名: 「寿司」、「焼肉」、「居酒屋」、「イタリアン」、「ラーメン」のいずれかを入力  
#### 4.画像パス(jpeg、pngのみアップロード可能)  
#### 5.店舗概要(400文字以内)  
※店舗情報の上書きではなく新規店舗を追加するための機能です
### 記述方法  
Excel、またはGoogleスプレッドシートに、上記のカラム順序で入力してください。  
※店の名前→地域名→ジャンル名→画像パス→店舗概要 の順番で入力しないとインポートできません。  
#### 記述例  
![スクリーンショット 2024-12-19 234244](https://github.com/user-attachments/assets/2f8f8528-bf20-4d7f-a737-346169ed8228)

# 管理者ログインの方法
### 1.ログイン画面で以下のメールアドレス、パスワードを入力。  
email: coachtech@coachtech.com  
password: coachtech  
※ php artisan db:seed　実行時にデータベースに登録されるため、登録する必要はありません。  
### 2.ログイン後にホーム画面左上にある青い四角ボタンをクリック。  
### 3.一番下に「ManagementLogin」と表示されるのでクリック。  
### 4.管理者ログイン用画面で以下の内容を入力してログイン。  
email: admin@admin.com  
password: administrator  
役職を選択　→　管理者  
※ 同じくphp artisan db:seed　実行時にデータベースに登録されるため、登録する必要はありません。
