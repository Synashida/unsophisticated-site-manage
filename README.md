# unsophisticated-site-manage
静的コンテンツだけで構成されるようなシンプルなサイトの開発に利用できる簡易Dockerコンテナ

# 実行方法

## 前提

○ Dockerがインストール済みであること
  https://ops.jig-saw.com/tech-cate/docker-for-windows-install

○ VS Codeがインストールされていること
  https://www.javadrive.jp/vscode/install/index1.html
  
  VC CodeからDockerを利用する
  https://dev.classmethod.jp/articles/vscode-container-connect/

## 手順


1. hostsに127.0.0.1 test.localを追記する
2. ping test.localでpingが通ることを確認する。
3. このリポジトリをクローン
4. docker-compose up -d
5. http://localhost:8000
   
## Tips

### ポートを変更したい

docker-compose.ymlの

```
ports
  - "8000:80"
```

8000の値を任意の値に変更する。