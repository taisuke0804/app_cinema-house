# ポートフォリオ: CINEMA-HOUSE

このリポジトには、**映画予約システム**になります。このプロジェクトは、フロントエンド、バックエンド、データベース管理、デプロイメントなど、ウェブ開発における個人用ポートフォリオになりますのでご了承ください。  
小規模なプライベートシネマの座席予約管理を目的としたアプリケーションとなります。

## 機能

### ユーザー側
- 利用可能な映画とスケジュールを閲覧。
- 選択した映画の座席を予約。
- 予約履歴を表示。

### 管理者側
- 映画の詳細を追加および管理。
- 上映スケジュールを作成および管理。

## 使用技術

### フロントエンド
- **HTML5, CSS3, JavaScript**
- **jQuery3.7.1**
- **Bootstrap 5** を使用したレスポンシブデザインとUIコンポーネント

### バックエンド
- **PHP8.3** と **Laravel 11**

### データベース
- **MariaDB11.2.5**

### デプロイメント
- **Docker** を使用したローカル開発環境

## セットアップ

### 条件
- システムに Docker および Docker Compose がインストールされていること。
- Git がインストールされていること。
- ビルド作業の自動化ツール「Makefile」は必須ではありませんがあると便利です

### 手順
1. リポジトリをクローン:
   ```bash
   git clone https://github.com/taisuke0804/app_cinema-house.git
   ```

2. 必要に応じて環境変数を設定:
   `/.env` ファイルを開き、設定を更新してください。

3. Docker コンテナをビルドして起動:
   ```bash
   docker-compose up -d
   ```

4. アプリケーション実行のため各種コマンド実行とマイグレーション:
   ```bash
   docker compose exec dev-app php artisan key:generate
   docker compose exec dev-app php artisan storage:link
   docker compose exec dev-app chmod -R 777 storage bootstrap/cache
   docker compose exec dev-app php artisan migrate:fresh --seed --seeder=DevelopmentSeeder
   docker compose exec dev-app composer install
   docker compose exec dev-app npm install
   docker compose exec dev-app npm run dev
   ```

5. アプリケーションにアクセス:
   - ユーザーインターフェース: [http://localhost:8000](http://localhost:8000)
   - 管理者パネル: [http://localhost:8000/admin](http://localhost:8000/admin)

## ブランチ命名規則

このプロジェクトでは、以下のGitブランチ戦略を採用しています:
- `feature/<チケット番号>-<機能名>` 新機能の場合。
- `bugfix/<チケット番号>-<バグ内容>` バグ修正の場合。
- `improvement/<チケット番号>-<改良内容>` 機能改良の場合。
- `hotfix/<チケット番号>-<緊急修正内容>` 緊急修正の場合。

### 例:
```bash
git checkout -b feature/0001-add-movie-schedule
```

## 今後の追加予定機能
- 予約確認のためのメール通知。
- 管理者側の2段階認証機能。
- 管理者側でのユーザー管理機能。
- タスクスケジュールによる上映スケジュールの削除

## ライセンス
このプロジェクトは [MITライセンス](LICENSE) の下でライセンスされています。
---

プロジェクトをご覧いただきありがとうございます！ぜひフィードバックをよろしくお願いします。
