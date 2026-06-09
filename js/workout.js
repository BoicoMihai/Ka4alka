(function () {
  "use strict";

  const STORAGE_KEY = "ka4alka_workouts";

  /* ─── State ─── */
  let exerciseCards = [];          // array of card state objects
  let currentTimerCardId = null;   // which card's timer is being edited
  let currentWorkoutId = null;     // id of workout being edited (null = new)
  let savedWorkouts = [];          // workouts from localStorage

  /* ─── DOM refs ─── */
  const btnCreateNew   = document.getElementById("btn-create-new");
  const emptyState     = document.getElementById("empty-state");
  const builder        = document.getElementById("builder");
  const exerciseList   = document.getElementById("exercise-list");
  const btnAddExercise = document.getElementById("btn-add-exercise");
  const workoutTitle   = document.getElementById("workout-title");
  const workoutList    = document.getElementById("workout-list");
  const sidebarSearch  = document.getElementById("sidebar-search");

  // Exercise picker modal
  const modalOverlay   = document.getElementById("modal-overlay");
  const modalClose     = document.getElementById("modal-close");
  const categoryTabs   = document.getElementById("category-tabs");
  const modalSearch    = document.getElementById("modal-search");
  const exerciseGrid   = document.getElementById("exercise-grid");

  // Timer modal
  const timerOverlay   = document.getElementById("timer-overlay");
  const timerClose     = document.getElementById("timer-close");
  const timerMinInput  = document.getElementById("timer-min-input");
  const timerSecInput  = document.getElementById("timer-sec-input");
  const saveTimerBtn   = document.getElementById("save-timer-btn");

  /* ─── Helpers ─── */
  function uid() {
    return Math.random().toString(36).slice(2, 9);
  }

  function formatTimer(mins, secs) {
    const s = String(secs).padStart(2, "0");
    return `${mins}m ${s}s`;
  }

  function clamp(val, min, max) {
    return Math.max(min, Math.min(max, val));
  }

  function normalizeImagePath(image) {
    if (!image) return "";
    if (image.startsWith("http") || image.startsWith("exercise-images/")) {
      return image;
    }
    return `exercise-images/${image}`;
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;");
  }

  /* ─── Local storage ─── */
  function loadWorkoutsFromStorage() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      savedWorkouts = raw ? JSON.parse(raw) : [];
      if (!Array.isArray(savedWorkouts)) savedWorkouts = [];
    } catch (e) {
      savedWorkouts = [];
    }
  }

  function persistWorkouts() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(savedWorkouts));
  }

  function showBuilder() {
    emptyState.style.display = "none";
    builder.style.display    = "flex";
  }

  function clearBuilder() {
    exerciseCards = [];
    currentWorkoutId = null;
    workoutTitle.value = "";
    exerciseList.innerHTML = "";
  }

  function startNewWorkout() {
    clearBuilder();
    showBuilder();
    renderWorkoutList();
    workoutTitle.focus();
  }

  function buildWorkoutPayload(title) {
    return {
      name: title,
      exercises: exerciseCards.map(function (card) {
        return {
          name:     card.exercise.name,
          muscles:  card.exercise.muscles,
          image:    card.exercise.image,
          timerMin: card.timerMin,
          timerSec: card.timerSec,
          sets: card.sets.map(function (s) {
            return {
              weight: s.weight === "" ? "" : (parseFloat(s.weight) || 0),
              reps:   s.reps === "" ? "" : (parseInt(s.reps, 10) || 0)
            };
          })
        };
      })
    };
  }

  function workoutToCards(workout) {
    return workout.exercises.map(function (ex) {
      return {
        id: uid(),
        exercise: {
          name:    ex.name,
          muscles: ex.muscles || [],
          image:   ex.image || ""
        },
        timerMin: ex.timerMin != null ? ex.timerMin : 1,
        timerSec: ex.timerSec != null ? ex.timerSec : 30,
        sets: (ex.sets && ex.sets.length)
          ? ex.sets.map(function (s) {
              return {
                id: uid(),
                weight: s.weight != null ? String(s.weight) : "",
                reps:   s.reps != null ? String(s.reps) : ""
              };
            })
          : [{ id: uid(), weight: "", reps: "" }]
      };
    });
  }

  function loadWorkoutIntoBuilder(workoutId) {
    const workout = savedWorkouts.find(function (w) { return w.id === workoutId; });
    if (!workout) return;

    clearBuilder();
    currentWorkoutId = workout.id;
    workoutTitle.value = workout.name;
    exerciseCards = workoutToCards(workout);
    exerciseCards.forEach(renderCard);
    showBuilder();
    renderWorkoutList();
  }

  function deleteWorkout(workoutId) {
    savedWorkouts = savedWorkouts.filter(function (w) { return w.id !== workoutId; });
    persistWorkouts();
    if (currentWorkoutId === workoutId) {
      clearBuilder();
      emptyState.style.display = "flex";
      builder.style.display = "none";
    }
    renderWorkoutList();
  }

  function renderWorkoutList() {
    const query = sidebarSearch ? sidebarSearch.value.trim().toLowerCase() : "";
    const filtered = savedWorkouts.filter(function (w) {
      return !query || w.name.toLowerCase().includes(query);
    });

    if (!filtered.length) {
      workoutList.innerHTML = query
        ? '<p class="workout-list-empty">No workouts match your search.</p>'
        : '<p class="workout-list-empty">No saved workouts yet.</p>';
      return;
    }

    workoutList.innerHTML = filtered.map(function (w) {
      const count = (w.exercises && w.exercises.length) || 0;
      const label = count === 1 ? "1 exercise" : count + " exercises";
      const active = w.id === currentWorkoutId ? " active" : "";
      return `<button type="button" class="workout-list-item${active}" data-workout-id="${escapeHtml(w.id)}">
        <div class="workout-list-item-info">
          <p class="workout-list-item-name">${escapeHtml(w.name)}</p>
          <p class="workout-list-item-meta">${label}</p>
        </div>
        <span class="workout-list-delete" data-delete-id="${escapeHtml(w.id)}" title="Delete workout">✕</span>
      </button>`;
    }).join("");
  }

  workoutList.addEventListener("click", function (e) {
    const deleteBtn = e.target.closest(".workout-list-delete");
    if (deleteBtn) {
      e.stopPropagation();
      const id = deleteBtn.dataset.deleteId;
      if (confirm("Delete this workout?")) deleteWorkout(id);
      return;
    }
    const item = e.target.closest(".workout-list-item");
    if (item) loadWorkoutIntoBuilder(item.dataset.workoutId);
  });

  if (sidebarSearch) {
    sidebarSearch.addEventListener("input", renderWorkoutList);
  }

  /* ─── Show builder ─── */
  btnCreateNew.addEventListener("click", startNewWorkout);

  /* ─── Add Exercise button ─── */
  btnAddExercise.addEventListener("click", openExercisePicker);

  /* ════════════════════════════════════════════
     EXERCISE PICKER MODAL
  ════════════════════════════════════════════ */

  let currentCategory  = "exercises_abs";
  let allExercises     = [];   // exercises for current category

  function openExercisePicker() {
    modalOverlay.style.display = "flex";
    modalSearch.value = "";
    loadCategory(currentCategory);
  }

  modalClose.addEventListener("click", function () {
    modalOverlay.style.display = "none";
  });

  modalOverlay.addEventListener("click", function (e) {
    if (e.target === modalOverlay) modalOverlay.style.display = "none";
  });

  // Category tab clicks
  categoryTabs.addEventListener("click", function (e) {
    const tab = e.target.closest(".cat-tab");
    if (!tab) return;
    document.querySelectorAll(".cat-tab").forEach(t => t.classList.remove("active"));
    tab.classList.add("active");
    currentCategory = tab.dataset.file;
    modalSearch.value = "";
    loadCategory(currentCategory);
  });

  // Search filter
  modalSearch.addEventListener("input", function () {
    renderExerciseGrid(filterExercises(modalSearch.value));
  });

  function loadCategory(file) {
    exerciseGrid.innerHTML = '<p class="loading-text">Loading exercises...</p>';
    fetch(`data/${file}.json`)
      .then(function (r) {
        if (!r.ok) throw new Error("Not found");
        return r.json();
      })
      .then(function (data) {
        allExercises = data;
        renderExerciseGrid(data);
      })
      .catch(function () {
        exerciseGrid.innerHTML = '<p class="loading-text">Could not load exercises.</p>';
      });
  }

  function filterExercises(query) {
    if (!query.trim()) return allExercises;
    const q = query.toLowerCase();
    return allExercises.filter(function (ex) {
      return ex.name.toLowerCase().includes(q);
    });
  }

  function renderExerciseGrid(exercises) {
    if (!exercises.length) {
      exerciseGrid.innerHTML = '<p class="loading-text">No exercises found.</p>';
      return;
    }
    exerciseGrid.innerHTML = exercises.map(function (ex) {
      const imgSrc = normalizeImagePath(ex.image);
      const imgEl  = imgSrc
        ? `<img src="${imgSrc}" alt="${ex.name}" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
           <div class="exercise-tile-placeholder" style="display:none;">💪</div>`
        : `<div class="exercise-tile-placeholder">💪</div>`;
      return `<div class="exercise-tile" data-name="${ex.name}"
                   data-muscles="${(ex.tags||[]).join(",") }"
                   data-image="${imgSrc}">
                ${imgEl}
                <div class="exercise-tile-name">${escapeHtml(ex.name)}</div>
              </div>`;
    }).join("");

    // Tile click → add card
    exerciseGrid.querySelectorAll(".exercise-tile").forEach(function (tile) {
      tile.addEventListener("click", function () {
        addExerciseCard({
          name:    tile.dataset.name,
          muscles: tile.dataset.muscles ? tile.dataset.muscles.split(",").filter(Boolean) : [],
          image:   tile.dataset.image
        });
        modalOverlay.style.display = "none";
      });
    });
  }

  /* ════════════════════════════════════════════
     EXERCISE CARDS
  ════════════════════════════════════════════ */

  function addExerciseCard(exercise) {
    const card = {
      id:       uid(),
      exercise: exercise,
      timerMin: 1,
      timerSec: 30,
      sets: [{ id: uid(), weight: "", reps: "" }]  // 1 default set
    };
    exerciseCards.push(card);
    renderCard(card);
  }

  function renderCard(card) {
    // Remove existing card DOM if re-rendering
    const existing = document.getElementById(`card-${card.id}`);
    if (existing) existing.remove();

    const imgSrc = normalizeImagePath(card.exercise.image);

    const imgEl = imgSrc
      ? `<img class="card-exercise-img" src="${imgSrc}" alt="${card.exercise.name}"
              onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
         <div class="card-exercise-img placeholder" style="display:none;">💪</div>`
      : `<div class="card-exercise-img placeholder">💪</div>`;

    const muscleTags = card.exercise.muscles
      .map(m => `<span class="muscle-tag">${m}</span>`)
      .join("");

    const setRows = card.sets.map(function (set, idx) {
      return `<tr data-set-id="${set.id}">
        <td class="set-number-cell">${idx + 1}</td>
        <td class="set-input-cell">
          <input class="set-input weight-input" type="number" min="0" placeholder="—"
                 value="${set.weight}" data-field="weight" data-set-id="${set.id}">
        </td>
        <td class="set-input-cell">
          <input class="set-input reps-input" type="number" min="0" placeholder="—"
                 value="${set.reps}" data-field="reps" data-set-id="${set.id}">
        </td>
        <td class="set-delete-cell">
          <button class="set-delete-btn" data-set-id="${set.id}" title="Remove set">✕</button>
        </td>
      </tr>`;
    }).join("");

    const el = document.createElement("div");
    el.className = "exercise-card";
    el.id = `card-${card.id}`;
    el.innerHTML = `
      <div class="card-top">
        ${imgEl}
        <div class="card-info">
          <p class="card-exercise-name">${card.exercise.name}</p>
          <div class="card-muscles">${muscleTags}</div>
          <div class="card-timer-row">
            <span class="timer-icon">⏱</span>
            <span class="card-timer-text">
              Rest Timer: <strong id="timer-display-${card.id}">${formatTimer(card.timerMin, card.timerSec)}</strong>
            </span>
            <button class="edit-timer-btn" data-card-id="${card.id}" title="Edit rest timer">✏️</button>
          </div>
        </div>
        <button class="card-delete-btn" data-card-id="${card.id}" title="Remove exercise">✕</button>
      </div>

      <table class="sets-table">
        <thead>
          <tr>
            <th>Set</th>
            <th>Weight (kg)</th>
            <th>Reps</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="sets-body-${card.id}">
          ${setRows}
        </tbody>
      </table>

      <button class="add-set-btn" data-card-id="${card.id}">+</button>
    `;

    exerciseList.appendChild(el);
    bindCardEvents(el, card);
  }

  function bindCardEvents(el, card) {

    // Delete entire card
    el.querySelector(".card-delete-btn").addEventListener("click", function () {
      el.style.animation = "none";
      el.style.opacity = "0";
      el.style.transform = "translateY(-8px)";
      el.style.transition = "opacity 0.2s, transform 0.2s";
      setTimeout(function () {
        el.remove();
        exerciseCards = exerciseCards.filter(c => c.id !== card.id);
      }, 200);
    });

    // Add set
    el.querySelector(".add-set-btn").addEventListener("click", function () {
      const newSet = { id: uid(), weight: "", reps: "" };
      card.sets.push(newSet);
      appendSetRow(card, newSet);
    });

    // Edit timer
    el.querySelector(".edit-timer-btn").addEventListener("click", function () {
      openTimerModal(card.id, card.timerMin, card.timerSec);
    });

    // Set inputs (delegation on tbody)
    const tbody = el.querySelector(`#sets-body-${card.id}`);
    tbody.addEventListener("input", function (e) {
      const inp = e.target;
      if (!inp.classList.contains("set-input")) return;
      const setId = inp.dataset.setId;
      const field = inp.dataset.field;
      const set   = card.sets.find(s => s.id === setId);
      if (set) set[field] = inp.value;
    });

    // Delete set row (delegation)
    tbody.addEventListener("click", function (e) {
      const btn = e.target.closest(".set-delete-btn");
      if (!btn) return;
      const setId = btn.dataset.setId;
      if (card.sets.length === 1) return; // keep at least 1 set
      card.sets = card.sets.filter(s => s.id !== setId);
      // Re-render sets inside card
      refreshSetsBody(card, tbody);
    });
  }

  /* Append a single new set row (no full re-render) */
  function appendSetRow(card, set) {
    const tbody = document.getElementById(`sets-body-${card.id}`);
    const idx   = card.sets.length; // 1-based index for display
    const tr    = document.createElement("tr");
    tr.dataset.setId = set.id;
    tr.innerHTML = `
      <td class="set-number-cell">${idx}</td>
      <td class="set-input-cell">
        <input class="set-input weight-input" type="number" min="0" placeholder="—"
               value="" data-field="weight" data-set-id="${set.id}">
      </td>
      <td class="set-input-cell">
        <input class="set-input reps-input" type="number" min="0" placeholder="—"
               value="" data-field="reps" data-set-id="${set.id}">
      </td>
      <td class="set-delete-cell">
        <button class="set-delete-btn" data-set-id="${set.id}" title="Remove set">✕</button>
      </td>
    `;
    tbody.appendChild(tr);
    // Focus first input of new row
    tr.querySelector(".weight-input").focus();
  }

  /* Re-render all set rows in-place (used after delete) */
  function refreshSetsBody(card, tbody) {
    tbody.innerHTML = card.sets.map(function (set, idx) {
      return `<tr data-set-id="${set.id}">
        <td class="set-number-cell">${idx + 1}</td>
        <td class="set-input-cell">
          <input class="set-input weight-input" type="number" min="0" placeholder="—"
                 value="${set.weight}" data-field="weight" data-set-id="${set.id}">
        </td>
        <td class="set-input-cell">
          <input class="set-input reps-input" type="number" min="0" placeholder="—"
                 value="${set.reps}" data-field="reps" data-set-id="${set.id}">
        </td>
        <td class="set-delete-cell">
          <button class="set-delete-btn" data-set-id="${set.id}" title="Remove set">✕</button>
        </td>
      </tr>`;
    }).join("");
  }


  function openTimerModal(cardId, mins, secs) {
    currentTimerCardId  = cardId;
    timerMinInput.value = mins;
    timerSecInput.value = secs;
    timerOverlay.style.display = "flex";
    timerMinInput.focus();
  }

  timerClose.addEventListener("click", function () {
    timerOverlay.style.display = "none";
  });

  timerOverlay.addEventListener("click", function (e) {
    if (e.target === timerOverlay) timerOverlay.style.display = "none";
  });

  saveTimerBtn.addEventListener("click", function () {
    const mins = clamp(parseInt(timerMinInput.value, 10) || 0, 0, 10);
    const secs = clamp(parseInt(timerSecInput.value, 10) || 0, 0, 59);

    const card = exerciseCards.find(c => c.id === currentTimerCardId);
    if (card) {
      card.timerMin = mins;
      card.timerSec = secs;
      // Update display in card
      const display = document.getElementById(`timer-display-${card.id}`);
      if (display) display.textContent = formatTimer(mins, secs);
    }
    timerOverlay.style.display = "none";
  });

  // Clamp on blur
  timerMinInput.addEventListener("blur", function () {
    timerMinInput.value = clamp(parseInt(timerMinInput.value)||0, 0, 10);
  });
  timerSecInput.addEventListener("blur", function () {
    timerSecInput.value = clamp(parseInt(timerSecInput.value)||0, 0, 59);
  });

  /* ════════════════════════════════════════════
     SAVE WORKOUT (localStorage)
  ════════════════════════════════════════════ */

  document.getElementById("btn-save-workout").addEventListener("click", function () {
    const title = workoutTitle.value.trim();
    if (!title) {
      workoutTitle.focus();
      return;
    }
    if (!exerciseCards.length) {
      alert("Add at least one exercise before saving.");
      return;
    }

    const payload = buildWorkoutPayload(title);
    const now = new Date().toISOString();

    if (currentWorkoutId) {
      const idx = savedWorkouts.findIndex(function (w) { return w.id === currentWorkoutId; });
      if (idx !== -1) {
        savedWorkouts[idx] = Object.assign({}, savedWorkouts[idx], payload, { updatedAt: now });
      }
    } else {
      currentWorkoutId = uid();
      savedWorkouts.unshift({
        id: currentWorkoutId,
        createdAt: now,
        updatedAt: now,
        name: payload.name,
        exercises: payload.exercises
      });
    }

    persistWorkouts();
    renderWorkoutList();
  });

/* ─── Init ─── */
loadWorkoutsFromStorage();
renderWorkoutList();

/* ─── Load from URL param ─── */
const urlParams = new URLSearchParams(window.location.search);
const idFromUrl = urlParams.get("id");
if (idFromUrl) loadWorkoutIntoBuilder(idFromUrl);

})();

