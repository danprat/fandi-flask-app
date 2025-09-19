<?php
include 'koneksi.php';

$response = array();

if (isset($_GET['id_pertemuan'])) {
    $id_pertemuan = $_GET['id_pertemuan'];

    // Query untuk menghitung total dan jumlah pembayar (tanpa total_arisan)
    $sql_summary = "SELECT 
                        SUM(CASE WHEN bayar_kas = 1 THEN 2000 ELSE 0 END) as total_kas,
                        SUM(jumlah_sosial) as total_sosial,
                        COUNT(CASE WHEN bayar_kas = 1 AND bayar_arisan = 1 THEN 1 END) as jumlah_lunas
                    FROM iuran_warga 
                    WHERE id_pertemuan = ?";
    
    $stmt_summary = $koneksi->prepare($sql_summary);
    $stmt_summary->bind_param("i", $id_pertemuan);
    $stmt_summary->execute();
    $result_summary = $stmt_summary->get_result();
    $response['summary'] = $result_summary->fetch_assoc();

    // Query untuk mengambil daftar warga yang sudah bayar lunas (kas & arisan)
    $sql_lunas = "SELECT w.nama_warga FROM iuran_warga iw 
                  JOIN warga w ON iw.id_warga = w.id 
                  WHERE iw.id_pertemuan = ? AND iw.bayar_kas = 1 AND iw.bayar_arisan = 1
                  ORDER BY w.nama_warga ASC";
    
    $stmt_lunas = $koneksi->prepare($sql_lunas);
    $stmt_lunas->bind_param("i", $id_pertemuan);
    $stmt_lunas->execute();
    $result_lunas = $stmt_lunas->get_result();
    $warga_lunas = array();
    while($row = $result_lunas->fetch_assoc()) {
        $warga_lunas[] = $row['nama_warga'];
    }
    $response['warga_lunas'] = $warga_lunas;

    // Query untuk mengambil daftar warga yang belum bayar lunas
    $sql_belum_lunas = "SELECT w.nama_warga FROM iuran_warga iw 
                        JOIN warga w ON iw.id_warga = w.id 
                        WHERE iw.id_pertemuan = ? AND (iw.bayar_kas = 0 OR iw.bayar_arisan = 0)
                        ORDER BY w.nama_warga ASC";

    $stmt_belum_lunas = $koneksi->prepare($sql_belum_lunas);
    $stmt_belum_lunas->bind_param("i", $id_pertemuan);
    $stmt_belum_lunas->execute();
    $result_belum_lunas = $stmt_belum_lunas->get_result();
    $warga_belum_lunas = array();
    while($row = $result_belum_lunas->fetch_assoc()) {
        $warga_belum_lunas[] = $row['nama_warga'];
    }
    $response['warga_belum_lunas'] = $warga_belum_lunas;

} else {
    $response['status'] = 'error';
    $response['message'] = 'ID Pertemuan tidak valid.';
}

echo json_encode($response);
$koneksi->close();

?>