# Cron Setup untuk Auto-Release Expired Bookings

## Setup Cron Job

Tambahkan cron job berikut ke server untuk menjalankan scheduler Laravel setiap menit:

```bash
* * * * * cd /www/wwwroot/e-rentcar.com && php artisan schedule:run >> /dev/null 2>&1
```

### Cara Setup di cPanel/Linux:

1. Buka crontab editor:
```bash
crontab -e
```

2. Tambahkan baris berikut:
```bash
* * * * * cd /www/wwwroot/e-rentcar.com && php artisan schedule:run >> /dev/null 2>&1
```

3. Save dan exit

### Cara Setup di cPanel Web Interface:

1. Login ke cPanel
2. Cari "Cron Jobs"
3. Pilih "Common Settings" → "Once Per Minute (* * * * *)"
4. Di "Command" masukkan:
```bash
cd /www/wwwroot/e-rentcar.com && php artisan schedule:run
```
5. Klik "Add New Cron Job"

## Manual Testing

Untuk test command secara manual:

```bash
php artisan bookings:release-expired
```

## Verifikasi

Cek apakah cron job sudah berjalan:

```bash
crontab -l
```

## Monitoring

Untuk melihat log scheduler (optional):

```bash
* * * * * cd /www/wwwroot/e-rentcar.com && php artisan schedule:run >> /www/wwwroot/e-rentcar.com/storage/logs/scheduler.log 2>&1
```
