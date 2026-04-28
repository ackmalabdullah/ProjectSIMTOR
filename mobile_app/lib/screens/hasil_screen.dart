import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';
import '../models/motor_model.dart';

class HasilScreen extends StatelessWidget {
  final HasilSimulasi hasil;
  const HasilScreen({super.key, required this.hasil});

  String _formatRupiah(double value) {
    if (value >= 1000000) {
      return 'Rp ${(value / 1000000).toStringAsFixed(1)} Jt';
    }
    final formatted = value
        .toStringAsFixed(0)
        .replaceAllMapped(
          RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
          (m) => '${m[1]}.',
        );
    return 'Rp $formatted';
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.white,
      appBar: AppBar(
        backgroundColor: AppTheme.white,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: AppTheme.textDark),
          onPressed: () => Navigator.pop(context),
        ),
        title: Text(
          '< Hasil',
          style: GoogleFonts.poppins(
              fontSize: 16,
              fontWeight: FontWeight.w600,
              color: AppTheme.textDark),
        ),
      ),
      body: Column(
        children: [
          // Step indicator
          _buildStepIndicator(),

          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Summary Cards
                  Row(
                    children: [
                      _buildSummaryCard('Total harga',
                          _formatRupiah(hasil.totalHarga), false),
                      const SizedBox(width: 8),
                      _buildSummaryCard(
                          'Dp dibayar', _formatRupiah(hasil.dpDibayar), false),
                      const SizedBox(width: 8),
                      _buildSummaryCard(
                          'Sisa Kredit', _formatRupiah(hasil.sisaKredit), false),
                    ],
                  ),

                  const SizedBox(height: 20),
                  Text('Pilih cicilan kamu',
                      style: GoogleFonts.poppins(
                          fontSize: 15, fontWeight: FontWeight.w700)),
                  const SizedBox(height: 12),

                  // Tenor options
                  Row(
                    children: [
                      _buildTenorCard('12 bulan', '1,7jt', false),
                      const SizedBox(width: 8),
                      _buildTenorCard('24 bulan', '954rb', true),
                      const SizedBox(width: 8),
                      _buildTenorCard('36 bulan', '679rb', false),
                    ],
                  ),

                  const SizedBox(height: 20),

                  // ML Analysis Card
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: AppTheme.lightGrey,
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Container(
                              padding: const EdgeInsets.symmetric(
                                  horizontal: 8, vertical: 3),
                              decoration: BoxDecoration(
                                color: AppTheme.primaryRed,
                                borderRadius: BorderRadius.circular(6),
                              ),
                              child: Text('Analisis ML Model',
                                  style: GoogleFonts.poppins(
                                      fontSize: 12,
                                      fontWeight: FontWeight.w600,
                                      color: AppTheme.white)),
                            ),
                          ],
                        ),
                        const SizedBox(height: 12),
                        _buildAnalisisRow(
                            'Tenor Rekomendasi', '${hasil.tenorRekomendasi} bulan'),
                        _buildAnalisisRow('Cicilan per bulan',
                            _formatRupiah(hasil.cicilanPerBulan)),
                        _buildAnalisisRow('Rasio cicilan/gaji',
                            '${(hasil.rasioGaji * 100).toInt()}% v'),
                        const SizedBox(height: 8),
                        Text('Alasan Rekomendasi',
                            style: GoogleFonts.poppins(
                                fontSize: 13, fontWeight: FontWeight.w600)),
                        const SizedBox(height: 4),
                        Text(
                          hasil.alasanRekomendasi,
                          style: GoogleFonts.poppins(
                              fontSize: 12,
                              color: AppTheme.darkGrey,
                              height: 1.5),
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(height: 20),
                ],
              ),
            ),
          ),

          Padding(
            padding: const EdgeInsets.all(16),
            child: ElevatedButton(
              onPressed: () {
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: Text('Simulasi disimpan ke riwayat!',
                        style: GoogleFonts.poppins()),
                    backgroundColor: AppTheme.primaryRed,
                    duration: const Duration(seconds: 2),
                  ),
                );
              },
              child: Text('Simpan ke Riwayat',
                  style: GoogleFonts.poppins(
                      fontSize: 15, fontWeight: FontWeight.w600)),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStepIndicator() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
      child: Row(
        children: [
          _stepCircle('V', 'Motor', true),
          _stepLine(true),
          _stepCircle('V', 'Data', true),
          _stepLine(true),
          _stepCircle('3', 'Hasil', true),
        ],
      ),
    );
  }

  Widget _stepCircle(String label, String text, bool isActive) {
    return Column(
      children: [
        Container(
          width: 32,
          height: 32,
          decoration: BoxDecoration(
            color: isActive ? AppTheme.primaryRed : AppTheme.lightGrey,
            shape: BoxShape.circle,
          ),
          child: Center(
            child: Text(label,
                style: GoogleFonts.poppins(
                    fontSize: 13,
                    fontWeight: FontWeight.w700,
                    color: AppTheme.white)),
          ),
        ),
        const SizedBox(height: 2),
        Text(text,
            style: GoogleFonts.poppins(
                fontSize: 11,
                color: AppTheme.primaryRed,
                fontWeight: FontWeight.w600)),
      ],
    );
  }

  Widget _stepLine(bool isActive) {
    return Expanded(
      child: Container(
        height: 2,
        margin: const EdgeInsets.only(bottom: 18),
        color: isActive ? AppTheme.primaryRed : AppTheme.lightGrey,
      ),
    );
  }

  Widget _buildSummaryCard(String title, String value, bool highlight) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(10),
        decoration: BoxDecoration(
          color: highlight ? AppTheme.primaryRed : AppTheme.lightGrey,
          borderRadius: BorderRadius.circular(10),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(title,
                style: GoogleFonts.poppins(
                    fontSize: 11,
                    color: highlight ? AppTheme.white : AppTheme.grey)),
            const SizedBox(height: 2),
            Text(value,
                style: GoogleFonts.poppins(
                    fontSize: 13,
                    fontWeight: FontWeight.w700,
                    color: highlight ? AppTheme.white : AppTheme.textDark)),
          ],
        ),
      ),
    );
  }

  Widget _buildTenorCard(String tenor, String cicilan, bool isRecommended) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 14, horizontal: 8),
        decoration: BoxDecoration(
          color: isRecommended ? AppTheme.primaryRed : AppTheme.lightGrey,
          borderRadius: BorderRadius.circular(10),
          border: Border.all(
            color: isRecommended ? AppTheme.primaryRed : AppTheme.borderColor,
            width: 2,
          ),
        ),
        child: Column(
          children: [
            Text(cicilan,
                style: GoogleFonts.poppins(
                    fontSize: 18,
                    fontWeight: FontWeight.w800,
                    color:
                        isRecommended ? AppTheme.white : AppTheme.textDark)),
            Text('/bulan',
                style: GoogleFonts.poppins(
                    fontSize: 11,
                    color: isRecommended
                        ? AppTheme.white.withOpacity(0.85)
                        : AppTheme.grey)),
            const SizedBox(height: 4),
            Text(tenor,
                style: GoogleFonts.poppins(
                    fontSize: 12,
                    color: isRecommended
                        ? AppTheme.white.withOpacity(0.85)
                        : AppTheme.grey)),
          ],
        ),
      ),
    );
  }

  Widget _buildAnalisisRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 3),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(label,
              style:
                  GoogleFonts.poppins(fontSize: 13, color: AppTheme.grey)),
          Text(value,
              style: GoogleFonts.poppins(
                  fontSize: 13, fontWeight: FontWeight.w600)),
        ],
      ),
    );
  }
}
