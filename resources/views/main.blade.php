@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center hero-content-wrapper">
            <div class="col-lg-6 hero-text-content">
                <div class="hero-content-inner">
                    <h1 class="display-4 fw-bold mb-4">BIENVENIDO A INSTITUTO RESILIENCIA</h1>
                    <p class="lead mb-4">Tu plataforma educativa para aprender, avanzar y lograr tus metas.</p>
                    <div class="d-flex gap-3 flex-wrap justify-content-center">
                        <a href="{{ route('store') }}" class="btn btn-primary btn-lg">Explorar Cursos</a>
                        <a href="{{ route('information.index') }}" class="btn btn-outline-primary btn-lg">Más Información</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Imagen normal para desktop -->
                <div class="text-center d-none d-lg-block">
                    <img src="{{ asset('images/escuela.jpg') }}" alt="Instituto Resiliencia" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fondo para móvil que ocupa toda la sección -->
    <div class="mobile-hero-background d-lg-none"></div>
</section>

<!-- Misión y Visión Section -->
<section class="mission-vision py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">NUESTRA MISIÓN Y VISIÓN</h2>
            <p class="lead">Comprometidos con tu crecimiento educativo</p>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="mission-vision-card text-center p-4 rounded shadow-lg h-100">
                    <i class="bi bi-bullseye display-4 mb-3 mission-icon"></i>
                    <h3 class="h4 fw-bold mb-3 mission-title">Misión</h3>
                    <p class="mission-text">
                        Formar profesionales resilientes capaces de adaptarse a los cambios 
                        y transformar desafíos en oportunidades mediante educación de calidad 
                        accesible para todos.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="mission-vision-card text-center p-4 rounded shadow-lg h-100">
                    <i class="bi bi-eye display-4 mb-3 vision-icon"></i>
                    <h3 class="h4 fw-bold mb-3 vision-title">Visión</h3>
                    <p class="vision-text">
                        Ser el instituto líder en educación digital, reconocido por formar 
                        la próxima generación de profesionales que impulsarán el desarrollo 
                        y la innovación en nuestra sociedad.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Características Section -->
<section class="features py-5">
    <div class="container">
        <h2 class="display-5 fw-bold text-center mb-5">¿POR QUÉ ELEGIRNOS?</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-award display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">CAPACITACIÓN</h4>
                    <p class="feature-text">
                        Programas educativos diseñados por expertos con metodologías 
                        innovadoras y contenido actualizado.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-currency-dollar display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">PRECIO</h4>
                    <p class="feature-text">
                        Educación de calidad a precios accesibles con diferentes planes 
                        de pago y becas disponibles.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-clock display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">TIEMPO</h4>
                    <p class="feature-text">
                        Flexibilidad horaria total. Aprende a tu propio ritmo sin comprometer 
                        tus otras responsabilidades.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonios Section -->
<section class="testimonials py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="Testimonials-title-intro">Testimonios de nuestros Ex-Alumnos</h2>
            <p class="lead">Descubre las experiencias de quienes ya han vivido el proceso de aprendizaje con nosotros</p>
        </div>
        
        <div class="testimonials-container">
            <div class="swiper testimonials-swiper">
                <div class="swiper-wrapper">
                    <!-- Testimonio 1 -->
                    <div class="swiper-slide">
                        <div class="testimonial-content">
                            <div class="testimonial-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h3 class="testimonial-name">Sarah Price</h3>
                            <p class="testimonial-title">Benemerita Universidad Autonoma de Puebla</p>
                            <p class="testimonial-quote">El curso cumplió al 100% con las expectativas.</p>
                        </div>
                    </div>

                    <!-- Testimonio 2 -->
                    <div class="swiper-slide">
                        <div class="testimonial-content">
                            <div class="testimonial-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h3 class="testimonial-name">Carlos Martínez</h3>
                            <p class="testimonial-title">Ingeniero en Sistemas</p>
                            <p class="testimonial-quote">La metodología de enseñanza es excepcional. Pude aplicar inmediatamente lo aprendido en mi trabajo.</p>
                        </div>
                    </div>

                    <!-- Testimonio 3 -->
                    <div class="swiper-slide">
                        <div class="testimonial-content">
                            <div class="testimonial-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h3 class="testimonial-name">Ana García</h3>
                            <p class="testimonial-title">Diseñadora Gráfica</p>
                            <p class="testimonial-quote">Los cursos son muy completos y los instructores tienen un conocimiento profundo de los temas.</p>
                        </div>
                    </div>

                    <!-- Testimonio 4 -->
                    <div class="swiper-slide">
                        <div class="testimonial-content">
                            <div class="testimonial-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h3 class="testimonial-name">Miguel Ángel</h3>
                            <p class="testimonial-title">Estudiante de Maestría</p>
                            <p class="testimonial-quote">La flexibilidad horaria me permitió compaginar mis estudios con mi trabajo a tiempo completo.</p>
                        </div>
                    </div>

                    <!-- Testimonio 5 -->
                    <div class="swiper-slide">
                        <div class="testimonial-content">
                            <div class="testimonial-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h3 class="testimonial-name">Laura Sánchez</h3>
                            <p class="testimonial-title">Profesora Universitaria</p>
                            <p class="testimonial-quote">El material de estudio es excelente y muy bien estructurado. Totalmente recomendado.</p>
                        </div>
                    </div>
                </div>
                <!-- Botones y paginación -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div> 
        </div>
    </div>
</section>

<!-- Preguntas Frecuentes Section -->
<section class="faq py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="faq-title">Preguntas Frecuentes</h2>
            <p class="lead">Resolvemos tus dudas más comunes</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Cómo puedo inscribirme a un curso?
                            <span class="icon">▾</span>
                        </div>
                        <div class="accordion-content">
                            Para inscribirte a un curso, simplemente visita nuestra tienda, selecciona el curso de tu interés y haz clic en "Comprar". 
                            Podrás acceder al curso inmediatamente después de completar el proceso de pago.
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Los cursos tienen certificación?
                            <span class="icon">▾</span>
                        </div>
                        <div class="accordion-content">
                            Sí, todos nuestros cursos incluyen un certificado digital de finalización que puedes descargar 
                            una vez que completes todos los módulos y actividades del curso.
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Qué métodos de pago aceptan?
                            <span class="icon">▾</span>
                        </div>
                        <div class="accordion-content">
                            Aceptamos tarjetas de crédito y débito, PayPal y transferencias bancarias. También ofrecemos 
                            planes de pago para algunos de nuestros programas más extensos.
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Puedo acceder al contenido desde mi móvil?
                            <span class="icon">▾</span>
                        </div>
                        <div class="accordion-content">
                            Sí, nuestra plataforma es completamente responsive y puedes acceder a todos los cursos 
                            desde cualquier dispositivo: computadora, tablet o smartphone.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="h2 fw-bold mb-3">¿Listo para comenzar tu journey educativo?</h3>
                <p class="mb-0">Únete a miles de estudiantes que ya están transformando su futuro con nosotros.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('store') }}" class="btn btn-cta btn-lg">Inscribirse Ahora</a>
            </div>
        </div>
    </div>
</section>

<!-- Incluir Swiper JS y CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
.hero-section {
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
    position: relative;
    overflow: hidden;
}

/* Contenedor de fondo para móvil - OCUPA TODA LA SECCIÓN */
.mobile-hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("{{ asset('images/escuela.jpg') }}");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 0;
}

/* Overlay oscuro directo en el fondo móvil */
.mobile-hero-background::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Overlay negro al 50% */
    z-index: 1;
}

/* Asegurar que el contenido esté por encima */
.hero-section .container {
    position: relative;
    z-index: 2;
    height: 100%;
}

.hero-content-wrapper {
    position: relative;
    z-index: 3;
    height: 100%;
}

/* Contenedor interno para mejor centrado */
.hero-content-inner {
    width: 100%;
}

/* Ajustes para móvil - CONTENIDO CENTRADO */
@media (max-width: 991.98px) {
    .hero-section {
        min-height: 80vh;
        display: flex;
        align-items: center;
        background: none !important; /* Remover el gradiente en móvil */
    }
    
    .hero-text-content {
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
    }
    
    .hero-content-inner {
        max-width: 100%;
    }
    
    .hero-section h1,
    .hero-section p {
        color: white !important;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }
    
    .hero-section .btn-primary {
        background-color: rgba(255, 255, 255, 0.9);
        color: #000;
        border: none;
    }
    
    .hero-section .btn-outline-primary {
        background-color: transparent;
        color: white;
        border: 2px solid white;
    }
    
    .hero-section .btn-outline-primary:hover {
        background-color: white;
        color: #000;
    }
    
    /* Centrar los botones */
    .justify-content-center {
        justify-content: center !important;
    }
}

/* Ajustes adicionales para móviles pequeños */
@media (max-width: 576px) {
    .hero-section {
        min-height: 70vh;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
    
    .hero-text-content {
        min-height: 65vh;
        padding: 0 1rem;
    }
    
    .hero-section h1.display-4 {
        font-size: 2rem;
        margin-bottom: 1.5rem !important;
    }
    
    .hero-section .lead {
        font-size: 1.1rem;
        margin-bottom: 2rem !important;
    }
    
    .hero-section .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        margin: 0.25rem;
    }
    
    .mobile-hero-background {
        background-position: center 30%;
    }
    
    /* Asegurar que los botones se apilen en móviles muy pequeños */
    .d-flex.flex-wrap {
        flex-direction: column;
        align-items: center;
    }
    
    .d-flex.flex-wrap .btn {
        width: 100%;
        max-width: 250px;
        margin-bottom: 0.5rem;
    }
}

/* Para tablets */
@media (max-width: 768px) and (min-width: 576px) {
    .hero-section {
        min-height: 75vh;
    }
    
    .hero-text-content {
        min-height: 70vh;
    }
    
    .hero-content-inner {
        max-width: 90%;
        margin: 0 auto;
    }
}

/* Para modo oscuro en móvil */
body.dark-mode .mobile-hero-background::after {
    background: rgba(0, 0, 0, 0.6); /* Overlay más oscuro en modo oscuro */
}

/* Asegurar que en desktop se vea normal */
@media (min-width: 992px) {
    .mobile-hero-background {
        display: none;
    }
    
    .hero-section {
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
    }
    
    .hero-section h1,
    .hero-section p {
        color: inherit;
        text-shadow: none;
    }
    
    .hero-text-content {
        text-align: left;
        display: block;
        min-height: auto;
    }
    
}

/* Asegurar que los botones mantengan sus estilos en desktop */
@media (min-width: 992px) {
    .hero-section .btn-primary {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }
    
    .hero-section .btn-outline-primary {
        background-color: transparent;
        color: var(--btn-outline-text);
        border-color: var(--btn-outline-border);
    }
    
    .hero-section .btn-outline-primary:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
    }
}

/* Misión y Visión */
.mission-vision-card {
    background-color: var(--light-base);
    color: var(--text-primary);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

/* Para modo oscuro */
body.dark-mode .mission-vision-card {
    background-color: var(--dark-300);
    color: var(--text-primary);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
}

.mission-icon, .vision-icon {
    color: var(--btn-primary-bg);
}

.mission-title, .vision-title {
    color: inherit;
}

.mission-text, .vision-text {
    color: inherit;
    opacity: 0.9;
}

.mission-vision-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
}

/* Asegurar que el hover funcione correctamente en ambos modos */
body.light-mode .mission-vision-card:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

body.dark-mode .mission-vision-card:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.4) !important;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .mission-vision-card {
        padding: 2rem 1.5rem !important;
        margin-bottom: 1.5rem;
    }
}

@media (max-width: 576px) {
    .mission-vision-card {
        padding: 1.5rem 1rem !important;
        margin-bottom: 1rem;
    }
}

/* Características */
.feature-card {
    background-color: var(--light-base);
    color: var(--text-primary);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

/* Para modo oscuro */
body.dark-mode .feature-card {
    background-color: var(--dark-300);
    color: var(--text-primary);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
}

.feature-icon-svg {
    color: var(--btn-primary-bg);
}

.feature-title {
    color: inherit;
}

.feature-text {
    color: inherit;
    opacity: 0.9;
}

.feature-icon {
    transition: transform 0.3s ease;
}

.feature-icon:hover {
    transform: scale(1.1);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
}

body.light-mode .feature-card:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

body.dark-mode .feature-card:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.4) !important;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .feature-card {
        padding: 2rem 1.5rem !important;
        margin-bottom: 1.5rem;
    }
}

@media (max-width: 576px) {
    .feature-card {
        padding: 1.5rem 1rem !important;
        margin-bottom: 1rem;
    }
}

/* Testimonios - Estilo Swiper */
.testimonials {
    background-color: var(--bg-secondary);
}

.testimonials-container {
    width: 90%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px 20px;
}

.Testimonials-title-intro {
    font-family: "Lato", sans-serif;
    text-align: center;
    font-weight: bold;
    font-size: 30px;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.swiper {
    padding: 30px 0;
}

/* Modo Claro */
body.light-mode .swiper-slide {
    background-color: var(--light-base);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

body.light-mode .testimonial-content {
    color: var(--text-primary);
}

body.light-mode .testimonial-name {
    color: var(--text-primary);
}

body.light-mode .testimonial-quote {
    color: var(--text-secondary);
}

body.light-mode .swiper-button-next,
body.light-mode .swiper-button-prev {
    color: var(--text-primary);
    background: var(--light-base);
    border: 1px solid var(--border-color);
}

body.light-mode .swiper-button-next:hover,
body.light-mode .swiper-button-prev:hover {
    background: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

body.light-mode .swiper-pagination-bullet {
    background: var(--light-400);
}

body.light-mode .swiper-pagination-bullet-active {
    background: var(--btn-primary-bg);
}

/* Modo Oscuro */
body.dark-mode .swiper-slide {
    background-color: var(--dark-300);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

body.dark-mode .testimonial-content {
    color: var(--text-primary);
}

body.dark-mode .testimonial-name {
    color: var(--text-primary);
}

body.dark-mode .testimonial-quote {
    color: var(--text-secondary);
}

body.dark-mode .swiper-button-next,
body.dark-mode .swiper-button-prev {
    color: var(--text-primary);
    background: var(--dark-300);
    border: 1px solid var(--border-color);
}

body.dark-mode .swiper-button-next:hover,
body.dark-mode .swiper-button-prev:hover {
    background: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

body.dark-mode .swiper-pagination-bullet {
    background: var(--dark-500);
}

body.dark-mode .swiper-pagination-bullet-active {
    background: var(--btn-primary-bg);
}

/* Estilos comunes para ambos modos */
.swiper-slide {
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    padding: 40px 30px;
    width: 360px;
    opacity: 0.5;
    transform: scale(0.9);
    transition: all 0.4s ease;
}

.swiper-slide-active {
    opacity: 1;
    transform: scale(1);
    z-index: 10;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
}

.testimonial-content {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.testimonial-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    border: 4px solid var(--border-color);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    font-size: 2rem;
}

.bi-person-fill{
    alight-items: center;
    justify-content: center;
    margin: auto;
}

.testimonial-name {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 5px;
    text-transform: uppercase;
}

.testimonial-title {
    color: var(--btn-primary-bg);
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 20px;
}

.testimonial-quote {
    font-size: 16px;
    line-height: 1.6;
    font-style: italic;
}

.swiper-button-next,
.swiper-button-prev {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    transform: translateY(-50%);
    transition: all 0.3s ease;
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 20px;
    font-weight: bold;
}

.swiper-pagination {
    margin-top: 40px;
    text-align: center;
    position: relative;
    bottom: 0;
}

.swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    opacity: 1;
    transition: all 0.3s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .Testimonials-title-intro {
        font-size: 24px;
    }
    
    .swiper-slide {
        width: 280px;
        padding: 30px 20px;
    }
    
    .testimonial-avatar {
        width: 80px;
        height: 80px;
        font-size: 1.5rem;
    }
    
    .testimonial-name {
        font-size: 16px;
    }
    
    .testimonial-quote {
        font-size: 14px;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        width: 40px;
        height: 40px;
    }
    
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .testimonials-container {
        padding: 20px 10px;
    }
    
    .swiper-slide {
        width: 250px;
        padding: 25px 15px;
    }
}

/* Preguntas Frecuentes - Acordeón Personalizado */
.faq {
    background-color: var(--bg-secondary);
}

.faq-title {
    font-family: 'Lato', sans-serif;
    text-align: center;
    font-size: 2rem;
    margin-bottom: 2rem;
    color: var(--text-primary);
}

.accordion {
    max-width: 800px;
    margin: 0 auto;
}

/* Modo Claro */
body.light-mode .accordion-item {
    background-color: var(--light-base);
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

body.light-mode .accordion-header {
    background-color: var(--light-base);
    color: var(--text-primary);
}

body.light-mode .accordion-header:hover {
    background-color: var(--light-100);
}

body.light-mode .accordion-header.active {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

body.light-mode .accordion-content {
    background-color: var(--light-50);
    color: var(--text-primary);
}

/* Modo Oscuro */
body.dark-mode .accordion-item {
    background-color: var(--dark-300);
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

body.dark-mode .accordion-header {
    background-color: var(--dark-300);
    color: var(--text-primary);
}

body.dark-mode .accordion-header:hover {
    background-color: var(--dark-400);
}

body.dark-mode .accordion-header.active {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

body.dark-mode .accordion-content {
    background-color: var(--dark-200);
    color: var(--text-primary);
}

/* Estilos comunes para ambos modos */
.accordion-item {
    border-radius: 8px;
    margin-bottom: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.accordion-header {
    padding: 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: 'Lato', sans-serif;
    font-weight: bold;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.accordion-header .icon {
    transition: transform 0.3s ease;
    font-size: 1.2rem;
}

.accordion-header.active .icon {
    transform: rotate(180deg);
}

.accordion-content {
    padding: 0 1.5rem;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
    font-family: 'Noto Serif', serif;
    font-weight: lighter;
    line-height: 1.6;
}

.accordion-content.active {
    max-height: 300px;
    padding: 1rem 1.5rem 1.5rem;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .faq-title {
        font-size: 1.75rem;
    }
    
    .accordion-header {
        padding: 1.25rem;
        font-size: 1rem;
    }
    
    .accordion-content {
        padding: 0 1.25rem;
    }
    
    .accordion-content.active {
        padding: 1rem 1.25rem 1.25rem;
    }
}

@media (max-width: 576px) {
    .faq-title {
        font-size: 1.5rem;
    }
    
    .accordion-header {
        padding: 1rem;
        font-size: 0.95rem;
    }
    
    .accordion-content {
        padding: 0 1rem;
    }
    
    .accordion-content.active {
        padding: 0.75rem 1rem 1rem;
    }
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, var(--btn-primary-bg) 0%, var(--light-700) 100%);
    color: var(--btn-primary-text);
}

.btn-cta {
    background-color: var(--btn-primary-text);
    color: var(--btn-primary-bg);
    border: 2px solid var(--btn-primary-text);
    font-weight: 600;
}

.btn-cta:hover {
    background-color: transparent;
    color: var(--btn-primary-text);
    border-color: var(--btn-primary-text);
    transform: translateY(-2px);
}

/* Ajustes responsivos MEJORADOS */
@media (max-width: 768px) {
    .hero-section .display-4 {
        font-size: 2rem;
    }
    
    .d-flex.gap-3 {
        gap: 1rem !important;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    /* Más espacio para las cards en móvil */
    .feature-card,
    .mission-vision-card {
        padding: 2rem 1.5rem !important;
        margin-bottom: 1.5rem;
    }
    
    .swiper-slide {
        width: 280px;
        padding: 30px 20px;
        margin: 0 10px;
    }
    
    .Testimonials-title-intro {
        font-size: 24px;
    }
    
    .testimonials-container {
        padding: 20px 10px;
    }
    
    .faq-title {
        font-size: 1.75rem;
    }
    
    .accordion-header {
        padding: 1.25rem;
        font-size: 1rem;
    }
    
    .accordion-content {
        padding: 0 1.25rem;
    }
    
    .accordion-content.active {
        padding: 1rem 1.25rem 1.25rem;
    }
    
    /* Más margen en secciones para móvil */
    .py-5 {
        padding-top: 3rem !important;
        padding-bottom: 3rem !important;
    }
    
    .mb-5 {
        margin-bottom: 2rem !important;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .hero-section .display-4 {
        font-size: 1.75rem;
    }
    
    .feature-card,
    .mission-vision-card {
        padding: 1.5rem 1rem !important;
        margin-bottom: 1rem;
    }
    
    .swiper-slide {
        width: 250px;
        padding: 25px 15px;
    }
    
    .testimonial-avatar {
        width: 80px;
        height: 80px;
        font-size: 1.5rem;
    }
    
    .testimonial-name {
        font-size: 16px;
    }
    
    .testimonial-quote {
        font-size: 14px;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        width: 40px;
        height: 40px;
    }
    
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 16px;
    }
}

/* Mejoras de accesibilidad */
.btn {
    transition: all 0.3s ease;
}

/* Asegurar contraste en modo oscuro */
body.dark-mode .text-muted {
    color: var(--text-secondary) !important;
}

body.dark-mode .lead {
    color: var(--text-primary);
}

/* Sombra más pronunciada para todas las cards */
.shadow-lg {
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

/* Espaciado adicional para móviles */
.mobile-spacing {
    margin-bottom: 1.5rem;
}
</style>

<script>
// Inicializar Swiper para testimonios
document.addEventListener('DOMContentLoaded', function () {
    // Testimonios Swiper
    new Swiper('.testimonials-swiper', {
        slidesPerView: 'auto',
        centeredSlides: true,
        loop: true,
        spaceBetween: 40,
        speed: 600,
        effect: 'coverflow',
        coverflowEffect: {
            rotate: 0,
            stretch: -50, 
            depth: 150, 
            modifier: 1,
            slideShadows: false
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            320: {
                spaceBetween: 20,
                coverflowEffect: {
                    stretch: -30,
                    depth: 100
                }
            },
            768: {
                spaceBetween: 40,
                coverflowEffect: {
                    stretch: -50,
                    depth: 150
                }
            }
        }
    });

    // Acordeón FAQ
    const accordionItems = document.querySelectorAll('.accordion-item');
    
    accordionItems.forEach(item => {
        const header = item.querySelector('.accordion-header');
        const content = item.querySelector('.accordion-content');
        
        header.addEventListener('click', function() {
            // Cierra otros acordeones primero
            document.querySelectorAll('.accordion-item').forEach(otherItem => {
                if (otherItem !== item) {
                    const otherHeader = otherItem.querySelector('.accordion-header');
                    const otherContent = otherItem.querySelector('.accordion-content');
                    
                    otherHeader.classList.remove('active');
                    otherContent.classList.remove('active');
                    otherContent.style.maxHeight = '0';
                }
            });
            
            // Alterna el acordeón clickeado
            const isActive = header.classList.contains('active');
            
            header.classList.toggle('active');
            content.classList.toggle('active');
            
            if (!isActive) {
                // Abre suavemente
                content.style.maxHeight = content.scrollHeight + 'px';
            } else {
                // Cierra suavemente
                content.style.maxHeight = '0';
            }
        });
        
        // Asegura que el contenido esté cerrado al inicio
        content.style.maxHeight = '0';
    });
});
</script>
@endsection