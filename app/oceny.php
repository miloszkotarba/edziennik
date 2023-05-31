<?php

require_once 'models/categories.php';
require 'models/zajecia.php';
require 'models/oceny.php';
require_once 'alerts.php';
require_once 'Validate.php';

class Oceny extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Category();
        $this->ZajeciaModel = new Zajecie();
        $this->OcenaModel = new Ocena();
    }

    public function index()
    {
        $this->is_logged();

        //teacher
        if ($_SESSION['usersRole'] == 1) {
            header('Location: /oceny/nauczyciel');
        } else {
            header('Location: /oceny/uczen');
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
                $row = $this->Model->showCategoriesWithoutBasic($id_user);
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

    public function modyfikuj_kategorie()
    {
        $this->is_teacher();

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'categoryName' => trim($_POST['categoryName']),
            'categoryWeight' => trim($_POST['categoryWeight']),
            'categoryAverage' => trim($_POST['categoryAverage']),
            'categoryTheme' => trim($_POST['categoryTheme']),
            'categoryId' => trim($_POST['categoryId'])
        ];

        //Validate inputs
        if (empty($data['categoryId'])) {
            alerts::SetError("Błąd: Nie zmieniono kategorii.", 0);
            redirect('/oceny/kategorie/lista');
        }

        $id_usera = $_SESSION['usersId'];
        if ($this->Model->checkCategoryOwner($id_usera, $data['categoryId']) == false) {
            alerts::SetError("Błąd: Nie zmieniono kategorii.", 0);
            redirect('/oceny/kategorie/lista');
        }

        if (empty($data['categoryName']) || empty($data['categoryAverage']) || empty($data['categoryTheme'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect('/oceny/kategorie/lista');
        }

        if (strlen($data['categoryName']) > 50) {
            alerts::SetError("Nazwa kategorii przekracza limit 50 znaków.", 0);
            redirect('/oceny/kategorie/lista');
        }

        if ($data['categoryAverage'] === "yes") {
            $data['categoryAverage'] = 1;
        } else if ($data['categoryAverage'] === "no") {
            $data['categoryAverage'] = 0;
            $data['categoryWeight'] = 0;
        } else {
            alerts::SetError("Błąd. Spróbuj ponownie.", 0);
            redirect('/oceny/kategorie/lista');
        }

        if (!ctype_digit(strval($data['categoryWeight']))) {
            alerts::SetError("Waga musi być liczbą.", 0);
            redirect('/oceny/kategorie/lista');
        }

        if ($data['categoryWeight'] > 10 || $data['categoryWeight'] < 0) {
            alerts::SetError("Waga musi być liczbą z przedziału < 0, 10 >.", 0);
            redirect('/oceny/kategorie/lista');
        }

        $categoryallowed = array("F0E68C", "87CEFA", "B0C4DE", "F0F8FF", "F0FFFF", "F5F5DC", "FFEBCD", "FFF8DC", "A9A9A9", "BDB76B", "7FBC8F", "DCDCDC", "DAA520", "E6E6FA", "FFA07A", "32CD32", "66CDAA", "C0C0C0", "D2B48C", "3333FF", "7B68EE", "BA55D3", "FFB6C1", "FF1493", "DC143C", "FF0000", "FF8C00", "FFD700", "ADFF2F", "7CFC00");

        if (!in_array($data['categoryTheme'], $categoryallowed)) {
            alerts::SetError("Podano niepoprawny kolor.", 0);
            redirect('/oceny/kategorie/lista');
        }

        $final = $this->Model->modifyCategory($data['categoryName'], $data['categoryWeight'], $data['categoryTheme'], $data['categoryAverage'], $data['categoryId']);
        if ($final) {
            alerts::SetSuccess("Zmieniono kategorię.");
            header('Location: /oceny/kategorie/lista');
        } else {
            alerts::SetError("Błąd: Nie zmieniono kategorii.", 0);
            redirect('/oceny/kategorie/lista');
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
                alerts::SetError("Nie usunięto kategorii z przypisanymi ocenami.");
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

    public function lista()
    {
        $this->is_teacher();
        $teacherId = $_SESSION['usersId'];
        $result = $this->ZajeciaModel->showTeachersLessons($teacherId);
        require 'views/oceny/teacher.grade.list.php';
    }

    public function pokaz($link = NULL)
    {
        $this->is_teacher();
        if ($link == NULL) {
            redirect('/oceny/lista');
            exit();
        }
        $link = htmlspecialchars($link);
        $row = $this->ZajeciaModel->checkIfZajeciaExists($link);
        if (!$row) {
            redirect('/oceny/lista');
        }
        $final = $this->OcenaModel->showStudentsFromLesson($link);
        require 'views/oceny/teacher.grade.list.show.php';
    }

    public function dodaj($zajeciaId = NULL, $studentId = NULL)
    {
        $this->is_teacher();
        $nazwa = $this->OcenaModel->getStudentbyId($studentId);
        $imie = $nazwa[0]->usersName;
        $nazwisko = $nazwa[0]->usersSurname;
        $przedmiot = $this->OcenaModel->getSubjectbyZajeciaId($zajeciaId);
        $przedmiot = $przedmiot[0]->subjectName;
        $kategorie = $this->OcenaModel->showCategoriesbyZajeciaId($zajeciaId);
        $systemKategorie = $this->OcenaModel->showSystemCategories($zajeciaId);
        require 'views/oceny/teacher.grade.add.php';
    }

    public function add()
    {
        $this->is_teacher();

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'kategoria' => trim($_POST['kategoria']),
            'ocena' => trim($_POST['ocena']),
            'komentarz' => trim($_POST['komentarz']),
            'zajeciaId' => trim($_POST['zajeciaId']),
            'studentId' => trim($_POST['studentId']),
            'date' => trim($_POST['date']),
        ];


        $data['date'] = $data['date'] . date(' H:i:s');

        $kategoriaName = $this->OcenaModel->showNamebyCategoryId($data['kategoria'])->name;
        $kategorieSystemowe = array("przewidywana śródroczna", "śródroczna", "przewidywana roczna", "roczna");
        if (in_array($kategoriaName, $kategorieSystemowe)) {
            $final = $this->OcenaModel->checkSystemGrade($data['kategoria'], $data['zajeciaId'], $data['studentId']);
            if (!$final) {
                $final = $this->OcenaModel->insertGrade($data['zajeciaId'], $data['studentId'], $data['kategoria'], $data['ocena'], $data['komentarz'], $data['date']);
                if ($final) {
                    alerts::SetSuccess("Dodano ocenę.");
                } else {
                    alerts::SetError("Błąd. Nie dodano oceny.");
                }
            } else {
                alerts::SetError("Błąd: Nie dodano oceny");
            }
        } else {
            $final = $this->OcenaModel->insertGrade($data['zajeciaId'], $data['studentId'], $data['kategoria'], $data['ocena'], $data['komentarz'], $data['date']);
            if ($final) {
                alerts::SetSuccess("Dodano ocenę.");
            } else {
                alerts::SetError("Błąd. Nie dodano oceny.");
            }
        }

        echo '<script>
    opener.location.reload();
    javascript:window.close();</script>';
    }

    public function is_student()
    {
        $this->is_logged();
        if ($_SESSION['usersRole'] != 0) {
            header('Location: /oceny');
            exit();
        }
    }

    public function uczen()
    {
        $this->is_student();
        $studentId = $_SESSION['usersId'];
        $final = $this->OcenaModel->showLessonsforStudent($studentId);
        require 'views/oceny/student.grade.list.php';
    }

    public function szczegoly($gradeId = NULL, $studentId = NULL)
    {
        $this->is_teacher();
        if (empty($gradeId) || empty($studentId)) {
            header('Location: /oceny');
            exit();
        }
        $this->is_teacher();
        $nazwa = $this->OcenaModel->getStudentbyId($studentId);
        $imie = $nazwa[0]->usersName;
        $nazwisko = $nazwa[0]->usersSurname;
        $przedmiot = $this->OcenaModel->getSubjectbyGradeId($gradeId);
        $przedmiot = $przedmiot->subjectName;
        $zajeciaId = $this->OcenaModel->getZajeciabyGradeId($gradeId);
        $zajeciaId = $zajeciaId->zajeciaId;
        $kategorie = $this->OcenaModel->showCategoriesbyZajeciaId($zajeciaId);
        $systemKategorie = $this->OcenaModel->showSystemCategories($zajeciaId);
        $result = $this->OcenaModel->getGradeValueCommentCategory($gradeId);
        $value = $result->value;
        $category = $result->categoryName;
        $komentarz = $result->comment;
        $data = $result->date;
        $data = explode(" ", $data);
        $data = $data[0];
        require 'views/oceny/teacher.grade.edit.php';
    }


    public function usun($gradeId = NULL)
    {
        $this->is_teacher();
        if (empty($gradeId)) {
            header('Location: /oceny');
            exit();
        }
        $final = $this->OcenaModel->deleteGrade($gradeId);
        if ($final) {
            alerts::SetSuccess("Usunięto ocenę.");
        }
        echo '<script>
    opener.location.reload();
    javascript:window.close();</script>';
    }

    public function seryjnie($link = NULL)
    {
        $this->is_teacher();
        if ($link == NULL) {
            redirect('/oceny/lista');
            exit();
        }
        $row = $this->ZajeciaModel->checkIfZajeciaExists($link);
        if (!$row) {
            redirect('/oceny/lista');
        }
        $final = $this->OcenaModel->showStudentsFromLesson($link);
        $semestr = $this->ZajeciaModel->getSchoolYear();
        $semestr1od = $semestr->semestr1od;
        $semestr1do = $semestr->semestr1do;
        $semestr2od = $semestr->semestr2od;
        $semestr2do = $semestr->semestr2do;
        $kategorie = $this->OcenaModel->showCategoriesbyZajeciaId($link);
        $systemKategorie = $this->OcenaModel->showSystemCategories($link);
        $data = Date('Y-m-d');
        if ($data >= $semestr1od && $data <= $semestr1do) {
            $semestr = 1;
        } else if ($data >= $semestr2od && $data <= $semestr2do) {
            $semestr = 2;
        } else {
            redirect('/oceny/lista');
        }
        require 'views/oceny/teacher.grade.add.multiple.php';
    }

    public function valid()
    {
        $this->is_teacher();

        $ocena = $_POST['ocenaValue'];
        $komentarz = $_POST['ocenaComment'];
        $user = $_POST['user'];
        $kategoria = $_POST['kategoria'];
        $data = $_POST['date'] . " " . date("H:i:s");
        $zajeciaId = $_POST['zajecia'];


        foreach ($ocena as $index => $oceny) {
            if ($oceny !== "") {
                $this->OcenaModel->insertGrade($zajeciaId, $user[$index], $kategoria, $oceny, $komentarz[$index], $data);
            }
        }

        $link = '/oceny/pokaz/' . $zajeciaId;
        alerts::SetSuccess("Pomyślnie dodano oceny.");
        header("Location: $link");
    }

    public function edit()
    {
        $this->is_teacher();

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'kategoria' => trim($_POST['kategoria']),
            'ocena' => trim($_POST['ocena']),
            'komentarz' => trim($_POST['komentarz']),
            'ocenaId' => trim($_POST['ocenaId']),
            'date' => trim($_POST['date']),
            'zajeciaId' => trim($_POST['zajeciaId']),
            'studentId' => trim($_POST['studentId']),
            'previousCategory' => trim($_POST['previousCategory'])
        ];

        $data['date'] = $data['date'] . date(' H:i:s');
        $data['komentarz'] = htmlspecialchars($data['komentarz']);

        $kategoriaName = $this->OcenaModel->showNamebyCategoryId($data['kategoria'])->name;
        $kategorieSystemowe = array("przewidywana śródroczna", "śródroczna", "przewidywana roczna", "roczna");

        if (!in_array($kategoriaName, $kategorieSystemowe)) {
            $final = $this->OcenaModel->updateGrade($data['ocenaId'], $data['ocena'], $data['date'], $data['komentarz'], $data['kategoria']);
            if ($final) {
                alerts::SetSuccess("Zmieniono ocenę.");
            } else {
                alerts::SetError("Błąd. Nie zmieniono oceny.");
            }
        } else {
            $final = $this->OcenaModel->checkSystemGrade($data['kategoria'], $data['zajeciaId'], $data['studentId']);
            if (!$final || $kategoriaName == $data['previousCategory']) {
                $result = $this->OcenaModel->updateGrade($data['ocenaId'], $data['ocena'], $data['date'], $data['komentarz'], $data['kategoria']);
                if ($result) {
                    alerts::SetSuccess("Zmieniono ocenę.");
                } else {
                    alerts::SetError("Błąd. Nie zmieniono oceny.");
                }
            } else {
                alerts::SetError("Nie można dodać oceny z tej kategorii.");
            }
        }

        echo '<script>
    opener.location.reload();
    javascript:window.close();</script>';
    }
}