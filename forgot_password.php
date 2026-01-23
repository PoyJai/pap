<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RECOVERY | IRON SIGHT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Bai+Jamjuree:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Bai Jamjuree', sans-serif; 
            background: #0A0A0B; 
            background-image: url('https://www.cpr.org/cdn-cgi/image/width=3840,quality=75,format=auto/https://wp-cpr.s3.amazonaws.com/uploads/2025/04/gun_store_resized-15.jpg" class="grayscale contrast-125 rotate-[-3deg] drop-shadow-2xl border-r-8 border-orange-600 relative z-10'); 
            background-size: cover; 
            background-position: center; 
            background-attachment: fixed;
        }
        .font-header { font-family: 'Orbitron', sans-serif; }
        /* สไตล์กระจกฝ้าตามแบบที่คุณต้องการ */
        .colored-card { 
            background: rgba(10, 10, 12, 0.75); 
            backdrop-filter: blur(15px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        /* Gradient ปุ่มตามสไตล์หน้า Login */
        .login-bg { 
            background: linear-gradient(135deg, #FF8C00 0%, #ed6c02 100%); 
            transition: 0.3s;
        }
        .login-bg:hover { 
            filter: brightness(1.1);
            transform: translateY(-2px);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.3s;
        }
        .input-field:focus {
            border-color: #FF8C00;
            background: rgba(255, 255, 255, 0.1);
            outline: none;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md p-8 colored-card rounded-2xl border-t-4 border-orange-500 relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-orange-600/10 rounded-full blur-3xl"></div>
        
        <div class="text-center mb-8 relative z-10">
            <h1 class="font-header text-3xl font-black text-white mb-2 italic tracking-tighter">
                RECOVERY<span class="text-orange-500"> PROTOCOL</span>
            </h1>
            <p class="text-gray-400 text-xs uppercase tracking-widest font-bold">ยืนยันตัวตนเพื่อตั้งรหัสผ่านใหม่</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-400 rounded-lg text-center text-xs font-bold animate-pulse">
                ⚠️ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="forgot_db.php" method="post" class="space-y-5 relative z-10">
            
            <div>
                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-widest mb-2">Username / ชื่อผู้ใช้งาน</label>
                <input type="text" name="username" required 
                       class="input-field w-full px-4 py-3 text-white rounded-lg" 
                       placeholder="ระบุรหัสหน่วยปฏิบัติการ">
            </div>

            <div>
                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-widest mb-2">New Password / รหัสผ่านใหม่</label>
                <input type="password" name="password_1" required 
                       class="input-field w-full px-4 py-3 text-white rounded-lg" 
                       placeholder="••••••••">
            </div>

            <div>
                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-widest mb-2">Confirm / ยืนยันรหัสผ่าน</label>
                <input type="password" name="password_2" required 
                       class="input-field w-full px-4 py-3 text-white rounded-lg" 
                       placeholder="••••••••">
            </div>

            <button type="submit" name="reset_password" 
                    class="w-full py-4 login-bg text-black font-header font-black uppercase italic rounded-lg shadow-xl shadow-orange-600/20 mt-4">
                Execute Reset
            </button>

            <div class="mt-8 text-center">
                <a href="login.php" class="text-xs font-bold text-gray-500 hover:text-white transition uppercase tracking-widest">
                    &larr; Back to Login System
                </a>
            </div>
        </form>
    </div>

</body>
</html>