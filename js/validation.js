// Dark Mode Toggle
const toggleDarkMode = () => {
    const body = document.body;
    const header = document.querySelector('header');
    const buttons = document.querySelectorAll('button, .btn');
    const inputFields = document.querySelectorAll('input, textarea');
    
    // Toggle dark mode class on body and header
    body.classList.toggle('dark-mode');
    header.classList.toggle('dark-mode');

    // Toggle button and input styles
    buttons.forEach(button => button.classList.toggle('dark-mode'));
    inputFields.forEach(field => field.classList.toggle('dark-mode'));
};

// Check localStorage to maintain dark mode state
if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
    document.querySelector('header').classList.add('dark-mode');
}

// Dark Mode Toggle Button
document.getElementById('dark-mode-toggle').addEventListener('click', () => {
    toggleDarkMode();
    
    // Save dark mode state in localStorage
    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
    } else {
        localStorage.setItem('darkMode', 'disabled');
    }
});
