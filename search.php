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
}

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $search = mysqli_real_escape_string($conn, $search); 

    // Исправлено: Удалены одинарные кавычки вокруг имени столбца
    $sql = "SELECT * FROM Books WHERE Name='$search'";
    $result = $conn->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<ul>"; // Начало списка
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>
                    Номер: " . $row['Id'] . ", 
                    Наименование: " . htmlspecialchars($row['Name']) . ", 
                    Автор: " . htmlspecialchars($row['Autor']) . ", 
                    Жанр: " . htmlspecialchars($row['Genre']) . ", 
                    Год издания: " . htmlspecialchars($row['Year']) . ", 
                    Издательство: " . htmlspecialchars($row['Publishing_house']) . "
                  </li>";
        }
        echo "</ul>"; // Конец списка
    } else {
        echo "Результатов не найдено";
    }
} else {
    echo "Запрос на поиск не предоставлен";
}

$conn->close(); // Закрываем соединение
?>