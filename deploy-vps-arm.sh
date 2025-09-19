#!/bin/bash

echo "Deploying Flask App on ARM VPS..."

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "Docker is not running. Please run ./install-vps-arm.sh first"
    exit 1
fi

# Stop existing containers if running
echo "Stopping existing containers..."
docker compose down 2>/dev/null || true

# Pull latest changes if git repo
if [ -d ".git" ]; then
    echo "Pulling latest changes..."
    git pull
fi

# Build and start containers
echo "Building and starting containers..."
docker compose up -d --build

# Show status
echo "Deployment completed!"
echo ""
echo "Services status:"
docker compose ps

echo ""
echo "Application URLs:"
echo "- PHP App: http://your-vps-ip:8081"
echo "- Flask App: http://your-vps-ip:5001" 
echo "- MySQL: your-vps-ip:3307"
echo ""
echo "To view logs: docker compose logs -f"
echo "To stop: docker compose down"