<?php
$servername = "127.0.0.1"; // или ваш сервер
$username = "root"; // замените на ваше имя пользователя
$password = ""; // замените на ваш пароль
$dbname = "test"; // замените на имя вашей базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
} else {
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хешируем пароль

    // SQL запрос для вставки данных в таблицу Авторизация
    $checkLoginSql = "SELECT * FROM `Avtorization` WHERE `Логин` = '$login'";
    $result = $conn->query($checkLoginSql);

    
    if ($result->num_rows > 0) {
        // Логин уже занят
        echo "<script>alert('Логин занят. Пожалуйста, выберите другой.');window.location.href = 'register.html';</script>";
    } else {
        // SQL запрос для вставки данных в таблицу Авторизация
        $sql = "INSERT INTO `Avtorization` (`Login`, `Password`) VALUES ('$login', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            // Получение последнего вставленного ID
            $last_id = $conn->insert_id;

        // Вставка в таблицу Данные пользователя
        $sql = "INSERT INTO `Users` (`Surname`, `Name`, `Date`, `Email`, `Login`, `Password`) 
                VALUES ('$lastname', '$firstname', '$birthdate', '$email', '$login', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            // Всплывающее окно с сообщением об успешной регистрации
            echo "<script>
            alert('Регистрация прошла успешно!');
            window.location.href = 'register.html'; // Замените на нужный URL
          </script>";
        } else {
            echo "Ошибка при вставке в таблицу Данные пользователя: " . $conn->error;
        }
        } else {
            echo "<div style='color: red; font-weight: bold;'>Ошибка при вставке в таблицу Авторизация: " . $conn->error . "</div>";
        }
    }
}

$conn->close(); // Закрываем соединение
?>