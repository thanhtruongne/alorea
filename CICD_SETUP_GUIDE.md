# Hướng dẫn Setup CI/CD với Docker & GitHub Actions

## 🎯 Tổng quan

Hệ thống CI/CD này bao gồm các stage:
1. **Build**: Build Docker image từ source code
2. **Test**: Chạy unit tests (optional)
3. **Push**: Push image lên GitHub Container Registry
4. **Deploy**: Tự động deploy lên server production

## 📋 Yêu cầu

- GitHub repository
- Docker Hub hoặc GitHub Container Registry
- Server production (VPS/Cloud) có Docker và Docker Compose

## 🔧 Setup từng bước

### Bước 1: Cấu hình GitHub Secrets

Vào repository GitHub → **Settings** → **Secrets and variables** → **Actions** → **New repository secret**

Thêm các secrets sau:

#### Bắt buộc cho Deploy:
```
PRODUCTION_HOST       : IP hoặc domain của server production (VD: 192.168.1.100)
PRODUCTION_USER       : Username SSH (VD: ubuntu, root)
SSH_PRIVATE_KEY       : Private key SSH để kết nối server
SSH_PORT              : Port SSH (mặc định 22)
```

#### Optional (nếu dùng Docker Hub thay vì GHCR):
```
DOCKER_USERNAME       : Username Docker Hub
DOCKER_PASSWORD       : Password hoặc Access Token Docker Hub
```

#### Biến môi trường cho Laravel:
```
DB_PASSWORD           : Password MySQL production
DB_DATABASE           : Tên database
DB_USERNAME           : Username database
```

### Bước 2: Tạo SSH Key cho GitHub Actions

Trên server production, tạo SSH key mới:

```bash
ssh-keygen -t ed25519 -C "github-actions" -f ~/.ssh/github-actions
```

Thêm public key vào authorized_keys:
```bash
cat ~/.ssh/github-actions.pub >> ~/.ssh/authorized_keys
```

Copy private key và paste vào GitHub Secret `SSH_PRIVATE_KEY`:
```bash
cat ~/.ssh/github-actions
```

### Bước 3: Chuẩn bị Server Production

#### 3.1. Cài đặt Docker và Docker Compose
```bash
# Cài Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Cài Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

#### 3.2. Clone repository về server
```bash
# Tạo thư mục
sudo mkdir -p /var/www
cd /var/www

# Clone repository (thay YOUR_GITHUB_USERNAME bằng username của bạn)
sudo git clone https://github.com/thanhtruongne/alorea.git
sudo chown -R $USER:$USER alorea
cd alorea

# Hoặc clone với SSH key (nếu đã setup)
# sudo git clone git@github.com:thanhtruongne/alorea.git
```

**Lưu ý**: Nếu repository private, bạn cần:
- Tạo Personal Access Token trên GitHub (Settings → Developer settings → Personal access tokens)
- Clone bằng: `git clone https://USERNAME:TOKEN@github.com/thanhtruongne/alorea.git`

#### 3.3. Tạo/Sửa file docker-compose.yml trên server (nếu cần)

File đã có sẵn từ repository. Nếu cần sửa cho production:
```bash
nano docker-compose.yml
```

Đảm bảo phần `app` sử dụng image từ registry (không có `build`):
```yaml
  app:
    image: ghcr.io/thanhtruongne/alorea:main
    container_name: alorea_app
    working_dir: /app
    expose:
      - "9000"
    environment:
      - DB_HOST=db
      - DB_DATABASE=${DB_DATABASE}
      - DB_USERNAME=${DB_USERNAME}
      - DB_PASSWORD=${DB_PASSWORD}
    depends_on:
      db:
        condition: service_healthy
    restart: always
```

Sửa port cho webserver (80 thay vì 5000):
```yaml
  webserver:
    ports:
      - "80:80"
```

#### 3.4. Tạo file .env trên server
```bash
nano .env
```

Nội dung:
```env
DB_DATABASE=alorea
DB_USERNAME=root
DB_PASSWORD=your_secure_password
```

#### 3.5. Copy và chỉnh sửa Laravel .env
```bash
# Copy file .env mẫu
cp .env.example .env

# Sửa cấu hình database và app
nano .env
```

Sửa các dòng:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

DB_HOST=db
DB_DATABASE=alorea
DB_USERNAME=root
DB_PASSWORD=your_secure_password
```

#### 3.6. Kiểm tra nginx config

File `nginx.app.conf` đã có sẵn từ repository. Nếu cần sửa:
```bash
nano nginx.app.conf
```

#### 3.7. Login vào GitHub Container Registry trên server
```bash
echo "YOUR_GITHUB_TOKEN" | docker login ghcr.io -u YOUR_GITHUB_USERNAME --password-stdin
```

### Bước 4: Cập nhật docker-compose.yml trong repo

Sửa dòng image trong file docker-compose.yml:
```yaml
app:
  image: ghcr.io/thanhtruongne/alorea:main
```

Thay `thanhtruongne/alorea` bằng đúng tên repository của bạn.

### Bước 5: Push code lên GitHub

```bash
git add .
git commit -m "Setup CI/CD with GitHub Actions"
git push origin main
```

### Bước 6: Kiểm tra Workflow

1. Vào repository GitHub → **Actions**
2. Xem workflow "CI/CD Pipeline" đang chạy
3. Kiểm tra từng step: Build → Test → Deploy

### Bước 7: Xác minh Deploy thành công

Trên server production:
```bash
# Kiểm tra containers
docker ps

# Xem logs
docker compose logs -f app

# Test API
curl http://localhost
```

## 🔄 Workflow chi tiết

### Workflow 1: ci-cd.yml (Main Pipeline)

**Trigger**: Push vào branch `main` hoặc `develop`, Pull Request vào `main`

**Jobs**:
1. **build-and-test**
   - Checkout code
   - Setup Docker Buildx
   - Login vào GHCR
   - Build Docker image
   - Push image lên registry
   - Run tests (optional)

2. **deploy** (chỉ chạy với branch main)
   - SSH vào server production
   - Pull image mới nhất
   - Restart containers
   - Run migrations
   - Clear cache Laravel

### Workflow 2: build-only.yml (Feature branches)

**Trigger**: Push vào branch `feature/*` hoặc `bugfix/*`

**Jobs**:
- Build image để test (không push lên registry)
- Scan vulnerabilities với Trivy

## 🚀 Các tính năng nâng cao

### 1. Thêm stage Staging (trước Production)

Tạo file `.github/workflows/deploy-staging.yml`:
```yaml
name: Deploy to Staging

on:
  push:
    branches: [ develop ]

jobs:
  deploy-staging:
    runs-on: ubuntu-latest
    steps:
      - name: Deploy to staging server
        uses: appleboy/ssh-action@v1.0.0
        with:
          host: ${{ secrets.STAGING_HOST }}
          username: ${{ secrets.STAGING_USER }}
          key: ${{ secrets.SSH_PRIVATE_KEY }}
          script: |
            cd /var/www/alorea-staging
            docker compose pull app
            docker compose up -d --force-recreate app
```

### 2. Thêm notifications (Slack, Discord)

Thêm vào cuối file ci-cd.yml:
```yaml
      - name: Notify Slack
        if: always()
        uses: 8398a7/action-slack@v3
        with:
          status: ${{ job.status }}
          webhook_url: ${{ secrets.SLACK_WEBHOOK }}
```

### 3. Rollback tự động khi deploy fail

Thêm step rollback:
```yaml
      - name: Rollback on failure
        if: failure()
        uses: appleboy/ssh-action@v1.0.0
        with:
          host: ${{ secrets.PRODUCTION_HOST }}
          username: ${{ secrets.PRODUCTION_USER }}
          key: ${{ secrets.SSH_PRIVATE_KEY }}
          script: |
            cd /var/www/alorea
            docker compose down app
            docker tag ghcr.io/thanhtruongne/alorea:previous ghcr.io/thanhtruongne/alorea:main
            docker compose up -d app
```

## 🐛 Troubleshooting

### Lỗi: Permission denied (publickey)
**Giải pháp**: Kiểm tra SSH key đã thêm đúng vào server và GitHub Secrets.

### Lỗi: Image pull failed
**Giải pháp**: Đảm bảo đã login GHCR trên server production.

### Lỗi: Container unhealthy
**Giải pháp**: Kiểm tra logs: `docker compose logs app db`

### Build quá lâu
**Giải pháp**: Đã enable cache trong workflow, lần build sau sẽ nhanh hơn.

## 📚 Tài liệu tham khảo

- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [Docker Build Push Action](https://github.com/docker/build-push-action)
- [GitHub Container Registry](https://docs.github.com/en/packages/working-with-a-github-packages-registry/working-with-the-container-registry)

## ✅ Checklist Setup

- [ ] Tạo GitHub Secrets (PRODUCTION_HOST, SSH_PRIVATE_KEY, etc.)
- [ ] Setup SSH key trên server
- [ ] Cài Docker + Docker Compose trên server
- [ ] Tạo docker-compose.yml và .env trên server
- [ ] Login GHCR trên server
- [ ] Push code lên GitHub
- [ ] Kiểm tra workflow chạy thành công
- [ ] Verify deployment trên server

## 🎉 Hoàn thành!

Sau khi setup xong, mỗi lần push code lên branch `main`, hệ thống sẽ tự động:
1. Build Docker image mới
2. Push lên GitHub Container Registry
3. Deploy lên server production
4. Run migrations và clear cache

Chúc bạn thành công! 🚀
