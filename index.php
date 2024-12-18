<?php
// Memasukkan file konfigurasi database untuk mendapatkan koneksi
require './config/database.php';
// Variabel $conn berasal dari file database.php dan digunakan untuk menyambungkan aplikasi dengan database

// Mengambil jumlah total produk kategori food (category_id = 1) dari tabel 'products'
// Query ini menghitung banyaknya produk dengan kategori food di database dan menyimpan hasilnya dalam $totalFoods
$totalFoods = $conn->query("SELECT COUNT(*) as total_foods FROM products WHERE category_id = 1")->fetch_assoc();
// Hasil query hanya berupa satu baris(satu data), jadi kita menggunakan fetch_assoc() untuk mengambil hasil sebagai array associative.

// var_dump($totalFoods['total_foods']);
// untuk keperluan debugging, disarankan selalu menggunakan var_dump() untuk mengecek isi variabel

// Mengambil jumlah total produk kategori drink (category_id = 2) dari tabel 'products'
// Query ini menghitung banyaknya produk dengan kategori drink di database dan menyimpan hasilnya dalam $totalFoods
$totalDrinks = $conn->query("SELECT COUNT(*) as total_drinks FROM products WHERE category_id = 2")->fetch_assoc();
// Hasil query hanya berupa satu baris(satu data), jadi kita menggunakan fetch_assoc() untuk mengambil hasil sebagai array associative.

// var_dump($totalDrinks['total_drinks']);
// untuk keperluan debugging, disarankan selalu menggunakan var_dump() untuk mengecek isi variabel

// Query ini mengambil semua kolom dari tabel 'products' dengan category_id 1 dan menyimpannya dalam variabel $foods
$foods = $conn->query("SELECT * FROM  products WHERE category_id = 1");
// tidak memerlukan fetch_assoc() karena akan di-looping dengan foreach

// Query ini mengambil semua kolom dari tabel 'products' dengan category_id 2 dan menyimpannya dalam variabel $foods
$drinks = $conn->query("SELECT * FROM  products WHERE category_id = 2");
// tidak memerlukan fetch_assoc() karena akan di-looping dengan foreach

// hanya untuk menampilkan data $drinks supaya lebih mudah dibaca
// echo '<pre>';
// print_r($foods->fetch_all(MYSQLI_ASSOC));
// echo '</pre>';
// exit; // Menghentikan eksekusi script setelah menampilkan output
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MeowCafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/output.css">
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet" />
</head>

<body>
    <main
        class="py-[75px] px-[70px] bg-backgroundPrimary min-h-screen flex gap-16">
        <div>
            <p class="font-bold text-3xl">
                <span class="text-sky-600">Meow</span>Cafe
            </p>
            <aside class="bg-white min-h-full w-72 p-6 mt-6 rounded-xl">
                <p class="font-bold">Category</p>
                <div class="flex flex-col mt-4 gap-y-1">
                    <button
                        class="flex justify-between py-3 px-4 rounded font-semibold bg-[#4880FF]/20 category-button"
                        data-category="food">
                        <div>
                            <i class="ri-restaurant-line mr-3 text-[#4880FF]/80"></i>
                            <span class="text-[#4880FF]/80">Food</span>
                        </div>
                        <span class="count text-[#4880FF]/80"><?= $totalFoods['total_foods'] ?></span>
                    </button>

                    <!-- Ada dua cara untuk menampilkan halaman drink -->

                    <!-- Cara Pertama, tidak perlu pindah halaman. Cara ini bisa dilakukan dengan bantuan javascript. Jika ingin menggunakan cara pertama silahkan buka komentar baris kode 77 sampai 84, dan komentar baris kode 87 sampai 93  -->
                    <button
                        class="flex justify-between py-3 px-4 rounded text-textPrimary font-semibold category-button" data-category="drink">
                        <div>
                            <i class="ri-goblet-line mr-3"></i>
                            <span>Drink</span>
                        </div>
                        <span class="count"><?= $totalDrinks['total_drinks'] ?></span>
                    </button>

                    <!-- Cara Kedua, akan berpindah ke halaman drink.php. Tidak memerlukan bantuan javascript. Jika ingin menggunakan cara kedua silahkan buka komentar baris kode 87 sampai 93, dan komentar baris kode 77 sampai 84  -->
                    <!-- <a href="drink.php"
                        class="flex justify-between py-3 px-4 rounded text-textPrimary font-semibold category-button" data-category="drink">
                        <div>
                            <i class="ri-goblet-line mr-3"></i><span>Drink</span>
                        </div>
                        <span class="count"><?= $totalDrinks['total_drinks'] ?></span>
                    </a> -->
                </div>
            </aside>
        </div>
        <main class="w-full">
            <p class="font-bold text-3xl">Menu</p>
            <section class="mt-6 grid grid-cols-3 gap-6">
                <?php foreach ($foods as $food) : ?>
                    <div class="product bg-white rounded-xl overflow-hidden" data-category="food">
                        <div
                            class="max-h-[300px] overflow-hidden object-cover object-center">
                            <img
                                src="<?= 'images/' . $food['image'] ?>"
                                alt=""
                                class="w-full h-full" />
                        </div>
                        <div class="p-5">
                            <p class="font-bold"><?= $food['name'] ?></p>
                            <p class="font-bold text-[14px] text-primary"><?= 'Rp' . number_format($food['price'], 0, ',', '.'); ?></p>
                            <button
                                class="py-2 px-9 mt-3 bg-[#E2EAF8] rounded-xl font-bold text-bold">
                                Pesan
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php foreach ($drinks as $drink) : ?>
                    <div class="product bg-white rounded-xl overflow-hidden" data-category="drink">
                        <div
                            class="max-h-[300px] overflow-hidden object-cover object-center">
                            <img
                                src="<?= 'images/' . $drink['image'] ?>"
                                alt=""
                                class="w-full h-full" />
                        </div>
                        <div class="p-5">
                            <p class="font-bold"><?= $drink['name'] ?></p>
                            <p class="font-bold text-[14px] text-primary"><?= 'Rp' . number_format($drink['price'], 0, ',', '.'); ?></p>
                            <button
                                class="py-2 px-9 mt-3 bg-[#E2EAF8] rounded-xl font-bold text-bold">
                                Pesan
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.category-button');
            const products = document.querySelectorAll('.product');

            // Set kategori default (misalnya "food")
            const defaultCategory = 'food';

            // Sembunyikan produk selain kategori default
            products.forEach(product => {
                if (product.getAttribute('data-category') !== defaultCategory) {
                    product.style.display = 'none';
                }
            });

            // Aktifkan tombol kategori default
            buttons.forEach(button => {
                const category = button.getAttribute('data-category');
                if (category === defaultCategory) {
                    button.classList.add('bg-[#4880FF]/20');
                    const icon = button.querySelector('i');
                    const spanText = button.querySelector('span:not(.count)');
                    const countText = button.querySelector('.count');
                    if (icon) icon.classList.add('text-[#4880FF]/80');
                    if (spanText) spanText.classList.add('text-[#4880FF]/80');
                    if (countText) countText.classList.add('text-[#4880FF]/80');
                }
            });

            // Tambahkan event listener untuk tombol kategori
            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    buttons.forEach(btn => {
                        // Reset semua button
                        btn.classList.remove('bg-[#4880FF]/20');
                        const icon = btn.querySelector('i');
                        const spanText = btn.querySelector('span:not(.count)');
                        const countText = btn.querySelector('.count');
                        if (icon) icon.classList.remove('text-[#4880FF]/80');
                        if (spanText) spanText.classList.remove('text-[#4880FF]/80');
                        if (countText) countText.classList.remove('text-[#4880FF]/80');
                    });

                    // Tambahkan class ke tombol yang aktif
                    button.classList.add('bg-[#4880FF]/20');
                    const activeIcon = button.querySelector('i');
                    const activeSpanText = button.querySelector('span:not(.count)');
                    const activeCountText = button.querySelector('.count');
                    if (activeIcon) activeIcon.classList.add('text-[#4880FF]/80');
                    if (activeSpanText) activeSpanText.classList.add('text-[#4880FF]/80');
                    if (activeCountText) activeCountText.classList.add('text-[#4880FF]/80');

                    // Filter produk berdasarkan kategori
                    const category = button.getAttribute('data-category');
                    products.forEach(product => {
                        product.style.display = product.getAttribute('data-category') === category ? 'block' : 'none';
                    });
                });
            });
        });
    </script>
</body>

</html>