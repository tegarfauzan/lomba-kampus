

import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.toggleTheme = () => {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
};

Alpine.start();
