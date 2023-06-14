<?php
if (!isset($_SESSION)) session_start();

class Page
{

    public static function displayHeader($title, $css = NULL)
    {
        ?>
        <!DOCTYPE html>
        <html lang="pl-PL">
        <head>
            <meta charset="UTF-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title><?= $title ?></title>
            <link rel="icon" type="image/svg+xml"
                  href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22256%22 height=%22256%22 viewBox=%220 0 100 100%22><text x=%2250%%22 y=%2250%%22 dominant-baseline=%22central%22 text-anchor=%22middle%22 font-size=%22104%22>🎓</text></svg>"/>
            <link rel="stylesheet"
                  href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"/>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <?php if (is_null($css)) {
                echo '<link rel="stylesheet" href="/css/dashboard.css"/>';
            } else {
                echo '<link rel="stylesheet" href="/css/' . $css . '"/>';
                echo '
            <link rel="stylesheet" href="/css/dashboard.css"/>';
            };
            ?>

        </head>
        </html>

        </body>
        <?php
    }

    public static function displayNavigation()
    {
        ?>
        <header>
        <div class="left">
            <h2><a href="/dashboard" style="text-decoration: none; color: black;">Edziennik</a></h2>
        </div>
        <div class="right">
            <span>Witaj, <?php if (isset($_SESSION['usersId'])) echo $_SESSION['usersName'] . " " . $_SESSION['usersSurname']; ?></span>
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
                    <a href="/dashboard">
                        <i class="las la-home"></i>
                        <span>Strona główna</span>
                    </a>
                </li>
                <?php if($_SESSION['usersRole'] != 2)
                    echo <<< END
                <li>
                    <a href="/oceny">
                        <i class="las la-graduation-cap"></i>
                        <span class="nav-item">Oceny</span>
                    </a>
                </li>
                END; ?>
                <li>
                    <a href="/ogloszenia">
                        <i class="las la-scroll"></i>
                        <span class="nav-item">Ogłoszenia</span>
                    </a>
                </li>
                <li>
                    <a href="/terminarz">
                        <i class="las la-calendar"></i>
                        <span class="nav-item">Terminarz</span>
                    </a>
                </li>
                <?php if($_SESSION['usersRole'] == 1)
                    echo <<< END
                <li>
                    <a href="/kartaocen">
                        <i class="las la-print"></i>
                        <span class="nav-item">Karta ocen</span>
                    </a>
                </li>
                END; ?>
                <li>
                    <a href="/profile">
                        <i class="las la-user-cog"></i>
                        <span class="nav-item">Ustawienia konta</span>
                    </a>
                </li>
                <?php if($_SESSION['usersRole'] == 2)
                    echo <<< END
                <li>
                    <a href="/admin">
                        <i class="las la-tools"></i>
                        <span class="nav-item">Administracja</span>
                    </a>
                </li>
                END; ?>
            </ul>
        </nav>
        <?php
    }

    public static function displayFooter()
    {
        ?>
        </div>
        <script>
        window.addEventListener('scroll', () => {
        let bodyScroll = window.scrollY;

        if (bodyScroll > 100) {
        document.querySelector('nav').style.height = '100vh';
        }
        else {
            document.querySelector('nav').style.height = 'calc(100vh - 100px)';
        }
        });
        </script>
        </body>
        </html>

        <?php
    }
}