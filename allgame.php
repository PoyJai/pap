<?php
session_start();
require_once 'db_config.php'; 

// 1. ดึงข้อมูลจากฐานข้อมูล aesthetic_games_db_1 (เรียงตาม ID เพื่อให้เหมือนโครงสร้าง DB)
$sql = "SELECT id, title, description, genre, image_url, price FROM games ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRON SIGHT | Tactical Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0A0B0D; color: #E2E8F0; font-family: 'Kanit', sans-serif; }
        .font-tactical { font-family: 'Orbitron', sans-serif; }
        
        /* สไตล์การ์ด */
        .weapon-card {
            background: #14161A;
            border: 1px solid #2D3748;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 90% 100%, 0 100%);
            transition: all 0.3s ease;
        }
        .weapon-card:hover { border-color: #FF8C00; transform: translateY(-5px); }

        /* สไตล์ตะกร้าสินค้า (Sidebar) */
        #cart-sidebar {
            transition: transform 0.3s ease-in-out;
            background: rgba(10, 11, 13, 0.98);
            border-left: 2px solid #FF8C00;
        }
        .cart-open #cart-sidebar { transform: translateX(0); }
        .cart-closed #cart-sidebar { transform: translateX(100%); }
    </style>
</head>
<body class="cart-closed">

    <nav class="sticky top-0 z-50 bg-black/90 border-b border-orange-600/50 p-4 shadow-xl">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="font-tactical text-2xl font-black italic text-white">
                IRON<span class="text-orange-500">SIGHT</span>
            </a>
            <!-- <button id="cart-btn" class="relative group flex items-center gap-2 bg-white/5 px-4 py-2 rounded border border-white/10 hover:border-orange-500 transition">
                <span class="font-tactical text-[10px] uppercase hidden md:block">Tactical Bag</span>
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-orange-600 text-black text-[10px] font-black px-1.5 rounded-sm">0</span>
            </button> -->
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="weapon-card group flex flex-col">
                        <div class="h-48 bg-black flex items-center justify-center p-4 relative">
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" class="max-w-full max-h-full object-contain filter grayscale group-hover:grayscale-0 transition duration-500">
                            <span class="absolute top-2 left-2 bg-orange-600 text-black text-[9px] font-black px-2 py-1 uppercase font-tactical">
                                <?= htmlspecialchars($row['genre']) ?>
                            </span>
                        </div>
                        <div class="p-6 border-t border-white/5">
                            <h3 class="font-tactical text-base font-bold mb-2 truncate text-white italic uppercase"><?= htmlspecialchars($row['title']) ?></h3>
                            <p class="text-gray-500 text-[10px] mb-6 line-clamp-2 h-8 uppercase italic"><?= htmlspecialchars($row['description']) ?></p>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[8px] text-gray-600 font-bold uppercase">Price</p>
                                    <p class="text-xl font-black text-white italic">฿<?= number_format($row['price'], 0) ?></p>
                                </div>
                                <button onclick='addToCart(<?= json_encode($row) ?>)'
                                        class="w-10 h-10 bg-orange-600 hover:bg-orange-500 text-black flex items-center justify-center transition shadow-lg shadow-orange-600/20 active:scale-90">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- <div id="cart-sidebar" class="fixed top-0 right-0 h-full w-full max-w-sm z-[100] transform translate-x-full shadow-2xl flex flex-col">
        <div class="p-6 border-b border-white/10 flex justify-between items-center">
            <h2 class="font-tactical text-xl font-black italic uppercase tracking-tighter">Inventory <span class="text-orange-500">Bag</span></h2>
            <button id="close-cart" class="text-gray-500 hover:text-white uppercase font-black text-xs">✕ Close</button>
        </div>
        
        <div id="cart-items" class="flex-grow overflow-y-auto p-6 space-y-4 custom-scrollbar">
            </div>

        <div class="p-6 border-t border-white/10 bg-black/50">
            <div class="flex justify-between items-center mb-6">
                <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Total Value</span>
                <span id="cart-total" class="text-2xl font-black text-white italic">฿0.00</span>
            </div>
            <button onclick="window.location.href='cart_logic.php'" class="w-full py-4 bg-orange-600 hover:bg-orange-500 text-black font-tactical font-black uppercase italic tracking-widest transition-all shadow-lg shadow-orange-600/10">
                Proceed to Checkout
            </button>
        </div>
    </div> -->

    <script>
    // 1. เปลี่ยนชื่อ Key ให้ตรงกับหน้า index และ checkout
    let cart = JSON.parse(localStorage.getItem('game_cart') || '[]');

    const updateCartUI = () => {
        const cartItems = document.getElementById('cart-items');
        const cartCount = document.getElementById('cart-count');
        const cartTotal = document.getElementById('cart-total');
        
        cartCount.innerText = cart.length;
        cartItems.innerHTML = '';
        let total = 0;

        if(cart.length === 0) {
            cartItems.innerHTML = '<p class="text-center text-gray-600 py-10 italic uppercase text-xs font-bold tracking-widest">No Items Selected</p>';
        }

        cart.forEach((item, index) => {
            total += parseFloat(item.price);
            cartItems.innerHTML += `
                <div class="flex justify-between items-center bg-white/5 p-4 border-l-2 border-orange-500 animate-fadeIn mb-2">
                    <div>
                        <p class="font-bold text-white text-[11px] uppercase truncate w-32">${item.title}</p>
                        <p class="text-orange-500 font-black text-sm">฿${parseFloat(item.price).toLocaleString()}</p>
                    </div>
                    <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-400 font-black text-[10px] uppercase">Remove</button>
                </div>
            `;
        });

        cartTotal.innerText = `฿${total.toLocaleString()}`;
        // 2. บันทึกโดยใช้ Key 'game_cart'
        localStorage.setItem('game_cart', JSON.stringify(cart));
    }

    window.addToCart = (item) => {
        cart.push(item);
        updateCartUI();
        // เปิด Sidebar อัตโนมัติเมื่อกดซื้อ
        document.body.classList.replace('cart-closed', 'cart-open');
    }

    window.removeFromCart = (index) => {
        cart.splice(index, 1);
        updateCartUI();
    }

    // เปิด-ปิด Sidebar
    document.getElementById('cart-btn').onclick = () => {
        document.body.classList.replace('cart-closed', 'cart-open');
    };
    document.getElementById('close-cart').onclick = () => {
        document.body.classList.replace('cart-open', 'cart-closed');
    };

    window.onload = updateCartUI;
</script>
</body>
</html>