@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
<style>
    .contact-hero {
        background: linear-gradient(135deg, rgba(14,82,70,0.07), rgba(6,30,34,0.03));
        padding: 4rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    .contact-hero h1 {
         font-weight: 700; 
         font-size: 2.5rem; 
         color: var(--text-primary); 
    }

    .contact-hero .lead { 
        color: var(--text-secondary) !important; 
    }

    .card-contact {
        margin-top: 1rem;
        border-radius: 12px;
        padding: 1.25rem;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
    }

    .contact-grid {
        display: flex;
        gap: 2rem;
        align-items: stretch;
    }

    .btn {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    /* Two column layout: left = Get In Touch (info + form/buttons), right = map */
    .contact-left {
        flex: 1 1 40%;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .contact-right {
        flex: 1 1 60%;
    }

    .contact-info-block {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .contact-info-item {
        display: flex;
        gap: .75rem;
        align-items: flex-start;
        padding: .75rem;
        border-radius: 10px;
        background: rgba(0,0,0,0.02);
        border: 1px solid var(--border-color);
        text-align: left;
    }

    .contact-info-item .bi {
        font-size: 1.25rem;
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--bg-primary);
        color: var(--btn-primary-bg);
        flex-shrink: 0;
        margin-top: 2px;
    }

    .contact-info-content {
        flex: 1;
        text-align: left;
    }

    .ratio.map-ratio { 
        border-radius: 10px; 
        overflow: hidden; 
        border: 1px solid var(--border-color); 
    }

    .d-flex {
        justify-content: center;
        gap: 0.5rem;
    }

    /* Responsive: stack on small screens */
    @media (max-width: 991.98px) {
        .contact-grid { flex-direction: column; }
    }
</style>

<section class="contact-hero">
    <div class="container">
        <div class="row gy-4">
            <div class="col-12">
                <h1>Contáctanos</h1>
                <p class="lead">¿Tienes dudas sobre nuestros cursos o servicios? Escríbenos y con gusto te responderemos.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-left">
                <div class="card-contact">
                    <h4 class="mb-3" style="color: var(--text-primary);">Sobre nosotros</h4>
                    <div class="contact-info-block mb-3">
                        <div class="contact-info-item">
                            <i class="bi bi-telephone-fill"></i>
                            <div class="contact-info-content">
                                <div class="small text">Teléfono</div>
                                <div class="fw-bold">(+52) 1 - 220 - 300 - 0543</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div class="contact-info-content">
                                <div class="small text">Clases presenciales en:</div>
                                <div class="fw-bold">Puebla, Puebla</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <i class="bi bi-browser-edge"></i>
                            <div class="contact-info-content">
                                <div class="small text">Redes sociales</div>
                                <div class="fw-bold">@instituto_resiliencia</div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones directos (WhatsApp / Instagram) -->
                    <div class="card-contact mt-3">
                        <div class="d-grid gap-2">
                            <a href="https://api.whatsapp.com/send?phone=5212203000543&text=Hola%2C%20buen%20día%2C%20informes%20sobre%20el%20examen%20de%20admisión%20BUAP%202026!!%20🐺🐺😎😎" target="_blank" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-whatsapp me-2"></i> Contáctanos por WhatsApp
                            </a>
                            <a href="https://www.instagram.com/instituto_resiliencia" target="_blank" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-instagram me-2"></i> Contáctanos por Instagram
                            </a>
                        </div>
                        <p class="text small mt-3 mb-0">Horarios de atención: Lunes a domingo de 8:00 AM - 11:59 PM</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Map -->
            <div class="contact-right">
                <div class="card-contact">
                    <h4 class="mb-3" style="color: var(--text-primary);">Nuestra ubicación</h4>
                    <p class="text small mb-3">Visítanos en nuestra sede central o solicita una cita.</p>

                    <div class="ratio map-ratio ratio-4x3">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d120437.4853692465!2d-98.26981354999999!3d19.041296!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfc0bd5ebc7b3b%3A0x5370c5aaf16afc4f!2sPuebla%2C%20Pue.!5e0!3m2!1ses!2smx!4v1700000000000!5m2!1ses!2smx" 
                            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
                <div class="card-contact">
                    <div class="mt-0 d-flex gap-2">
                        <a class="btn btn-outline-primary btn-lg" href="https://www.facebook.com/profile.php?id=100065627762968&ref=_xav_ig_profile_page_web" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a class="btn btn-outline-primary btn-lg" href="https://www.instagram.com/instituto_resiliencia" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a class="btn btn-outline-primary btn-lg" href="https://www.tiktok.com/@institutoresilien" title="TikTok"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</section>
@endsection