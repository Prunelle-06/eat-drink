document.addEventListener('DOMContentLoaded', function() {
  // Animation des statistiques
  const statCards = document.querySelectorAll('.stat-card h3');
  
  function animateStats() {
    statCards.forEach(stat => {
      const target = parseInt(stat.getAttribute('data-count'));
      const duration = 2000;
      const step = target / (duration / 16);
      let current = 0;
      
      const counter = setInterval(() => {
        current += step;
        if (current >= target) {
          stat.textContent = target + (stat.getAttribute('data-count') === '98' ? '%' : '+');
          clearInterval(counter);
        } else {
          stat.textContent = Math.floor(current) + (stat.getAttribute('data-count') === '98' ? '%' : '+');
        }
      }, 16);
    });
  }
  
  const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateStats();
        statsObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });
  
  statsObserver.observe(document.querySelector('.stats-section'));
  
  // Fonctionnalités multi-utilisateurs
  const tabBtns = document.querySelectorAll('.tab-btn');
  const tabContents = document.querySelectorAll('.tab-content');
  
  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {

      tabBtns.forEach(b => b.classList.remove('active'));
      tabContents.forEach(c => c.classList.remove('active'));
      
      btn.classList.add('active');
      
      // Montre le contenu correspondant
      const tabId = btn.getAttribute('data-tab') + '-tab';
      document.getElementById(tabId).classList.add('active');
    });
  });
  
  // Section témoignages
  const testimonials = [
    {
      quote: "Cette plateforme a révolutionné notre participation aux événements culinaires. La gestion des commandes est incroyablement fluide.",
      name: "Marie D.",
      title: "Cheffe pâtissière - Douceurs Parisiennes"
    },
    {
      quote: "En tant que visiteur, j'ai pu découvrir des artisans exceptionnels et commander des produits uniques en quelques clics seulement.",
      name: "Pierre L.",
      title: "Food blogger - Saveurs du Monde"
    },
    {
      quote: "L'outil analytique nous a permis d'optimiser notre offre et de doubler nos ventes lors du dernier salon.",
      name: "Sophie M.",
      title: "Directrice - Vins & Terroirs"
    }
  ];
  
  const testimonialContainer = document.querySelector('.testimonial-slider');
  const dotsContainer = document.createElement('div');
  dotsContainer.className = 'slider-nav';
  
  testimonials.forEach((_, index) => {
    const dot = document.createElement('div');
    dot.className = 'slider-dot' + (index === 0 ? ' active' : '');
    dot.addEventListener('click', () => showTestimonial(index));
    dotsContainer.appendChild(dot);
  });
  
  testimonialContainer.appendChild(dotsContainer);
  
  let currentTestimonial = 0;
  
  function showTestimonial(index) {
    currentTestimonial = index;
    const testimonial = testimonials[index];
    
    testimonialContainer.innerHTML = `
      <div class="testimonial-card">
        <div class="testimonial-content">
          <p>${testimonial.quote}</p>
        </div>
        <div class="testimonial-author">
          <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiByeD0iNTAiIGZpbGw9IiNFNUU3RUIiLz4KPHN2ZyB4PSIyNSIgeT0iMjUiIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cGF0aCBkPSJNMTIgMTJDMTQuMjA5MSAxMiAxNiA5Ljc2MTQyIDE2IDdDMTYgNC4yMzg1OCAxNC4yMDkxIDIgMTIgMkM5Ljc5MDg2IDIgOCA0LjIzODU4IDggN0M4IDkuNzYxNDIgOS43OTA4NiAxMiAxMiAxMlpNMTIgMTRDOC42ODYyOSAxNCA2IDE2LjY4NjMgNiAyMEg2VjIySDdWMjBDNyAxNy43OTA5IDkuNzkwODYgMTUgMTIgMTVDMTQuMjA5MSAxNSAxNyAxNy43OTA5IDE3IDIwVjIySDI0VjIwQzE4IDE2LjY4NjMgMTUuMzEzNyAxNCAxMiAxNFoiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+Cjwvc3ZnPgo=" alt="${testimonial.name}">
          <div>
            <h4>${testimonial.name}</h4>
            <span>${testimonial.title}</span>
          </div>
        </div>
      </div>
    `;
    
    testimonialContainer.appendChild(dotsContainer);
    
    const dots = document.querySelectorAll('.slider-dot');
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
  }
  
  // Rotation automatique des temoignages
  setInterval(() => {
    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
    showTestimonial(currentTestimonial);
  }, 5000);
  
  showTestimonial(0);
  
  // Animation sur le defilement
  const featureCards = document.querySelectorAll('.feature-card');
  
  const featureObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.style.opacity = 1;
          entry.target.style.transform = 'translateY(0)';
        }, index * 150);
      }
    });
  }, { threshold: 0.1 });
  
  featureCards.forEach(card => {
    card.style.opacity = 0;
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    featureObserver.observe(card);
  });
});    