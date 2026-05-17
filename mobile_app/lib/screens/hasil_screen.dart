import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

import '../theme/app_theme.dart';
import '../models/hasil_simulasi.dart';

class HasilScreen extends StatefulWidget {
  final HasilSimulasi hasil;

  const HasilScreen({
    super.key,
    required this.hasil,
  });

  @override
  State<HasilScreen> createState() => _HasilScreenState();
}

class _HasilScreenState extends State<HasilScreen> {
  Future<void> simpanRiwayat() async {
  try {
    final prefs = await SharedPreferences.getInstance();

    final token = prefs.getString('token');

    final response = await http.post(
      Uri.parse(
        "http://192.168.1.6:8080/api/simulasi/simpan",
      ),
      headers: {
        "Content-Type": "application/json",
        "Authorization": "Bearer $token",
      },
      body: jsonEncode({
        "motor_id": widget.hasil.motorId,
        "nama_motor": widget.hasil.motorName,
        "gambar": widget.hasil.imageUrl,
        "harga_motor": widget.hasil.hargaMotor,
        "penghasilan": widget.hasil.penghasilan,
        "dp_persen": widget.hasil.dpPersen * 100,
        "dp_nominal": widget.hasil.dpNominal,
        "tenor": widget.hasil.tenorRekomendasi,
        "cicilan_per_bulan":
            widget.hasil.cicilanPerBulan,
        "persen_gaji":
            widget.hasil.rasioGaji * 100,
        "status_kelayakan":
            widget.hasil.statusKelayakan,
      }),
    );

    print(response.statusCode);
    print(response.body);

    if (response.statusCode == 200) {

      showDialog(
        context: context,
        barrierDismissible: false,
        builder: (_) {
          return AlertDialog(
            shape: RoundedRectangleBorder(
              borderRadius:
                  BorderRadius.circular(20),
            ),
            content: Column(
              mainAxisSize: MainAxisSize.min,
              children: [

                const Icon(
                  Icons.check_circle,
                  color: Colors.green,
                  size: 70,
                ),

                const SizedBox(height: 16),

                Text(
                  "Berhasil!",
                  style: GoogleFonts.poppins(
                    fontSize: 20,
                    fontWeight: FontWeight.w700,
                  ),
                ),

                const SizedBox(height: 8),

                Text(
                  "Hasil simulasi berhasil disimpan ke riwayat",
                  textAlign: TextAlign.center,
                  style: GoogleFonts.poppins(
                    fontSize: 13,
                  ),
                ),
              ],
            ),
          );
        },
      );

      await Future.delayed(
        const Duration(seconds: 2),
      );

      if (mounted) {

        Navigator.of(context).pop();

        Navigator.pop(context, true);
      }

    } else {

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text(
            "Gagal simpan riwayat",
          ),
        ),
      );
    }

  } catch (e) {

    print(e);

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          "Error: $e",
        ),
      ),
    );
  }
}

  String _formatRupiah(double value) {
    if (value >= 1000000) {
      return 'Rp ${(value / 1000000).toStringAsFixed(1)} Jt';
    }

    final formatted = value.toStringAsFixed(0).replaceAllMapped(
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
          icon: const Icon(
            Icons.arrow_back,
            color: AppTheme.textDark,
          ),
          onPressed: () => Navigator.pop(context),
        ),
        title: Text(
          '< Hasil',
          style: GoogleFonts.poppins(
            fontSize: 16,
            fontWeight: FontWeight.w600,
            color: AppTheme.textDark,
          ),
        ),
      ),
      body: Column(
        children: [
          _buildStepIndicator(),

          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment:
                    CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      _buildSummaryCard(
                        'Total harga',
                        _formatRupiah(
                          widget.hasil.totalHarga,
                        ),
                        false,
                      ),

                      const SizedBox(width: 8),

                      _buildSummaryCard(
                        'DP dibayar',
                        _formatRupiah(
                          widget.hasil.dpDibayar,
                        ),
                        false,
                      ),

                      const SizedBox(width: 8),

                      _buildSummaryCard(
                        'Sisa Kredit',
                        _formatRupiah(
                          widget.hasil.sisaKredit,
                        ),
                        false,
                      ),
                    ],
                  ),

                  const SizedBox(height: 20),

                  Text(
                    'Rekomendasi ML',
                    style: GoogleFonts.poppins(
                      fontSize: 15,
                      fontWeight: FontWeight.w700,
                    ),
                  ),

                  const SizedBox(height: 12),

                  Row(
                    children: [
                      _buildTenorCard(
                        '${widget.hasil.tenorRekomendasi} bulan',
                        _formatRupiah(
                          widget.hasil.cicilanPerBulan,
                        ),
                        true,
                      ),
                    ],
                  ),

                  const SizedBox(height: 20),

                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: AppTheme.lightGrey,
                      borderRadius:
                          BorderRadius.circular(12),
                    ),
                    child: Column(
                      crossAxisAlignment:
                          CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Container(
                              padding:
                                  const EdgeInsets.symmetric(
                                horizontal: 8,
                                vertical: 3,
                              ),
                              decoration: BoxDecoration(
                                color:
                                    AppTheme.primaryRed,
                                borderRadius:
                                    BorderRadius.circular(
                                  6,
                                ),
                              ),
                              child: Text(
                                'Analisis ML Model',
                                style:
                                    GoogleFonts.poppins(
                                  fontSize: 12,
                                  fontWeight:
                                      FontWeight.w600,
                                  color:
                                      AppTheme.white,
                                ),
                              ),
                            ),
                          ],
                        ),

                        const SizedBox(height: 12),

                        _buildAnalisisRow(
                          'Tenor Rekomendasi',
                          '${widget.hasil.tenorRekomendasi} bulan',
                        ),

                        _buildAnalisisRow(
                          'Cicilan per bulan',
                          _formatRupiah(
                            widget.hasil
                                .cicilanPerBulan,
                          ),
                        ),

                        _buildAnalisisRow(
                          'Rasio cicilan/gaji',
                          '${(widget.hasil.rasioGaji * 100).toStringAsFixed(1)}%',
                        ),

                        _buildAnalisisRow(
                          'Penghasilan',
                          _formatRupiah(
                            widget.hasil
                                .penghasilan,
                          ),
                        ),

                        const SizedBox(height: 6),

Container(
  padding: const EdgeInsets.symmetric(
    horizontal: 12,
    vertical: 8,
  ),
  decoration: BoxDecoration(
    color: widget.hasil.statusKelayakan
                .toUpperCase()
                .trim() ==
            "LAYAK"
        ? Colors.green.withOpacity(0.15)
        : Colors.red.withOpacity(0.15),
    borderRadius: BorderRadius.circular(8),
  ),
  child: Row(
    children: [
      Icon(
        widget.hasil.statusKelayakan
                    .toUpperCase()
                    .trim() ==
                "LAYAK"
            ? Icons.check_circle
            : Icons.cancel,
        color:
            widget.hasil.statusKelayakan
                        .toUpperCase()
                        .trim() ==
                    "LAYAK"
                ? Colors.green
                : Colors.red,
      ),

      const SizedBox(width: 8),

      Text(
        widget.hasil.statusKelayakan,
        style: GoogleFonts.poppins(
          fontSize: 13,
          fontWeight: FontWeight.w700,
          color:
              widget.hasil.statusKelayakan
                          .toUpperCase()
                          .trim() ==
                      "LAYAK"
                  ? Colors.green
                  : Colors.red,
        ),
      ),
    ],
  ),
),

                        const SizedBox(height: 8),

                        Text(
                          'Alasan Rekomendasi',
                          style: GoogleFonts.poppins(
                            fontSize: 13,
                            fontWeight:
                                FontWeight.w600,
                          ),
                        ),

                        const SizedBox(height: 4),

                        Text(
                          widget.hasil
                              .alasanRekomendasi,
                          style: GoogleFonts.poppins(
                            fontSize: 12,
                            color:
                                AppTheme.darkGrey,
                            height: 1.5,
                          ),
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
              onPressed: simpanRiwayat,
              child: Text(
                'Simpan ke Riwayat',
                style: GoogleFonts.poppins(
                  fontSize: 15,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStepIndicator() {
    return Padding(
      padding: const EdgeInsets.symmetric(
        horizontal: 24,
        vertical: 12,
      ),
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

  Widget _stepCircle(
    String label,
    String text,
    bool isActive,
  ) {
    return Column(
      children: [
        Container(
          width: 32,
          height: 32,
          decoration: BoxDecoration(
            color: isActive
                ? AppTheme.primaryRed
                : AppTheme.lightGrey,
            shape: BoxShape.circle,
          ),
          child: Center(
            child: Text(
              label,
              style: GoogleFonts.poppins(
                fontSize: 13,
                fontWeight: FontWeight.w700,
                color: AppTheme.white,
              ),
            ),
          ),
        ),

        const SizedBox(height: 2),

        Text(
          text,
          style: GoogleFonts.poppins(
            fontSize: 11,
            color: AppTheme.primaryRed,
            fontWeight: FontWeight.w600,
          ),
        ),
      ],
    );
  }

  Widget _stepLine(bool isActive) {
    return Expanded(
      child: Container(
        height: 2,
        margin: const EdgeInsets.only(
          bottom: 18,
        ),
        color: isActive
            ? AppTheme.primaryRed
            : AppTheme.lightGrey,
      ),
    );
  }

  Widget _buildSummaryCard(
    String title,
    String value,
    bool highlight,
  ) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(10),
        decoration: BoxDecoration(
          color: highlight
              ? AppTheme.primaryRed
              : AppTheme.lightGrey,
          borderRadius:
              BorderRadius.circular(10),
        ),
        child: Column(
          crossAxisAlignment:
              CrossAxisAlignment.start,
          children: [
            Text(
              title,
              style: GoogleFonts.poppins(
                fontSize: 11,
                color: highlight
                    ? AppTheme.white
                    : AppTheme.grey,
              ),
            ),

            const SizedBox(height: 2),

            Text(
              value,
              style: GoogleFonts.poppins(
                fontSize: 13,
                fontWeight: FontWeight.w700,
                color: highlight
                    ? AppTheme.white
                    : AppTheme.textDark,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildTenorCard(
    String tenor,
    String cicilan,
    bool isRecommended,
  ) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.symmetric(
          vertical: 14,
          horizontal: 8,
        ),
        decoration: BoxDecoration(
          color: isRecommended
              ? AppTheme.primaryRed
              : AppTheme.lightGrey,
          borderRadius:
              BorderRadius.circular(10),
          border: Border.all(
            color: isRecommended
                ? AppTheme.primaryRed
                : AppTheme.borderColor,
            width: 2,
          ),
        ),
        child: Column(
          children: [
            Text(
              cicilan,
              style: GoogleFonts.poppins(
                fontSize: 18,
                fontWeight: FontWeight.w800,
                color: isRecommended
                    ? AppTheme.white
                    : AppTheme.textDark,
              ),
            ),

            Text(
              '/bulan',
              style: GoogleFonts.poppins(
                fontSize: 11,
                color: isRecommended
                    ? AppTheme.white
                        .withOpacity(0.85)
                    : AppTheme.grey,
              ),
            ),

            const SizedBox(height: 4),

            Text(
              tenor,
              style: GoogleFonts.poppins(
                fontSize: 12,
                color: isRecommended
                    ? AppTheme.white
                        .withOpacity(0.85)
                    : AppTheme.grey,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildAnalisisRow(
    String label,
    String value,
  ) {
    return Padding(
      padding:
          const EdgeInsets.symmetric(vertical: 3),
      child: Row(
        mainAxisAlignment:
            MainAxisAlignment.spaceBetween,
        children: [
          Text(
            label,
            style: GoogleFonts.poppins(
              fontSize: 13,
              color: AppTheme.grey,
            ),
          ),

          Text(
            value,
            style: GoogleFonts.poppins(
              fontSize: 13,
              fontWeight: FontWeight.w600,
            ),
          ),
        ],
      ),
    );
  }
}