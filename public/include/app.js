const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-visible');
        } else {
            entry.target.classList.remove('fade-in-visible');
        }
    });
});

const hiddenElements = document.querySelectorAll('.fade-in-hidden');
hiddenElements.forEach((el) => observer.observe(el));

    document.addEventListener('DOMContentLoaded', function() {
        // When the page is scrolled, show/hide the back-to-top button
        window.addEventListener("scroll", function() {
            var backToTopButton = document.querySelector('.back-to-top');
            if (backToTopButton) {
                if (window.scrollY > 200) {
                    backToTopButton.style.display = 'block';
                } else {
                    backToTopButton.style.display = 'none';
                }
            } else {
            }
        });

        // Smooth scrolling when the button is clicked
        var backToTopLink = document.querySelector('.back-to-top');
        if (backToTopLink) {
            backToTopLink.addEventListener('click', function(e) {
                e.preventDefault();
                console.log("Back to top link clicked."); // Debugging statement
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        } else {
        }
    });
