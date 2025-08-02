const hamburger = document.querySelector('.hamburger');
const menu = document.querySelector('.menu');

hamburger.addEventListener('click', () => {
  menu.classList.toggle('collapsed');
});
const sliderWrapper = document.querySelector('.slider-wrapper');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

let currentIndex = 0;
const totalVideos = sliderWrapper.children.length;

function updateSlider() {
  sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
}

prevBtn.addEventListener('click', () => {
  currentIndex = (currentIndex === 0) ? totalVideos - 1 : currentIndex - 1;
  updateSlider();
});

nextBtn.addEventListener('click', () => {
  currentIndex = (currentIndex === totalVideos - 1) ? 0 : currentIndex + 1;
  updateSlider();
});
const brandSelect = document.getElementById('brandSelect');
  const modelSelect = document.getElementById('modelSelect');

  const modelsByBrand = {
    bmw: ['3 Serisi', '5 Serisi', 'X1', 'X5'],
    mercedes: ['A Serisi', 'C Serisi', 'E Serisi', 'GLA'],
    audi: ['A3', 'A4', 'Q3', 'Q5']
  };

  brandSelect.addEventListener('change', () => {
    const brand = brandSelect.value;
    modelSelect.innerHTML = '<option value="">Tümü</option>';

    if (brand && modelsByBrand[brand]) {
      modelsByBrand[brand].forEach(model => {
        const option = document.createElement('option');
        option.value = model.toLowerCase().replace(/\s+/g, '-');
        option.textContent = model;
        modelSelect.appendChild(option);
      });
      modelSelect.disabled = false;
    } else {
      modelSelect.disabled = true;
    }
  });

  document.querySelectorAll('.car-card').forEach(card => {
    const images = card.querySelectorAll('.slider img');
    const nextBtn = card.querySelector('.next');
    const prevBtn = card.querySelector('.prev');
    let current = 0;

    nextBtn.addEventListener('click', () => {
      images[current].classList.remove('active');
      current = (current + 1) % images.length;
      images[current].classList.add('active');
    });

    prevBtn.addEventListener('click', () => {
      images[current].classList.remove('active');
      current = (current - 1 + images.length) % images.length;
      images[current].classList.add('active');
    });
  });
const searchBtn = document.getElementById('searchBtn');
const searchInput = document.getElementById('searchInput');

searchBtn.addEventListener('click', () => {
  if(searchInput.style.display === 'none' || searchInput.style.display === '') {
    searchInput.style.display = 'inline-block';
    searchInput.focus();
  } else {
    searchInput.style.display = 'none';
  }
});
searchBtn.addEventListener('click', () => {
  searchInput.classList.toggle('show');
  if(searchInput.classList.contains('show')) {
    searchInput.focus();
  }
});

  document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.getElementById("searchBtn");
    const searchInput = document.getElementById("searchInput");

    searchBtn.addEventListener("click", function () {
      if (searchInput.style.display === "none" || searchInput.style.display === "") {
        searchInput.style.display = "inline-block";
        searchInput.focus();
      } else {
        searchInput.style.display = "none";
      }
    });
  });