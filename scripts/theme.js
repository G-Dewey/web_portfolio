// On page load
const savedTheme = localStorage.getItem('theme') || 'dark';
localStorage.setItem('theme', savedTheme);
document.documentElement.setAttribute('data-bs-theme', savedTheme);

// Once HMTL is ready
$(document).ready(function() {
    const $themeIcon = $('#theme-icon');

    if (savedTheme === 'dark') {
        $themeIcon.removeClass("bi-sun");
        $themeIcon.addClass("bi-moon");

    } else {
        $themeIcon.removeClass("bi-moon");
        $themeIcon.addClass("bi-sun");
    }

    // Toggle Click Handler
    $('#darkModeToggle').on('click', function() {
        const currentTheme = $('html').attr('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        $('html').attr('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);

        if (newTheme === 'dark') {
            $themeIcon.removeClass("bi-sun");
            $themeIcon.addClass("bi-moon");
        } else {
            $themeIcon.removeClass("bi-moon");
            $themeIcon.addClass("bi-sun");
        }
    });
});