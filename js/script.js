document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const toggleSignup = document.getElementById('toggleSignup');
    const toggleLogin = document.getElementById('toggleLogin');

    // Toggle between login and signup forms
    toggleSignup.addEventListener('click', function(e) {
        e.preventDefault();
        loginForm.classList.remove('active');
        signupForm.classList.add('active');
    });

    toggleLogin.addEventListener('click', function(e) {
        e.preventDefault();
        signupForm.classList.remove('active');
        loginForm.classList.add('active');
    });
});

