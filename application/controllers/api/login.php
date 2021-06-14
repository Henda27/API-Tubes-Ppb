<?php
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM pegawai WHERE id_admin = '$pegawai'";
$query = $conn->query($sql);

if ($query->num_rows < 1) {
    echo json_encode(['error' => 'Username Pegawai salah']);
} else {
    $row = $query->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Kata Sandi Salah!!']);
    }
}
