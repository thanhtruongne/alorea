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

#### 2.1. Hiểu về SSH Key

SSH Key gồm 2 phần:
- **Private Key** (khóa bí mật): Giữ bí mật, dùng để xác thực từ GitHub Actions
- **Public Key** (khóa công khai): Đặt trên server, cho phép kết nối từ private key

#### 2.2. Tạo SSH Key trên server production

```bash
# SSH vào server production
ssh your_username@your_server_ip

# Tạo SSH key pair mới
ssh-keygen -t ed25519 -C "github-actions" -f ~/.ssh/github-actions
```

**Giải thích lệnh:**
- `-t ed25519`: Dùng thuật toán mã hóa Ed25519 (bảo mật, hiện đại)
- `-C "github-actions"`: Comment để nhận biết key này dùng cho gì
- `-f ~/.ssh/github-actions`: Lưu key vào file `github-actions` trong thư mục `~/.ssh/`

**Khi chạy lệnh, hệ thống sẽ hỏi:**
```
Enter passphrase (empty for no passphrase):
```
→ **Nhấn Enter** (để trống, không đặt mật khẩu) vì GitHub Actions không thể nhập passphrase tự động.

**Kết quả:** 2 file được tạo:
- `~/.ssh/github-actions` (private key - khóa bí mật)
- `~/.ssh/github-actions.pub` (public key - khóa công khai)

#### 2.3. Thêm public key vào authorized_keys

```bash
cat ~/.ssh/github-actions.pub >> ~/.ssh/authorized_keys
```

**Giải thích:**
- `cat`: Đọc nội dung file
- `>>`: Ghi thêm vào cuối file (không ghi đè)
- `~/.ssh/authorized_keys`: File chứa danh sách các public key được phép SSH vào server

**Lưu ý:** File này phải có đúng permissions:
```bash
chmod 600 ~/.ssh/authorized_keys
chmod 700 ~/.ssh
```

#### 2.4. Copy private key để paste vào GitHub

```bash
cat ~/.ssh/github-actions
```

**Kết quả hiển thị giống như:**
```
-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAABG5vbmUAAAAEbm9uZQAAAAAAAAABAAAAMwAAAAtzc2gtZW
QyNTUxOQAAACDGKz...
...nhiều dòng...
-----END OPENSSH PRIVATE KEY-----
```

**Cách copy:**
1. **Trên Linux/Mac:** Chọn toàn bộ text và copy (Ctrl+Shift+C)
2. **Hoặc dùng lệnh:** 
   ```bash
   # Copy vào clipboard (nếu có xclip)
   cat ~/.ssh/github-actions | xclip -selection clipboard
   
   # Hoặc hiển thị để copy thủ công
   cat ~/.ssh/github-actions
   ```

#### 2.5. Thêm private key vào GitHub Secrets

1. Vào repository GitHub
2. **Settings** → **Secrets and variables** → **Actions**
3. Click **New repository secret**
4. Name: `SSH_PRIVATE_KEY`
5. Value: Paste toàn bộ nội dung private key (bao gồm cả dòng BEGIN và END)
6. Click **Add secret**

**Lưu ý quan trọng:**
- Copy **toàn bộ** nội dung, từ `-----BEGIN` đến `-----END`
- Không thêm/bớt khoảng trắng, không sửa gì
- Không chia sẻ private key với ai

#### 2.6. Test SSH key (Optional)

Từ máy tính khác, test kết nối bằng private key:
```bash
# Copy private key về máy local (chỉ để test)
scp your_username@your_server_ip:~/.ssh/github-actions ~/test-key

# Test SSH với key
ssh -i ~/test-key your_username@your_server_ip

# Xóa file test sau khi xong
rm ~/test-key
```

**Lưu ý bảo mật:**
- Sau khi copy private key vào GitHub Secrets, **không nên** giữ bản copy ở máy local
- Private key trên server chỉ dùng để GitHub Actions có thể deploy
- Nếu bị lộ private key, phải xóa public key khỏi `authorized_keys` và tạo key mới

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
