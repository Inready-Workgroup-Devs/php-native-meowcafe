<?php
// Konfigurasi koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'angkatan16_db';
// $tes = 14;

$conn = mysqli_connect($host, $username, $password, $database); //mysqli_connect() adalah fungsi(function) untuk menghubungkan ke database

// if ($conn) { // Jika koneksi sukses, maka tampilkan pesan berhasil
//     echo "Koneksi ke database berhasil!";
// }
?>