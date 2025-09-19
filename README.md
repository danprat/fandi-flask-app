# Docker Compose Setup for Face Recognition App

This application consists of:
- PHP API backend (port 8080)
- Flask web app (port 5000)
- MySQL database (port 3306)
- Python scripts for face recognition

## Prerequisites
- Docker
- Docker Compose

## Setup
1. Clone or copy the project files
2. Run `docker-compose up --build` to build and start all services
3. Access the PHP API at http://localhost:8080
4. Access the Flask app at http://localhost:5000

## Services
- **mysql**: MySQL 8.0 database
- **php**: Apache with PHP 8.1
- **flask**: Python Flask app
- **python**: Python scripts container

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