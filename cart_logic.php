<?php
session_start();
require_once 'db_config.php';

// เช็คสถานะการ Login (บังคับ Login ก่อนชำระเงิน)
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$current_username = htmlspecialchars($_SESSION["username"]);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHECKOUT | IRON SIGHT TACTICAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Bai+Jamjuree:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #0A0A0B; 
            color: #E2E2E2; 
            font-family: 'Bai Jamjuree', sans-serif;
            background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        }
        .font-header { font-family: 'Orbitron', sans-serif; }
        .input-tactical {
            background: #14161A;
            border: 1px solid #2D3748;
            color: white;
            padding: 12px;
            width: 100%;
            outline: none;
            transition: 0.3s;
        }
        .input-tactical:focus { border-color: #FF8C00; box-shadow: 0 0 10px rgba(255, 140, 0, 0.2); }
        .checkout-card { background: rgba(20, 22, 24, 0.9); border: 1px solid #2D3748; }
    </style>
</head>
<body>

    <nav class="border-b border-orange-600/30 bg-black/90 p-6 shadow-2xl">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="font-header text-2xl font-black italic text-white uppercase">
                IRON<span class="text-orange-500">SIGHT</span> <span class="text-sm font-light text-gray-500 ml-4">/ Secure Checkout</span>
            </a>
            <a href="allgame.php" class="text-xs font-header text-gray-500 hover:text-orange-500 transition">Return to Armory</a>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        <form action="process_order.php" method="POST" id="checkout-form">
            <div class="grid lg:grid-cols-3 gap-10">
                
                <div class="lg:col-span-2 space-y-8">
                    <section class="checkout-card p-8">
                        <h2 class="font-header text-xl font-black italic mb-6 text-orange-500 uppercase">1. Operator Information</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500 mb-2 block">Username</label>
                                <input type="text" value="<?= $current_username ?>" class="input-tactical opacity-50 cursor-not-allowed" readonly>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500 mb-2 block">Full Name</label>
                                <input type="text" name="full_name" class="input-tactical" placeholder="หน่วยปฏิบัติการ..." required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-bold uppercase text-gray-500 mb-2 block">Delivery Address (Email for Digital Assets)</label>
                                <input type="email" name="email" class="input-tactical" placeholder="operator@ironsight.com" required>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-card p-8">
                        <h2 class="font-header text-xl font-black italic mb-6 text-orange-500 uppercase">2. Payment Protocol</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="transfer" class="hidden peer" checked>
                                <div class="p-4 border border-gray-800 bg-black text-center peer-checked:border-orange-500 peer-checked:bg-orange-500/10 transition">
                                    <span class="text-xs font-bold uppercase tracking-widest">Bank Transfer</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="qr" class="hidden peer">
                                <div class="p-4 border border-gray-800 bg-black text-center peer-checked:border-orange-500 peer-checked:bg-orange-500/10 transition">
                                    <span class="text-xs font-bold uppercase tracking-widest">QR Payment</span>
                                </div>
                            </label>
                        </div>
                    </section>
                </div>

                <div class="lg:col-span-1">
                    <div class="checkout-card p-8 sticky top-28 border-t-4 border-orange-500">
                        <h2 class="font-header text-xl font-black italic mb-6 uppercase">Asset Summary</h2>
                        
                        <div id="checkout-items" class="space-y-4 mb-8 max-h-60 overflow-y-auto pr-2">
                            </div>

                        <div class="border-t border-gray-800 pt-6 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 uppercase">Subtotal</span>
                                <span id="subtotal" class="font-bold">฿0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 uppercase">Tax (0%)</span>
                                <span class="font-bold">฿0.00</span>
                            </div>
                            <div class="flex justify-between pt-4 border-t border-orange-600/50">
                                <span class="font-header text-lg font-black uppercase">Grand Total</span>
                                <span id="grand-total" class="font-header text-2xl text-orange-500 font-black italic">฿0.00</span>
                            </div>
                        </div>

                        <input type="hidden" name="cart_data" id="cart-data-input">

                        <button type="submit" class="w-full mt-8 bg-orange-600 hover:bg-orange-500 py-4 text-black font-header font-black italic uppercase transition shadow-lg shadow-orange-600/20 active:scale-95">
                            Confirm Procurement
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </main>

    <script>
        function renderCheckout() {
            const cart = JSON.parse(localStorage.getItem('game_cart') || '[]');
            const container = document.getElementById('checkout-items');
            const subtotalEl = document.getElementById('subtotal');
            const totalEl = document.getElementById('grand-total');
            const cartInput = document.getElementById('cart-data-input');
            
            let total = 0;

            if (cart.length === 0) {
                window.location.href = 'allgame.php'; // ถ้าไม่มีของให้กลับหน้าเดิม
                return;
            }

            container.innerHTML = '';
            cart.forEach(item => {
                total += parseFloat(item.price);
                container.innerHTML += `
                    <div class="flex justify-between items-center text-xs">
                        <div>
                            <p class="font-bold text-white uppercase">${item.title}</p>
                            <p class="text-[9px] text-orange-500 font-bold tracking-tighter">${item.genre}</p>
                        </div>
                        <span class="font-header">฿${parseFloat(item.price).toLocaleString()}</span>
                    </div>
                `;
            });

            subtotalEl.innerText = `฿${total.toLocaleString()}`;
            totalEl.innerText = `฿${total.toLocaleString()}`;
            
            // ใส่ข้อมูล JSON ลงใน Hidden Input เพื่อให้ PHP เอาไปเก็บลง Database ได้
            cartInput.value = JSON.stringify(cart);
        }

        window.onload = renderCheckout;
    </script>
</body>
</html>