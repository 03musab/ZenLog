// Smooth scroll to the 'about' section when clicking 'Learn More'
document.getElementById('learn-more-btn').addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector('#about').scrollIntoView({ 
        behavior: 'smooth' 
    });
});
