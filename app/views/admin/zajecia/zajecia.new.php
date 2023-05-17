<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Przypisywanie zajęć", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Przypisywanie zajęć</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <?php if ($result != 0) {
                echo <<< END
                <form action="/zajecia/new" method="post" style="max-width: 40%">
                <p>Klasa</p>
                <input type="text" placeholder="$className" disabled>
                <input type="hidden" value="$link" name="oddzialId">
                <p>Przedmiot</p>
                <select name="przedmiotId">
                END;
                foreach ($subjects as $subject) {
                    echo <<< END
                            <option value="$subject->subjectId">
                            &nbsp;$subject->subjectName&nbsp;
                            </option>
                            END;
                }
                echo <<< END
                </select>
                <p>Nauczyciel</p>
                <select name="nauczycielId">
                END;
                foreach ($teachers as $teacher) {
                    echo <<< END
                            <option value="$teacher->usersId">
                            &nbsp;$teacher->usersSurname $teacher->usersName&nbsp;
                            </option>
                            END;
                }
                echo <<< END
                </select>
                <input type="submit" value="Dodaj">
            </form>
            END;
            }
            ?>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
