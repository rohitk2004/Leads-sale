// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    // Only prevent default if it's a hash link on the same page
    const href = this.getAttribute("href");
    if (href.startsWith("#") && href.length > 1) {
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    }
  });
});

// Animate elements on scroll
const observerOptions = {
  threshold: 0.1,
  rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add("animate-in");
      // Stop observing once animated
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

// Select all elements to animate
// Note: sold-lead-card also has class lead-card, so it's covered
document.addEventListener("DOMContentLoaded", () => {
  const elementsToAnimate = document.querySelectorAll(
    ".feature-card, .step-card, .lead-card, .review-card",
  );

  // If elements are already in view (e.g. on load), animate them immediately
  // or let observer handle it. Observer works on load too.

  elementsToAnimate.forEach((el) => {
    observer.observe(el);
  });
});
