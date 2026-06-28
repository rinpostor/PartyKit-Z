#!/usr/bin/env bash
set -e

# Persiapan direktori data untuk SQLite (Render filesystem persist antar restart di /var/data)
if [ ! -d /var/data ]; then
    mkdir -p /var/data
fi

# Copy database SQLite jika belum ada di persistent storage
if [ ! -f /var/data/database.sqlite ]; then
    if [ -f database/database.sqlite ]; then
        cp database/database.sqlite /var/data/database.sqlite
        echo "Database copied to persistent storage"
    else
        touch /var/data/database.sqlite
        echo "Empty database created"
    fi
fi

# Symlink database ke lokasi persistent
ln -sf /var/data/database.sqlite database/database.sqlite

# Jalankan migrasi
php artisan migrate --force

# Start Laravel
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
