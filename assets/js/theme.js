
document.addEventListener("DOMContentLoaded", function() {
    var toggle = document.getElementById("theme-toggle");
    var circle = document.querySelector('.circle');

    if (toggle) {
        var storedTheme = localStorage.getItem('theme') || (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light");
        if (storedTheme) {
            document.body.setAttribute('data-theme', storedTheme);
            toggle.classList.toggle('dark', storedTheme === 'dark');
            toggle.classList.toggle('light', storedTheme === 'light');
            toggleCirclePosition(storedTheme);
        }

        toggle.onclick = function() {
            var currentTheme = document.body.getAttribute("data-theme");
            var targetTheme = "light";

            if (currentTheme === "light") {
                targetTheme = "dark";
            }

            document.body.setAttribute('data-theme', targetTheme);
            localStorage.setItem('theme', targetTheme);

            toggle.classList.toggle('dark', targetTheme === 'dark');
            toggle.classList.toggle('light', targetTheme === 'light');
            toggleCirclePosition(targetTheme);
        };
    }
});

function toggleCirclePosition(theme) {
    var circle = document.querySelector('.circle');
    if (theme === 'dark') {
        circle.style.left = '5%';
    } else {
        circle.style.left = '50%';
    }
}


function toggleCirclePosition(theme) {
    var circle = document.querySelector('.circle');
    if (theme === 'dark') {
        circle.classList.add('change');
    } else {
        circle.classList.remove('change');
    }
}

