<?php
session_start();
require_once 'db_config.php'; 

// เช็คสถานะการ Login
$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$current_username = $is_logged_in ? htmlspecialchars($_SESSION["username"]) : "GUEST"; 

// ระบบ Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("location: index.php");
    exit;
}

// ดึงข้อมูล New Arrivals (4 รายการล่าสุด)
$sql = "SELECT id, title, description, genre, image_url, price FROM games ORDER BY id DESC LIMIT 4";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRON SIGHT | TACTICAL HQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Bai+Jamjuree:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --tactical-orange: #FF8C00; }
        body {
            background-color: #0A0A0B;
            color: #E2E2E2;
            font-family: 'Bai Jamjuree', sans-serif;
            background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        }
        .font-header { font-family: 'Orbitron', sans-serif; }
        .btn-tactical {
            background: linear-gradient(45deg, #1A1C1E, #2A2E34);
            border-left: 4px solid var(--tactical-orange);
            transition: 0.3s;
            text-transform: uppercase;
        }
        .btn-tactical:hover { background: var(--tactical-orange); color: black; transform: skewX(-5deg); }
        .weapon-card {
            background: rgba(20, 22, 24, 0.9);
            border: 1px solid #2A2E34;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 95% 100%, 0 100%);
            transition: 0.4s;
        }
        .weapon-card:hover { border-color: var(--tactical-orange); }
    </style>
</head>
<body>

    <nav class="border-b border-white/5 bg-black/80 backdrop-blur-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-orange-600 rounded-sm rotate-45 flex items-center justify-center">
                    <div class="w-2 h-2 bg-black rounded-full"></div>
                </div>
                <span class="text-2xl font-black font-header tracking-tighter uppercase">IRON<span class="text-orange-500">SIGHT</span></span>
            </div>
            
            <div class="hidden md:flex space-x-8 text-xs font-bold font-header tracking-widest uppercase">
                <a href="index.php" class="text-orange-500 underline decoration-2 underline-offset-8">HQ / Home</a>
                <a href="allgame.php" class="hover:text-orange-500 transition">Armory / All Games</a>
                <a href="contact.php" class="hover:text-orange-500 transition">Contact CEO</a>
            </div>

            <div class="flex items-center gap-6">
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] text-gray-500 uppercase font-bold">Operator Status</p>
                    <p class="text-xs font-header <?= $is_logged_in ? 'text-green-500' : 'text-gray-400' ?>"><?= $current_username ?></p>
                </div>
                
                <?php if($is_logged_in): ?>
                    <a href="?action=logout" class="text-[10px] font-bold text-red-500 hover:text-red-400 font-header border border-red-500/30 px-2 py-1">LOGOUT</a>
                <?php else: ?>
                    <a href="login.php" class="text-[10px] font-bold text-orange-500 hover:text-orange-400 font-header border border-orange-500/30 px-2 py-1">LOGIN</a>
                <?php endif; ?>

                <!-- <button class="relative group" onclick="window.location.href='checkout.php'">
                    <svg class="w-6 h-6 text-orange-500 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-orange-600 text-black text-[9px] font-black px-1.5 rounded-sm">0</span>
                </button> -->
            </div>
        </div>
    </nav>

    <header class="relative py-24 overflow-hidden">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center relative z-10">
            <div>
                <span class="text-orange-500 font-header text-xs font-bold tracking-[0.4em] uppercase mb-4 block">Authorization Level: Clearance 01</span>
                <h1 class="text-6xl md:text-8xl font-black font-header leading-[0.9] mb-6 italic uppercase">
                    Tactical <br> <span class="text-transparent" style="-webkit-text-stroke: 1px #FF8C00;">Armory</span>
                </h1>
                <p class="text-gray-400 max-w-sm text-sm mb-10 border-l-2 border-orange-600 pl-4 leading-relaxed">
                    ยุทโธปกรณ์เสริมประสิทธิภาพสำหรับการปฏิบัติการระดับสูง เข้าถึงคลังแสงด้วยระบบรักษาความปลอดภัยขั้นสูงสุด
                </p>
                <div class="flex gap-4">
                    <button onclick="window.location.href='allgame.php'" class="btn-tactical px-12 py-5 font-header font-black italic shadow-lg shadow-orange-600/30">Enter Armory</button>
                </div>
            </div>
            <div class="relative hidden md:block group">
                <div class="absolute -inset-4 bg-orange-600/10 blur-3xl rounded-full group-hover:bg-orange-600/20 transition"></div>
                <img src="https://www.cpr.org/cdn-cgi/image/width=3840,quality=75,format=auto/https://wp-cpr.s3.amazonaws.com/uploads/2025/04/gun_store_resized-15.jpg" class="grayscale contrast-125 rotate-[-3deg] drop-shadow-2xl border-r-8 border-orange-600 relative z-10">
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-20">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-black font-header italic uppercase border-b-2 border-orange-600 pb-2">Recent Deployments</h2>
            <a href="allgame.php" class="text-[10px] font-header text-gray-500 hover:text-orange-500 uppercase tracking-widest">View All Assets &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="weapon-card flex flex-col group">
                        <div class="h-56 overflow-hidden bg-[#0a0a0b] p-8 flex items-center justify-center">
                            <img src="<?= $row['image_url'] ?>" class="max-w-full max-h-full object-contain grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-700">
                        </div>
                        <div class="p-6 border-t border-white/5 bg-[#14161A]">
                            <span class="text-[9px] text-orange-500 font-black uppercase tracking-[0.2em]"><?= $row['genre'] ?></span>
                            <h3 class="text-lg font-bold font-header mb-4 truncate uppercase text-white"><?= $row['title'] ?></h3>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Standard Issue</p>
                                    <p class="text-xl font-black text-white italic">฿<?= number_format($row['price']) ?></p>
                                </div>
                                <button onclick='addToCart(<?= json_encode($row) ?>)' class="w-12 h-12 bg-white/5 hover:bg-orange-600 hover:text-black flex items-center justify-center transition border border-white/10 hover:border-orange-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full border border-dashed border-gray-800 p-20 text-center">
                    <p class="text-gray-600 font-header italic uppercase tracking-widest">Database connection active, but no records found.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="border-t border-white/5 py-12 bg-black/50">
        <div class="container mx-auto px-6 text-center">
            <p class="font-header text-[10px] text-gray-600 uppercase tracking-[0.5em]">&copy; 2026 Iron Sight Tactical Solutions. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // ใช้ Key เดียวกันกับหน้าอื่นๆ (game_cart)
        function updateCartUI() {
            const cart = JSON.parse(localStorage.getItem('game_cart') || '[]');
            document.getElementById('cart-count').innerText = cart.length;
        }

        function addToCart(item) {
            let cart = JSON.parse(localStorage.getItem('game_cart') || '[]');
            cart.push(item);
            localStorage.setItem('game_cart', JSON.stringify(cart));
            updateCartUI();
            
            // แสดงแจ้งเตือนแบบ Tactical
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-5 right-5 bg-orange-600 text-black px-6 py-3 font-header font-black italic uppercase text-xs z-50 animate-bounce';
            notification.innerText = 'Asset Logged: ' + item.title;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 2500);
        }

        // โหลดจำนวนตะกร้าเมื่อเปิดหน้า
        window.onload = updateCartUI;
    </script>
</body>
</html>