// Hacer NicEdit responsive - ajustar cuando cambia el tamaño de la ventana
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        document.querySelectorAll('.text-input').forEach(textInput => {
            const nicEditPanel = textInput.querySelector('.nicEdit-panelContain');
            const nicEditMain = textInput.querySelector('.nicEdit-main');
            if (nicEditPanel) {
                nicEditPanel.style.width = '100%';
            }
            if (nicEditMain) {
                nicEditMain.style.width = '100%';
            }
        });
    }, 100);
});
