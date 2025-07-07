document.addEventListener('DOMContentLoaded', function() {
    // Animación de Reveal on Scroll
    const revealElements = document.querySelectorAll('.reveal');

    const revealOnScroll = () => {
        revealElements.forEach(el => {
            const elTop = el.getBoundingClientRect().top;
            const elBottom = el.getBoundingClientRect().bottom;
            const windowHeight = window.innerHeight;

            // Si el elemento está visible en la ventana
            if (elTop < windowHeight - 100 && elBottom > 0) {
                el.classList.add('active');
            } else {
                // Opcional: Remover la clase para que se oculte al salir de la vista (si quieres un re-reveal)
                // el.classList.remove('active');
            }
        });
    };

    // Ejecutar al cargar y al hacer scroll
    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll(); // Ejecutar al inicio para los elementos ya visibles

    // Botón de Volver Arriba (Scroll to Top)
    const scrollToTopBtn = document.getElementById('scrollToTopBtn');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) { // Muestra el botón después de 300px de scroll
            scrollToTopBtn.style.display = 'block';
        } else {
            scrollToTopBtn.style.display = 'none';
        }
    });

    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Desplazamiento suave
        });
    });

    // Desplazamiento suave a secciones al hacer clic en los enlaces del nav
    document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            // Usa el ID de la sección directamente
            const targetId = this.getAttribute('href');
            document.querySelector(targetId).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

});