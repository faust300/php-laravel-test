# Board API (Laravel 10 + PHP 8.2)

라라벨 사전과제용 게시판 API 입니다.  
게시글(Post)과 댓글(Comment)에 대한 CRUD를 지원하며, 모든 수정/삭제는 비밀번호 검증을 거쳐야 합니다.  
Docker 환경에서 실행 가능하며, Postman Collection을 통해 테스트할 수 있습니다.

---

## 🚀 기술 스택
- Laravel 10
- PHP 8.2
- MySQL 8
- Eloquent ORM
- Docker / Docker Compose

---

## ⚙️ 설치 및 실행 방법

### 1. 프로젝트 클론 & 환경 변수 설정
```bash
git clone https://github.com/faust300/php-laravel-test.git
cd php-laravel-test

cp .env.example .env
```

### 2. 컨테이너 빌드 & 실행
```bash
docker compose up -d --build
```

### 3. 앱 키 생성
```bash
docker compose exec app php artisan key:generate
```

### 4. DB 마이그레이션 & 시더 실행
```bash
docker compose exec app php artisan migrate --seed
```

> 시더 실행 시, 더미 게시글과 댓글이 생성됩니다.  
> 모든 시더 데이터의 비밀번호는 기본적으로 `1234` 입니다.

---

## 📚 API 엔드포인트

### 🔹 Posts (게시글)
- `GET    /api/posts?size={n}&page={m}` → 게시글 목록 (페이지네이션, size 기본 10, 최대 50)
- `GET    /api/posts/{id}` → 게시글 상세 (댓글 포함)
- `POST   /api/posts` → 게시글 작성 (**password 필수**)
- `PATCH  /api/posts/{id}` → 게시글 수정 (**password 검증**)
- `DELETE /api/posts/{id}` → 게시글 삭제 (**password 검증, soft delete**)

### 🔹 Comments (댓글)
- `GET    /api/posts/{post_id}/comments?size={n}&page={m}` → 댓글 목록 (페이지네이션)
- `POST   /api/posts/{post_id}/comments` → 댓글 작성 (**password 필수**)
- `PATCH  /api/comments/{id}` → 댓글 수정 (**password 검증**)
- `DELETE /api/comments/{id}` → 댓글 삭제 (**password 검증, soft delete**)

---

## 📦 요청/응답 예시

### 게시글 작성
**Request**
```http
POST /api/posts
Content-Type: application/json
Accept: application/json

{
  "title": "첫 글",
  "content": "라라벨 테스트 API",
  "author": "익명",
  "password": "1234"
}
```

**Response**
```json
{
  "success": true,
  "message": "Post created successfully",
  "data": {
    "id": 1,
    "author": "익명",
    "title": "첫 글",
    "content": "라라벨 테스트 API",
    "created_at": "2025-09-24T08:08:11.000000Z",
    "updated_at": "2025-09-24T08:08:11.000000Z",
    "deleted_at": null
  }
}
```

### 게시글 상세 조회 (댓글 포함)
```http
GET /api/posts/1
Accept: application/json
```

**Response (일부)**
```json
{
  "success": true,
  "message": "Post detail with comments fetched successfully",
  "data": {
    "id": 1,
    "author": "익명",
    "title": "첫 글",
    "content": "라라벨 테스트 API",
    "comments": [
      {
        "id": 10,
        "post_id": 1,
        "author": "익명",
        "content": "첫 댓글!",
        "created_at": "2025-09-24T09:00:00.000000Z"
      }
    ]
  }
}
```

---

## 📑 공통 응답 포맷
```json
성공:
{
  "success": true,
  "message": "메시지",
  "data": { ... }
}

실패:
{
  "success": false,
  "message": "에러 메시지",
  "code": 3001,
  "errors": { ... }
}
```

---

## 🧪 Postman Collection
API 테스트용 Postman Collection 파일이 포함되어 있습니다.

파일 위치:  
`BoardAPI_Full.postman_collection.json`

환경 변수:
- `base_url` (기본값: `http://localhost:8080`)
- `size` (기본 페이지 사이즈, 10)
- `post_id`, `comment_id`

---

## ✅ 요구사항 충족 여부
- [x] Laravel 10 이상, PHP 8.1+
- [x] DB: MySQL
- [x] Eloquent ORM 활용
- [x] 마이그레이션/시더 작성
- [x] Postman Collection 문서 작성
- [x] 기능 요구사항(Post CRUD, 댓글 CRUD, 페이지네이션, 유효성 검사, 공통 JSON 응답) 충족

---

## 👤 Author
이상흡
