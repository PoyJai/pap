<?php
session_start();
require_once 'server.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // 1. ตรวจสอบว่ารหัสผ่านตรงกันไหม
    if ($pass !== $confirm_pass) {
        $error = "ACCESS DENIED: PASSWORDS DO NOT MATCH";
    } else {
        // 2. ตรวจสอบว่ามี Username นี้หรือยัง
        $check_sql = "SELECT id FROM users WHERE username = ?";
        $stmt_check = $conn->prepare($check_sql);
        
        if (!$stmt_check) {
            $error = "DATABASE ERROR: " . $conn->error;
        } else {
            $stmt_check->bind_param("s", $user);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result->num_rows > 0) {
                $error = "ERROR: USERNAME ALREADY REGISTERED";
            } else {
                // 3. เข้ารหัสและบันทึกข้อมูล
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                $insert_sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $stmt_insert = $conn->prepare($insert_sql);
                
                if ($stmt_insert) {
                    $stmt_insert->bind_param("sss", $user, $email, $hashed_pass);
                    if ($stmt_insert->execute()) {
                        header("location: login.php?registered=true");
                        exit;
                    } else {
                        $error = "CRITICAL ERROR: REGISTRATION FAILED";
                    }
                }
            }
            $stmt_check->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>REGISTER | IRON SIGHT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Kanit:wght@300;400&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0A0B0D; color: #E2E8F0; font-family: 'Kanit', sans-serif; }
        .font-tactical { font-family: 'Orbitron', sans-serif; }
        .auth-card { 
            background: #14161A; 
            border: 1px solid #2D3748; 
            clip-path: polygon(0 0, 100% 0, 100% 90%, 95% 100%, 0 100%); 
        }
        .input-tactical { 
            background: #000; 
            border: 1px solid #2D3748; 
            color: white; 
            transition: 0.3s;
        }
        .input-tactical:focus { border-color: #FF8C00; outline: none; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');">
    
    <div class="auth-card w-full max-w-md p-10 border-t-4 border-t-orange-600 shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="font-tactical text-2xl font-black italic uppercase text-white tracking-tighter">
                New <span class="text-orange-500">Operator</span>
            </h1>
            <p class="text-gray-500 text-[9px] uppercase tracking-[0.3em] mt-1">Registration Protocol v1.0</p>
        </div>

        <?php if($error): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-500 text-[11px] font-bold uppercase tracking-tight">
                ⚠️ <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="text-[9px] font-tactical text-gray-400 uppercase tracking-widest mb-1 block">Username</label>
                <input type="text" name="username" placeholder="CHOOSE CALLSIGN" required class="w-full p-3 input-tactical text-sm font-tactical">
            </div>
            <div>
                <label class="text-[9px] font-tactical text-gray-400 uppercase tracking-widest mb-1 block">Email Address</label>
                <input type="email" name="email" placeholder="UNIT@STUNSHOP.COM" required class="w-full p-3 input-tactical text-sm">
            </div>
            <div>
                <label class="text-[9px] font-tactical text-gray-400 uppercase tracking-widest mb-1 block">Password</label>
                <input type="password" name="password" placeholder="MIN. 8 CHARS" required class="w-full p-3 input-tactical text-sm">
            </div>
            <div>
                <label class="text-[9px] font-tactical text-gray-400 uppercase tracking-widest mb-1 block">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="RE-ENTER PASSWORD" required class="w-full p-3 input-tactical text-sm">
            </div>
            
            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 py-4 mt-4 text-black font-tactical font-black italic uppercase text-xs shadow-lg shadow-orange-600/20 transition active:scale-95">
                Initialize Account
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-white/5 text-center">
            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-tactical">
                Already registered? <a href="login.php" class="text-orange-500 font-bold hover:underline">Access Login</a>
            </p>
        </div>
    </div>
</body>
</html>