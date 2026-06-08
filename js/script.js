document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const toggleSignup = document.getElementById('toggleSignup');
    const toggleLogin = document.getElementById('toggleLogin');

    if (toggleSignup && toggleLogin && loginForm && signupForm) {
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
    }

    const signupModal = document.getElementById('signup-modal');
    const loginModal = document.getElementById('login-modal');
    const switchToSignup = document.getElementById('switch-to-signup');
    const switchToLogin = document.getElementById('switch-to-login');
    const closeSignup = document.getElementById('close-signup');
    const closeLogin = document.getElementById('close-login');
    const headerSignup = document.querySelector('.header-auth.signup');
    const headerLogin = document.querySelector('.header-auth.login');

    function openSignupModal() {
        if (loginModal) loginModal.classList.remove('active');
        if (signupModal) signupModal.classList.add('active');
    }

    function openLoginModal() {
        if (signupModal) signupModal.classList.remove('active');
        if (loginModal) loginModal.classList.add('active');
    }

    function closeModals() {
        if (signupModal) signupModal.classList.remove('active');
        if (loginModal) loginModal.classList.remove('active');
    }

    if (signupModal && switchToSignup) {
        switchToSignup.addEventListener('click', function(e) {
            e.preventDefault();
            openSignupModal();
        });
    }

    if (loginModal && switchToLogin) {
        switchToLogin.addEventListener('click', function(e) {
            e.preventDefault();
            openLoginModal();
        });
    }

    if (headerSignup) {
        headerSignup.addEventListener('click', function() {
            openSignupModal();
        });
    }

    if (headerLogin) {
        headerLogin.addEventListener('click', function() {
            openLoginModal();
        });
    }

    if (closeSignup) {
        closeSignup.addEventListener('click', function() {
            closeModals();
        });
    }

    if (closeLogin) {
        closeLogin.addEventListener('click', function() {
            closeModals();
        });
    }

    if (signupModal) {
        signupModal.addEventListener('click', function(e) {
            if (e.target === signupModal) {
                closeModals();
            }
        });
    }

    if (loginModal) {
        loginModal.addEventListener('click', function(e) {
            if (e.target === loginModal) {
                closeModals();
            }
        });
    }
});



