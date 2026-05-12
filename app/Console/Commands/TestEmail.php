<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'test:email {email}';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $email = $this->argument('email');
        
        try {
            Mail::raw('Test email dari E-RentCar. Jika kamu menerima email ini, konfigurasi SMTP sudah benar!', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - E-RentCar');
            });
            
            $this->info('✅ Email berhasil dikirim ke: ' . $email);
            $this->info('📧 Cek inbox Mailtrap kamu di: https://mailtrap.io/inboxes');
        } catch (\Exception $e) {
            $this->error('❌ Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
