document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.nav-toggle');
  const navWrap = document.querySelector('.nav-wrap');
  if (toggle && navWrap) {
    toggle.addEventListener('click', () => navWrap.classList.toggle('open'));
    navWrap.querySelectorAll('.nav a').forEach((link) => {
      link.addEventListener('click', () => navWrap.classList.remove('open'));
    });
  }

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && !reduceMotion) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
          startCounters(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });
    revealEls.forEach((el) => observer.observe(el));
  } else {
    revealEls.forEach((el) => el.classList.add('in-view'));
    document.querySelectorAll('.counter').forEach(finishCounter);
  }

  document.querySelectorAll('.service-head').forEach((head) => {
    head.addEventListener('click', () => {
      const item = head.closest('.service-item');
      const wasActive = item.classList.contains('active');
      item.parentElement.querySelectorAll('.service-item').forEach((el) => el.classList.remove('active'));
      if (!wasActive) item.classList.add('active');
    });
  });

  const track = document.querySelector('.testimonial-track');
  const prevBtn = document.querySelector('.t-prev');
  const nextBtn = document.querySelector('.t-next');
  if (track && prevBtn && nextBtn) {
    const scrollAmount = () => track.querySelector('.testimonial-card').offsetWidth + 24;
    prevBtn.addEventListener('click', () => track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' }));
    nextBtn.addEventListener('click', () => track.scrollBy({ left: scrollAmount(), behavior: 'smooth' }));
  }

  initScrollProgress();
  initTilt();
  initHeroScene(reduceMotion);
});

function initScrollProgress() {
  const bar = document.querySelector('.scroll-progress');
  if (!bar) return;
  const update = () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const pct = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    bar.style.width = pct + '%';
  };
  window.addEventListener('scroll', update, { passive: true });
  update();
}

function finishCounter(el) {
  const target = parseFloat(el.dataset.count || '0');
  const suffix = el.dataset.suffix || '';
  el.textContent = target + suffix;
}

function startCounters(root) {
  const counters = root.matches && root.matches('.counter')
    ? [root]
    : root.querySelectorAll
      ? root.querySelectorAll('.counter')
      : [];
  counters.forEach((el) => {
    const target = parseFloat(el.dataset.count || '0');
    const suffix = el.dataset.suffix || '';
    const duration = 1200;
    const start = performance.now();

    function tick(now) {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const value = Math.round(target * eased);
      el.textContent = value + suffix;
      if (progress < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  });
}

function initTilt() {
  document.querySelectorAll('.tilt-card').forEach((card) => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const rotateX = ((y / rect.height) - 0.5) * -8;
      const rotateY = ((x / rect.width) - 0.5) * 8;
      card.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(4px)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(800px) rotateX(0) rotateY(0) translateZ(0)';
    });
  });
}

function initHeroScene(reduceMotion) {
  const canvas = document.getElementById('hero-canvas');
  if (!canvas || typeof THREE === 'undefined' || reduceMotion) return;

  const hero = canvas.closest('.hero');
  let width = canvas.clientWidth;
  let height = canvas.clientHeight;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
  camera.position.z = 9;

  const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setSize(width, height);

  const geometry = new THREE.IcosahedronGeometry(2.6, 1);
  const material = new THREE.MeshBasicMaterial({
    color: 0xf2f2f0,
    wireframe: true,
    transparent: true,
    opacity: 0.4,
  });
  const shape = new THREE.Mesh(geometry, material);
  scene.add(shape);

  let mouseX = 0;
  let mouseY = 0;
  let scrollFactor = 0;

  window.addEventListener('mousemove', (e) => {
    mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
    mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
  });

  window.addEventListener('scroll', () => {
    scrollFactor = window.scrollY * 0.001;
  }, { passive: true });

  window.addEventListener('resize', () => {
    width = canvas.clientWidth;
    height = canvas.clientHeight;
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
  });

  const clock = new THREE.Clock();

  function animate() {
    const t = clock.getElapsedTime();
    shape.rotation.y = t * 0.12 + scrollFactor;
    shape.rotation.x = t * 0.06 + scrollFactor * 0.6;
    shape.rotation.y += mouseX * 0.15;
    shape.rotation.x += mouseY * 0.1;

    renderer.render(scene, camera);
    requestAnimationFrame(animate);
  }
  animate();
}
