<?php

require_once 'models/categories.php';
require_once 'alerts.php';
require_once 'Validate.php';

class Oceny extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Category();
    }

    public function index()
    {
        $this->is_logged();

        //teacher
        if ($_SESSION['usersRole'] == 1) {
            header('Location: /oceny/nauczyciel');
        } else {
            echo "UCZEN";
        }
    }

    public function is_logged()
    {
        if (!isset($_SESSION['usersId'])) {
            header('Location: /home');
            exit();
        }
    }

    /* NAUCZYCIEL */

    public function nauczyciel()
    {
        $this->is_teacher();
        require 'views/oceny/teacher.view.php';
    }

    public function kategorie($link = NULL, $link2 = NULL)
    {
        if ($link == NULL) {
            header('Location: /oceny');
            exit();
        }

        $this->is_teacher();

        switch ($link) {
            case "dodaj":
                require 'views/oceny/teacher.category.add.php';
                break;
            case "lista":
                $id_user = $_SESSION['usersId'];
                $row = $this->Model->showAllCategories($id_user);
                require 'views/oceny/teacher.category.list.php';
                break;
            case "edytuj":
                $id_user = $_SESSION['usersId'];
                if (!$this->Model->checkCategoryOwner($id_user, $link2)) {
                    redirect('/oceny/kategorie/lista');
                }
                $result = $this->Model->showCategory($link2);
                if (!$result) {
                    alerts::SetError("Nastąpił błąd.", 0);
                    redirect('/oceny/kategorie/lista');
                }
                require 'views/oceny/teacher.category.edit.php';
                break;
            default:
                header('Location: /blad');
                exit();
                break;
        }
    }

    public function dodaj_kategorie()
    {
        $this->is_teacher();

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'categoryName' => trim($_POST['categoryName']),
            'categoryWeight' => trim($_POST['categoryWeight']),
            'categoryAverage' => trim($_POST['categoryAverage']),
            'categoryTheme' => trim($_POST['categoryTheme'])
        ];

        //Validate inputs
        if (empty($data['categoryName']) || empty($data['categoryAverage']) || empty($data['categoryTheme'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect('/oceny/kategorie/dodaj');
        }

        if (strlen($data['categoryName']) > 50) {
            alerts::SetError("Nazwa kategorii przekracza limit 50 znaków.", 0);
            redirect('/oceny/kategorie/dodaj');
        }

        if ($data['categoryAverage'] === "yes") {
            $data['categoryAverage'] = 1;
        } else if ($data['categoryAverage'] === "no") {
            $data['categoryAverage'] = 0;
            $data['categoryWeight'] = 0;
        } else {
            alerts::SetError("Błąd. Spróbuj ponownie.", 0);
            redirect('/oceny/kategorie/dodaj');
        }

        if (!ctype_digit(strval($data['categoryWeight']))) {
            alerts::SetError("Waga musi być liczbą.", 0);
            redirect('/oceny/kategorie/dodaj');
        }

        if ($data['categoryWeight'] > 10 || $data['categoryWeight'] < 0) {
            alerts::SetError("Waga musi być liczbą z przedziału < 0, 10 >.", 0);
            redirect('/oceny/kategorie/dodaj');
        }

        $categoryallowed = array("F0E68C", "87CEFA", "B0C4DE", "F0F8FF", "F0FFFF", "F5F5DC", "FFEBCD", "FFF8DC", "A9A9A9", "BDB76B", "7FBC8F", "DCDCDC", "DAA520", "E6E6FA", "FFA07A", "32CD32", "66CDAA", "C0C0C0", "D2B48C", "3333FF", "7B68EE", "BA55D3", "FFB6C1", "FF1493", "DC143C", "FF0000", "FF8C00", "FFD700", "ADFF2F", "7CFC00");

        if (!in_array($data['categoryTheme'], $categoryallowed)) {
            alerts::SetError("Podano niepoprawny kolor.", 0);
            redirect('/oceny/kategorie/dodaj');
        }

        if ($this->Model->findCategoryByName($_SESSION['usersId'], $data['categoryName'])) {
            //Category is not unique
            alerts::SetError("Taka kategoria już istnieje.", 0);
            redirect('/oceny/kategorie/dodaj');
        } else {
            $id_usera = $_SESSION['usersId'];
            $final = $this->Model->insertCategory($data["categoryName"], $data['categoryWeight'], $data['categoryTheme'], $data['categoryAverage'], $id_usera);
            if ($final) {
                alerts::SetSuccess("Dodano kategorię.");
                header('Location: /oceny');
            } else {
                alerts::SetError("Nastąpił błąd. Nie dodano kategorii.", 0);
                redirect('/oceny/kategorie/dodaj');
            }
        }
    }

    public function usun_kategorie($link = NULL)
    {
        $this->is_teacher();
        if ($link == NULL) redirect('/oceny/kategorie/lista');
        $id_user = $_SESSION['usersId'];
        if (!$this->Model->checkCategoryOwner($id_user, $link)) {
            alerts::SetError("Nastąpił błąd. Nie usunięto kategorii.");
            redirect('/oceny/kategorie/lista');
        } else {
            $final = $this->Model->deleteCategory($link);
            if ($final) {
                alerts::SetSuccess("Usunięto kategorię.");
                header('Location: /oceny/kategorie/lista');
            } else {
                alerts::SetError("Nastąpił błąd. Nie usunięto kategorii.");
                redirect('/oceny/kategorie/lista');
            }
        }
    }

    public function is_teacher()
    {
        $this->is_logged();
        if ($_SESSION['usersRole'] != 1) {
            header('Location: /oceny');
            exit();
        }
    }
}