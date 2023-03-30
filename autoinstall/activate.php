<?php
session_start();

//import i walidacja danych
require_once('validate.php');

if (!isset($_POST['name'])) {
    header('Location: index.php');
    $_SESSION['error'] = "Uzupełnij formularz.";
    exit();
}

$imie = $_POST['name'];
$imie = new Formularz("$imie");
if ($imie->validate_name()) $_SESSION['imie'] = $imie->get_safe_value();
else $_SESSION['error'] = "Pole <b>Imię</b> jest niepoprawne.";


$nazwisko = $_POST['surname'];
$nazwisko = new Formularz("$nazwisko");
if ($nazwisko->validate_surname()) $_SESSION['nazwisko'] = $nazwisko->get_safe_value();
else $_SESSION['error'] = "Pole <b>Nazwisko</b> jest niepoprawne.";

$email = $_POST['email'];
$email = new Formularz("$email");
if ($email->validate_email()) $_SESSION['email'] = $email->get_safe_value();
else $_SESSION['error'] = "Pole <b>Email</b> jest niepoprawne.";

$haslo = $_POST['password'];
$haslo = new Formularz("$haslo", "yes", "0", "4");

$haslo2 = $_POST['password2'];
$haslo2 = new Formularz("$haslo2");
if (!$haslo->validate()) $_SESSION['error'] = "Pole <b>Hasło</b> nie spełnia wymogów!";
else if (!$haslo2->validate_passwords($haslo)) $_SESSION['error'] = "<b>Hasła nie mogą się różnić.";
else $haslo2 = $haslo2->get_safe_value();

$db_host = $_POST['host'];
$db_host = new Formularz("$db_host");
if ($db_host->validate()) $_SESSION['db_host'] = $db_host->get_safe_value();
else $_SESSION['error'] = "Pole <b>Host</b> jest niepoprawne.";

$db_name = $_POST['db_name'];
$db_name = new Formularz("$db_name");
if ($db_name->validate()) $_SESSION['db_name'] = $db_name->get_safe_value();
else $_SESSION['error'] = "Pole <b>Nazwa bazy danych</b> jest niepoprawne.";

$db_username = $_POST['db_user'];
$db_username = new Formularz("$db_username");
if ($db_username->validate()) $_SESSION['db_username'] = $db_username->get_safe_value();
else $_SESSION['error'] = "Pole <b>Użytkownik bazy danych</b> jest niepoprawne.";

$db_password = $_POST['db_password'];
$db_password = new Formularz("$db_password", "false");

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    header('Location: index.php');
    exit();
}

///polaczenie z baza danych i utworzenie tabel
$db_host = $db_host->get_safe_value();
$db_username = $db_username->get_safe_value();
$db_password = $db_password->get_safe_value();
$db_name = $db_name->get_safe_value();
$nazwisko = $nazwisko->get_safe_value();
$imie = $imie->get_safe_value();
$email = $email->get_safe_value();


$pol = new mysqli("$db_host", "$db_username", "$db_password", "$db_name");

if ($pol->connect_errno != 0) {
    $_SESSION['error'] = "Błąd połączenia z bazą danych!";
    ob_start();
    header('Location: index.php');
    ob_end_flush();
    
    exit();
}

///dodanie tabeli USERS do bazy danych uzytkownika
$sql = "CREATE TABLE `$db_name`.`users` (`id` INT NOT NULL AUTO_INCREMENT , `nazwisko` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL , `imie` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL , `email` VARCHAR(50) NOT NULL , `password` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`));";

if (!$pol->query($sql)) {
    $_SESSION['error'] = "Błąd połączenia z bazą danych! Brak uprawnień: <b>Create_priv</b>.";
    header('Location: index.php');
    $pol->close();
    exit();
};

///dodanie administratora do tabeli USERS
$sql2 = "INSERT INTO `users` (`id`, `nazwisko`, `imie`, `email`, `password`) VALUES (NULL, '$nazwisko','$imie','$email','$haslo2');";
if ($pol->query($sql2)) echo "Wszystko ok";
else {

    header('Location: index.php');
    $_SESSION['error'] = "Błąd połączenia z bazą danych! Brak uprawnień: <b>Insert_priv</b>.";
    $pol->close();
    exit();
};

$pol->close();

///zapis credentials do bazy
$to_store = '<?php
define("DB_HOST","' . $db_host . '");
define("DB_USER","' . $db_username . '");
define("DB_PASSWORD","' . $db_password . '");
define("DB_NAME","' . $db_name . '");
?>';

$url = dirname(__FILE__, 2) . '/config.php';
$plik = file_put_contents("$url", "$to_store");
if($plik === false)
{
    header('Location: index.php');
    $_SESSION['error'] = "<b>Błąd: </b>Brak uprawnień do zapisu plików";
    ob_end_flush();
}

///koniec sesji
session_unset();
session_destroy();
?>
