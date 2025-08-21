<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .header {
            background-color: #2E6342;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .header h2 {
            font-family: 'Dancing Script', 'Cursive', sans-serif;
            color: white;
            margin: 0;
        }
        .info-box {
            background-color: white;
            color: black;
            padding: 15px 20px;
            border-left: 4px solid #2E6342;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .button {
            background-color: #2E6342; /* Latar belakang hijau */
            color: white; /* Teks berwarna putih */
            padding: 12px 30px;
            text-align: center;
            text-decoration: none; /* Menghilangkan garis bawah */
            border-radius: 5px;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 20px;
            transition: background-color 0.3s, color 0.3s;
            cursor: pointer; /* Pointer saat hover */
            border: none; /* Menghilangkan border default dari tombol */
        }
        /* Mengatasi warna biru pada link */
        .button:hover {
            background-color: #1e4f36; /* Latar belakang hijau lebih gelap saat hover */
            color: white; /* Teks tetap putih saat hover */
        }
        /* Untuk memastikan link tidak menjadi biru saat diklik */
        .button:link,
        .button:visited {
            color: white;
            text-decoration: none;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            color: #aaa;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="https://raw.githubusercontent.com/apiiuw/KedaiJabatKopi/main/public/img/icon/icon.png" alt="Jabat Kopi Logo">
        <h2>Kedai Jabat Kopi</h2>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <p><strong>Hello, {{ $user->name }}! 🍃</strong></p>

        <p>We received a request to reset the password for your account. Click the button below to reset your password.</p>

        <!-- Reset Password Link (change from button to a) -->
        <a href="{{ route('auth.reset-password', ['token' => $token]) }}" class="button">
            Reset Password
        </a>

        <p>If you didn't request a password reset, please ignore this email.</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        This message was sent by <strong>Kedai Jabat Kopi</strong> - brewed with love ❤️
    </div>

</body>
</html>
