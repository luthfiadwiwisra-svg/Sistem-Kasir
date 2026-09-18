// script.js
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const uangDiberi = document.getElementById('uang_diberi');
    const totalEl = document.getElementById('total');
    const kembalianEl = document.getElementById('kembalian');

    function hitungTotal() {
        let total = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const row = cb.closest('tr');
                const harga = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace(/\D/g, ''));
                const jumlah = row.querySelector('input[type="number"]').value || 0;
                total += harga * jumlah;
            }
        });
        totalEl.textContent = total.toLocaleString('id-ID');
        hitungKembalian(total);
    }

    function hitungKembalian(total) {
        const bayar = parseFloat(uangDiberi.value) || 0;
        kembalianEl.textContent = (bayar - total).toLocaleString('id-ID');
    }

    checkboxes.forEach(cb => cb.addEventListener('change', hitungTotal));
    document.querySelectorAll('input[type="number"]').forEach(inp => inp.addEventListener('input', hitungTotal));
    uangDiberi.addEventListener('input', () => hitungKembalian(parseFloat(totalEl.textContent.replace(/\./g, ''))));
});