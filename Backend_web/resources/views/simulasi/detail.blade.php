<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Simulasi - SIM-002</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-honda { background-color: #cc0000; }
        .text-honda { color: #cc0000; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-honda p-6 text-white flex justify-between items-center">
            <h2 class="font-bold">Detail simulasi — SIM-002</h2>
            <a href="/simulasi" class="text-white opacity-80 hover:opacity-100 font-bold">✕</a>
        </div>

        <div class="p-6 border-b border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-honda rounded-full flex items-center justify-center text-white font-bold text-lg">SR</div>
            <div>
                <h3 class="font-bold text-gray-800">Siti Rahayu</h3>
                <p class="text-sm text-gray-400 font-medium">siti@gmail.com</p>
            </div>
        </div>

        <div class="p-6 space-y-4">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Pekerjaan</span>
                <span class="font-bold text-gray-800">Wiraswasta</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Penghasilan/bulan</span>
                <span class="font-bold text-gray-800">Rp 3.800.000</span>
            </div>
            <hr class="border-dashed">
            <div class="flex justify-between text-sm text-honda font-bold uppercase tracking-wider">
                <span>Motor dipilih</span>
                <span>Honda Beat Street</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 text-xs">Harga motor</span>
                <span class="font-bold text-gray-800">Rp 18.900.000</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 text-xs">Uang muka (DP)</span>
                <span class="font-bold text-gray-800">Rp 2.500.000</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 font-medium">Cicilan/bulan</span>
                <span class="font-bold text-honda">Rp 480.000</span>
            </div>
            <div class="flex justify-between text-sm border-t pt-4">
                <span class="text-gray-500">Tenor</span>
                <span class="font-bold text-gray-800 text-lg">24 <span class="text-xs font-normal">bulan</span></span>
            </div>
            <div class="bg-red-50 p-3 rounded-lg flex justify-between items-center">
                <span class="text-xs text-honda font-bold uppercase">Total Bayar</span>
                <span class="font-black text-honda">Rp 14.020.000</span>
            </div>
        </div>

        <div class="p-6 pt-0 flex gap-3">
            <button class="flex-1 border border-gray-300 py-2 rounded-lg font-bold text-gray-600 hover:bg-gray-50 transition">Tutup</button>
            <button class="flex-1 border border-honda text-honda py-2 rounded-lg font-bold hover:bg-red-50 transition">Cetak PDF</button>
        </div>
    </div>

</body>
</html>