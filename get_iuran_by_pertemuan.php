<?php
include 'koneksi.php';

$response = array();

// Memastikan id_pertemuan dikirim melalui GET
if (isset($_GET['id_pertemuan'])) {
    $id_pertemuan = $_GET['id_pertemuan'];

    // Langkah 1: Ambil semua ID warga yang aktif
    $warga_result = $koneksi->query("SELECT id FROM warga WHERE status_aktif = 1");
    while ($warga_row = $warga_result->fetch_assoc()) {
        $id_warga = $warga_row['id'];

        // Langkah 2: Cek apakah data iuran untuk warga ini di pertemuan ini sudah ada
        $check_stmt = $koneksi->prepare("SELECT id FROM iuran_warga WHERE id_pertemuan = ? AND id_warga = ?");
        $check_stmt->bind_param("ii", $id_pertemuan, $id_warga);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        // Langkah 3: Jika tidak ada, buat data iuran default (semua belum bayar)
        if ($check_result->num_rows === 0) {
            $insert_stmt = $koneksi->prepare("INSERT INTO iuran_warga (id_pertemuan, id_warga) VALUES (?, ?)");
            $insert_stmt->bind_param("ii", $id_pertemuan, $id_warga);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
        $check_stmt->close();
    }

    // Langkah 4: Ambil semua data iuran untuk pertemuan ini, gabungkan dengan nama warga
    $sql = "SELECT 
                iw.id, 
                iw.id_warga, 
                w.nama_warga, 
                iw.bayar_kas, 
                iw.bayar_arisan, 
                iw.jumlah_sosial 
            FROM 
                iuran_warga iw
            JOIN 
                warga w ON iw.id_warga = w.id
            WHERE 
                iw.id_pertemuan = ?
            ORDER BY
                w.nama_warga ASC";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_pertemuan);
    $stmt->execute();
    $result = $stmt->get_result();

    $iuran_data = array();
    while ($row = $result->fetch_assoc()) {
        $iuran_data[] = $row;
    }
    $response = $iuran_data;

} else {
    $response['status'] = 'error';
    $response['message'] = 'ID Pertemuan tidak disertakan';
}

echo json_encode($response);
$koneksi->close();

?>