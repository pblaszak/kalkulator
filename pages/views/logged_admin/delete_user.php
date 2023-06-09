<?php
session_start();
$conn = new mysqli("localhost", "root", "", "baza_danych");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Usuń użytkownika z bazy danych
    $sql = "DELETE FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Użytkownik został usunięty.";
    } else {
        echo "Wystąpił błąd podczas usuwania użytkownika.";
    }
} else {
    echo "Nieprawidłowy identyfikator użytkownika.";
}

?>