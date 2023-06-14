<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Terminarz");
Page::displayNavigation();
?>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var calendarEl = document.getElementById('calendar')

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                validRange: {
                    start: '2022-09-01',
                    end: '2023-08-31'
                },
                locale: 'pl',
                firstDay: 1,
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
            });

            calendar.render()
        })
    </script>
    <style>
        #calendar {
            min-width: 100%;
            height: 700px;
            overflow: scroll;
        }

        /* SCROLL PRZY HEIGHT KALENDARZA */
        .fc-scroller.fc-scroller-liquid-absolute {
            overflow: hidden !important;
        }

        /* UKRYCIE PRZYCISKU TODAY */
        .fc-today-button.fc-button.fc-button-primary {
            display: none;
        }

        td.fc-day {

        }

        .fc-toolbar {
            text-transform: capitalize;
        }
    </style>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-calendar"></i>
                    <span>Terminarz</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box" style="padding: 50px 25px">
            <div id="calendar">
            </div>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
