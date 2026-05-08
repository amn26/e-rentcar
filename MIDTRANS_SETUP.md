# Midtrans Payment Integration Setup

## 1. Daftar Akun Midtrans

1. Buka https://dashboard.midtrans.com/register
2. Daftar akun baru (gunakan email aktif)
3. Verifikasi email
4. Login ke dashboard

## 2. Dapatkan API Keys

### Sandbox (Testing):
1. Login ke https://dashboard.sandbox.midtrans.com/
2. Klik **Settings** → **Access Keys**
3. Copy credentials:
   - **Merchant ID**
   - **Client Key**
   - **Server Key**

### Production (Live):
1. Login ke https://dashboard.midtrans.com/
2. Lengkapi verifikasi bisnis
3. Klik **Settings** → **Access Keys**
4. Copy credentials yang sama

## 3. Setup di .env

Tambahkan ke file `.env`:

```env
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
```

**Note:** 
- Set `MIDTRANS_IS_PRODUCTION=false` untuk testing (sandbox)
- Set `MIDTRANS_IS_PRODUCTION=true` untuk production (live)

## 4. Setup Notification URL

Di Midtrans Dashboard:
1. Klik **Settings** → **Configuration**
2. Set **Payment Notification URL**: `https://your-domain.com/payment/callback`
3. Set **Finish Redirect URL**: `https://your-domain.com/payment/finish`
4. Set **Unfinish Redirect URL**: `https://your-domain.com/payment/unfinish`
5. Set **Error Redirect URL**: `https://your-domain.com/payment/error`
6. Save

## 5. Testing Payment

### Sandbox Test Cards:

**QRIS:**
- Scan QR code dengan app simulator
- Atau gunakan test number: `000000000000000`

**Virtual Account:**
- BCA VA: `{merchant_code}12345678`
- BNI VA: `{merchant_code}12345678`
- BRI VA: `{merchant_code}12345678`
- Mandiri VA: `{merchant_code}12345678`

**E-Wallet:**
- GoPay: Gunakan simulator di dashboard
- ShopeePay: Gunakan simulator di dashboard

**Credit Card:**
- Card Number: `4811 1111 1111 1114`
- CVV: `123`
- Exp: `01/25`
- OTP: `112233`

## 6. Payment Flow

1. User membuat booking
2. Redirect ke payment page
3. User klik "Pay Now" → Midtrans Snap popup muncul
4. User pilih metode pembayaran (QRIS/VA/E-Wallet)
5. User complete payment
6. Midtrans kirim notification ke `/payment/callback`
7. System update booking status
8. User redirect ke success page

## 7. Supported Payment Methods

✅ **QRIS** - Scan QR dengan app banking apapun
✅ **Virtual Account:**
   - BCA
   - BNI
   - BRI
   - Mandiri
   - Permata
   - Other Banks

✅ **E-Wallet:**
   - GoPay
   - ShopeePay

✅ **Credit/Debit Card** (optional, bisa diaktifkan)

## 8. Security

- Server Key harus **RAHASIA**, jangan commit ke git
- Gunakan HTTPS untuk production
- Validate signature di callback endpoint
- Set proper CORS headers

## 9. Troubleshooting

**Error: "Invalid signature"**
- Pastikan Server Key benar
- Check signature validation di PaymentController

**Payment tidak update status:**
- Check notification URL sudah benar
- Check logs di Midtrans dashboard
- Pastikan callback endpoint accessible dari internet

**Snap popup tidak muncul:**
- Check Client Key di .env
- Check browser console untuk error
- Pastikan Snap.js loaded

## 10. Go Live Checklist

- [ ] Lengkapi verifikasi bisnis di Midtrans
- [ ] Ganti ke Production API Keys
- [ ] Set `MIDTRANS_IS_PRODUCTION=true`
- [ ] Update notification URL ke domain production
- [ ] Test semua payment methods
- [ ] Setup monitoring & alerts

## Support

- Docs: https://docs.midtrans.com/
- Dashboard: https://dashboard.midtrans.com/
- Support: support@midtrans.com
