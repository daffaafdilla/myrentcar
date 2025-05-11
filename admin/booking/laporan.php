<?php
require '../../koneksi/koneksi.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="laporan_booking_all.csv"');

$output = fopen('php://output', 'w');

fputcsv($output, ['No.', 'Kode Booking', 'Merk Mobil', 'Nama', 'Tanggal Sewa', 'Lama Sewa (hari)', 'Total Harga (Rp)', 'Konfirmasi']);

$sql = "SELECT mobil.merk, booking.* FROM booking 
        JOIN mobil ON booking.id_mobil = mobil.id_mobil 
        ORDER BY booking.tanggal ASC";
$hasil = $koneksi->query($sql)->fetchAll();

$no = 1;
foreach ($hasil as $isi) {
    $row = [
        $no++,
        $isi['kode_booking'],
        $isi['merk'],
        $isi['nama'],
        $isi['tanggal'],
        $isi['lama_sewa'],
        number_format($isi['total_harga'], 2, ',', '.'), // Format angka
        $isi['konfirmasi_pembayaran']
    ];
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
