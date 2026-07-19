(function () {
    function tickDuration() {
        document.querySelectorAll('.duration-live').forEach(function (el) {
            var start = parseInt(el.getAttribute('data-start'), 10);
            if (!start) return;

            var elapsed = Math.floor(Date.now() / 1000) - start;
            if (elapsed < 0) elapsed = 0;

            var h = Math.floor(elapsed / 3600);
            var m = Math.floor((elapsed % 3600) / 60);
            var s = elapsed % 60;

            el.textContent = h + 'j ' + String(m).padStart(2, '0') + 'm ' + String(s).padStart(2, '0') + 'd';
        });
    }

    function tickSla() {
        document.querySelectorAll('.sla-countdown').forEach(function (el) {
            var deadline = parseInt(el.getAttribute('data-deadline'), 10);
            if (!deadline) return;

            var diff = deadline - Math.floor(Date.now() / 1000);
            var over = diff <= 0;
            var abs = Math.abs(diff);

            var h = Math.floor(abs / 3600);
            var m = Math.floor((abs % 3600) / 60);
            var s = abs % 60;

            var text = (over ? 'LEWAT WAKTU ' : 'Sisa ') + h + 'j ' + String(m).padStart(2, '0') + 'm ' + String(s).padStart(2, '0') + 'd';
            el.textContent = text;
            el.classList.toggle('text-red-600', over);
        });
    }

    function tick() {
        tickDuration();
        tickSla();
    }

    tick();
    setInterval(tick, 1000);
})();