// Mobile menu
function mobileMenuShow() {
  let mobileList = document.getElementById("mobile-menu-links");
  if (mobileList.style.display === "block") {
    mobileList.style.display = "none";
  } else {
    mobileList.style.display = "block";
  }
}

// Dropdown menu
function dropdownMenu() {
  let dropdownList = document.getElementById("dropdown-menu");
  if (dropdownList.style.display === "block") {
    dropdownList.style.display = "none";
  } else {
    dropdownList.style.display = "block";
  }
}

// Hero slideshow
let currentSlide = 0;
const slides = document.querySelectorAll(".slide")

const init = (n) => {
  slides.forEach((slide) => {
    slide.style.display = "none"
  })
  slides[n].style.display = "flex"
}
document.addEventListener("DOMContentLoaded", init(currentSlide))


const next = () => {
  currentSlide >= slides.length - 1 ? currentSlide = 0 : currentSlide++
  init(currentSlide)
}

const prev = () => {
  currentSlide <= 0 ? currentSlide = slides.length - 1 : currentSlide--
  init(currentSlide)
}

document.querySelector(".next").addEventListener('click', next)
document.querySelector(".prev").addEventListener('click', prev)

setInterval(() => {
  next()
}, 5000);