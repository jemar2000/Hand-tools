const profile = document.querySelector('.profile');
const navbar = document.querySelector('.navbar');

document.querySelector('#user-btn').onclick = () => {
   profile.classList.toggle('active');
   navbar.classList.remove('active');
};

document.querySelector('#menu-btn').onclick = () => {
   navbar.classList.toggle('active');
   profile.classList.remove('active');
};

window.onscroll = () => {
   profile.classList.remove('active');
   navbar.classList.remove('active');
};

const subImages = document.querySelectorAll('.sub-images img');
const mainImage = document.querySelector('.main-image img');

subImages.forEach(image => {
   image.onclick = () => {
      const src = image.getAttribute('src');
      mainImage.src = src;
   };
});
