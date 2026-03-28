// On page load
// Immediately apply the theme from storage to prevent a "flash" of the wrong theme
const savedTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
localStorage.setItem('theme', savedTheme);
document.documentElement.setAttribute('data-bs-theme', savedTheme);

// Once HTML is ready
$(document).ready(function() {
    const $themeIcon = $('#theme-icon');

    // Sync the UI icon with the current saved theme state
    if (savedTheme === 'dark') {
        $themeIcon.removeClass("bi-sun");
        $themeIcon.addClass("bi-moon");

    } else {
        $themeIcon.removeClass("bi-moon");
        $themeIcon.addClass("bi-sun");
    }

    // Toggle Click Handler
    // Swaps between light and dark modes and updates both the DOM and local storage
    $('#darkModeToggle').on('click', function() {
        const currentTheme = $('html').attr('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        // Update the Bootstrap theme attribute
        $('html').attr('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);

        // Update the visual icon to match the new theme
        if (newTheme === 'dark') {
            $themeIcon.removeClass("bi-sun");
            $themeIcon.addClass("bi-moon");
        } else {
            $themeIcon.removeClass("bi-moon");
            $themeIcon.addClass("bi-sun");
        }
    });
});