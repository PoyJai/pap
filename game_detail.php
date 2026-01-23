<?php
session_start();
require_once 'db_config.php'; 

if (isset($_GET['logout'])) {
    session_destroy();
    header('location: login.php'); 
    exit;
}

$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$current_username = $is_logged_in ? htmlspecialchars($_SESSION["username"]) : "UNKNOWN_OPERATOR"; 

$game_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($game_id === 0) {
    header("Location: allgame.php");
    exit;
}

$sql = "SELECT id, title, description, long_description, genre, image_url, price, release_date, developer, rating FROM games WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $game_id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    header("Location: allgame.php");
    exit;
}

$stmt->close();
$conn->close();

// Cleanup Data
$game_title = htmlspecialchars($game['title']);
$game_short_desc = htmlspecialchars($game['description']);
$game_long_desc = nl2br(htmlspecialchars($game['long_description']));
$game_genre = htmlspecialchars($game['genre']);
$game_image = empty($game['image_url']) ? 'https://via.placeholder.com/1200x600?text=NO_SIGNAL' : htmlspecialchars($game['image_url']);
$game_price = number_format((float)$game['price'], 2);
$game_release = date('d-m-Y', strtotime($game['release_date']));
$game_developer = htmlspecialchars($game['developer']);
$game_rating = (float)$game['rating'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $game_title ?> | CLASSIFIED_DATA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'neon-blood': '#FF0000',
                        'dead-red': '#880808',
                        'dark-void': '#050505',
                        'hacker-green': '#00FF41'
                    },
                    fontFamily: {
                        'brutal': ['"Permanent Marker"', 'sans-serif'],
                        'cyber': ['Orbitron', 'sans-serif'],
                        'mono': ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #050505;
            color: #b0b0b0;
            font-family: 'JetBrains Mono', monospace;
            background-image: radial-gradient(circle at 50% 50%, #1a0505 0%, #050505 100%);
        }

        /* Scanline Overlay */
        .scanlines::before {
            content: " ";
            display: block;
            position: fixed;
            top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), 
                        linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
            z-index: 9999;
            background-size: 100% 3px, 3px 100%;
            pointer-events: none;
        }

        .brutal-border {
            border: 2px solid #880808;
            position: relative;
        }

        .brutal-border::after {
            content: "SECURE_FILE";
            position: absolute;
            top: -12px; left: 20px;
            background: #880808;
            color: white;
            padding: 0 10px;
            font-size: 10px;
            font-weight: bold;
        }

        .btn-action {
            clip-path: polygon(5% 0, 100% 0, 95% 100%, 0% 100%);
            transition: 0.3s;
        }

        .btn-action:hover {
            box-shadow: 0 0 20px #FF0000;
            transform: scale(1.02);
        }

        .glitch-text {
            animation: glitch 2s infinite;
        }

        @keyframes glitch {
            0% { text-shadow: 2px 0 #ff0000; }
            50% { text-shadow: -2px 0 #00ff41; }
            100% { text-shadow: 2px 0 #ff0000; }
        }
    </style>
</head>
<body class="scanlines">

    <header class="border-b border-dead-red bg-black/80 backdrop-blur-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="font-brutal text-3xl text-neon-blood tracking-tighter">STUN<span class="text-white italic">SHOP</span></a>
            <div class="flex items-center space-x-6 text-xs font-bold tracking-widest">
                <a href="allgame.php" class="hover:text-neon-blood transition">[ BACK_TO_ARCHIVES ]</a>
                <button id="open-cart-btn" class="relative">
                    <span id="cart-item-count" class="bg-neon-blood text-black px-1 absolute -top-3 -right-3">0</span>
                    CART
                </button>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8">
                <div class="relative group mb-8 border-4 border-dead-red">
                    <img src="<?= $game_image ?>" class="w-full grayscale hover:grayscale-0 transition duration-700">
                    <div class="absolute top-0 left-0 bg-dead-red text-white p-2 font-bold text-xs">
                        LIVE_FEED // 00<?= $game_id ?>
                    </div>
                </div>

                <div class="brutal-border p-8 bg-black/60">
                    <h1 class="text-5xl font-brutal text-white mb-2 uppercase italic"><?= $game_title ?></h1>
                    <div class="flex gap-4 mb-6">
                        <span class="bg-neon-blood/20 text-neon-blood px-3 py-1 text-xs border border-neon-blood"><?= $game_genre ?></span>
                        <span class="text-zinc-600 text-xs py-1">DEPLOYED: <?= $game_release ?></span>
                    </div>

                    <p class="text-xl text-zinc-300 italic mb-10 leading-relaxed border-l-4 border-dead-red pl-6">
                        "<?= $game_short_desc ?>"
                    </p>

                    <h3 class="font-cyber text-neon-blood mb-4 flex items-center gap-2">
                        <span class="w-8 h-1 bg-neon-blood"></span> FILE_DETAILS
                    </h3>
                    <div class="text-zinc-400 leading-loose space-y-4 font-mono text-sm">
                        <?= $game_long_desc ?>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-24 space-y-6">
                    
                    <div class="bg-dead-red p-1">
                        <div class="bg-black p-6 border border-dead-red">
                            <div class="flex justify-between items-end mb-6">
                                <span class="text-xs text-zinc-500 uppercase">Acquisition_Cost</span>
                                <span class="text-4xl font-cyber font-black text-white">฿<?= $game_price ?></span>
                            </div>
                            
                            <button id="add-to-cart-btn" 
                                    data-id="<?= $game['id'] ?>" 
                                    data-title="<?= $game_title ?>"
                                    data-price="<?= $game['price'] ?>"
                                    class="btn-action w-full py-4 bg-neon-blood text-black font-black text-xl hover:bg-white transition uppercase">
                                ADD_TO_LOADOUT
                            </button>
                        </div>
                    </div>

                    <div class="brutal-border p-6 bg-black/40 text-[11px] uppercase tracking-widest font-bold">
                        <h4 class="mb-4 text-zinc-500 border-b border-zinc-800 pb-2">Technical_Specs</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-zinc-600">Architect</span>
                                <span class="text-white"><?= $game_developer ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-600">Danger_Level</span>
                                <span class="text-neon-blood"><?= $game_rating ?> / 5.0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-600">Status</span>
                                <span class="text-hacker-green glitch-text">STABLE</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <div id="cart-modal" class="fixed inset-0 bg-black/95 z-[100] hidden flex items-center justify-center p-4">
        <div class="bg-black border-2 border-neon-blood w-full max-w-lg p-8 shadow-[0_0_50px_rgba(255,0,0,0.3)]">
            <div class="flex justify-between items-center mb-8 border-b border-dead-red pb-4">
                <h2 class="font-brutal text-2xl text-white italic">CURRENT_LOADOUT</h2>
                <button id="close-cart-modal-btn" class="text-neon-blood hover:text-white transition">[X]</button>
            </div>
            <div id="cart-items-list" class="space-y-4 mb-8 max-h-60 overflow-y-auto pr-2 font-mono text-xs">
                </div>
            <div class="border-t border-dead-red pt-4 flex justify-between items-center">
                <span class="text-zinc-500 uppercase">Total_Damage:</span>
                <span id="cart-total-amount" class="text-3xl font-cyber text-white">฿0.00</span>
            </div>
            <button id="checkout-btn" class="btn-action w-full mt-6 py-3 bg-white text-black font-bold uppercase hover:bg-neon-blood transition">
                CONFIRM_ORDER
            </button>
        </div>
    </div>

    <script>
        // Cart System (Optimized for LocalStorage)
        const addToCartBtn = document.getElementById('add-to-cart-btn');
        const cartCount = document.getElementById('cart-item-count');
        const cartModal = document.getElementById('cart-modal');
        const cartItemsList = document.getElementById('cart-items-list');

        const getCart = () => JSON.parse(localStorage.getItem('game_cart') || '[]');
        const saveCart = (cart) => localStorage.setItem('game_cart', JSON.stringify(cart));

        const updateUI = () => {
            const cart = getCart();
            cartCount.innerText = cart.length;
            
            let total = 0;
            cartItemsList.innerHTML = cart.length ? '' : '<p class="text-zinc-800">NO_DATA_FOUND</p>';
            
            cart.forEach((item, index) => {
                total += parseFloat(item.price);
                cartItemsList.innerHTML += `
                    <div class="flex justify-between items-center border-l-2 border-neon-blood pl-4 py-2 bg-zinc-900/30">
                        <span>${item.title}</span>
                        <div class="flex gap-4 items-center">
                            <span class="text-neon-blood">฿${parseFloat(item.price).toFixed(2)}</span>
                            <button onclick="removeItem(${index})" class="text-zinc-600 hover:text-white">[DELETE]</button>
                        </div>
                    </div>
                `;
            });
            document.getElementById('cart-total-amount').innerText = `฿${total.toLocaleString()}`;
        };

        addToCartBtn.onclick = () => {
            const cart = getCart();
            const id = addToCartBtn.dataset.id;
            if (!cart.find(i => i.id === id)) {
                cart.push({
                    id: id,
                    title: addToCartBtn.dataset.title,
                    price: addToCartBtn.dataset.price
                });
                saveCart(cart);
                updateUI();
                cartModal.classList.remove('hidden');
            } else {
                alert("ITEM_ALREADY_IN_LOADOUT");
            }
        };

        window.removeItem = (index) => {
            const cart = getCart();
            cart.splice(index, 1);
            saveCart(cart);
            updateUI();
        };

        document.getElementById('open-cart-btn').onclick = () => cartModal.classList.remove('hidden');
        document.getElementById('close-cart-modal-btn').onclick = () => cartModal.classList.add('hidden');
        document.getElementById('checkout-btn').onclick = () => window.location.href = 'checkout.php';

        updateUI();
    </script>
</body>
</html>