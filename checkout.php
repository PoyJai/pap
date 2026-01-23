<?php 
session_start(); 
$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$current_username = $is_logged_in ? htmlspecialchars($_SESSION["username"]) : "GUEST"; 
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>INVENTORY CHECK | IRON SIGHT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Bai+Jamjuree:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0A0A0B; color: #F3F4F6; font-family: 'Bai Jamjuree', sans-serif; background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png'); }
        .font-header { font-family: 'Orbitron', sans-serif; }
        .cart-item { background: #14161A; border: 1px solid #2D3748; clip-path: polygon(0 0, 100% 0, 100% 95%, 98% 100%, 0 100%); }
    </style>
</head>
<body class="min-h-screen">
    <nav class="bg-black/90 border-b border-orange-600/50 p-4 sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="font-header text-xl font-black text-white italic uppercase">IRON<span class="text-orange-500">SIGHT</span> / CART</a>
            <span class="text-[10px] font-header text-orange-500 tracking-[0.3em] hidden md:block uppercase">Inventory Validation Protocol</span>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        <div class="grid lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-4" id="cart-container">
                </div>

            <div class="lg:col-span-1">
                <div class="bg-[#14161A] p-8 border-t-4 border-orange-600 shadow-2xl sticky top-24">
                    <h2 class="font-header text-xl font-bold mb-6 uppercase italic">Procurement Summary</h2>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-gray-500">
                            <span class="uppercase text-[10px] font-bold">Operator ID</span>
                            <span class="text-white text-xs font-header"><?= $current_username ?></span>
                        </div>
                        <div class="flex justify-between border-t border-white/5 pt-4">
                            <span class="font-header text-lg">Total Cost</span>
                            <span id="grand-total" class="font-header text-2xl text-orange-500 font-black italic">฿0</span>
                        </div>
                    </div>
                    
                    <button onclick="window.location.href='cart_logic.php'" class="w-full bg-orange-600 hover:bg-orange-500 py-4 text-black font-header font-black italic uppercase transition shadow-lg shadow-orange-600/20">
                        Proceed to Checkout
                    </button>
                    
                    <button onclick="clearCart()" class="w-full mt-4 text-[10px] text-gray-600 uppercase hover:text-red-500 transition font-bold tracking-widest">
                        Purge Inventory
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function renderCart() {
            const cart = JSON.parse(localStorage.getItem('game_cart') || '[]');
            const container = document.getElementById('cart-container');
            let total = 0;

            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-24 bg-white/5 border border-dashed border-gray-800">
                        <p class="text-gray-600 uppercase font-black tracking-[0.5em]">Inventory Empty</p>
                        <a href="allgame.php" class="text-orange-500 text-xs font-header mt-4 inline-block hover:underline italic uppercase">Access Armory</a>
                    </div>`;
                document.getElementById('grand-total').innerText = "฿0";
                return;
            }

            container.innerHTML = '';
            cart.forEach((item, index) => {
                total += parseFloat(item.price);
                container.innerHTML += `
                    <div class="cart-item p-6 flex justify-between items-center group">
                        <div class="flex items-center gap-8">
                            <div class="w-20 h-20 bg-black p-2">
                                <img src="${item.image_url}" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h3 class="font-header text-white font-bold uppercase">${item.title}</h3>
                                <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest">${item.genre}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-header text-xl text-white mb-2 font-black italic">฿${parseFloat(item.price).toLocaleString()}</p>
                            <button onclick="removeItem(${index})" class="text-[10px] text-red-500 uppercase font-bold hover:text-red-400 transition tracking-tighter italic">Remove Asset [-]</button>
                        </div>
                    </div>`;
            });

            document.getElementById('grand-total').innerText = `฿${total.toLocaleString()}`;
        }

        function removeItem(index) {
            let cart = JSON.parse(localStorage.getItem('game_cart') || '[]');
            cart.splice(index, 1);
            localStorage.setItem('game_cart', JSON.stringify(cart));
            renderCart();
        }

        function clearCart() {
            if(confirm('CONFIRM PURGE: REMOVE ALL ITEMS?')) {
                localStorage.removeItem('game_cart');
                renderCart();
            }
        }

        window.onload = renderCart;
    </script>
</body>
</html>