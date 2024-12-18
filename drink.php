<?php
require_once './config/database.php';

// Query untuk menghitung total produk dengan kategori Food
$totalFoods = $conn->query("SELECT COUNT(*) as total_foods FROM products WHERE category_id = 1")->fetch_assoc();

// Query untuk menghitung total produk dengan kategori Drink
$totalDrinks = $conn->query("SELECT COUNT(*) as total_drinks FROM products WHERE category_id = 2")->fetch_assoc();

// Query untuk mengambil data dari kategori Drink
$drinks = $conn->query("SELECT * FROM  products WHERE category_id = 2");
// tidak memerlukan fetch_assoc() karena akan di-looping dengan foreach

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MeowCafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
        rel="stylesheet" />
</head>

<body>
    <main class="py-[75px] px-[70px] bg-gray-100 min-h-screen flex gap-16">
        <div>
            <p class="font-bold text-3xl">
                <span class="text-[#4880FF]">Meow</span>Cafe
            </p>
            <aside class="bg-white min-h-full w-72 p-6 mt-6 rounded-xl">
                <p class="font-bold">Category</p>
                <div class="flex flex-col mt-4 gap-y-1">
                    <a href="index.php"
                        class="flex justify-between py-3 px-4 rounded text-textPrimary font-semibold category-button" data-category="food">
                        <div>
                            <i class="ri-restaurant-line mr-3"></i>
                            <span class="">Food</span>
                        </div>
                        <span class="count"><?= $totalFoods['total_foods'] ?></span>
                    </a>
                    <a href="drink.php"
                        class="flex justify-between py-3 px-4 rounded text-textPrimary font-semibold bg-[#4880FF]/20 category-button" data-category="drink">
                        <div>
                            <i class="ri-goblet-line mr-3 text-[#4880FF]/80"></i><span class="text-[#4880FF]/80">Drink</span>
                        </div>
                        <span class="count text-[#4880FF]/80"><?= $totalDrinks['total_drinks'] ?></span>
                    </a>
                </div>
        </div>
        </aside>
        </div>
        <section class="w-full">
            <p class="font-bold text-3xl">Menu</p>
            <div id="product-list" class="mt-6 grid grid-cols-3 gap-6">
                <?php
                foreach ($drinks as $drink):
                ?>
                    <div class="product bg-white rounded-xl overflow-hidden" data-category="drink">
                        <div class="max-h-[300px] overflow-hidden">
                            <img src="<?= 'images/' . $drink['image'] ?>" alt="<?= $drink['name'] ?>" class="w-full h-full object-cover object-center" />
                        </div>
                        <div class="p-5">
                            <p class="font-bold"><?= $drink['name'] ?></p>
                            <p class="font-bold text-[14px] text-[#4880FF]/80">
                                <?= 'Rp' . number_format($drink['price'], 0, ',', '.'); ?>
                            </p>
                            <button class="py-2 px-9 mt-3 bg-[#E2EAF8] rounded-xl font-bold">Pesan</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>

</html>