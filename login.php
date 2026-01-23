<?php
session_start();
require_once 'server.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 1. ตรวจสอบการเตรียมคำสั่ง (Prepare)
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // หากพังตรงนี้ แสดงว่าไม่มีตาราง users หรือคอลัมน์สะกดผิด
        $error = "DATABASE ERROR: " . htmlspecialchars($conn->error);
    } else {
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($pass, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $row['username'];
                header("location: index.php");
                exit;
            } else {
                $error = "ACCESS DENIED: INVALID PASSWORD";
            }
        } else {
            $error = "ACCESS DENIED: USER NOT FOUND";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>LOGIN | IRON SIGHT</title>
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
                Operator <span class="text-orange-500">Login</span>
            </h1>
            <p class="text-gray-500 text-[9px] uppercase tracking-[0.3em] mt-1">Iron Sight Tactical Security</p>
        </div>

        <?php if($error): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-500 text-[11px] font-bold uppercase tracking-tight">
                ⚠️ <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="text-[9px] font-tactical text-gray-400 uppercase tracking-widest mb-2 block">Service ID / Username</label>
                <input type="text" name="username" placeholder="ENTER CALLSIGN" required class="w-full p-4 input-tactical text-sm font-tactical">
            </div>
            <div>
                <label class="text-[9px] font-tactical text-gray-400 uppercase tracking-widest mb-2 block">Access Code</label>
                <input type="password" name="password" placeholder="********" required class="w-full p-4 input-tactical text-sm">
            </div>
            
            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 py-4 text-black font-tactical font-black italic uppercase text-xs shadow-lg shadow-orange-600/20 transition active:scale-95">
                Establish Connection
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-white/5 text-center">
            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-tactical">
                New Operator? <a href="register.php" class="text-orange-500 font-bold hover:underline">Register Profile</a>
            </p>
        </div>
        <div class="mt-8 pt-6 border-t border-white/5 text-center">
            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-tactical">
                Forgot your password?<a href="forgot_password.php" class="text-orange-500 font-bold hover:underline">Forgot your password</a>
            </p>
        </div>
    </div>

</body>
</html>