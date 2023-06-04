<?php

require_once 'models/kartaocen.php';
require_once 'models/oceny2.php';
require_once 'alerts.php';

class KartaOcen extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->KartaModel = new KartyOcen();
        $this->Model = new Grade();
    }

    public function index()
    {
        $this->is_teacher();
        $final = $this->KartaModel->checkWychowawstwo($_SESSION['usersId']);
        require 'views/kartaocen/kartaocen.list.php';
    }

    public function drukuj($klasaId = NULL)
    {
        $this->is_teacher();

        if ($klasaId == NULL) {
            redirect('/dashboard');
        }

///PDF
        require 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();

        $students = $this->KartaModel->showUserFromClass($klasaId);
        if (!$students) {
            require 'views/kartaocen/kartaocen.error.php';
            exit();
        }

        $data = "";
        $licznik = 0;

        $date = date('Y-m-d H:i');

        foreach ($students as $student) {

            $studentId = $student->usersId;

            $data .= '<span style="font-size: 0.9rem">Data wydruku: '.$date.'</span>';
            $data .= '<h2 style="margin-bottom: 0.5rem; font-size: 1.7rem; text-align: center; margin-bottom: 1rem">Karta Ocen</h2>';
            $data .= '<span style="font-size: 1.1rem">Uczeń: <b>' . $student->usersSurname . ' ' . $student->usersName . '</b></span><br/>';
            $data .= '<span style="font-size: 1.1rem">Klasa: <b>' . $student->klasa . '</b></span>';

            $final = $this->KartaModel->showLessonsforStudent($studentId);
            if ($final) {
                $data .= ' <div class="oceny" style="width: 100%; margin-top: 1rem"><table style="border: 1px solid black; font-family: sans-serif;">
                        <tbody>
                        <tr>
                            <th rowspan="2" style="background: white"><b>Przedmiot</b></th>
                            <th colspan="4" style="background: white"><b>Okres 1</b></th>
                            <th colspan="2" style="background: white"><b>Okres 2</b></th>
                            <th colspan="3" style="background: white"><b>Koniec roku</b></th>
                        </tr>
                        <tr class="first">
                            <td style="text-align: center" style="background: white">Oceny bieżące</td>
                            <td class="Sr1" style="background: white; text-align: center">
                                <a title="Średnia ocen z pierwszego okresu">Śr.I</a>
                            </td>
                            <td style="background: white">
                                <a
                                        title="Przewidywana ocena śródroczna z pierwszego okresu"
                                >(I)</a
                                >
                            </td>
                            <td style="background: white">
                                <a title="Ocena śródroczna z pierwszego okresu">I</a>
                            </td>
                            <td style="background: white">Oceny bieżące</td>
                            <td style="background: white">
                                <a title="Średnia ocen z drugiego okresu">Śr.II</a>
                            </td>
                            <td style="background: white"><a title="Średnia roczna">Śr.R</a></td>
                            <td style="background: white"><a title="Przewidywana ocena roczna">(R)</a></td>
                            <td style="background: white"><a title="Ocena roczna">R</a></td>
                        </tr>';
            }
            if (!$final) {
                require 'views/kartaocen/kartaocen.error.php';
                exit();
            }
            foreach ($final as $item) {
                $result = $this->Model->showGradesForEachSubject($studentId, $item->zajeciaId);
                $przewidywana_srodroczna = $this->Model->showPrzewidywanaSrodroczna($studentId, $item->zajeciaId);
                $srodroczna = $this->Model->showSrodroczna($studentId, $item->zajeciaId);
                if ($srodroczna) $srodroczna = $srodroczna->value;
                $data .= '
                <tr>
                    <td style="text-align: center; background: #fff">' . $item->subjectName . '</td>';
                $data .= '<td style="padding: 0.5rem; 1rem; background: #fff">';
                if ($result) {
                    foreach ($result as $ocena) {
                        $data .= $ocena->value . ' ';
                    }
                }
                if (!$result) $data .= "Brak ocen";
                $data .= ' <span style="color: #fff">-</span></td>
                    <td style="text-align: center; background: #fff">';
                $sredniasem1 = $this->KartaModel->SredniaSem1($item->zajeciaId, $studentId);
                if ($sredniasem1->srednia != NULL) $data .= $sredniasem1->srednia;
                else {
                    $data .= "-";
                };
                $data .= '</td>
                    <td style="text-align: center; background: #fff">';
                if ($przewidywana_srodroczna) $data .= $przewidywana_srodroczna->value;
                else $data .= "-";
                $data .= '</td>
                    <td style="text-align: center; background: #fff">';
                if ($srodroczna) $data .= $srodroczna;
                else $data .= "-";
                $data .= '</td>
                    <!--SEM 2-->
                    <td style="padding: 0.5rem; 1rem; background: #fff">';
                $result = $this->Model->showGradesForEachSubjectSem2($studentId, $item->zajeciaId);
                $przewidywana_roczna = $this->Model->showPrzewidywanaRoczna($studentId, $item->zajeciaId);
                if ($przewidywana_roczna)
                    $przewidywana_roczna = $przewidywana_roczna->value;
                $roczna = $this->Model->showRoczna($studentId, $item->zajeciaId);
                if ($roczna)
                    $roczna = $roczna->value;
                if ($result) {
                    foreach ($result as $ocena2) {
                        $data .= $ocena2->value . ' ';
                    }
                }
                if (!$result) $data .= "Brak ocen";
                $data .= '</td>
                    <td style="text-align: center; background: #fff">';
                $sredniasem2 = $this->KartaModel->SredniaSem2($item->zajeciaId, $studentId);
                if ($sredniasem2->srednia != NULL) $data .= $sredniasem2->srednia;
                else {
                    $data .= "-";
                };
                $data .= '</td>
                    <td style="text-align: center; background: #fff" >';
                if ($sredniasem1->srednia == NULL) {
                    if ($sredniasem2->srednia != NULL) {
                        $data .= $sredniasem2->srednia;
                    } else {
                        $data .= '-';
                    }
                }
                if ($sredniasem1->srednia != NULL) {
                    if ($sredniasem2->srednia == NULL) {
                        $data .= $sredniasem1->srednia;
                    } else {
                        $avg = ($sredniasem1->srednia + $sredniasem2->srednia)/2;
                        $avg = number_format((float)$avg, 2, '.', '');
                        $data .= $avg;
                    }
                }
                $data .= '</td>
                    <td style="text-align: center; background: #fff">';
                if ($przewidywana_roczna) $data .= $przewidywana_roczna;
                else $data .= "-";
                $data .= '</td>
                    <td style="text-align: center; background: #fff">';
                if ($roczna) $data .= $roczna;
                else $data .= '-';
                $data .= '</td>
                </tr>
            ';
            }

            $data .= '</tbody></table>';

            $data .= '
      <ul style="list-style-type: none; margin-top: 2rem">
      <li style="margin-bottom: 0.1rem"><b>Śr.I</b> - Średnia ocen bieżących z pierwszego okresu</li>
      <li style="margin-bottom: 0.1rem"><b>I</b> - Ocena śródroczna z pierwszego okresu</li>
      <li style="margin-bottom: 0.1rem"><b>(I)</b> - Przewidywana ocena śródroczna z pierwszego okresu</li>
      <li style="margin-bottom: 0.1rem"><b>II</b> - Ocena śródroczna z drugiego okresu</li>
      <li style="margin-bottom: 0.1rem" ><b>Śr.R</b> - Średnia roczna</li>
      <li style="margin-bottom: 0.1rem"><b>(R)</b> - Przewidywana ocena roczna</li>
      <li style="margin-bottom: 0.1rem"><b>R</b> - Ocena roczna</li>
    </ul>';

            $data .= '</div>';
            if ($licznik != count($students) - 1) {
                $data .= "<pagebreak/>";
            }
            $licznik++;
        }

        $css = file_get_contents('css/teacher.css');
        $mpdf->SetTitle('Karta ocen');
        $mpdf->setFooter('E-dziennik Kotika');
        $mpdf->writeHTML($css, 1);
        $mpdf->writeHTML("$data");
        $mpdf->Output();
    }

    public function is_logged()
    {
        if (!isset($_SESSION['usersId'])) {
            header('Location: /dashboard');
            exit();
        }
    }

    public function is_teacher()
    {
        $this->is_logged();
        if ($_SESSION['usersRole'] != 1) {
            header('Location: /dashboard');
            exit();
        }
    }
}