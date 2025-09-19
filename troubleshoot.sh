#!/bin/bash

echo "=== Fandi Flask App Troubleshooting ==="
echo ""

echo "1. Checking Docker containers status..."
docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
echo ""

echo "2. Checking container logs (last 20 lines)..."
echo "--- PHP Container Logs ---"
docker logs --tail 20 $(docker ps -q --filter "name=php") 2>/dev/null || echo "PHP container not found"
echo ""

echo "--- Flask Container Logs ---"
docker logs --tail 20 $(docker ps -q --filter "name=flask") 2>/dev/null || echo "Flask container not found"
echo ""

echo "--- MySQL Container Logs ---"
docker logs --tail 20 $(docker ps -q --filter "name=mysql") 2>/dev/null || echo "MySQL container not found"
echo ""

echo "--- Python Container Logs ---"
docker logs --tail 20 $(docker ps -q --filter "name=python") 2>/dev/null || echo "Python container not found"
echo ""

echo "3. Testing service connectivity..."
echo "Testing PHP service (port 8081):"
curl -s -o /dev/null -w "HTTP Status: %{http_code}\n" http://localhost:8081/ || echo "PHP service not accessible"

echo "Testing Flask service (port 5001):"
curl -s -o /dev/null -w "HTTP Status: %{http_code}\n" http://localhost:5001/ || echo "Flask service not accessible"
echo ""

echo "4. Checking volumes..."
docker volume ls | grep -E "(mysql|uploads)"
echo ""

echo "5. Network information..."
docker network ls | grep -E "(fandi|app)"
echo ""

echo "6. System resources..."
echo "Memory usage:"
docker stats --no-stream --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}" 2>/dev/null || echo "Unable to get stats"
echo ""

echo "7. Quick fixes you can try:"
echo "   - Restart all containers: docker compose restart"
echo "   - Rebuild containers: docker compose up -d --build --no-cache"
echo "   - Check logs in real-time: docker compose logs -f"
echo "   - Remove and recreate: docker compose down && docker compose up -d --build"
echo ""

echo "=== End of troubleshooting ==="