<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Terminarz");
Page::displayNavigation();
?>
    <style>
        ul.weeks,
        ul.days {
            list-style: none;
        }

        .wrapper {
            min-width: 800px;
            width: 100%;
            background: #fff;
            border-radius: 10px;
        }

        .wrapper header {
            display: flex;
            align-items: center;
            padding: 20px 10px;
            justify-content: space-between;
            border-bottom: none;
        }

        header .current-date {
            font-size: 1.45rem;
            font-weight: 500;
        }

        header .icons i {
            font-size: 30px;
            color: #777;
            margin: 0 1px;
            cursor: pointer;
            border-radius: 50%;
            padding: 5px;
            transition: background 0.2s ease-in-out;
        }

        header .icons i:hover {
            background: #f2f2f2;
        }

        .calendar {
            padding: 20px;
            min-height: 600px;
        }

        .calendar ul {
            display: flex;
            flex-wrap: wrap;
            text-align: center;
        }

        .calendar ul li {
            border: 0.55px solid rgb(164, 164, 164);
            width: calc(100% / 7);
        }

        .calendar .weeks li {
            font-weight: 400;
            padding: 5px 0;
            background: #a4c803;
            font-size: 1.1rem;
        }

        .calendar .days li {
            min-height: 90px;
            cursor: pointer;
            z-index: 1;
            padding: 6px 10px;
            background: #f9f9f9;
            font-size: 1.1rem;
            font-weight: 400;
            color: #222;
        }

        .days li .day-items {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .days li .day-items a {
            background: rgb(234, 234, 234);
            padding: 1px 7.5px;
            display: block;
            line-height: 28px;
            border-radius: 5px;
            box-shadow: 0 0 6px -1.5px rgb(91, 91, 91);
            font-size: 1rem;
            color: black;
        }

        .calendar .days li.inactive {
            color: #aaa;
            text-align: right;
        }

        .calendar .days li.active {
            color: #1f8d3b;
            font-weight: 500;
            font-size: 1.15rem;
        }

        .scroll-box {
            overflow-x: scroll;
        }

        .scroll-box .wrapper {
            width: 100%;
        }

        .links-box {
            width: 100%;
        }

        /* EVENT */
        .event-box {
            margin-top: 1rem;
        }

        .event {
            margin: 7px 0;
            color: #fff;
            border-radius: 3px;
            padding: 10px;
            font-size: 0.9rem;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
            font-weight: 400;
            line-height: 128%;
        }


        .event span {
            display: inline-block;
            text-align: left;
            width: 100%;
        }

    </style>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const currentDate = document.querySelector(".current-date"),
                daysTag = document.querySelector(".days"),
                prevNextIcon = document.querySelectorAll(".icons i")

            let date = new Date(),
                currentYear = date.getFullYear(),
                currentMonth = date.getMonth()

            const months = [
                "Styczeń",
                "Luty",
                "Marzec",
                "Kwiecień",
                "Maj",
                "Czerwiec",
                "Lipiec",
                "Sierpień",
                "Wrzesień",
                "Październik",
                "Listopad",
                "Grudzień",
            ]

            function renderCalendar() {
                let firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay()
                firstDayOfMonth = firstDayOfMonth == "0" ? 6 : firstDayOfMonth - 1

                let lastDateofMonth = new Date(currentYear, currentMonth + 1, 0).getDate()

                let lastDayofMonth = new Date(
                    currentYear,
                    currentMonth,
                    lastDateofMonth
                ).getDay()
                lastDayofMonth = lastDayofMonth == "0" ? 6 : lastDayofMonth - 1

                let lastDateofLastMonth = new Date(currentYear, currentMonth, 0).getDate(),
                    liTag = ""

                var events = <?= $result ?>;

                for (let i = firstDayOfMonth; i > 0; i--) {
                    liTag += `<li class="inactive"><span>${
                        lastDateofLastMonth - i + 1
                    }</span></li>`
                }

                for (let i = 1; i <= lastDateofMonth; i++) {
                    let miesiac = currentMonth + 1;
                    if (miesiac < 10) miesiac = '0' + miesiac
                    let dzien = i;
                    if (i < 10) dzien = '0' + i

                    let isToday =
                        i === date.getDate() &&
                        currentMonth === new Date().getMonth() &&
                        currentYear === new Date().getFullYear()
                            ? "active"
                            : ""

                    let HTML = '<div class="event-box">';

                    if (events) {


                        var arrayIndexes = events.reduce((a, curr, index) => {
                            if (curr.data == `${dzien}-${miesiac}-${currentYear}`)
                                a.push(index);
                            return a;
                        }, []);


                        if (arrayIndexes.length) {
                            arrayIndexes.forEach(index => {

                                if (events[index].zajecia == null) events[index].zajecia = ''
                                else events[index].zajecia += ', '

                                HTML += `<div class="event" style="background: ${events[index].color}"><span>Przedział czasu: ${events[index].czasOd} - ${events[index].czasDo}</span><span>${events[index].zajecia}${events[index].kategoria}</span><span>Nauczyciel: ${events[index].nazwisko} ${events[index].imie}</span><span>${events[index].klasa} LO</span></div>`;
                            })
                        }
                    }

                    HTML += "</div>";

                    liTag +=
                        isToday === "active"
                            ? `<li class="active" id="${dzien}-${miesiac}-${currentYear}"><div class="day-items"><a href="/terminarz/dodaj/<?=$oddzialId?>/${currentYear}-${miesiac}-${dzien}"><i class='bx bx-plus'></i></a><span>${i}</span></div>${HTML}</li>`
                            : `<li id="${dzien}-${miesiac}-${currentYear}"><div class="day-items"><a href="/terminarz/dodaj/<?=$oddzialId?>/${currentYear}-${miesiac}-${dzien}"><i class='bx bx-plus'></i></a><span>${i}</span></div>${HTML}</li>`

                }

                for (let i = lastDayofMonth; i < 6; i++) {
                    liTag += `<li class="inactive"><span>${i - lastDayofMonth + 1}</span></li>`
                }

                currentDate.innerHTML = `${months[currentMonth]} ${currentYear}`
                daysTag.innerHTML = liTag
            }

            renderCalendar()

            prevNextIcon.forEach((icon) => {
                icon.addEventListener("click", () => {
                    currentMonth = icon.id === "prev" ? currentMonth - 1 : currentMonth + 1

                    if (currentMonth < 0 || currentMonth > 11) {
                        date = new Date(currentYear, currentMonth)
                        currentYear = date.getFullYear()
                        currentMonth = date.getMonth()
                    } else {
                        date = new Date()
                    }
                    renderCalendar()
                })
            })
        })
    </script>
    <main>
        <div class="links-box" style="padding: 30px 20px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-calendar"></i>
                    <span>Terminarz</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box" style="padding: 30px 10px">

            <div class="scroll-box">
                <div class="wrapper">
                    <header>
                        <div class="icons">
                            <i id="prev" class="bx bx-chevron-left"></i>
                        </div>
                        <p class="current-date"></p>
                        <div class="icons">
                            <i id="next" class="bx bx-chevron-right"></i>
                        </div>
                    </header>
                    <div class="calendar">
                        <ul class="weeks">
                            <li>Pon.</li>
                            <li>Wt.</li>
                            <li>Śr.</li>
                            <li>Czw.</li>
                            <li>Pt.</li>
                            <li>Sob.</li>
                            <li>Niedz.</li>
                        </ul>

                        <ul class="days"></ul>
                    </div>
                </div>
            </div>


        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
