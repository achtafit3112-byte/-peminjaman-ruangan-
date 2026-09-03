function hitungDurasi() {
    const mulai = document.getElementById('waktu_mulai');
    const selesai = document.getElementById('waktu_selesai');
    const output = document.getElementById('durasi');
    if (!mulai || !selesai || !output || !mulai.value || !selesai.value) return;
    const a = new Date('2000-01-01T' + mulai.value);
    const b = new Date('2000-01-01T' + selesai.value);
    let jam = (b - a) / 3600000;
    if (jam < 0) jam += 24;
    output.value = jam.toFixed(1) + ' jam';
}
