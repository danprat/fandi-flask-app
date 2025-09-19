#!/bin/bash

echo "Initializing database..."

# Wait for MySQL to be ready
until mysql -h mysql -u root -prootpassword -e "SELECT 1" > /dev/null 2>&1; do
  echo "Waiting for MySQL to be ready..."
  sleep 2
done

# Download and execute SQL file if it doesn't exist
mysql -h mysql -u root -prootpassword kampuspu_rt -e "SHOW TABLES;" | grep -q "warga"
if [ $? -ne 0 ]; then
    echo "Database tables not found, initializing..."
    
    # Download SQL file from GitHub
    curl -s -o /tmp/kampuspu_apirt06.sql https://raw.githubusercontent.com/danprat/fandi-flask-app/main/kampuspu_apirt06.sql
    
    if [ -f /tmp/kampuspu_apirt06.sql ]; then
        mysql -h mysql -u root -prootpassword kampuspu_rt < /tmp/kampuspu_apirt06.sql
        echo "Database initialized successfully!"
    else
        echo "Failed to download SQL file, creating basic structure..."
        # Create basic tables as fallback
        mysql -h mysql -u root -prootpassword kampuspu_rt << 'EOF'
CREATE TABLE IF NOT EXISTS warga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_hp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pertemuan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    jenis ENUM('Maulidan', 'Yasinan') NOT NULL,
    tema TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS kehadiran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_warga INT,
    id_pertemuan INT,
    status ENUM('Hadir', 'Tidak Hadir') DEFAULT 'Tidak Hadir',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_warga) REFERENCES warga(id),
    FOREIGN KEY (id_pertemuan) REFERENCES pertemuan(id)
);
EOF
    fi
else
    echo "Database already initialized."
fi

echo "Database initialization completed!"