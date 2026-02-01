<?php
header('Content-Type: application/json');

// Konfiguracja
$toEmail = 'carolalmadeoriente@gmail.com'; // Adres docelowy
$subject = 'Nowa wiadomość ze strony Fuego Lingua';

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie i oczyszczenie danych
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    // Walidacja
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Proszę wypełnić wszystkie pola poprawnie.';
        echo json_encode($response);
        exit;
    }

    // Treść wiadomości
    $email_content = "Imię: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Wiadomość:\n$message\n";

    // Nagłówki
    $headers = "From: no-reply@fuegolingua.pl\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Wysyłka
    if (mail($toEmail, $subject, $email_content, $headers)) {
        $response['success'] = true;
        $response['message'] = 'Wiadomość została wysłana!';
    } else {
        $response['message'] = 'Wystąpił problem z wysłaniem wiadomości. Spróbuj ponownie później.';
    }
} else {
    $response['message'] = 'Nieprawidłowe żądanie.';
}

echo json_encode($response);
?>
