# Docker Compose Setup for Face Recognition App

This application consists of:
- PHP API backend (port 8080)
- Flask web app (port 5000)
- MySQL database (port 3306)
- Python scripts for face recognition

## Prerequisites
- Docker
- Docker Compose

## Quick Start (Using Pre-built Images)
1. Clone the repository:
   ```bash
   git clone https://github.com/danprat/fandi-flask-app.git
   cd fandi-flask-app
   ```

2. Run the application:
   ```bash
   docker-compose up
   ```

3. Access the applications:
   - PHP API: http://localhost:8080
   - Flask App: http://localhost:5000

## Build from Source (Alternative)
If you prefer to build images locally:
```bash
docker-compose -f docker-compose.yml up --build
```

## Services
- **mysql**: MySQL 8.0 database
- **php**: Apache with PHP 8.1 (image: `ghcr.io/danprat/fandi-flask-app/php:latest`)
- **flask**: Python Flask app (image: `ghcr.io/danprat/fandi-flask-app/flask:latest`)
- **python**: Python scripts container (image: `ghcr.io/danprat/fandi-flask-app/python:latest`)

## Database
The database is initialized with the SQL file `kampuspu_apirt06.sql`.
Default credentials:
- User: kampuspu_rt
- Password: dhM3YMtk%ADD]Za-
- Database: kampuspu_rt

## Volumes
- `mysql_data`: Persistent MySQL data
- `./uploads`: Shared uploads directory

## Stopping
Run `docker-compose down` to stop all services.

## GitHub Actions
Images are automatically built and pushed to GitHub Container Registry on every push to main branch.