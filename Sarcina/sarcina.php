<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mindic - Satul Mîndic</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="sarcina.css">
</head>
<body>

<nav>
  <a href="#" class="nav-logo">
    <img src="sarcinaimg/LOGO.png" alt="Mindic Logo">
  </a>
  <ul class="nav-links">
    <li><a href="#">Acasa</a></li>
    <li><a href="#stiri">Stiri</a></li>
    <li><a href="#despre">Despre</a></li>
  </ul>
  <div class="nav-actions">
    <button class="btn-signup">Sign up</button>
    <button class="btn-login">Log In</button>
  </div>
</nav>

<section id="hero">
  <div class="hero-bg">
    <img src="sarcinaimg/BGIMAGE.png" alt="" class="bg-image">
  </div>
  <div class="hero-content">
    <p class="hero-subtitle">Bun venit la satul</p>
    <h1 class="hero-title">MINDIC</h1>
    <p class="hero-desc">Descopera adevaratul tezaur tăinuit de acest coltișor de rai.</p>
    <p class="hero-tagline">Trăiește o experiență de neuitat!</p>
    <a href="#despre" class="btn-despre">Despre</a>
  </div>
</section>

<section id="stiri">
  <h2 class="section-title reveal">ULTIMELE ȘTIRI</h2>

  <div class="newsMain-wrap reveal">
    <div class="newsMain">
      <a class="see-all">vezi toate</a>

      <div class="carousel-wrapper">
        <button class="carousel-btn prev" id="prevBtn">&#8249;</button>
        <div class="carousel-track-outer">
          <div class="carousel-track" id="carouselTrack">

            <div class="news-card">
              <img src="sarcinaimg/image1.png" alt="Revenirea lui Dorin Recean">
              <div class="news-card-body">
                <p>Revenirea lui Dorin Recean în satul de baștină</p>
                <button class="btn-vezi">Vezi</button>
              </div>
            </div>

            <div class="news-card">
              <img src="sarcinaimg/image2.png" alt="Vila Ohanovicz">
              <div class="news-card-body">
                <p>Vila Ohanovicz în 2024. Oportunități</p>
                <button class="btn-vezi">Vezi</button>
              </div>
            </div>

            <div class="news-card">
              <img src="sarcinaimg/image3.png" alt="Festivalul Portului Popular">
              <div class="news-card-body">
                <p>A șaptea ediție a festivalului "Portului Popular și al Pâinii"</p>
                <button class="btn-vezi">Vezi</button>
              </div>
            </div>

            <div class="news-card">
              <img src="sarcinaimg/image4.png" alt="Stire 4">
              <div class="news-card-body">
                <p>Eveniment cultural în satul Mîndic, ediția 2024</p>
                <button class="btn-vezi">Vezi</button>
              </div>
            </div>

            <div class="news-card">
              <img src="sarcinaimg/image5.png" alt="Stire 5">
              <div class="news-card-body">
                <p>Activități educaționale la liceul din Mîndic</p>
                <button class="btn-vezi">Vezi</button>
              </div>
            </div>

          </div>
        </div>
        <button class="carousel-btn next" id="nextBtn">&#8250;</button>
      </div>

    </div>
  </div>
</section>

<section id="despre">
  <h2 class="section-title reveal">DESPRE LOCALITATE</h2>
  <div class="despre-inner">
    <div class="despre-text reveal">
      <p>
        <strong>Satul Mîndic</strong> este o localitate în <a href="#">Raionul Drochia</a> situată la
        latitudinea 48.1511, longitudinea 27.7927 și altitudinea de 154 metri față de nivelul mării.
      </p>
      <p>
        Această localitate este în administrarea <a href="#">or. Drochia</a>.
        Conform recensământului din anul 2004 populația este de 3 402 locuitori.
      </p>
      <p>
        Distanța directă până în or. Drochia este de 12 km. Distanța
        directă până în or. Chișinău este de 163 km.
      </p>
      <button class="btn-legenda">Legenda</button>
    </div>

    <div class="despre-map reveal">
      <img class="map-img" src="sarcinaimg/Property 1=Default.png" alt="Harta Mîndic">
      <div class="map-shadow"></div>
      <a href="#" class="map-overlay"><span>View Full Map</span></a>
    </div>
  </div>
</section>

<script src="sarcina.js"></script>
</body>
</html>