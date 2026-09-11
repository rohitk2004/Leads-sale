// Mobile nav toggle
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.nav-toggle');
  const navWrap = document.querySelector('.nav-wrap');
  if (toggle && navWrap) {
    toggle.addEventListener('click', () => navWrap.classList.toggle('open'));
  }

  // Scroll reveal
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

  // 3D tilt effect on cards
  document.querySelectorAll('.tilt').forEach((card) => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const rotateX = ((y / rect.height) - 0.5) * -14;
      const rotateY = ((x / rect.width) - 0.5) * 14;
      card.style.transform = `perspective(700px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(700px) rotateX(0) rotateY(0) translateZ(0)';
    });
  });

  initHeroScene();
});

function initHeroScene() {
  const canvas = document.getElementById('hero-canvas');
  if (!canvas || typeof THREE === 'undefined') return;

  const hero = canvas.closest('.hero');
  let width = hero.clientWidth;
  let height = hero.clientHeight;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(50, width / height, 0.1, 1000);
  camera.position.z = 22;

  const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setSize(width, height);

  const group = new THREE.Group();
  scene.add(group);

  const geometries = [
    new THREE.IcosahedronGeometry(3, 0),
    new THREE.TorusKnotGeometry(2, 0.6, 100, 16),
    new THREE.OctahedronGeometry(2.4, 0),
    new THREE.DodecahedronGeometry(2, 0),
  ];

  const accentColors = [0x6c8cff, 0x7fe0c9, 0x6c8cff, 0x7fe0c9];
  const shapes = [];

  geometries.forEach((geo, i) => {
    const material = new THREE.MeshStandardMaterial({
      color: accentColors[i % accentColors.length],
      metalness: 0.4,
      roughness: 0.25,
      wireframe: i % 2 === 1,
    });
    const mesh = new THREE.Mesh(geo, material);
    mesh.position.set(
      (i - geometries.length / 2) * 6 + 3,
      Math.sin(i) * 3,
      -i * 2
    );
    group.add(mesh);
    shapes.push(mesh);
  });

  const ambient = new THREE.AmbientLight(0xffffff, 0.5);
  scene.add(ambient);
  const point1 = new THREE.PointLight(0x6c8cff, 2, 100);
  point1.position.set(10, 10, 10);
  scene.add(point1);
  const point2 = new THREE.PointLight(0x7fe0c9, 2, 100);
  point2.position.set(-10, -5, 10);
  scene.add(point2);

  let mouseX = 0;
  let mouseY = 0;

  hero.addEventListener('mousemove', (e) => {
    const rect = hero.getBoundingClientRect();
    mouseX = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
    mouseY = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
  });

  window.addEventListener('resize', () => {
    width = hero.clientWidth;
    height = hero.clientHeight;
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
  });

  const clock = new THREE.Clock();

  function animate() {
    const t = clock.getElapsedTime();
    shapes.forEach((mesh, i) => {
      mesh.rotation.x = t * 0.2 + i;
      mesh.rotation.y = t * 0.3 + i;
    });
    group.rotation.y += (mouseX * 0.3 - group.rotation.y) * 0.03;
    group.rotation.x += (mouseY * 0.2 - group.rotation.x) * 0.03;

    renderer.render(scene, camera);
    requestAnimationFrame(animate);
  }
  animate();
}
