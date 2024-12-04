// Element references
let dashboard = document.getElementById("dashboard");
let incomes = document.getElementById("incomes");
let spendings = document.getElementById("spendings");
let settings = document.getElementById("settings");

// Function to reset all menu styles
function resetMenuStyles() {
    const defaultBgColor = '#dd0b8c';
    const defaultTextColor = 'white';

    [dashboard, incomes, spendings, settings].forEach(item => {
        item.style.background = defaultBgColor;
        item.style.color = defaultTextColor;
    });
}

// Event listener for menu items
[dashboard, incomes, spendings, settings].forEach(item => {
    item.addEventListener('click', function () {
        resetMenuStyles();
        item.style.background = 'white';
        item.style.color = '#dd0b8c';
    });
});

// Menu item activation logic
let menus = document.querySelectorAll('.menu');
menus.forEach(menu => {
    menu.addEventListener('click', function () {
        menus.forEach(item => item.classList.remove('active'));
        menu.classList.add('active');
    });
});

// Circle Progress setup using jQuery
$(document).ready(function () {
    $('.round').each(function () {
        const value = $(this).data('value');
        $(this).circleProgress({
            value: value,
            size: 80,
            thickness: 8,
            fill: { color: '#27ae60' },
            startAngle: -Math.PI / 2,
            emptyFill: '#ecf0f1'
        }).on('circle-animation-progress', function (event, progress, stepValue) {
            $(this).find('strong').text(`${Math.round(stepValue * 100)}%`);
        });
    });
});
