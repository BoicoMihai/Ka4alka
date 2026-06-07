<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mindic Header</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="sarcina.css" />
</head>
<body>
  <header class="site-header">
    <div class="header-inner">

      <a href="#" class="logo">
        <img src="sarcinaimg/LOGO.png">
      </a>

      <nav class="nav">
        <a href="#" class="nav-link">Acasă</a>
        <a href="#" class="nav-link">Știri</a>
        <a href="#" class="nav-link">Despre</a>
      </nav>

      <div class="auth-buttons">
        <a href="#" class="btn-signup">Sign up</a>
        <a href="#" class="btn-login">Log in</a>
      </div>

    </div>
  </header>

  <main class="hero" style="background-image: url('sarcinaimg/BGIMAGE.png');">
    <div class="hero-content">
      <p class="hero-tagline">BUN VENIT LA SATUL</p>
      <h1>MINDIC</h1>
      <p class="hero-description">Descoperă adevăratul tezaur tăinuit de acest colțșor de rai.</p>
      <p class="hero-highlight">Trăiește o experiență de neuitat!</p>
      <a href="#" class="btn btn-primary">Despre</a>
    </div>
  </main>
  <section class="news-section">
    <h2>ULTIMELE ȘTIRI</h2>
    <div class="news-top">
      <a href="#" class="view-all">Vezi toate</a>
    </div>

    <div class="carousel-wrapper">
      <button class="carousel-btn prev" aria-label="Previous">‹</button>

      <div class="carousel" aria-hidden="false">
        <div class="carousel-track">
          <!-- five placeholder items -->
          <article class="news-card">
            <div class="card-media"><img src="https://via.placeholder.com/420x300?text=1" alt=""></div>
            <div class="card-body">
              <p class="card-title">Revenirea lui Dorin Recean în satul de baştină</p>
              <a class="card-btn" href="#">Vezi</a>
            </div>
          </article>

          <article class="news-card">
            <div class="card-media"><img src="https://via.placeholder.com/420x300?text=2" alt=""></div>
            <div class="card-body">
              <p class="card-title">Vila Ohanovicz în 2024. Oportunităţi</p>
              <a class="card-btn" href="#">Vezi</a>
            </div>
          </article>

          <article class="news-card">
            <div class="card-media"><img src="https://via.placeholder.com/420x300?text=3" alt=""></div>
            <div class="card-body">
              <p class="card-title">A şaptea ediţie a festivalului „Portului Popular şi al Pâinii”</p>
              <a class="card-btn" href="#">Vezi</a>
            </div>
          </article>

          <article class="news-card">
            <div class="card-media"><img src="https://via.placeholder.com/420x300?text=4" alt=""></div>
            <div class="card-body">
              <p class="card-title">Eveniment local: Târgul meşterilor</p>
              <a class="card-btn" href="#">Vezi</a>
            </div>
          </article>

          <article class="news-card">
            <div class="card-media"><img src="https://via.placeholder.com/420x300?text=5" alt=""></div>
            <div class="card-body">
              <p class="card-title">Proiect comunitar: renovarea monumentului</p>
              <a class="card-btn" href="#">Vezi</a>
            </div>
          </article>

        </div>
      </div>

      <button class="carousel-btn next" aria-label="Next">›</button>
    </div>
  </section>

  <script>
    (function(){
      const track = document.querySelector('.carousel-track');
      const prev = document.querySelector('.carousel-btn.prev');
      const next = document.querySelector('.carousel-btn.next');
      const items = Array.from(track.children);
      let index = 0;

      function visibleCount(){
        return window.innerWidth < 720 ? 1 : 3;
      }

      function update(){
        const vis = visibleCount();
        const shift = (100/vis) * index;
        track.style.transform = `translateX(-${shift}%)`;
      }

      prev.addEventListener('click', ()=>{
        index = Math.max(0, index - 1);
        update();
      });

      next.addEventListener('click', ()=>{
        const vis = visibleCount();
        const maxIndex = Math.max(0, items.length - vis);
        index = Math.min(maxIndex, index + 1);
        update();
      });

      window.addEventListener('resize', ()=>{
        index = Math.min(index, Math.max(0, items.length - visibleCount()));
        setCardWidths();
        update();
      });

      function setCardWidths(){
        const vis = visibleCount();
        const perc = 100 / vis;
        items.forEach((it)=>{ it.style.flex = `0 0 ${perc}%`; });
      }

      setCardWidths();
      update();
    })();
  </script>

</body>
</html>