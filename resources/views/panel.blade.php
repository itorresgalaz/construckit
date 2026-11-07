<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel — ConstrucKit</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css"
          integrity="sha384-e4/pU/7fdyaPKtXkqAgHNgoYAb2LNmChhpSuSp8o6saYtS2sP+JZsu8Wy/7mGV7w"
          crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=archivo:400,600,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ck-bg:     #F0EDE8;
            --ck-board:  #1C2526;
            --ck-ink:    #0E1719;
            --ck-green:  #1A6B52;
            --ck-card:   #FFFFFF;
            --ck-radius: 6px;
        }

        body {
            font-family: 'Archivo', system-ui, sans-serif;
            background: var(--ck-bg);
            color: var(--ck-ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .panel-nav {
            background: var(--ck-board);
            color: #fff;
            padding: 1rem 1.5rem;
        }
        .panel-nav .navbar-brand {
            font-weight: 800;
            font-size: 1.1rem;
            color: #fff;
            text-decoration: none;
        }
        .panel-nav .navbar-brand span {
            color: #E07B00;
        }
        .panel-nav .btn-logout {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,.35);
            color: #fff;
            font-size: .875rem;
            font-weight: 600;
            padding: .4rem 1rem;
            border-radius: var(--ck-radius);
            transition: background .15s, border-color .15s;
            cursor: pointer;
        }
        .panel-nav .btn-logout:hover,
        .panel-nav .btn-logout:focus-visible {
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.65);
        }

        main {
            flex: 1;
            padding: 3rem 0;
        }

        .welcome-card {
            background: var(--ck-card);
            border-radius: var(--ck-radius);
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
        }
        .welcome-card h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--ck-ink);
        }
        .welcome-card p {
            color: #64748b;
            font-size: 1rem;
        }
        .welcome-card code {
            background: var(--ck-bg);
            padding: .25rem .5rem;
            border-radius: 3px;
            font-size: .875rem;
        }

        .panel-footer {
            background: var(--ck-board);
            color: #8A9499;
            font-size: .8125rem;
            padding: 1rem 0;
            text-align: center;
        }

        :focus-visible {
            outline: 3px solid #E07B00;
            outline-offset: 2px;
        }
    </style>
</head>
<body>

<a class="visually-hidden-focusable" href="#main">Ir al contenido principal</a>

<nav class="panel-nav d-flex align-items-center justify-content-between" aria-label="Navegación del panel">
    <a class="navbar-brand" href="/panel">Construc<span>Kit</span></a>
    <button type="button" class="btn-logout" id="logout-btn">Cerrar sesión</button>
</nav>

<main id="main">
    <div class="container">
        <h1 class="h4 fw-bold mb-3">Equipos</h1>

        <div class="bg-white rounded shadow-sm p-3">
            <table id="eq-table" class="table table-hover align-middle w-100">
                <caption class="visually-hidden">Listado de equipos</caption>
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Patente</th>
                        <th scope="col">Marca / modelo</th>
                        <th scope="col" class="text-end">Horómetro</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-end">Ver</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <p id="eq-status" class="text-muted small mt-2" role="status"></p>
    </div>
</main>

<footer class="panel-footer">
    ConstrucKit &copy; {{ date('Y') }}
</footer>

{{-- Historial: mantenciones o combustible --}}
<div class="modal fade" id="history-modal" tabindex="-1" aria-labelledby="history-title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="history-title"></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead id="history-head"></thead>
                        <tbody id="history-body"></tbody>
                    </table>
                </div>
                <p id="history-status" class="text-muted small" role="status"></p>
                <nav aria-label="Paginación del historial"><ul class="pagination pagination-sm mb-0" id="history-pager"></ul></nav>
            </div>
        </div>
    </div>
</div>

{{-- Reporte: pide el rango de fechas --}}
<div class="modal fade" id="report-modal" tabindex="-1" aria-labelledby="report-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="report-title"></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="report-form" novalidate>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label for="report-from" class="form-label">Desde</label>
                            <input type="date" id="report-from" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="report-to" class="form-label">Hasta</label>
                            <input type="date" id="report-to" class="form-control" required>
                        </div>
                    </div>
                    <p id="report-error" class="text-danger small mt-3 mb-0" role="alert"></p>
                    <dl id="report-result" class="row mt-3 mb-0" hidden>
                        <dt class="col-7">Litros totales</dt><dd class="col-5 text-end" id="r-liters"></dd>
                        <dt class="col-7">Gasto en combustible</dt><dd class="col-5 text-end" id="r-fuel"></dd>
                        <dt class="col-7">Gasto en mantenciones</dt><dd class="col-5 text-end" id="r-maint"></dd>
                        <dt class="col-7">Rendimiento (litros por hora)</dt><dd class="col-5 text-end" id="r-lph"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="report-btn">Ver reporte</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs"
        crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"
        integrity="sha384-RZEqG156bBQSxYY9lwjUz/nKVkqYj/QNK9dEjjyJ/EVTO7ndWwk6ZWEkvaKdRm/U"
        crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"
        integrity="sha384-G85lmdZCo2WkHaZ8U1ZceHekzKcg37sFrs4St2+u/r2UtfvSDQmQrkMsEx4Cgv/W"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/axios@1.7.9/dist/axios.min.js"
        integrity="sha384-jLwhcmGu/RL8PSTUEl/559f8QVLL4QqM+HBvoZlt4F7XCdsdoDGAwW4nPFfoM7lU"
        crossorigin="anonymous"></script>

<script>
(function () {
    'use strict';

    const token = sessionStorage.getItem('ck_token');

    // Sin token, volver al login
    if (!token) {
        window.location.replace('/');
        return;
    }

    // Configurar Axios con el token
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    // Logout
    const logoutBtn = document.getElementById('logout-btn');
    logoutBtn.addEventListener('click', async function () {
        try {
            await axios.post('/api/v1/logout');
        } catch (err) {
            console.error('Logout error:', err);
        } finally {
            sessionStorage.removeItem('ck_token');
            window.location.replace('/');
        }
    });
    // Token vencido o inválido: volver al login
    axios.interceptors.response.use(r => r, err => {
        if (err.response?.status === 401) {
            sessionStorage.removeItem('ck_token');
            window.location.replace('/');
        }
        return Promise.reject(err);
    });

    // ── Formato ─────────────────────────────────────
    const LABELS = {
        truck: 'Camión', excavator: 'Excavadora', generator: 'Generador', other: 'Otro',
        operational: 'Operativo', under_maintenance: 'En mantención', out_of_service: 'Fuera de servicio',
        preventive: 'Preventiva', corrective: 'Correctiva', diesel: 'Diésel', gasoline: 'Bencina',
    };
    const label = v => LABELS[v] ?? v ?? '—';
    const clp = v => new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP', maximumFractionDigits: 0 }).format(v ?? 0);
    const num = v => new Intl.NumberFormat('es-CL', { maximumFractionDigits: 2 }).format(Number(v ?? 0));
    const date = v => v ? new Date(v).toLocaleString('es-CL') : '—';

    function errMsg(err) {
        if (!err.response) {
            if (err instanceof Error && !(err.config)) {
                return `Error de aplicación: ${err.message}`;
            }
            return 'Sin respuesta del servidor. Revisa tu conexión.';
        }
        const r = err.response;
        if (r.status === 422 && r.data.errors) return Object.values(r.data.errors).flat().join(' ');
        if (r.status === 404) return 'No se encontró el equipo.';
        return r.data?.message || 'Error del servidor. Intenta de nuevo.';
    }

    // Todo texto de la API entra con textContent, nunca innerHTML.
    function el(tag, text, cls) {
        const e = document.createElement(tag);
        e.textContent = text;
        if (cls) e.className = cls;
        return e;
    }

    function renderPager(ul, meta, go) {
        ul.replaceChildren();
        if (!meta || meta.last_page <= 1) return;
        const item = (text, page, disabled) => {
            const li = el('li', '', 'page-item' + (disabled ? ' disabled' : ''));
            const b = el('button', text, 'page-link');
            b.type = 'button';
            b.disabled = disabled;
            b.addEventListener('click', () => go(page));
            li.append(b);
            ul.append(li);
        };
        item('Anterior', meta.current_page - 1, meta.current_page === 1);
        item(`${meta.current_page} de ${meta.last_page}`, meta.current_page, true);
        item('Siguiente', meta.current_page + 1, meta.current_page === meta.last_page);
    }

    // ── Equipos (DataTables) ────────────────────────
    const eqStatus = document.getElementById('eq-status');
    const historyModal = bootstrap.Modal.getOrCreateInstance('#history-modal');
    const reportModal = bootstrap.Modal.getOrCreateInstance('#report-modal');
    let eqTable;

    // DataTables inserta el valor de "display" como HTML: se escapa todo dato de la API.
    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const text = fn => (d, t, row) => { const v = fn(d, row); return t === 'display' ? esc(v) : v; };

    // La API pagina de a 10 y no filtra ni ordena: se traen todas las páginas para que
    // búsqueda y orden de DataTables cubran la flota completa.
    async function fetchAllEquipment() {
        const get = page => axios.get('/api/v1/equipment', { params: { page } });
        const first = (await get(1)).data;
        const rest = await Promise.all(Array.from({ length: first.meta.last_page - 1 }, (_, i) => get(i + 2)));
        return first.data.concat(...rest.map(r => r.data.data));
    }

    async function loadEquipment() {
        eqStatus.textContent = 'Cargando equipos…';
        try {
            const rows = await fetchAllEquipment();
            eqStatus.textContent = '';
            eqTable = new DataTable('#eq-table', {
                data: rows,
                columns: [
                    { title: 'Código', data: 'internal_code', render: text(d => d) },
                    { title: 'Tipo', data: 'type', render: text(d => label(d)) },
                    { title: 'Patente', data: 'license_plate', render: text(d => d || '—') },
                    { title: 'Marca / modelo', data: 'brand', render: text((d, r) => `${r.brand} ${r.model}`) },
                    { title: 'Horómetro', data: 'current_hour_meter', className: 'text-end',
                      render: (d, t) => t === 'display' ? `${num(d)} h` : Number(d) },
                    { title: 'Estado', data: 'status', render: text(d => label(d)) },
                    { title: 'Ver', data: null, orderable: false, searchable: false, className: 'text-end text-nowrap',
                      render: () => '<button type="button" class="btn btn-sm btn-outline-secondary ms-1" data-action="maintenances">Mantenciones</button>'
                          + '<button type="button" class="btn btn-sm btn-outline-secondary ms-1" data-action="fuel">Combustible</button>'
                          + '<button type="button" class="btn btn-sm btn-outline-secondary ms-1" data-action="report">Reporte</button>' },
                ],
                createdRow: (row, eq) => row.querySelectorAll('button[data-action]').forEach(b =>
                    b.setAttribute('aria-label', `${b.textContent} de ${eq.internal_code}`)),
                pageLength: 10,
                language: {
                    search: 'Buscar:', lengthMenu: 'Mostrar _MENU_ equipos',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ equipos', infoEmpty: 'Sin equipos',
                    infoFiltered: '(filtrado de _MAX_)', zeroRecords: 'Ningún equipo coincide con la búsqueda.',
                    emptyTable: 'Aún no hay equipos registrados.',
                    paginate: { first: 'Primero', last: 'Último', next: 'Siguiente', previous: 'Anterior' },
                },
            });
        } catch (err) {
            eqStatus.textContent = errMsg(err);
        }
    }

    document.getElementById('eq-table').addEventListener('click', e => {
        const b = e.target.closest('button[data-action]');
        if (!b) return;
        const eq = eqTable.row(b.closest('tr')).data();
        if (b.dataset.action === 'report') openReport(eq);
        else openHistory(eq, b.dataset.action);
    });

    // ── Historial (mantenciones / combustible) ──────
    const KINDS = {
        maintenances: {
            title: 'Mantenciones', path: 'maintenances',
            cols: ['Fecha', 'Tipo', 'Horómetro', 'Costo', 'Descripción'],
            row: m => [date(m.occurred_at), label(m.type), `${num(m.hour_meter)} h`, clp(m.cost_clp), m.description || '—'],
        },
        fuel: {
            title: 'Cargas de combustible', path: 'fuel-loads',
            cols: ['Fecha', 'Combustible', 'Litros', 'Monto', 'Horómetro'],
            row: f => [date(f.occurred_at), label(f.fuel_type), num(f.liters), clp(f.amount_clp), `${num(f.hour_meter)} h`],
        },
    };
    const hHead = document.getElementById('history-head');
    const hBody = document.getElementById('history-body');
    const hStatus = document.getElementById('history-status');
    const hPager = document.getElementById('history-pager');
    let current = null;

    function openHistory(eq, kind) {
        current = { eq, kind: KINDS[kind] };
        document.getElementById('history-title').textContent = `${current.kind.title} · ${eq.internal_code}`;
        const tr = document.createElement('tr');
        current.kind.cols.forEach(c => tr.append(el('th', c)));
        hHead.replaceChildren(tr);
        hBody.replaceChildren();
        hPager.replaceChildren();
        historyModal.show();
        loadHistory(1);
    }

    async function loadHistory(page) {
        const { eq, kind } = current;
        hStatus.textContent = 'Cargando…';
        try {
            const { data } = await axios.get(`/api/v1/equipment/${eq.id}/${kind.path}`, { params: { page } });
            hBody.replaceChildren();
            data.data.forEach(item => {
                const tr = document.createElement('tr');
                kind.row(item).forEach(v => tr.append(el('td', v)));
                hBody.append(tr);
            });
            hStatus.textContent = data.data.length ? '' : 'Este equipo no tiene registros.';
            renderPager(hPager, data.meta, loadHistory);
        } catch (err) {
            hStatus.textContent = errMsg(err);
        }
    }

    // ── Reporte con rango de fechas ─────────────────
    const rForm = document.getElementById('report-form');
    const rError = document.getElementById('report-error');
    const rResult = document.getElementById('report-result');
    const rBtn = document.getElementById('report-btn');
    let reportEq = null;

    function openReport(eq) {
        reportEq = eq;
        document.getElementById('report-title').textContent = `Reporte · ${eq.internal_code}`;
        rForm.reset();
        rError.textContent = '';
        rResult.hidden = true;
        reportModal.show();
    }

    rForm.addEventListener('submit', async e => {
        e.preventDefault();
        rError.textContent = '';
        rResult.hidden = true;
        const from = document.getElementById('report-from').value;
        const to = document.getElementById('report-to').value;
        if (!from || !to) { rError.textContent = 'Ingresa la fecha inicial y la final.'; return; }
        if (from > to) { rError.textContent = 'La fecha inicial no puede ser posterior a la final.'; return; }

        rBtn.disabled = true;
        try {
            const { data } = await axios.get(`/api/v1/equipment/${reportEq.id}/report`, { params: { from, to } });
            document.getElementById('r-liters').textContent = `${num(data.total_liters)} L`;
            document.getElementById('r-fuel').textContent = clp(data.total_fuel_amount_clp);
            document.getElementById('r-maint').textContent = clp(data.total_maintenance_cost_clp);
            document.getElementById('r-lph').textContent = data.liters_per_hour === null ? 'Sin datos suficientes' : `${num(data.liters_per_hour)} L/h`;
            rResult.hidden = false;
        } catch (err) {
            rError.textContent = errMsg(err);
        } finally {
            rBtn.disabled = false;
        }
    });

    loadEquipment();
})();
</script>

</body>
</html>
