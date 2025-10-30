<!-- Floating Help Panel -->
<div id="floating-help" class="floating-help">
    <div id="floating-header" class="floating-header">
        <span>Guía de fórmulas</span>
        <button id="minimize-btn" class="btn-minimize">−</button>
    </div>

    <div id="floating-tabs" class="floating-tabs">
       
        <button class="tab-btn active" data-tab="tab-math">Matemáticas</button>
        <button class="tab-btn" data-tab="tab-chem">Química</button>
    </div>

    <div id="tab-math" class="tab-content active">
        <p> Para crear es "$...$"" y para centrar "$$...$$" </p>
        @foreach([
            ['Pitágoras', 'a^2 + b^2 = c^2'],
            ['Fracción', '\\frac{a}{b}'],
            ['Raíz cuadrada', '\\sqrt{x}'],
            ['Integral', '\\int x\, dx = \\frac{x^2}{2} + C'],
            ['Sumatoria', '\\sum_{i=1}^n i = \\frac{n(n+1)}{2}'],
            ['Exponente', 'x^n']
        ] as [$label, $latex])
            <div class="formula-row">
                <div class="formula-text">{{ $label }}</div>
                <div class="formula-code">{{ $latex }}</div>
                <div class="formula-render">\( {{ $latex }} \)</div>
            </div>
        @endforeach
    </div>

    <div id="tab-chem" class="tab-content">
        @foreach([
            ['Molécula agua', '\\ce{H2O}'],
            ['Reacción química', '\\ce{2H2 + O2 -> 2H2O}'],
            ['Iones', '\\ce{Na+ + Cl- -> NaCl}'],
            ['Estados', '\\ce{H2(g) + O2(g) -> H2O(l)}'],
            ['Ácido acético', '\\ce{CH3COOH}']
        ] as [$label, $latex])
            <div class="formula-row">
                <div class="formula-text">{{ $label }}</div>
                <div class="formula-code">{{ $latex }}</div>
                <div class="formula-render">\( {{ $latex }} \)</div>
            </div>
        @endforeach
    </div>
</div>

<!-- Styles -->
<style>
    .floating-help {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 320px;
        max-height: 400px;
        background: #f8f9fa;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-size: 0.9rem;
        z-index: 10000;
        display: flex;
        flex-direction: column;
        cursor: default;
    }

    .floating-header {
        background: #343a40;
        color: white;
        padding: 10px;
        border-radius: 10px 10px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: grab;
    }

    .floating-header:active {
        cursor: grabbing;
    }

    .btn-minimize {
        background: transparent;
        border: none;
        color: white;
        font-size: 1.3rem;
        cursor: pointer;
    }

    .floating-tabs {
        display: flex;
        border-bottom: 1px solid #ccc;
    }

    .tab-btn {
        flex: 1;
        padding: 8px;
        border: none;
        background: #e9ecef;
        cursor: pointer;
        font-weight: bold;
    }

    .tab-btn.active {
        background: #dee2e6;
        color: black;
    }

    .tab-content {
        padding: 10px;
        overflow-y: auto;
        max-height: 300px;
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .formula-row {
        margin-bottom: 10px;
    }

    .formula-text {
        font-weight: bold;
    }

    .formula-code {
        font-family: monospace;
        background: #eee;
        padding: 2px 5px;
        border-radius: 4px;
    }

    .formula-render {
        margin-top: 4px;
    }
</style>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const help = document.getElementById('floating-help');
    const header = document.getElementById('floating-header');
    const minimizeBtn = document.getElementById('minimize-btn');
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    // Minimizar / restaurar
    minimizeBtn.addEventListener('click', () => {
        const minimized = help.style.height === '40px';
        help.style.height = minimized ? '' : '40px';
        document.getElementById('floating-tabs').style.display = minimized ? 'flex' : 'none';
        contents.forEach(c => c.style.display = minimized && c.classList.contains('active') ? 'block' : 'none');
        minimizeBtn.textContent = minimized ? '−' : '+';
    });

    // Tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            contents.forEach(c => c.classList.remove('active'));
            document.getElementById(tab.dataset.tab).classList.add('active');

            if (help.style.height !== '40px') {
                contents.forEach(c => c.style.display = c.classList.contains('active') ? 'block' : 'none');
            }
        });
    });

    // Arrastrar
    let dragging = false, startX, startY, startLeft, startTop;
    header.addEventListener('mousedown', (e) => {
        dragging = true;
        startX = e.clientX;
        startY = e.clientY;
        const rect = help.getBoundingClientRect();
        startLeft = rect.left;
        startTop = rect.top;
        document.body.style.userSelect = 'none';
    });

    document.addEventListener('mouseup', () => {
        dragging = false;
        document.body.style.userSelect = '';
    });

    document.addEventListener('mousemove', (e) => {
        if (!dragging) return;
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        const left = Math.max(0, Math.min(window.innerWidth - help.offsetWidth, startLeft + dx));
        const top = Math.max(0, Math.min(window.innerHeight - help.offsetHeight, startTop + dy));
        help.style.left = left + 'px';
        help.style.top = top + 'px';
        help.style.right = 'auto';
        help.style.bottom = 'auto';
    });
});
</script>

<!-- MathJax -->
<script>
window.MathJax = {
    tex: {
        inlineMath: [['\\(', '\\)']],
        displayMath: [['\\[', '\\]']],
        packages: { '[+]': ['mhchem'] }
    },
    svg: { fontCache: 'global' }
};
</script>
<script async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
