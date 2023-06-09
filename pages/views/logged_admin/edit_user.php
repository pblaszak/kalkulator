<?php
session_start();
$conn = new mysqli("localhost", "root", "", "baza_danych");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Sprawdź, czy formularz został wysłany
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pobierz dane z formularza
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $role_id = $_POST['role_id'];

        // Zaktualizuj dane użytkownika w bazie danych
        $sql = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', email = '$email', role_id = '$role_id' WHERE id = $userId";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "Dane użytkownika zostały zaktualizowane.";
        } else {
            echo "Wystąpił błąd podczas aktualizacji danych użytkownika: " . mysqli_error($conn);
        }
    }

    // Pobierz dane użytkownika z bazy danych
    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $user = mysqli_fetch_assoc($result);
    
        // Wyświetl formularz edycji użytkownika
        echo '<form method="POST" action="">';
        echo '<input type="text" name="firstName" value="' . $user['firstName'] . '"><br>';
        echo '<input type="text" name="lastName" value="' . $user['lastName'] . '"><br>';
        echo '<input type="email" name="email" value="' . $user['email'] . '"><br>';
        echo '<input type="text" name="role_id" value="' . $user['role_id'] . '"><br>';
        echo '<input type="submit" value="Zapisz">';
        echo '</form>';
    } else {
        echo "Nieprawidłowy identyfikator użytkownika: " . mysqli_error($conn);
    }
} else {
    echo "Nieprawidłowy identyfikator użytkownika.";
}

?>