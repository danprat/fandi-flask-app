<?php
include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $koneksi->prepare("DELETE FROM pertemuan WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Data pertemuan berhasil dihapus';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'ID tidak ditemukan';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menghapus data: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'ID tidak boleh kosong';
    }
}

echo json_encode($response);
$koneksi->close();
?>