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

// theme.js — include on every page that has a header

(function () {
    const STORAGE_KEY = 'ka4alka-theme';

    // ── Apply saved theme immediately (prevents flash) ──
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved === 'light') document.body.classList.add('light-mode');

    document.addEventListener('DOMContentLoaded', function () {
        const toggle     = document.getElementById('account-toggle');
        const dropdown   = document.getElementById('account-dropdown');
        const themeBtn   = document.getElementById('theme-toggle');
        const themeIcon  = document.getElementById('theme-toggle-icon');
        const themeLabel = document.getElementById('theme-toggle-label');

        if (!toggle || !dropdown) return;

        // ── Sync label/icon to current state ──
        function syncUI() {
            const isLight = document.body.classList.contains('light-mode');
            themeIcon.textContent  = isLight ? '🌙' : '☀️';
            themeLabel.textContent = isLight ? 'Dark Mode' : 'Light Mode';
        }
        syncUI();

        // ── Toggle dropdown ──
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = dropdown.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen);
        });

        // ── Close on outside click ──
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target) && e.target !== toggle) {
                dropdown.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });

        // ── Close on Escape ──
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && dropdown.classList.contains('open')) {
                dropdown.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus();
            }
        });

        // ── Theme switch ──
        themeBtn.addEventListener('click', function () {
            document.body.classList.toggle('light-mode');
            const isLight = document.body.classList.contains('light-mode');
            localStorage.setItem(STORAGE_KEY, isLight ? 'light' : 'dark');
            syncUI();
        });
    });
})();

(function () {
    const STORAGE_KEY = "ka4alka_workouts";

    function loadWorkouts() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            const workouts = raw ? JSON.parse(raw) : [];
            return Array.isArray(workouts) ? workouts : [];
        } catch (e) { return []; }
    }

    function renderSidebarList() {
        const workoutList = document.getElementById("workout-list");
        const sidebarSearch = document.getElementById("sidebar-search");
        if (!workoutList) return;

        const query = sidebarSearch ? sidebarSearch.value.trim().toLowerCase() : "";
        const workouts = loadWorkouts().filter(function (w) {
            return !query || w.name.toLowerCase().includes(query);
        });

        if (!workouts.length) {
            workoutList.innerHTML = query
                ? '<p class="workout-list-empty">No workouts match your search.</p>'
                : '<p class="workout-list-empty">No saved workouts yet.</p>';
            return;
        }

        workoutList.innerHTML = workouts.map(function (w) {
            const count = (w.exercises && w.exercises.length) || 0;
            const label = count === 1 ? "1 exercise" : count + " exercises";
            return `<a href="new_workout.php?id=${w.id}" class="workout-list-item">
                <div class="workout-list-item-info">
                    <p class="workout-list-item-name">${w.name}</p>
                    <p class="workout-list-item-meta">${label}</p>
                </div>
            </a>`;
        }).join("");
    }

    document.addEventListener("DOMContentLoaded", function () {
        renderSidebarList();
        const sidebarSearch = document.getElementById("sidebar-search");
        if (sidebarSearch) {
            sidebarSearch.addEventListener("input", renderSidebarList);
        }
    });
})();

// Filter bar toggle
document.addEventListener('DOMContentLoaded', function () {
  const filterToggle = document.getElementById('filter-toggle');
  const filterBar    = filterToggle && filterToggle.closest('.filter-bar');
  if (!filterToggle || !filterBar) return;

  filterToggle.addEventListener('click', function () {
    filterBar.classList.toggle('open');
  });

  // Auto-open if a non-"all" filter is active (so user sees their active chip)
  const activeChip = filterBar.querySelector('.filter-chip.active');
  if (activeChip && !activeChip.href.includes('category=all')) {
    filterBar.classList.add('open');
  }
});

(function () {
    const STORAGE_KEY = "ka4alka_workouts";

    function loadWorkouts() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            const w = raw ? JSON.parse(raw) : [];
            return Array.isArray(w) ? w : [];
        } catch (e) { return []; }
    }

    function renderMainDropdown() {
        const dropdown = document.getElementById("main-workout-dropdown");
        if (!dropdown) return;

        const workouts = loadWorkouts();

        if (!workouts.length) {
            dropdown.innerHTML = '<p class="main-workout-dropdown-empty">No saved workouts yet.</p>';
            return;
        }

        dropdown.innerHTML = workouts.map(function (w) {
            const count = (w.exercises && w.exercises.length) || 0;
            const label = count === 1 ? "1 exercise" : count + " exercises";
            return `<a href="new_workout.php?id=${w.id}" class="main-workout-dropdown-item">
                <div>
                    <p class="main-workout-dropdown-item-name">${w.name}</p>
                    <p class="main-workout-dropdown-item-meta">${label}</p>
                </div>
            </a>`;
        }).join("");
    }

    document.addEventListener("DOMContentLoaded", function () {
        const toggle   = document.getElementById("my-workouts-toggle");
        const dropdown = document.getElementById("main-workout-dropdown");
        if (!toggle || !dropdown) return;

        renderMainDropdown();

        toggle.addEventListener("click", function () {
            const isOpen = dropdown.classList.toggle("open");
            toggle.setAttribute("aria-expanded", isOpen);
        });
    });
})();