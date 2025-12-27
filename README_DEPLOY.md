# Production Deployment Guide

This project has been prepared for production deployment on a standard Linux server (Ubuntu/Debian) running Nginx, PHP (8.1+), and MySQL/MariaDB.

## 1. Prerequisites
Ensure your server has the following installed:
- **Git**
- **PHP 8.1+** (extensions: bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml)
- **Composer**
- **Node.js & NPM**
- **Nginx**
- **MySQL 8.0+**
- **Supervisor** (for queues)

## 2. Server Configuration
Upload the configuration files from the `deployment/` folder to your server.

### Nginx
Copy `deployment/nginx.conf` to `/etc/nginx/sites-available/moho` and symlink it to `sites-enabled`.
```bash
sudo ln -s /etc/nginx/sites-available/moho /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Supervisor (Queues)
Copy `deployment/supervisor.conf` to `/etc/supervisor/conf.d/moho-worker.conf`.
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start moho-worker:*
```

### Scheduler (Cron)
Add the contents of `deployment/scheduler.cron` to your `crontab -e`:
```bash
* * * * * cd /var/www/moho && php artisan schedule:run >> /dev/null 2>&1
```

## 3. Application Deployment
1.  Clone your repository to `/var/www/moho`.
2.  Copy `.env.example` to `.env` and update production values:
    ```ini
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://your-domain.com
    DB_CONNECTION=mysql (Use credentials you provided)
    QUEUE_CONNECTION=database
    ```
3.  Run the deployment script:
    ```bash
    chmod +x deploy.sh
    ./deploy.sh
    ```

## 4. Troubleshooting
- **Database**: If migrations fail, ensure your DB credentials in `.env` are correct and the database exists.
- **Permissions**: Ensure storage folder is writable:
    ```bash
    chmod -R 775 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
    ```
- **Health Check**: Visit `https://your-domain.com/health` to verify system status.

## 5. Repairs Made
The following repairs were applied to the codebase to ensure it works:
- Restored standard Laravel 10 bootstrap architecture.
- Created missing `routes/api.php`.
- Added missing `App\Http\Controllers\Controller` base class.
- Installed `laravel/cashier` dependency.
- Verified database schema compatibility.
