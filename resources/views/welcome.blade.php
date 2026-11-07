<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ConstrucKit — Gestión de maquinaria pesada</title>

    {{-- Bootstrap 5.3 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    {{-- Archivo variable font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=archivo:400,500,600,800&display=swap" rel="stylesheet">

    <style>
        /* ── Tokens ──────────────────────────────────── */
        :root {
            --ck-bg:        #F0EDE8;
            --ck-board:     #1C2526;
            --ck-ink:       #0E1719;
            --ck-amber:     #E07B00;
            --ck-green:     #1A6B52;
            --ck-dust:      #8A9499;
            --ck-card:      #FFFFFF;
            --ck-radius:    6px;
        }

        /* ── Base ─────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Archivo', system-ui, sans-serif;
            background: var(--ck-bg);
            color: var(--ck-ink);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Focus ring accesible ─────────────────────── */
        :focus-visible {
            outline: 3px solid var(--ck-amber);
            outline-offset: 2px;
        }

        /* ── Navbar ───────────────────────────────────── */
        .ck-nav {
            background: var(--ck-board);
            padding: .875rem 1.5rem;
        }
        .ck-nav .navbar-brand {
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: .02em;
            color: #fff;
            text-decoration: none;
        }
        .ck-nav .navbar-brand span {
            color: var(--ck-amber);
        }
        .ck-nav .btn-nav {
            font-size: .875rem;
            font-weight: 600;
            padding: .4rem 1rem;
            border: 1.5px solid rgba(255,255,255,.35);
            color: #fff;
            border-radius: var(--ck-radius);
            background: transparent;
            transition: background .15s, border-color .15s;
            text-decoration: none;
        }
        .ck-nav .btn-nav:hover,
        .ck-nav .btn-nav:focus-visible {
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.65);
        }

        /* ── Hero ─────────────────────────────────────── */
        .ck-hero {
            background: var(--ck-board);
            padding: 5rem 0 4rem;
        }
        .ck-hero-headline {
            font-size: clamp(2.75rem, 6vw, 5rem);
            font-weight: 800;
            font-stretch: condensed;
            line-height: 1.0;
            color: #fff;
            letter-spacing: -.02em;
        }
        .ck-hero-headline em {
            font-style: normal;
            color: var(--ck-amber);
        }
        .ck-hero-sub {
            font-size: 1.0625rem;
            color: var(--ck-dust);
            line-height: 1.6;
            max-width: 44ch;
            margin-top: 1.25rem;
        }

        /* Login card en el hero */
        .ck-login-card {
            background: var(--ck-card);
            border-radius: var(--ck-radius);
            padding: 2rem;
            box-shadow: 0 4px 24px rgba(0,0,0,.28);
        }
        .ck-login-card h2 {
            font-size: 1.0625rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--ck-ink);
        }
        .ck-login-card label {
            font-size: .8125rem;
            font-weight: 600;
            color: var(--ck-ink);
        }
        .ck-login-card .form-control {
            border-radius: var(--ck-radius);
            border: 1.5px solid #D4D0CA;
            font-size: .9375rem;
            padding: .5rem .75rem;
        }
        .ck-login-card .form-control:focus {
            border-color: var(--ck-green);
            box-shadow: 0 0 0 3px rgba(26,107,82,.18);
        }
        .ck-btn-primary {
            background: var(--ck-green);
            border: none;
            border-radius: var(--ck-radius);
            color: #fff;
            font-weight: 700;
            font-size: .9375rem;
            padding: .625rem 1.5rem;
            width: 100%;
            transition: background .15s, transform .1s;
        }
        .ck-btn-primary:hover,
        .ck-btn-primary:focus-visible {
            background: #155c45;
        }
        .ck-btn-primary:active {
            transform: scale(.98);
        }
        .ck-btn-primary:disabled {
            opacity: .6;
            cursor: not-allowed;
        }
        #login-error {
            font-size: .8125rem;
            color: #c0392b;
            min-height: 1.25rem;
        }

        /* ── Banda de métricas ────────────────────────── */
        .ck-metrics {
            background: var(--ck-bg);
            border-top: 1px solid #D8D3CB;
            border-bottom: 1px solid #D8D3CB;
            padding: 2.5rem 0;
        }
        .ck-metric-num {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--ck-ink);
            line-height: 1;
        }
        .ck-metric-label {
            font-size: .8125rem;
            color: var(--ck-dust);
            margin-top: .375rem;
            font-weight: 500;
        }
        .ck-metric-sep {
            width: 1px;
            background: #D8D3CB;
            align-self: stretch;
        }

        /* ── Cómo funciona ────────────────────────────── */
        .ck-how {
            padding: 4.5rem 0;
        }
        .ck-how-title {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 2.5rem;
            color: var(--ck-ink);
        }
        .ck-step {
            background: var(--ck-card);
            border: 1px solid #E0DBD3;
            border-radius: var(--ck-radius);
            padding: 1.75rem 1.5rem;
        }
        .ck-step-icon {
            width: 44px;
            height: 44px;
            margin-bottom: 1rem;
        }
        .ck-step h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: .5rem;
            color: var(--ck-ink);
        }
        .ck-step p {
            font-size: .875rem;
            color: var(--ck-dust);
            line-height: 1.6;
            margin: 0;
        }

        /* ── Footer ───────────────────────────────────── */
        .ck-footer {
            background: var(--ck-board);
            color: var(--ck-dust);
            font-size: .8125rem;
            padding: 1.5rem 0;
        }
        .ck-footer a {
            color: var(--ck-dust);
            text-decoration: none;
        }
        .ck-footer a:hover { color: #fff; }

        /* ── Hero fade-in ─────────────────────────────── */
        @media (prefers-reduced-motion: no-preference) {
            .ck-hero-content {
                animation: ck-fadein 220ms ease both;
            }
            @keyframes ck-fadein {
                from { opacity: 0; transform: translateY(8px); }
                to   { opacity: 1; transform: translateY(0); }
            }
        }

        /* ── Responsive tweaks ────────────────────────── */
        @media (max-width: 991.98px) {
            .ck-hero { padding: 3.5rem 0 3rem; }
            .ck-login-card { margin-top: 2.5rem; }
            .ck-metric-sep { display: none; }
        }
    </style>
</head>
<body>

{{-- Accesibilidad: saltar al contenido --}}
<a class="visually-hidden-focusable" href="#main">Ir al contenido principal</a>

{{-- Navbar --}}
<nav class="ck-nav d-flex align-items-center justify-content-between" aria-label="Navegación principal">
    <a class="navbar-brand" href="/">Construc<span>Kit</span></a>
    <a class="btn-nav" href="#login-form">Iniciar sesión</a>
</nav>

<main id="main">

    {{-- Hero --}}
    <section class="ck-hero" aria-label="Presentación">
        <div class="container">
            <div class="row align-items-center g-5">

                {{-- Titular --}}
                <div class="col-lg-6 ck-hero-content">
                    <h1 class="ck-hero-headline">
                        Cada hora<br>
                        de cada máquina,<br>
                        <em>registrada.</em>
                    </h1>
                    <p class="ck-hero-sub">
                        ConstrucKit centraliza el horómetro, las cargas de combustible y las
                        mantenciones de tu flota. Preventivas pendientes a la vista antes
                        de que las 250&nbsp;horas sean un problema.
                    </p>
                </div>

                {{-- Login --}}
                <div class="col-lg-5 offset-lg-1 ck-hero-content">
                    <div class="ck-login-card">
                        <h2>Acceder al panel</h2>
                        <form id="login-form" novalidate aria-label="Formulario de inicio de sesión">
                            <div class="mb-3">
                                <label for="login-email" class="form-label">Correo electrónico</label>
                                <input
                                    type="email"
                                    id="login-email"
                                    name="email"
                                    class="form-control"
                                    autocomplete="email"
                                    required
                                    placeholder="operador@empresa.cl"
                                >
                            </div>
                            <div class="mb-4">
                                <label for="login-password" class="form-label">Contraseña</label>
                                <input
                                    type="password"
                                    id="login-password"
                                    name="password"
                                    class="form-control"
                                    autocomplete="current-password"
                                    required
                                    placeholder="••••••••"
                                >
                            </div>
                            <p id="login-error" role="alert" aria-live="polite"></p>
                            <button type="submit" class="ck-btn-primary" id="login-btn">
                                Entrar al panel
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Métricas --}}
    <section class="ck-metrics" aria-label="Por qué ConstrucKit">
        <div class="container">
            <div class="row justify-content-center text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="ck-metric-num">3</div>
                    <div class="ck-metric-label">tipos de equipo soportados</div>
                </div>
                <div class="col-auto d-none d-md-flex ck-metric-sep" role="separator" aria-hidden="true"></div>
                <div class="col-6 col-md-3">
                    <div class="ck-metric-num">250 h</div>
                    <div class="ck-metric-label">umbral de alerta preventiva</div>
                </div>
                <div class="col-auto d-none d-md-flex ck-metric-sep" role="separator" aria-hidden="true"></div>
                <div class="col-6 col-md-3">
                    <div class="ck-metric-num">0</div>
                    <div class="ck-metric-label">mantenciones duplicadas</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Cómo funciona --}}
    <section class="ck-how" id="como-funciona" aria-labelledby="how-title">
        <div class="container">
            <h2 class="ck-how-title" id="how-title">Cómo funciona</h2>
            <div class="row g-4">

                <div class="col-md-4">
                    <div class="ck-step">
                        {{-- Icono: wrench --}}
                        <svg class="ck-step-icon" viewBox="0 0 44 44" fill="none" aria-hidden="true">
                            <rect width="44" height="44" rx="6" fill="#E07B00" fill-opacity=".12"/>
                            <path d="M28 10a8 8 0 00-7.94 9.03L10.59 28.5A2 2 0 1013.5 31.4l9.47-9.47A8 8 0 1028 10zm0 12a4 4 0 110-8 4 4 0 010 8z" fill="#E07B00"/>
                        </svg>
                        <h3>Registra tu equipo</h3>
                        <p>Código interno, tipo, patente y horómetro inicial. Camión, excavadora o generador.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="ck-step">
                        {{-- Icono: fuel pump --}}
                        <svg class="ck-step-icon" viewBox="0 0 44 44" fill="none" aria-hidden="true">
                            <rect width="44" height="44" rx="6" fill="#1A6B52" fill-opacity=".12"/>
                            <path d="M14 12h12v18H14V12zm0-2a2 2 0 00-2 2v18a2 2 0 002 2h12a2 2 0 002-2V12a2 2 0 00-2-2H14zm14 4l4 4v8h-4V14zm-6 4h-4v2h4v-2z" fill="#1A6B52"/>
                        </svg>
                        <h3>Carga combustible y mantenciones</h3>
                        <p>Cada carga actualiza el horómetro del equipo. Si baja del último registro, el sistema lo rechaza con un error claro.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="ck-step">
                        {{-- Icono: chart/report --}}
                        <svg class="ck-step-icon" viewBox="0 0 44 44" fill="none" aria-hidden="true">
                            <rect width="44" height="44" rx="6" fill="#1C2526" fill-opacity=".1"/>
                            <rect x="12" y="22" width="4" height="10" fill="#1C2526"/>
                            <rect x="20" y="16" width="4" height="16" fill="#1C2526"/>
                            <rect x="28" y="12" width="4" height="20" fill="#E07B00"/>
                            <line x1="12" y1="34" x2="32" y2="34" stroke="#8A9499" stroke-width="1.5"/>
                        </svg>
                        <h3>Consulta reportes y preventivas</h3>
                        <p>Reporte por equipo y rango de fechas: litros, gastos y rendimiento. Listado de equipos que superan las 250&nbsp;horas sin mantención preventiva.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

{{-- Footer --}}
<footer class="ck-footer" aria-label="Pie de página">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <span>ConstrucKit &copy; {{ date('Y') }}</span>
        <span>API REST para gestión de maquinaria pesada</span>
    </div>
</footer>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

{{-- Axios --}}
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.9/dist/axios.min.js"
        integrity="sha384-jLwhcmGu/RL8PSTUEl/559f8QVLL4QqM+HBvoZlt4F7XCdsdoDGAwW4nPFfoM7lU"
        crossorigin="anonymous"></script>

<script>
(function () {
    'use strict';

    // Si ya hay token guardado, ir directo al panel
    if (sessionStorage.getItem('ck_token')) {
        window.location.replace('/panel');
        return;
    }

    const form    = document.getElementById('login-form');
    const btnEl   = document.getElementById('login-btn');
    const errorEl = document.getElementById('login-error');

    function setError(msg) {
        errorEl.textContent = msg;
    }

    function clearError() {
        errorEl.textContent = '';
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();

        const email    = form.querySelector('#login-email').value.trim();
        const password = form.querySelector('#login-password').value;

        if (!email || !password) {
            setError('Completa correo y contraseña.');
            return;
        }

        btnEl.disabled    = true;
        btnEl.textContent = 'Verificando…';

        try {
            const { data } = await axios.post('/api/v1/login', { email, password });
            sessionStorage.setItem('ck_token', data.token);
            window.location.replace('/panel');
        } catch (err) {
            const status = err.response?.status;
            if (status === 401 || status === 422) {
                setError('Correo o contraseña incorrectos.');
            } else if (err.request) {
                setError('Sin respuesta del servidor. Revisa tu conexión.');
            } else {
                setError('Error inesperado. Intenta de nuevo.');
            }
        } finally {
            btnEl.disabled    = false;
            btnEl.textContent = 'Entrar al panel';
        }
    });
})();
</script>

</body>
</html>
