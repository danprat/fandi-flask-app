# Fandi Flask App - Portainer Deployment

Aplikasi manajemen RT dengan fitur absensi wajah menggunakan Docker Compose.

## Deployment via Portainer

### Langkah 1: Persiapan VPS ARM

Jika Docker belum terinstall, jalankan:

```bash
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER
```

Logout dan login kembali, lalu install Portainer:

```bash
docker volume create portainer_data
docker run -d -p 8000:8000 -p 9000:9000 --name=portainer --restart=always -v /var/run/docker.sock:/var/run/docker.sock -v portainer_data:/data portainer/portainer-ce:latest
```

### Langkah 2: Deploy Stack di Portainer

1. Akses Portainer di `http://your-vps-ip:9000`
2. Login dan pilih local Docker environment
3. Buka menu **Stacks** → **Add Stack**
4. Pilih **Repository** sebagai build method
5. Masukkan:
   - **Name**: `fandi-flask-app`
   - **Repository URL**: `https://github.com/danprat/fandi-flask-app`
   - **Compose Path**: `portainer-simple.yml`
   - **Branch**: `main`

6. Klik **Deploy the Stack**

### Langkah 3: Akses Aplikasi

Setelah deployment selesai:

- **PHP App**: `http://your-vps-ip:8081`
- **Flask API**: `http://your-vps-ip:5001`
- **MySQL**: `your-vps-ip:3307`

### Environment Variables (Opsional)

Untuk customisasi, tambahkan environment variables berikut di Portainer:

```env
PHP_PORT=8081
FLASK_PORT=5001
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=kampuspu_rt
MYSQL_USER=kampuspu_rt
MYSQL_PASSWORD=dhM3YMtk%ADD]Za-
```

### Stack Files Available

1. **portainer-simple.yml** - Stack sederhana untuk quick deployment
2. **portainer-stack.yml** - Stack dengan konfigurasi lengkap
3. **portainer-stack-advanced.yml** - Stack dengan health checks dan advanced config

### Troubleshooting

1. **Apache .htaccess errors**: Fixed dengan mengaktifkan mod_rewrite di Dockerfile.php
2. **Build gagal**: Pastikan VPS memiliki RAM minimal 2GB dan Docker space cukup
3. **Port conflict**: Ubah port mapping jika ada konflik
4. **Database connection**: Tunggu beberapa menit untuk MySQL initialization
5. **500 Internal Server Error**: Jalankan `./troubleshoot.sh` untuk diagnosis lengkap

#### Common Solutions:

**Rebuild semua container:**
```bash
docker compose down
docker compose up -d --build --no-cache
```

**Reset database:**
```bash
docker volume rm fandi-flask-app_mysql_data
docker compose up -d --build
```

**Check real-time logs:**
```bash
docker compose logs -f
```

### Manual Build (jika perlu)

Jika ingin build manual di VPS:

```bash
git clone https://github.com/danprat/fandi-flask-app.git
cd fandi-flask-app
docker compose -f portainer-simple.yml up -d --build
```

### Monitoring

Monitor container logs via Portainer atau command line:

```bash
docker logs fandi-flask-app_php-app_1
docker logs fandi-flask-app_flask-app_1
docker logs fandi-flask-app_python-scripts_1
docker logs fandi-flask-app_mysql_1
```