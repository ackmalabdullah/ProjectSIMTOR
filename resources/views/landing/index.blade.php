<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotorKredit - Simulasi Kredit Motor Mudah & Cepat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://source.unsplash.com/random/1920x1080/?motorcycle') center/cover no-repeat;
            height: 100vh;
            color: white;
        }
        .card-motor {
            transition: transform 0.3s;
        }
        .card-motor:hover {
            transform: translateY(-10px);
        }
        .simulator {
            background: #f8f9fa;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">MotorKredit</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#simulasi">Simulasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#motor">Motor</a></li>
                    <li class="nav-item"><a class="nav-link" href="#keuntungan">Keuntungan</a></li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-3 px-4" href="{{ url('/login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary ms-2 px-4" href="{{ url('/register') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-3 fw-bold mb-4">Mau Cicil Motor Impian?<br>Mudah &amp; Transparan</h1>
                    <p class="lead mb-5">Hitung simulasi kredit motor secara real-time. DP ringan, cicilan terjangkau, proses cepat.</p>
                    <a href="#simulasi" class="btn btn-primary btn-lg px-5 py-3">Hitung Cicilan Sekarang</a>
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-lg px-5 py-3 ms-3">Masuk ke Dashboard</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Simulasi Kredit Section -->
    <section id="simulasi" class="simulator py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Simulasi Kredit Motor</h2>
                <p class="text-muted">Masukkan data di bawah ini untuk melihat estimasi cicilan per bulan</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-body p-5">
                            <form id="simulasiForm">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Pilih Motor</label>
                                        <select class="form-select" id="motor">
                                            <option value="25000000">Yamaha NMAX - Rp 25.000.000</option>
                                            <option value="18000000">Honda Vario 125 - Rp 18.000.000</option>
                                            <option value="32000000">Suzuki GSX-R150 - Rp 32.000.000</option>
                                            <option value="15000000">Honda Beat - Rp 15.000.000</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Uang Muka (DP)</label>
                                        <input type="range" class="form-range" id="dpRange" min="10" max="50" value="20">
                                        <div class="d-flex justify-content-between">
                                            <span id="dpPercent">20%</span>
                                            <span id="dpRupiah">Rp 5.000.000</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tenor (Bulan)</label>
                                        <select class="form-select" id="tenor">
                                            <option value="12">12 Bulan</option>
                                            <option value="24" selected>24 Bulan</option>
                                            <option value="36">36 Bulan</option>
                                            <option value="48">48 Bulan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Suku Bunga (% per tahun)</label>
                                        <input type="number" class="form-control" id="bunga" value="8" step="0.5">
                                    </div>
                                </div>

                                <button type="button" onclick="hitungSimulasi()" class="btn btn-primary w-100 mt-4 py-3 fw-bold">
                                    <i class="bi bi-calculator"></i> Hitung Cicilan
                                </button>
                            </form>

                            <!-- Hasil Simulasi -->
                            <div id="hasil" class="mt-5 pt-4 border-top text-center" style="display: none;">
                                <h4>Cicilan Per Bulan</h4>
                                <h2 class="text-primary fw-bold" id="cicilan">Rp 0</h2>
                                <div class="row mt-4 text-start">
                                    <div class="col-6">
                                        <small class="text-muted">Total Pembayaran</small>
                                        <p class="fw-bold" id="total">Rp 0</p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Total Bunga</small>
                                        <p class="fw-bold" id="bungaTotal">Rp 0</p>
                                    </div>
                                </div>
                                <a href="{{ url('/login') }}" class="btn btn-success mt-3">Ajukan Kredit Sekarang →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Keuntungan -->
    <section id="keuntungan" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Kenapa Memilih MotorKredit?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 card-motor text-center p-4">
                        <i class="bi bi-lightning-charge fs-1 text-primary mb-3"></i>
                        <h5>Proses Cepat</h5>
                        <p>Simulasi instan &amp; pengajuan online hanya dalam hitungan menit.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 card-motor text-center p-4">
                        <i class="bi bi-shield-check fs-1 text-success mb-3"></i>
                        <h5>Transparan</h5>
                        <p>Tidak ada biaya tersembunyi. Semua perhitungan jelas.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 card-motor text-center p-4">
                        <i class="bi bi-graph-up fs-1 text-warning mb-3"></i>
                        <h5>Cicilan Ringan</h5>
                        <p>DP mulai 10% + tenor fleksibel hingga 48 bulan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="text-center">
                <p>&copy; 2026 MotorKredit - Sistem Manajemen &amp; Simulasi Kredit Motor</p>
                <p>
                    <a href="{{ url('/login') }}" class="text-white mx-3">Login</a> |
                    <a href="{{ url('/register') }}" class="text-white mx-3">Daftar</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function hitungSimulasi() {
            let harga = parseFloat(document.getElementById('motor').value);
            let dpPercent = parseFloat(document.getElementById('dpRange').value);
            let dp = harga * (dpPercent / 100);
            let pinjaman = harga - dp;
            let tenor = parseInt(document.getElementById('tenor').value);
            let bungaTahun = parseFloat(document.getElementById('bunga').value) / 100;
            let bungaBulan = bungaTahun / 12;

            // Rumus anuitas sederhana
            let cicilan = (pinjaman * bungaBulan) / (1 - Math.pow(1 + bungaBulan, -tenor));

            let totalBayar = cicilan * tenor;
            let totalBunga = totalBayar - pinjaman;

            document.getElementById('cicilan').textContent = 'Rp ' + Math.round(cicilan).toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp ' + Math.round(totalBayar).toLocaleString('id-ID');
            document.getElementById('bungaTotal').textContent = 'Rp ' + Math.round(totalBunga).toLocaleString('id-ID');
            document.getElementById('hasil').style.display = 'block';
        }

        // Update DP secara real-time
        document.getElementById('dpRange').addEventListener('input', function() {
            let dpP = this.value;
            document.getElementById('dpPercent').textContent = dpP + '%';
            let harga = parseFloat(document.getElementById('motor').value);
            let dpRp = Math.round(harga * (dpP / 100));
            document.getElementById('dpRupiah').textContent = 'Rp ' + dpRp.toLocaleString('id-ID');
        });
    </script>
</body>
</html>