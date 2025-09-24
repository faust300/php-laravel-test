# Board API (Laravel 10 + PHP 8.2 + MySQL 8, Docker)

간단한 **게시판 API** 사전과제용 레포입니다.  
Docker 기반으로 누구나 동일한 환경에서 바로 실행할 수 있도록 구성했습니다.

---

## ✅ 스택
- **Laravel 10+**
- **PHP 8.2 (FPM, Alpine)**
- **Nginx (Alpine)**
- **MySQL 8**
- Docker / Docker Compose v2

---

## 🔧 사전 준비물
- Docker Desktop (또는 Docker Engine + Docker Compose v2)
- Git
- (선택) VS Code + 확장: *Docker, PHP Debug, Intelephense, Laravel Extra Intellisense*

---

## 🚀 빠른 실행 (Quick Start: Docker)

```bash
# 0) 레포 클론
git clone <YOUR_REPO_URL>.git
cd <YOUR_REPO_DIR>

# 1) .env 준비
cp .env.example .env

# 2) 컨테이너 기동 (빌드 포함)
docker compose up -d --build

# 3) 의존성 설치
docker compose exec app composer install

# 4) 앱 키 생성
docker compose exec app php artisan key:generate

# 5) 스토리지 링크
docker compose exec app php artisan storage:link

# 6) 데이터베이스 마이그레이션
docker compose exec app php artisan migrate
# 시더까지 넣으려면
# docker compose exec app php artisan migrate --seed
```

- 웹 접속: **http://localhost:8080**
- API 엔드포인트는 `routes/api.php`에서 확인 가능

---

## 🧩 환경 변수 (.env) 주요 항목
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=board_api
DB_USERNAME=board
DB_PASSWORD=boardpass

SESSION_DRIVER=file
```

> ⚠️ `.env`는 커밋하지 않고, `.env.example`를 제공합니다.

---

## 📦 도커 구성 요약
- **app**: PHP-FPM 8.2 + Composer  
- **web**: Nginx, 8080 포트 노출  
- **db**: MySQL 8 (board_api / board / boardpass)

---

## 🛠️ 자주 쓰는 명령어
```bash
docker compose ps                # 컨테이너 상태 확인
docker compose logs -f web       # 웹 서버 로그
docker compose exec app php artisan route:list   # 라우트 확인
docker compose exec db mysql -uboard -pboardpass board_api   # DB 접속
docker compose down              # 종료
docker compose down -v           # 종료 + 볼륨 삭제 (주의)
```

---

## 📂 프로젝트 구조 (요약)
```
.
├─ app/                  # 앱 코드
├─ database/             # migrations, seeders, factories
├─ public/               # /public/index.php
├─ routes/               # api.php, web.php
├─ storage/
├─ docker-compose.yml
└─ docker/
   ├─ php/
   │  ├─ Dockerfile
   │  └─ php.ini
   └─ nginx/
      └─ default.conf
```

---

## 🧯 트러블슈팅
- **`no configuration file provided: not found`** → `docker-compose.yml`이 있는 폴더에서 명령 실행해야 합니다.  
- **`Your Composer dependencies require a PHP version ">= 8.2.0"`** → Dockerfile을 `php:8.2-fpm-alpine` 이상으로 수정 후 재빌드.  
- **`Base table or view not found: 'sessions'`** → `.env`에서 `SESSION_DRIVER=file`로 변경.  
- **권한 문제(storage/bootstrap/cache)**  
  ```bash
  docker compose exec app sh -lc 'chmod -R ug+rw storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache'
  ```

---

## 📝 커밋 가이드 (예시)
```
chore(init): setup Laravel 10 with Docker (PHP 8.2 / Nginx / MySQL)
feat(db): add posts/comments migrations & models
feat(api): post & comment CRUD with validation + pagination
feat(resource): response wrapper + json resources
docs(postman): add collection
docs: update README (docker + quick start)
```

---

## 📄 라이선스
MIT (필요 시 변경)
