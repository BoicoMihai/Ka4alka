// ─── Per-user localStorage key ───────────────────────────────────────────────
// window.KA4ALKA_USER is injected by PHP before this script loads on every
// authenticated page. Falls back to 'guest' so nothing ever breaks.

function getWorkoutStorageKey() {
    var user = (window.KA4ALKA_USER || 'guest').toLowerCase().replace(/[^a-z0-9_-]/g, '_');
    return 'ka4alka_workouts_' + user;
}

// ─── Auth modals (login / signup pages) ──────────────────────────────────────

document.addEventListener('DOMContentLoaded', function () {
    var loginForm    = document.getElementById('loginForm');
    var signupForm   = document.getElementById('signupForm');
    var toggleSignup = document.getElementById('toggleSignup');
    var toggleLogin  = document.getElementById('toggleLogin');

    if (toggleSignup && toggleLogin && loginForm && signupForm) {
        toggleSignup.addEventListener('click', function (e) {
            e.preventDefault();
            loginForm.classList.remove('active');
            signupForm.classList.add('active');
        });
        toggleLogin.addEventListener('click', function (e) {
            e.preventDefault();
            signupForm.classList.remove('active');
            loginForm.classList.add('active');
        });
    }

    var signupModal    = document.getElementById('signup-modal');
    var loginModal     = document.getElementById('login-modal');
    var switchToSignup = document.getElementById('switch-to-signup');
    var switchToLogin  = document.getElementById('switch-to-login');
    var closeSignup    = document.getElementById('close-signup');
    var closeLogin     = document.getElementById('close-login');
    var headerSignup   = document.querySelector('.header-auth.signup');
    var headerLogin    = document.querySelector('.header-auth.login');

    function openSignupModal() {
        if (loginModal)  loginModal.classList.remove('active');
        if (signupModal) signupModal.classList.add('active');
    }
    function openLoginModal() {
        if (signupModal) signupModal.classList.remove('active');
        if (loginModal)  loginModal.classList.add('active');
    }
    function closeModals() {
        if (signupModal) signupModal.classList.remove('active');
        if (loginModal)  loginModal.classList.remove('active');
    }

    if (switchToSignup) switchToSignup.addEventListener('click', function (e) { e.preventDefault(); openSignupModal(); });
    if (switchToLogin)  switchToLogin.addEventListener('click',  function (e) { e.preventDefault(); openLoginModal(); });
    if (headerSignup)   headerSignup.addEventListener('click',  openSignupModal);
    if (headerLogin)    headerLogin.addEventListener('click',   openLoginModal);
    if (closeSignup)    closeSignup.addEventListener('click',   closeModals);
    if (closeLogin)     closeLogin.addEventListener('click',    closeModals);
    if (signupModal)    signupModal.addEventListener('click',   function (e) { if (e.target === signupModal)  closeModals(); });
    if (loginModal)     loginModal.addEventListener('click',    function (e) { if (e.target === loginModal)   closeModals(); });
});

// ─── Theme + dropdown + contact modal ────────────────────────────────────────

(function () {
    var THEME_KEY = 'ka4alka-theme';

    // Apply saved theme immediately to prevent flash
    if (localStorage.getItem(THEME_KEY) === 'light') {
        document.body.classList.add('light-mode');
    }

    document.addEventListener('DOMContentLoaded', function () {
        var toggle     = document.getElementById('account-toggle');
        var dropdown   = document.getElementById('account-dropdown');
        var themeBtn   = document.getElementById('theme-toggle');
        var themeIcon  = document.getElementById('theme-toggle-icon');
        var themeLabel = document.getElementById('theme-toggle-label');

        if (!toggle || !dropdown) return;

        function syncThemeUI() {
            var isLight = document.body.classList.contains('light-mode');
            if (themeIcon)  themeIcon.textContent  = isLight ? '🌙' : '☀️';
            if (themeLabel) themeLabel.textContent = isLight ? 'Dark Mode' : 'Light Mode';
        }
        syncThemeUI();

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = dropdown.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen);
        });

        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target) && e.target !== toggle) {
                dropdown.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && dropdown.classList.contains('open')) {
                dropdown.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus();
            }
        });

        if (themeBtn) {
            themeBtn.addEventListener('click', function () {
                document.body.classList.toggle('light-mode');
                var isLight = document.body.classList.contains('light-mode');
                localStorage.setItem(THEME_KEY, isLight ? 'light' : 'dark');
                syncThemeUI();
            });
        }

        // ── Contact modal ──
        var contactOpen   = document.getElementById('contact-open');
        var contactModal  = document.getElementById('contact-modal-overlay');
        var contactClose  = document.getElementById('contact-modal-close');
        var contactForm   = document.getElementById('contact-modal-form');
        var contactStatus = document.getElementById('contact-modal-status');

        function openContactModal() {
            if (!contactModal) return;
            contactModal.classList.add('open');
            contactModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
        function closeContactModal() {
            if (!contactModal) return;
            contactModal.classList.remove('open');
            contactModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            if (contactStatus) contactStatus.textContent = '';
        }

        if (contactOpen) {
            contactOpen.addEventListener('click', function (e) {
                e.stopPropagation();
                dropdown.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                openContactModal();
            });
        }
        if (contactClose) contactClose.addEventListener('click', closeContactModal);
        if (contactModal) {
            contactModal.addEventListener('click', function (e) {
                if (e.target === contactModal) closeContactModal();
            });
        }

        if (contactForm) {
            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();
                var payload = new URLSearchParams(new FormData(contactForm)).toString();
                if (contactStatus) contactStatus.textContent = 'Sending your message...';

                fetch('php/save_feedback.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                    body: payload
                })
                .then(function (r) {
                    return r.json().then(function (d) {
                        if (!r.ok) throw new Error(d.message || 'Unable to save feedback.');
                        return d;
                    });
                })
                .then(function () {
                    if (contactStatus) contactStatus.textContent = 'Thanks for reaching out — your message was saved successfully.';
                    contactForm.reset();
                })
                .catch(function (err) {
                    if (contactStatus) contactStatus.textContent = err.message || 'Something went wrong. Please try again.';
                });
            });
        }
    });
})();

// ─── Sidebar workout list ─────────────────────────────────────────────────────

(function () {
    function loadWorkouts() {
        try {
            var raw = localStorage.getItem(getWorkoutStorageKey());
            var w   = raw ? JSON.parse(raw) : [];
            return Array.isArray(w) ? w : [];
        } catch (e) { return []; }
    }

    function renderSidebarList() {
        var workoutList   = document.getElementById('workout-list');
        var sidebarSearch = document.getElementById('sidebar-search');
        if (!workoutList) return;

        var query    = sidebarSearch ? sidebarSearch.value.trim().toLowerCase() : '';
        var workouts = loadWorkouts().filter(function (w) {
            return !query || w.name.toLowerCase().includes(query);
        });

        if (!workouts.length) {
            workoutList.innerHTML = query
                ? '<p class="workout-list-empty">No workouts match your search.</p>'
                : '<p class="workout-list-empty">No saved workouts yet.</p>';
            return;
        }

        workoutList.innerHTML = workouts.map(function (w) {
            var count = (w.exercises && w.exercises.length) || 0;
            var label = count === 1 ? '1 exercise' : count + ' exercises';
            return '<a href="new_workout.php?id=' + w.id + '" class="workout-list-item">'
                 + '<div class="workout-list-item-info">'
                 + '<p class="workout-list-item-name">' + w.name + '</p>'
                 + '<p class="workout-list-item-meta">' + label + '</p>'
                 + '</div></a>';
        }).join('');
    }

    document.addEventListener('DOMContentLoaded', function () {
        renderSidebarList();
        var sidebarSearch = document.getElementById('sidebar-search');
        if (sidebarSearch) sidebarSearch.addEventListener('input', renderSidebarList);
    });
})();

// ─── Filter bar toggle (library.php) ─────────────────────────────────────────

document.addEventListener('DOMContentLoaded', function () {
    var filterToggle = document.getElementById('filter-toggle');
    var filterBar    = filterToggle && filterToggle.closest('.filter-bar');
    if (!filterToggle || !filterBar) return;

    filterToggle.addEventListener('click', function () {
        filterBar.classList.toggle('open');
    });

    var activeChip = filterBar.querySelector('.filter-chip.active');
    if (activeChip && !activeChip.href.includes('category=all')) {
        filterBar.classList.add('open');
    }
});

// ─── Main "My Workouts" expandable dropdown (index.php) ──────────────────────

(function () {
    function loadWorkouts() {
        try {
            var raw = localStorage.getItem(getWorkoutStorageKey());
            var w   = raw ? JSON.parse(raw) : [];
            return Array.isArray(w) ? w : [];
        } catch (e) { return []; }
    }

    function renderMainDropdown() {
        var dropdown = document.getElementById('main-workout-dropdown');
        if (!dropdown) return;

        var workouts = loadWorkouts();
        if (!workouts.length) {
            dropdown.innerHTML = '<p class="main-workout-dropdown-empty">No saved workouts yet.</p>';
            return;
        }

        dropdown.innerHTML = workouts.map(function (w) {
            var count = (w.exercises && w.exercises.length) || 0;
            var label = count === 1 ? '1 exercise' : count + ' exercises';
            return '<a href="new_workout.php?id=' + w.id + '" class="main-workout-dropdown-item">'
                 + '<div>'
                 + '<p class="main-workout-dropdown-item-name">' + w.name + '</p>'
                 + '<p class="main-workout-dropdown-item-meta">' + label + '</p>'
                 + '</div></a>';
        }).join('');
    }

    document.addEventListener('DOMContentLoaded', function () {
        var toggle   = document.getElementById('my-workouts-toggle');
        var dropdown = document.getElementById('main-workout-dropdown');
        if (!toggle || !dropdown) return;

        renderMainDropdown();

        toggle.addEventListener('click', function () {
            var isOpen = dropdown.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen);
        });
    });
})();

// ─── Explore Workouts expandable dropdown (index.php) ────────────────────────

(function () {
    // !! ARRAY not object — so .map() works in renderExploreDropdown !!
    var EXPLORE_WORKOUTS = [
        {
            id: 'explore-push-day',
            name: 'Push Day',
            exercises: [
                { name: 'Dumbbell Bench Press',         muscles: ['Chest', 'Shoulders', 'Triceps'], image: 'exercise-images/dumbbell-bench-press.png' },
                { name: 'Incline Bench Press',           muscles: ['Chest', 'Shoulders', 'Triceps'], image: 'exercise-images/incline-bench-press.png' },
                { name: 'Incline Dumbbell Bench Press',  muscles: ['Chest', 'Shoulders', 'Triceps'], image: 'exercise-images/incline-dumbbell-bench-press.png' },
                { name: 'Chest Dip',                     muscles: ['Chest', 'Shoulders', 'Triceps', 'Abs'], image: 'exercise-images/chest-dip.png' }
            ]
        },
        {
            id: 'explore-pull-day',
            name: 'Pull Day',
            exercises: [
                { name: 'Deadlift',     muscles: ['Back', 'Hamstrings'], image: 'exercise-images/deadlift.png' },
                { name: 'Pull-Ups',     muscles: ['Back', 'Biceps'],     image: 'exercise-images/pull-ups.png' },
                { name: 'Barbell Row',  muscles: ['Back', 'Biceps'],     image: 'exercise-images/barbell-row.png' },
                { name: 'Barbell Curl', muscles: ['Biceps'],             image: 'exercise-images/barbell-curl.png' }
            ]
        },
        {
            id: 'explore-leg-day',
            name: 'Leg Day',
            exercises: [
                { name: 'Squat',             muscles: ['Quads', 'Glutes'],      image: 'exercise-images/squat.png' },
                { name: 'Romanian Deadlift', muscles: ['Hamstrings', 'Glutes'], image: 'exercise-images/romanian-deadlift.png' },
                { name: 'Leg Press',         muscles: ['Quads', 'Glutes'],      image: 'exercise-images/leg-press.png' },
                { name: 'Leg Curl',          muscles: ['Hamstrings'],           image: 'exercise-images/leg-curl.png' }
            ]
        },
        {
            id: 'explore-full-body',
            name: 'Full Body',
            exercises: [
                { name: 'Squat',                muscles: ['Quads', 'Glutes'],              image: 'exercise-images/squat.png' },
                { name: 'Incline Bench Press',   muscles: ['Chest', 'Shoulders', 'Triceps'], image: 'exercise-images/incline-bench-press.png' },
                { name: 'Deadlift',              muscles: ['Back', 'Hamstrings'],           image: 'exercise-images/deadlift.png' },
                { name: 'Barbell Row',           muscles: ['Back', 'Biceps'],               image: 'exercise-images/barbell-row.png' },
                { name: 'Barbell Curl',          muscles: ['Biceps'],                       image: 'exercise-images/barbell-curl.png' },
                { name: 'Chest Dip',             muscles: ['Chest', 'Shoulders', 'Triceps', 'Abs'], image: 'exercise-images/chest-dip.png' }
            ]
        }
    ];

    function renderExploreDropdown() {
        var dropdown = document.getElementById('explore-workout-dropdown');
        if (!dropdown) return;

        dropdown.innerHTML = EXPLORE_WORKOUTS.map(function (w) {
            var count = w.exercises.length;
            var label = count === 1 ? '1 exercise' : count + ' exercises';
            return '<a href="new_workout.php?id=' + w.id + '" class="main-workout-dropdown-item">'
                 + '<div>'
                 + '<p class="main-workout-dropdown-item-name">' + w.name + '</p>'
                 + '<p class="main-workout-dropdown-item-meta">' + label + '</p>'
                 + '</div></a>';
        }).join('');
    }

    document.addEventListener('DOMContentLoaded', function () {
        var toggle   = document.getElementById('explore-workouts-toggle');
        var dropdown = document.getElementById('explore-workout-dropdown');
        if (!toggle || !dropdown) return;

        renderExploreDropdown();

        toggle.addEventListener('click', function () {
            var isOpen = dropdown.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen);
        });
    });
})();

// ─── Language toggle ──────────────────────────────────────────────────────────

(function () {
    var LANG_KEY = 'ka4alka-lang';

    var translations = {
        en: {
            searchExercise:         'Search exercise...',
            searchWorkout:          'Search workout...',
            createNewWorkout:       'Create New Workout',
            myWorkouts:             'My Workouts',
            startEmpty:             'Start Empty Workout',
            routines:               'Routines',
            exploreWorkout:         'Explore Workout',
            workoutNamePlaceholder: 'Workout name...',
            addExercise:            '+ Add Exercise',
            saveWorkout:            'Save Workout',
            noWorkouts:             'No saved workouts yet.',
            noMatch:                'No workouts match your search.',
            langToggle:             'Română',
            logOut:                 'Log Out',
            modalTitle:             'Add Exercise',
            searchModal:            'Search...',
            tabAbs:                 'Abs',
            tabBack:                'Back',
            tabBiceps:              'Biceps',
            tabChest:               'Chest',
            tabLegs:                'Legs',
            tabShoulders:           'Shoulders',
            tabTriceps:             'Triceps',
            emptyState:             'Click <strong>Create New Workout</strong> to get started',
        },
        ro: {
            searchExercise:         'Caută exercițiu...',
            searchWorkout:          'Caută antrenament...',
            createNewWorkout:       'Antrenament Nou',
            myWorkouts:             'Antrenamentele Mele',
            startEmpty:             'Începe Antrenament Gol',
            routines:               'Rutine',
            exploreWorkout:         'Explorează Antrenamente',
            workoutNamePlaceholder: 'Numele antrenamentului...',
            addExercise:            '+ Adaugă Exercițiu',
            saveWorkout:            'Salvează',
            noWorkouts:             'Niciun antrenament salvat.',
            noMatch:                'Niciun rezultat găsit.',
            langToggle:             'English',
            logOut:                 'Deconectare',
            modalTitle:             'Adaugă Exercițiu',
            searchModal:            'Caută...',
            tabAbs:                 'Abdomen',
            tabBack:                'Spate',
            tabBiceps:              'Biceps',
            tabChest:               'Piept',
            tabLegs:                'Picioare',
            tabShoulders:           'Umeri',
            tabTriceps:             'Triceps',
            emptyState:             'Apasă <strong>Antrenament Nou</strong> pentru a începe',
        }
    };

    function applyLang(lang) {
        var t = translations[lang];

        var searchInput = document.querySelector('.search-input');
        if (searchInput) searchInput.placeholder = t.searchExercise;

        var sidebarSearch = document.getElementById('sidebar-search');
        var createNewBtn  = document.querySelector('.create-new-workout p');
        var myWorkoutsBtn = document.querySelector('.my-workouts p');
        if (sidebarSearch) sidebarSearch.placeholder  = t.searchWorkout;
        if (createNewBtn)  createNewBtn.textContent   = t.createNewWorkout;
        if (myWorkoutsBtn) myWorkoutsBtn.textContent  = t.myWorkouts;

        var startEmpty   = document.querySelector('.empty-workout p');
        var routinesText = document.getElementById('Routines-text');
        var exploreBtn   = document.querySelector('.explore-workouts p');
        var mainWorkouts = document.querySelector('#my-workouts-toggle p');
        if (startEmpty)   startEmpty.textContent   = t.startEmpty;
        if (routinesText) routinesText.textContent = t.routines;
        if (exploreBtn)   exploreBtn.textContent   = t.exploreWorkout;
        if (mainWorkouts) mainWorkouts.textContent = t.myWorkouts;

        var workoutTitleInput = document.getElementById('workout-title');
        var saveWorkoutBtn    = document.getElementById('btn-save-workout');
        var addExerciseBtn    = document.getElementById('btn-add-exercise');
        var emptyStateText    = document.querySelector('.empty-state p');
        if (workoutTitleInput) workoutTitleInput.placeholder = t.workoutNamePlaceholder;
        if (saveWorkoutBtn)    saveWorkoutBtn.textContent    = t.saveWorkout;
        if (addExerciseBtn)    addExerciseBtn.innerHTML      = t.addExercise;
        if (emptyStateText)    emptyStateText.innerHTML      = t.emptyState;

        var modalTitle  = document.querySelector('.modal-title');
        var modalSearch = document.getElementById('modal-search');
        if (modalTitle)  modalTitle.textContent  = t.modalTitle;
        if (modalSearch) modalSearch.placeholder = t.searchModal;

        var tabMap = {
            exercises_abs:       t.tabAbs,
            exercises_back:      t.tabBack,
            exercises_biceps:    t.tabBiceps,
            exercises_chest:     t.tabChest,
            exercises_legs:      t.tabLegs,
            exercises_shoulders: t.tabShoulders,
            exercises_triceps:   t.tabTriceps,
        };
        document.querySelectorAll('.cat-tab').forEach(function (tab) {
            var label = tabMap[tab.dataset.file];
            if (label) tab.textContent = label;
        });

        var langLabel  = document.getElementById('lang-toggle-label');
        var logoutSpan = document.querySelector('a[href="logout.php"] span:last-child');
        if (langLabel)  langLabel.textContent  = t.langToggle;
        if (logoutSpan) logoutSpan.textContent = t.logOut;

        document.documentElement.lang = lang;
    }

    // Apply immediately to prevent flash
    var savedLang = localStorage.getItem(LANG_KEY) || 'en';
    if (savedLang === 'ro') applyLang('ro');

    document.addEventListener('DOMContentLoaded', function () {
        var langBtn = document.getElementById('lang-toggle');
        if (!langBtn) return;

        applyLang(localStorage.getItem(LANG_KEY) || 'en');

        langBtn.addEventListener('click', function () {
            var current = localStorage.getItem(LANG_KEY) || 'en';
            var next    = current === 'en' ? 'ro' : 'en';
            localStorage.setItem(LANG_KEY, next);
            applyLang(next);
        });
    });
})();