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

$username = $_POST['username'];
$username = new Formularz("$username","yes",0,5);
if($username->validate_string()) $_SESSION['username'] = $username->get_safe_value();
else $_SESSION['error'] = "Pole <b>Login</b> jest niepoprawne";

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
$login = $username->get_safe_value();


$pol = new mysqli("$db_host", "$db_username", "$db_password", "$db_name");

if ($pol->connect_errno != 0) {
    $_SESSION['error'] = "Błąd połączenia z bazą danych!";
    ob_start();
    header('Location: index.php');
    ob_end_flush();
    
    exit();
}

///dodanie tabeli USERS do bazy danych uzytkownika
$sql = '
-- phpMyAdmin SQL Dump
-- version 4.6.6deb4+deb9u2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Czas generowania: 30 Mar 2023, 18:14
-- Wersja serwera: 10.3.36-MariaDB-0+deb10u2
-- Wersja PHP: 7.3.31-1~deb10u2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `dziennik`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
`usersId` int(11) NOT NULL,
  `usersName` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `usersSurname` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `usersEmail` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usersLogin` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usersPassword` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usersRole` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `users`
--
               ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- AUTO_INCREMENT for dumped tables
--

                      --
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
';
if (!$pol->multi_query($sql)) {
    $_SESSION['error'] = "Błąd połączenia z bazą danych! Brak uprawnień: <b>Create_priv</b>.";
    header('Location: index.php');
    $pol->close();
    exit();
};

$pol->close();

///dodanie administratora do tabeli USERS
$pol2 = new mysqli("$db_host", "$db_username", "$db_password", "$db_name");
$sql2 = "INSERT INTO `users` (`usersId`, `usersName`, `usersSurname`, `usersEmail`, `usersLogin`, `usersPassword`, `usersRole`) VALUES (NULL, '$imie', '$nazwisko', '$email', '$login', '$haslo2', '2');";
if ($pol2->query($sql2) == false) {
    header('Location: index.php');
    $_SESSION['error'] = "Błąd połączenia z bazą danych! Brak uprawnień: <b>Insert_priv</b>.";
    $pol2->close();
    exit();
};
$pol2->close();

///zapis credentials do bazy
$to_store = '<?php
define("DB_HOST","' . $db_host . '");
define("DB_USER","' . $db_username . '");
define("DB_PASS","' . $db_password . '");
define("DB_NAME","' . $db_name . '");
require_once "app/app.php";
require_once "app/controller.php";
?>';

$url = '../config.php';
touch($url);
$plik = file_put_contents("$url", "$to_store");

///koniec sesji
session_unset();
session_destroy();
