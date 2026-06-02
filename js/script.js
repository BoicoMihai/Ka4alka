const signupButton = document.querySelector('.header-auth.signup');
const signupModal = document.getElementById('signup-modal');
const closeSignup = document.getElementById('close-signup');
const signupForm = document.querySelector('.signup-form');

if (signupButton && signupModal && closeSignup) {
  signupButton.addEventListener('click', () => {
    signupModal.classList.add('active');
  });

  closeSignup.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    signupModal.classList.remove('active');
  });

  signupModal.addEventListener('click', (event) => {
    if (event.target === signupModal) {
      signupModal.classList.remove('active');
    }
  });
}

// Modal switcher: signup to login
const switchToLogin = document.getElementById('switch-to-login');
if (switchToLogin) {
  switchToLogin.addEventListener('click', (e) => {
    e.preventDefault();
    signupModal.classList.remove('active');
    loginModal.classList.add('active');
  });
}

// Modal switcher: login to signup
const switchToSignup = document.getElementById('switch-to-signup');
if (switchToSignup) {
  switchToSignup.addEventListener('click', (e) => {
    e.preventDefault();
    loginModal.classList.remove('active');
    signupModal.classList.add('active');
  });
}

// Login modal logic
const loginButton = document.querySelector('.header-auth.login');
const loginModal = document.getElementById('login-modal');
const closeLogin = document.getElementById('close-login');
const loginForm = document.querySelector('.login-form');

if (loginButton && loginModal && closeLogin) {
  loginButton.addEventListener('click', () => {
    loginModal.classList.add('active');
  });

  closeLogin.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    loginModal.classList.remove('active');
  });

  loginModal.addEventListener('click', (event) => {
    if (event.target === loginModal) {
      loginModal.classList.remove('active');
    }
  });
}
