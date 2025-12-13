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
                    <p class="lead mb-4">Somos un centro de enseñanza para potencializar el aprendizaje de los y las estudiantes en diferentes campos de conocimientos. Especializándonos principalmente en las habilidades requeridas para la entrada a las mejores universidades del país. Únete a nosotros y descubre cómo podemos ayudarte a alcanzar tus metas académicas</p>
                    <div class="d-flex gap-3 flex-wrap justify-content-center">
                        <a href="{{ route('store') }}" class="btn btn-primary btn-lg">Explorar Cursos</a>
                        <a href="#mission-vision" class="btn btn-outline-primary btn-lg">Más Información</a>
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
<section id="mission-vision" class="mission-vision py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">NUESTRA MISIÓN Y VISIÓN</h2>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="mission-vision-card text-center p-4 rounded shadow-lg h-100">
                    <i class="bi bi-bullseye display-4 mb-3 mission-icon"></i>
                    <h3 class="h4 fw-bold mb-3 mission-title">Misión</h3>
                    <p class="mission-text">
                        El Instituto Resiliencia es una organización especializada en potenciar el aprendizaje de los estudiantes en diversas áreas académicas. Con cinco años de experiencia en el sector educativo, hemos obtenido resultados sumamente gratificantes. 
                        <br>Nuestra especialidad son los cursos de admisión a la Benemérita Universidad Autónoma de Puebla, institución en la que la mayoría de nuestros instructores se formaron, lo que enriquece nuestro conocimiento del proceso de ingreso.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="mission-vision-card text-center p-4 rounded shadow-lg h-100">
                    <i class="bi bi-eye display-4 mb-3 vision-icon"></i>
                    <h3 class="h4 fw-bold mb-3 vision-title">Visión</h3>
                    <p class="vision-text">
                        Ser la organización líder en apoyar a jóvenes estudiantes para desarrollar sus conocimientos y habilidades, mejorando tanto sus aspectos académicos como psicológicos. 
                        <br><br>Brindamos las herramientas necesarias para enfrentar desafíos relacionados con autoestima, rendimiento académico, logros educativos y las exigencias de un mundo globalizado.
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
        
        <!-- Primera fila con 2 tarjetas principales -->
        <div class="row justify-content-center">
            <!-- Tarjeta 1 - Capacitación -->
            <div class="col-md-6 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-award display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">CAPACITACIÓN DE EXCELENCIA</h4>
                    <p class="feature-text-short">
                        Cursos de ingreso basados en temarios oficiales y actualizados de las mejores universidades.
                    </p>
                    <div class="feature-full-content" style="display: none;">
                        <p class="feature-text">
                            Contamos con los mejores cursos para el ingreso a las mejores universidades del país, basado en los temarios oficiales y actualizados proporcionados por cada una de las instituciones. Nos destacamos por la calidad en nuestro plan psicopedagógico de enseñanza, planificado y guiado por psicólogos educativos y clínicos que en conjunto con licenciados y expertos en cada uno de los temas se llevan a cabo de la mejor manera.
                        </p>
                    </div>
                    <button class="btn btn-outline-primary read-more-btn mt-3" onclick="toggleReadMore(this)">
                        Leer más
                    </button>
                </div>
            </div>
            
            <!-- Tarjeta 2 - Costos -->
            <div class="col-md-6 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-currency-dollar display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">PRECIO ACCESIBLE</h4>
                    <p class="feature-text-short">
                        La mejor relación calidad-precio con un ambiente de aprendizaje óptimo por solo <strong>70 pesos por semana.</strong>
                    </p>
                    <div class="feature-full-content" style="display: none;">
                        <p class="feature-text">
                            No solo destacamos por ser el mejor instituto en calidad académica, comprometidos con el alumnado buscamos ser la mejor opción en un ambiente libre, respetuoso y divertido, teniendo como costo exclusivamente <strong>70 pesos por semana</strong> en nuestros cursos base para la admisión a universidades.
                        </p>
                    </div>
                    <button class="btn btn-outline-primary read-more-btn mt-3" onclick="toggleReadMore(this)">
                        Leer más
                    </button>
                </div>
            </div>
        </div>

        <!-- Segunda fila con 2 tarjetas principales -->
        <div class="row justify-content-center">
            <!-- Tarjeta 3 - Tiempo -->
            <div class="col-md-6 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-clock display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">TIEMPO Y ACOMPAÑAMIENTO</h4>
                    <p class="feature-text-short">
                        Acompañamiento continuo durante aproximadamente 6 meses hasta tu examen de admisión.
                    </p>
                    <div class="feature-full-content" style="display: none;">
                        <p class="feature-text">
                            Todos nuestros cursos cuentan con acompañamiento continuo desde la inscripción a dicho curso hasta la presentación de cada uno de sus exámenes, esto dependerá a que universidad o institución este próximo a entrar con un aproximado de 6 meses.
                        </p>
                    </div>
                    <button class="btn btn-outline-primary read-more-btn mt-3" onclick="toggleReadMore(this)">
                        Leer más
                    </button>
                </div>
            </div>
            
            <!-- Tarjeta 4 - Ciclo de Estudios -->
            <div class="col-md-6 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-journal-text display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">CICLO DE ESTUDIOS</h4>
                    <p class="feature-text-short">
                        Curso dividido en 3 ciclos estratégicos con clases de 90 minutos y evaluaciones constantes.
                    </p>
                    <div class="feature-full-content" style="display: none;">
                        <p class="feature-text">
                            Nuestro curso está guiado y planeado por profesionales en la educación, por lo que estratégicamente se divide en 3 ciclos donde se verán las materias necesarias para su pase a la universidad elegida. Al término de cada semana se harán exámenes didácticos de los temas vistos durante el periodo, así mismo, al término de cada ciclo se hará un examen simulador sumamente parecido al real. Es necesario saber que todos los viernes junto al examen didáctico tendrán una sesión de asesoría, donde se podrán aclarar dudas aún existentes. Todas nuestras clases son grabadas y duran 90 minutos al día.
                        </p>
                    </div>
                    <button class="btn btn-outline-primary read-more-btn mt-3" onclick="toggleReadMore(this)">
                        Leer más
                    </button>
                </div>
            </div>
        </div>

        <!-- Tercera fila con 2 tarjetas principales -->
        <div class="row justify-content-center">
            <!-- Tarjeta 5 - Exámenes Simuladores -->
            <div class="col-md-6 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-graph-up display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">EXÁMENES SIMULADORES</h4>
                    <p class="feature-text-short">
                        Simuladores didácticos semanales y oficiales que replican el examen real con estadísticas detalladas.
                    </p>
                    <div class="feature-full-content" style="display: none;">
                        <p class="feature-text">
                            Existen dos tipos de exámenes simuladores: didácticos y oficiales. Los didácticos son a forma de juego TODAS las semanas, y son temas que se vieron durante la semana en pie, mientras los oficiales son al término de cada ciclo y estarán estructurados con las mismas preguntas y tiempo de acuerdo al examen real. Al término de cualquier examen podrán ver sus estadísticas: preguntas correctas, incorrectas, tiempo dedicado en terminarlo, promedio de tiempo por pregunta, temas a mejorar y comparación de resultado con tus anteriores exámenes.
                        </p>
                    </div>
                    <button class="btn btn-outline-primary read-more-btn mt-3" onclick="toggleReadMore(this)">
                        Leer más
                    </button>
                </div>
            </div>
            
            <!-- Tarjeta 6 - Guías y Material -->
            <div class="col-md-6 mb-4">
                <div class="feature-card text-center p-4 rounded shadow-lg h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-book display-4 feature-icon-svg"></i>
                    </div>
                    <h4 class="fw-bold mb-3 feature-title">GUÍAS Y MATERIAL DIDÁCTICO</h4>
                    <p class="feature-text-short">
                        Material exclusivo IR para reforzar conocimientos y potenciar tus habilidades académicas.
                    </p>
                    <div class="feature-full-content" style="display: none;">
                        <p class="feature-text">
                            Contamos con guías propias de IR que ayudarán a reforzar los conocimientos vistos en clase y demostrado en exámenes simuladores, así como actividades y videos extras que te darán mayor seguridad en tus habilidades académicas.
                        </p>
                    </div>
                    <button class="btn btn-outline-primary read-more-btn mt-3" onclick="toggleReadMore(this)">
                        Leer más
                    </button>
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
        
        <div class="testimonial-container text-center">
            <a href="{{ route('testimonials') }}" class="btn btn-primary btn-lg">Ver Todos los Testimonios</a>
        </div>
    </div>
</section>

<!-- Preguntas Frecuentes Section -->
<section class="faq py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-center mb-5">PREGUNTAS FRECUENTES</h2>
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
                <h3 class="h2 fw-bold mb-3">¿Dudas?</h3>
                <p class="mb-0">Si tienes dudas puedes contactarnos para más información</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('contact') }}" class="btn btn-cta btn-lg">Contáctanos</a>
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

.cta-section .container{
margin-left: 20px;
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

.testimonial-container {
    padding: 40px 20px;
}
</style>

<script>
function toggleReadMore(button) {
    const card = button.closest('.feature-card');
    const shortText = card.querySelector('.feature-text-short');
    const fullContent = card.querySelector('.feature-full-content');
    
    if (fullContent.style.display === 'none') {
        fullContent.style.display = 'block';
        shortText.style.display = 'none';
        button.textContent = 'Leer menos';
    } else {
        fullContent.style.display = 'none';
        shortText.style.display = 'block';
        button.textContent = 'Leer más';
    }
}

// Inicializar Swiper para testimonios
document.addEventListener('DOMContentLoaded', function () {

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