<?php
if(!isset($_SESSION)) session_start();

class Page
{
    public static function displayHeader($title, $css = NULL)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title><?= $title ?></title>
            <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"/>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <?php if (is_null($css)) {
                echo '<link rel="stylesheet" href="/css/dashboard.css"/>';
            } else echo '<link rel="stylesheet" href="/css/' . $css . '"/>';
            ?>

        </head>
        </html>

        </body>
        <?php
    }

    public static function displayNavigation()
    {
        ?><header>
            <div class="left">
                <h2>Edziennik</h2>
            </div>
            <div class="right">
                <span>Witaj, <?php if(isset($_SESSION['usersId']))  echo $_SESSION['usersName']." ".$_SESSION['usersSurname'];?></span>
                <div class="avatar">
                    <i class="las la-user-circle"></i>
                </div>
                <div class="logout">
                    <a href="/login/logout">Wyloguj</a>
                </div>
            </div>
        </header>

        <div class="container">
        <nav>
            <ul>
                <li>
                    <a href="#">
                        <i class="las la-home"></i>
                        <span>Strona główna</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="las la-graduation-cap"></i>
                        <span>Oceny</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="las la-tasks"></i>
                        <span class="nav-item">Tematy zajęć</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="las la-scroll"></i>
                        <span class="nav-item">Ogłoszenia</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="las la-envelope"></i>
                        <span class="nav-item">Wiadomości</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="las la-print"></i>
                        <span class="nav-item">Wydruki</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="las la-user-cog"></i>
                        <span class="nav-item">Ustawienia konta</span>
                    </a>
                </li>
            </ul>
        </nav>
        <?php
    }

    public static function displayFooter()
    {
        ?>
        </div>

        </body>
        </html>

        <?php
    }
}