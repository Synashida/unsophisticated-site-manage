# unsophisticated-site-manage

検証用のサイトノーコードで作成できるように管理画面でバーチャルホストを作成できる。  
インフラ周りの準備をできるだけしないで検証環境を作れるようにするコンテナ。  
  
実装できるバーチャルホスト環境  
1. 静的コンテンツだけで実装されたサイト
2. 静的コンテンツ/ノンフレームワークの素のPHP7を利用したサイト
3. Wordpressを利用したサイト

## 管理画面

前提条件: hostsファイルに 127.0.0.1 test.local が設定されていること。  
参考: https://faq.mypage.otsuka-shokai.co.jp/app/answers/detail/a_id/126047/  

### 起動

docker-compose up -d  

### アクセス

http://test.local:8000  

### 作成方法

上記画面のドメイン名を入力。  
wordpressを利用する場合は、チェックボックスをONにして、DB名を入力。  
作成するボタンをクリックするとサイトが作成される。  
入力したドメイン名はhostsに登録する必要があるので、  
127.0.0.1 [入力したドメイン名]  
を追記することでアクセスできるようになる。  
  
## サイトの編集方法

./user-apps/[入力したドメイン名]  
ディレクトリにサイトのデータを配置・編集してください。  
(wordpressのファイルもここに作られます。)  

## wordpressのデータベースユーザ名とパスワード

User: root  
Password: mysqladmin  
※パスワードは変更不可  

## Adminer (phpMyAdminのようなもの)へのアクセス

http://localhost:8080/  
ユーザ名: root  
パスワード: mysqladmin  
データベース: 入力不要  

## メール受信の確認

http://localhost:8025/  

### SMTPの情報

host: mail  
port: 25  
SSL: 利用しない  
認証: 認証しない  
ユーザ名: なし  
パスワード: なし  

### 検証確認Wordpressプラグイン

Easy WP SMTP  
WP Mail SMTP by WPForms  

## 環境情報

PHP 7.4.23  
Wordpress 5.8 (作成時点の最新版)  


# インストール方法

## 前提

○ Dockerをインストール  
  https://ops.jig-saw.com/tech-cate/docker-for-windows-install  
  
○ VS Codeをインストール  
  https://www.javadrive.jp/vscode/install/index1.html  
    
  VC CodeからDockerを利用する  
  https://dev.classmethod.jp/articles/vscode-container-connect/  
  
  
### ポートを変更したい

docker-compose.ymlの  
  
```
ports
  - "8000:80"
```
  
8000の値を任意の値に変更する。  