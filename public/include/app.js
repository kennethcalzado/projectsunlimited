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
