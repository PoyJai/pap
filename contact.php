<?php
session_start();
require_once 'db_config.php'; 
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>CEO OFFICE | IRON SIGHT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Kanit:wght@300;400&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0A0B0D; color: #E2E8F0; font-family: 'Kanit', sans-serif; }
        .font-tactical { font-family: 'Orbitron', sans-serif; }
        
        .ceo-profile-card {
            background: linear-gradient(145deg, #14161a, #0a0b0d);
            border: 1px solid #FF8C00;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 85% 100%, 0 100%);
            box-shadow: 0 0 40px rgba(255, 140, 0, 0.15);
        }

        .text-center{ 
            size: 200px;
        }
        
        /* เอฟเฟกต์เส้นสแกน */
        .scan-line {
            width: 100%; height: 2px; background: #FF8C00;
            position: absolute; top: 0; opacity: 0.5;
            animation: scan 4s linear infinite;
            z-index: 10;
        }
        @keyframes scan { 0% { top: 0; } 100% { top: 100%; } }

        /* กรอบรูป CEO */
        .avatar-frame {
            position: relative;
            width: 160px; height: 160px;
            margin: 0 auto 2rem;
            border: 2px solid #FF8C00;
            padding: 5px;
            background: #000;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <nav class="sticky top-0 z-50 bg-black/90 border-b border-orange-600/50 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="font-tactical text-2xl font-black italic text-white">
                IRON<span class="text-orange-500">SIGHT</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="index.php" class="text-[10px] font-tactical uppercase tracking-widest text-gray-500 hover:text-white transition">Inventory</a>
                <!-- <div class="relative">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2"/></svg>
                    <span id="cart-item-count" class="absolute -top-2 -right-2 bg-orange-600 text-black text-[10px] font-black px-1.5 rounded-sm">0</span>
                </div> -->
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="ceo-profile-card w-full max-w-sm p-10 relative overflow-hidden">
            <div class="scan-line"></div>
            
            <div class="avatar-frame">
                <img src="https://scontent.fphs1-1.fna.fbcdn.net/v/t39.30808-6/482206875_1459211342130948_2627575574207966015_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeHyy5y-hed_9x8A0pfeOJNNIplBHAlDkFYimUEcCUOQVjYGsSLXXVfXItBjCMkHMlUN2YwC17oMe7wmWrIxbjnU&_nc_ohc=nVV5Xhgbt8EQ7kNvwHfV2F_&_nc_oc=Admuy1Zv2QC3CWy3J-SnR7FdDJvn7297EbvtDFL-GcVy1IdW7wjVeCysYn8kgmSZinY&_nc_zt=23&_nc_ht=scontent.fphs1-1.fna&_nc_gid=Fmyv_iRvtl24wuWFdaR6fg&oh=00_AfosSjy9lu4DknjPFazZNMQeD8_9rTd-XRPUyutrpRQuXg&oe=697965FB" 
                     alt="CEO Avatar" 
                     class="w-full h-full object-cover grayscale hover:grayscale-0 transition duration-700">
                <div class="absolute inset-0 border border-orange-500/30 pointer-events-none"></div>
            </div>

            <div class="text-center">
                <p class="font-tactical text-[20px] text-orange-500 tracking-[0.5em] uppercase mb-1"></p>
                <h1 class="font-tactical text-2xl font-black text-white italic uppercase mb-8 tracking-tighter">
                    ภูบดี <span class="text-zinc-600">เกตุทอง</span>
                </h1>
                
                <div class="space-y-2 mb-8 text-left bg-black/40 p-4 border border-white/5">
                    <div class="flex justify-between text-[20px]">
                        <span class="text-gray-500 uppercase font-tactical">Email:</span>
                        <span class="text-white">ceo@ironsight.com</span>
                    </div>
                    <div class="flex justify-between text-[10px]">
                        <span class="text-gray-500 uppercase font-tactical">Status:</span>
                        <span class="text-green-500 font-bold uppercase animate-pulse">Online</span>
                    </div>
                </div>

                <a href="mailto:ceo@ironsight.com" class="block w-full py-4 bg-orange-600 text-black font-tactical font-black italic uppercase text-[10px] tracking-widest hover:bg-orange-400 transition shadow-lg shadow-orange-600/20">
                    Send Direct Message
                </a>
            </div>
        </div>
    </main>

    <script>
        const updateCart = () => {
            const cart = JSON.parse(localStorage.getItem('tactical_cart') || '[]');
            document.getElementById('cart-item-count').innerText = cart.length;
        };
        window.onload = updateCart;
    </script>
</body>
</html>