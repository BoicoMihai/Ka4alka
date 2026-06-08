// ── CAROUSEL ──
let current = 0;
const VISIBLE = 3;

const track = document.getElementById('carouselTrack');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

function getCards() {
  return document.querySelectorAll('.news-card');
}

function updateCarousel() {
  const cards = getCards();
  const maxIndex = cards.length - VISIBLE;
  const cardWidth = cards[0].offsetWidth + 24; 
  track.style.transform = `translateX(-${current * cardWidth}px)`;
  prevBtn.style.opacity = current === 0 ? '0.3' : '1';
  nextBtn.style.opacity = current >= maxIndex ? '0.3' : '1';
}

function slide(dir) {
  const cards = getCards();
  const maxIndex = cards.length - VISIBLE;
  current = Math.max(0, Math.min(current + dir, maxIndex));
  updateCarousel();
}

prevBtn.addEventListener('click', () => slide(-1));
nextBtn.addEventListener('click', () => slide(1));

window.addEventListener('resize', () => updateCarousel());

// init button opacity
updateCarousel();


// ── SCROLL REVEAL ──
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));