#!/bin/bash
# Cron Job Status Check Script

echo "=== E-RentCar Cron Job Status ==="
echo ""
echo "Current Time: $(date)"
echo ""

echo "=== Active Cron Jobs ==="
crontab -l | grep -v "^#" | grep -v "^$"
echo ""

echo "=== Laravel Scheduler Status ==="
cd /www/wwwroot/e-rentcar.com && php artisan schedule:list
echo ""

echo "=== Recent Expired Bookings ==="
cd /www/wwwroot/e-rentcar.com && php artisan bookings:release-expired
echo ""

echo "=== Database Check ==="
mysql -u root -p$(grep DB_PASSWORD /www/wwwroot/e-rentcar.com/.env | cut -d '=' -f2) -e "
USE e_rentcar;
SELECT 
    COUNT(*) as total_pending,
    SUM(CASE WHEN payment_expires_at < NOW() THEN 1 ELSE 0 END) as expired_count,
    SUM(CASE WHEN payment_expires_at > NOW() THEN 1 ELSE 0 END) as active_count
FROM bookings 
WHERE booking_status = 'pending';
" 2>/dev/null || echo "Database check skipped (credentials needed)"

echo ""
echo "=== Status: OK ==="
