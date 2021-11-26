let menuToggle = document.querySelector('.toggle');
let navigation = document.querySelector('.navigation');
let profiles = document.querySelector('.profiles')
menuToggle.addEventListener("click", function() {
    menuToggle.classList.toggle('active')
    navigation.classList.toggle('active')
    profiles.classList.toggle('active')
})

const list = document.querySelectorAll('.list');

function activeLink() {
    list.forEach((item) =>
        item.classList.remove('active'));
    this.classList.add('active');
}
list.forEach((item) =>
    item.addEventListener('click', activeLink));