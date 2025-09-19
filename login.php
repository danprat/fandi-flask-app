<?php

include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $response['status'] = 'error';
            $response['message'] = 'Username dan password tidak boleh kosong';
        } else {
            // Ambil data user dari database berdasarkan username
            $stmt = $koneksi->prepare("SELECT id, username, password, role, nama_lengkap FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // Verifikasi password yang diinput dengan hash di database
                if (password_verify($password, $user['password'])) {
                    // Jika password cocok
                    $response['status'] = 'success';
                    $response['message'] = 'Login berhasil';
                    // Kirim data user (tanpa password) ke aplikasi
                    $response['data'] = [
                        'id' => $user['id'],
                        'nama_lengkap' => $user['nama_lengkap'],
                        'username' => $user['username'],
                        'role' => $user['role']
                    ];
                } else {
                    // Jika password salah
                    $response['status'] = 'error';
                    $response['message'] = 'Username atau password salah';
                }
            } else {
                // Jika username tidak ditemukan
                $response['status'] = 'error';
                $response['message'] = 'Username atau password salah';
            }
            $stmt->close();
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Data yang diperlukan tidak lengkap';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid';
}

echo json_encode($response);
$koneksi->close();

?>