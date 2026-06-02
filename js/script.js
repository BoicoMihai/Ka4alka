const signupButton = document.querySelector('.header-auth.signup');
const signupModal = document.getElementById('signup-modal');
const closeSignup = document.getElementById('close-signup');
const signupForm = document.querySelector('.signup-form');

if (signupButton && signupModal && closeSignup) {
  signupButton.addEventListener('click', () => {
    signupModal.classList.add('active');
  });

  closeSignup.addEventListener('click', () => {
    signupModal.classList.remove('active');
  });

  signupModal.addEventListener('click', (event) => {
    if (event.target === signupModal) {
      signupModal.classList.remove('active');
    }
  });
}

if (signupForm) {
  signupForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const email = signupForm.querySelector('#signup-email').value;
    const password = signupForm.querySelector('#signup-password').value;

    console.log('Sign up submitted:', { email, password });

    signupModal.classList.remove('active');
    signupForm.reset();
  });
}
