// Language toggle
const langBtn = document.getElementById("langToggle");
let isEn = false;
langBtn.addEventListener("click", () => {
  isEn = !isEn;
  document.body.classList.toggle("en", isEn);
  langBtn.textContent = isEn ? "PT" : "EN";
});

// Reveal on scroll
const reveals = document.querySelectorAll(".reveal");
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) e.target.classList.add("visible");
    });
  },
  { threshold: 0.1 },
);
reveals.forEach((r) => observer.observe(r));

// Nav scroll effect
window.addEventListener("scroll", () => {
  document.getElementById("navbar").style.boxShadow =
    window.scrollY > 30 ? "0 2px 20px rgba(26,20,16,.08)" : "none";
});
