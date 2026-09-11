document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.nav-toggle');
  const navWrap = document.querySelector('.nav-wrap');
  if (toggle && navWrap) {
    toggle.addEventListener('click', () => navWrap.classList.toggle('open'));
  }

  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });
    revealEls.forEach((el) => observer.observe(el));
  } else {
    revealEls.forEach((el) => el.classList.add('in-view'));
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

  initHeroScene();
});

function initHeroScene() {
  const canvas = document.getElementById('hero-canvas');
  if (!canvas || typeof THREE === 'undefined') return;

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

  window.addEventListener('mousemove', (e) => {
    mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
    mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
  });

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
    shape.rotation.y = t * 0.12;
    shape.rotation.x = t * 0.06;
    shape.rotation.y += mouseX * 0.15;
    shape.rotation.x += mouseY * 0.1;

    renderer.render(scene, camera);
    requestAnimationFrame(animate);
  }
  animate();
}
