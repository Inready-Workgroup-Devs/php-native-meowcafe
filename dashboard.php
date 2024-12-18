<?php
// Memasukkan file konfigurasi database untuk mendapatkan koneksi
require './config/database.php';
// Variabel $conn berasal dari file database.php dan digunakan untuk menyambungkan web dengan database

// Mengambil total penjualan minuman dari database
$totalDrinkSales = $conn->query("SELECT orders.status, COUNT(orders.id) AS total_orders
FROM orders
JOIN products ON orders.product_id = products.id
WHERE products.category_id = 2 AND orders.status = 'completed' ")->fetch_assoc();
// Penjelasan:
// 1. Menggunakan query SQL untuk menghitung jumlah pesanan minuman yang statusnya 'completed'.
// 2. JOIN digunakan untuk menggabungkan tabel 'orders' dan 'products' berdasarkan product_id.
// 3. 'category_id = 2' menunjukkan bahwa yang dihitung adalah pesanan minuman(drink).
// 4. Hasil query hanya berupa satu baris(satu data), jadi kita menggunakan fetch_assoc() untuk mengambil hasil sebagai array associative.

// var_dump($totalDrinkSales['total_orders']);
// untuk keperluan debugging, disarankan selalu menggunakan var_dump() untuk mengecek isi variabel

// Mengambil total penjualan makanan dari database
$totalFoodSales = $conn->query("SELECT orders.status, COUNT(orders.id) AS total_orders
FROM orders
JOIN products ON orders.product_id = products.id
WHERE products.category_id = 1 AND orders.status = 'completed' ")->fetch_assoc();
// Penjelasan:
// 1. Sama seperti query sebelumnya, tetapi kali ini mengambil pesanan makanan(food).
// 2. Menggunakan fetch_assoc() untuk mengambil hasil query yang hanya terdiri dari satu baris(satu data).

// var_dump($totalFoodSales);
// untuk keperluan debugging, disarankan selalu menggunakan var_dump() untuk mengecek isi variabel


// Menghitung total penjualan semua produk (minuman + makanan)
$totalOrders = $totalDrinkSales['total_orders'] + $totalFoodSales['total_orders'];
// Penjelasan:
// 1. $totalDrinkSales dan $totalFoodSales masing-masing sudah berisi jumlah produk yang terjual untuk minuman dan makanan.
// 2. Kita menambahkan kedua jumlah tersebut untuk mendapatkan total produk yang terjual secara keseluruhan.

// var_dump($totalOrders);
// untuk keperluan debugging, disarankan selalu menggunakan var_dump() untuk mengecek isi variabel


// Mengambil total pendapatan dari database berdasarkan harga produk yang terjual
$totalIncome = $conn->query("SELECT SUM(products.price) AS total_income
FROM orders
JOIN products ON orders.product_id = products.id
WHERE orders.status = 'completed';
")->fetch_assoc();
// Penjelasan:
// 1. Query ini menghitung total pendapatan dengan menjumlahkan harga semua produk yang terjual('status order nya sudah complete).
// 2. Menggunakan SUM() untuk menjumlahkan harga produk.
// 3. Menggunakan fetch_assoc() untuk mengambil hasil query yang hanya terdiri dari satu baris(satu data).

// var_dump($totalIncome);
// untuk keperluan debugging, disarankan selalu menggunakan var_dump() untuk mengecek isi variabel

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="styles/output.css">
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet" />
    <link rel="shortcut icon" href="../assets/inr.ico" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <main class="flex w-full">
        <aside class="py-6 w-[240px] bg-white h-screen fixed">
            <div class="flex h-full items-center justify-between flex-col w-full">
                <div class="w-full text-center">
                    <p class="font-extrabold text-lg">
                        <span class="text-primary">Meow</span>Cafe
                    </p>
                    <section class="mt-8 flex flex-col">
                        <div class="relative px-6">
                            <a
                                href="dashboard.php"
                                class="p-3 group data-active:bg-primary items-center flex w-full rounded-md data-active:text-white"
                                data-page="active">
                                <div
                                    class="bg-primary absolute rounded-e-lg top-0 left-0 h-full w-1 hidden group-data-active:block"></div>
                                <i class="ri-dashboard-line mr-4 text-lg"></i>
                                <span class="font-semibold">Dashboard</span>
                            </a>
                        </div>
                        <div class="relative px-6">
                            <a
                                href="products.php"
                                class="p-3 group data-active:bg-primary items-center flex w-full rounded-md data-active:text-white">
                                <div
                                    class="bg-primary absolute rounded-e-lg top-0 left-0 h-full w-1 hidden group-data-active:block"></div>
                                <i class="ri-microsoft-line mr-4 text-lg"></i>
                                <span class="font-semibold">Products</span>
                            </a>
                        </div>
                    </section>
                    <div class="h-[1px] bg-[#E0E0E0] w-full my-4"></div>
                    <section>
                        <div class="w-full px-4 mb-4">
                            <span
                                class="px-4 uppercase text-[#202224] font-bold text-sm w-full flex">Pages</span>
                        </div>
                        <div class="relative px-6">
                            <a
                                href="orders.php"
                                class="p-3 group data-active:bg-primary items-center flex w-full rounded-md data-active:text-white">
                                <div
                                    class="bg-primary absolute rounded-e-lg top-0 left-0 h-full w-1 hidden group-data-active:block"></div>
                                <i class="ri-clipboard-line mr-4 text-lg"></i>
                                <span class="font-semibold">Orders</span>
                            </a>
                        </div>
                    </section>
                </div>
                <div class="w-full px-6">
                    <button class="p-3 flex w-full items-center rounded-md">
                        <i class="ri-logout-circle-line mr-4 text-lg"></i>
                        <span class="font-semibold">Logout</span>
                    </button>
                </div>
            </div>
        </aside>
        <div class="ml-[240px] flex w-full relative">
            <nav
                class="h-[70px] flex py-4 px-7 justify-between items-center flex-grow fixed bg-white left-[240px] right-0">
                <input
                    type="text"
                    name=""
                    id=""
                    placeholder="Search"
                    class="px-4 w-96 h-full py-2 bg-[#F5F6FA] rounded-3xl border border-[#D5D5D5]" />
                <div class="flex gap-5 items-center h-full">
                    <div
                        class="overflow-hidden h-full aspect-square rounded-full object-center">
                        <img
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRj5r7mceg1cqsh7ZBtZYXjQUwXxjqTXV4qjHWC5Xf3_g&s"
                            alt=""
                            class="w-full" />
                    </div>
                    <div>
                        <p class="font-bold text-[#404040]">Imank</p>
                        <p class="text-sm font-semibold text-[#565656]">イマン</p>
                    </div>
                </div>
            </nav>
            <main class="p-7 bg-backgroundPrimary min-h-screen w-full mt-[70px]">
                <p class="text-3xl font-bold">Dashboard</p>
                <div class="mt-7 grid grid-cols-4 gap-x-7">
                    <div
                        class="flex flex-col justify-between flex-grow w-full bg-white p-4 h-40 rounded-xl">
                        <div class="inline-flex justify-between items-start">
                            <div class="font-semibold">Total Drink</div>
                            <div>
                                <i
                                    class="ri-group-fill text-3xl bg-purple/20 text-purple p-4 rounded-3xl"></i>
                            </div>
                        </div>
                        <div class="flex justify-between items-end">
                            <div>
                                <i class="ri-funds-line text-lg text-success"></i>
                            </div>
                            <p class="text-2xl font-bold"><?= $totalDrinkSales['total_orders'] ?></p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-between flex-grow w-full bg-white p-4 h-40 rounded-xl">
                        <div class="inline-flex justify-between items-start">
                            <div class="font-semibold">Total Food</div>
                            <div>
                                <i
                                    class="ri-line-chart-line text-3xl bg-success/20 text-success p-4 rounded-3xl"></i>
                            </div>
                        </div>
                        <div class="flex justify-between items-end">
                            <div>
                                <i class="ri-funds-line text-lg text-success"></i>
                            </div>
                            <p class="text-2xl font-bold"><?= $totalFoodSales['total_orders'] ?></p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-between flex-grow w-full bg-white p-4 h-40 rounded-xl">
                        <div class="inline-flex justify-between items-start">
                            <div class="font-semibold">Total Order</div>
                            <div>
                                <i
                                    class="ri-box-3-fill text-3xl bg-warning/20 text-warning p-4 rounded-3xl"></i>
                            </div>
                        </div>
                        <div class="flex justify-between items-end">
                            <div>
                                <i class="ri-funds-line text-lg text-success"></i>
                            </div>
                            <p class="text-2xl font-bold"><?= $totalOrders ?></p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-between flex-grow w-full bg-white p-4 h-40 rounded-xl">
                        <div class="inline-flex justify-between items-start">
                            <div class="font-semibold">Total Income</div>
                            <div>
                                <i
                                    class="ri-history-fill text-3xl bg-error/20 text-error p-4 rounded-3xl"></i>
                            </div>
                        </div>
                        <div class="flex justify-between items-end">
                            <div>
                                <i class="ri-funds-line text-lg text-success"></i>
                            </div>
                            <p class="text-2xl font-bold"><?= 'Rp' . number_format($totalIncome['total_income'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    <div class="w-full h-96 bg-white px-8 py-9 rounded-xl">
                        <p class="text-xl font-bold">Sales Details</p>
                        <canvas id="myChart" class="w-full"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </main>
    <script>
        const ctx = document.getElementById("myChart").getContext("2d");
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, "rgba(54, 162, 235, 0.5)");
        gradient.addColorStop(0.8, "rgba(54, 162, 235, 0)");
        const myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    "5k",
                    "10k",
                    "15k",
                    "20k",
                    "25k",
                    "30k",
                    "35k",
                    "40k",
                    "45k",
                    "50k",
                    "55k",
                    "60k",
                ],
                datasets: [{
                    label: "Data",
                    data: [
                        20, 35, 25, 64.37, 42, 47, 50, 30, 60, 40, 45, 10, 12312, 234,
                    ],
                    backgroundColor: gradient,
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: "rgba(54, 162, 235, 1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(54, 162, 235, 1)",
                }, ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            callback: function(value) {
                                return value + "%";
                            },
                        },
                        grid: {
                            drawBorder: false,
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || "";
                                if (label) {
                                    label += ": ";
                                }
                                label += parseFloat(context.raw).toFixed(2);
                                return label;
                            },
                        },
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
            },
        });
    </script>
</body>

</html>