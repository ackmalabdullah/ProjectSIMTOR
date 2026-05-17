import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:http/http.dart' as http;

import '../theme/app_theme.dart';
import '../models/motor_model.dart';
import '../models/hasil_simulasi.dart';
import '../services/auth_service.dart';
import 'hasil_screen.dart';

class SimulasiScreen extends StatefulWidget {
  final MotorModel motor;

  const SimulasiScreen({super.key, required this.motor});

  @override
  State<SimulasiScreen> createState() => _SimulasiScreenState();
}

class _SimulasiScreenState extends State<SimulasiScreen> {
  final _namaController = TextEditingController();
  final _penghasilanController = TextEditingController();

  String? _selectedPekerjaan;
  String? _selectedDp;

  bool isLoading = false;

  final double _kelengkapan = 0.6;

  final List<String> _pekerjaanOptions = [
    'Karyawan Swasta',
    'PNS',
    'Wiraswasta',
    'Freelancer',
    'Lainnya',
  ];

  final List<String> _dpOptions = ['10', '20', '30', '40', '50', '60'];

  @override
  void initState() {
    super.initState();
    loadUser();
  }

  Future<void> loadUser() async {
    final user = await AuthService.getUserData();

    if (user != null) {
      setState(() {
        _namaController.text = user['nama'] ?? '';
      });
    }
  }

  @override
  void dispose() {
    _namaController.dispose();
    _penghasilanController.dispose();
    super.dispose();
  }

  Future<void> _proses() async {
    try {
      setState(() {
        isLoading = true;
      });

      final penghasilan =
          double.tryParse(_penghasilanController.text.replaceAll('.', '')) ?? 0;

      final dpPersen = double.tryParse(_selectedDp ?? '10') ?? 10;

      if (penghasilan <= 0) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text("Penghasilan harus diisi")),
        );

        setState(() {
          isLoading = false;
        });

        return;
      }

      final response = await http.post(
        Uri.parse("http://192.168.1.6:8000/predict"),
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "nama_motor": widget.motor.name,
          "penghasilan": penghasilan,
          "dp_persen": dpPersen,
        }),
      );

      print("STATUS : ${response.statusCode}");
      print("BODY : ${response.body}");

      setState(() {
        isLoading = false;
      });

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        final hasil = HasilSimulasi(
          motorId: widget.motor.id,

          motorName: data['motor'],

          hargaMotor: (data['harga_otr'] as num).toDouble(),

          penghasilan: penghasilan,

          dpPersen: dpPersen / 100,

          dpNominal: (data['dp_nominal'] as num).toDouble(),

          tenorRekomendasi: data['tenor_rekomendasi'],

          cicilanPerBulan: (data['cicilan_per_bulan'] as num).toDouble(),

          rasioGaji: (data['persen_dari_gaji'] as num).toDouble() / 100,

          alasanRekomendasi: data['status_kelayakan'] == "LAYAK"
              ? "Motor masih dalam batas aman cicilan terhadap penghasilan bulanan."
              : "Cicilan melebihi batas aman penghasilan bulanan sehingga kurang direkomendasikan.",

          tanggal: DateTime.now(),

          // 🔥 INI YANG BENAR
          statusKelayakan: data['status_kelayakan'],

          imageUrl: widget.motor.imageUrl,
        );

        final result = await Navigator.push(
          context,
          MaterialPageRoute(builder: (_) => HasilScreen(hasil: hasil)),
        );

        if (result == true) {
          // refresh data riwayat
          setState(() {});
        }
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text("Gagal memproses simulasi")),
        );
      }
    } catch (e) {
      print("ERROR : $e");

      setState(() {
        isLoading = false;
      });

      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Error : $e")));
    }
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
          '< Simulasi',
          style: GoogleFonts.poppins(
            fontSize: 16,
            fontWeight: FontWeight.w600,
            color: AppTheme.textDark,
          ),
        ),
      ),
      body: Column(
        children: [
          _buildStepIndicator(currentStep: 1),

          Container(
            margin: const EdgeInsets.all(16),
            padding: const EdgeInsets.all(14),
            decoration: BoxDecoration(
              color: AppTheme.primaryRed,
              borderRadius: BorderRadius.circular(10),
            ),
            child: Row(
              children: [
                const Icon(Icons.motorcycle, color: AppTheme.white, size: 28),
                const SizedBox(width: 12),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'Motor dipilih',
                      style: GoogleFonts.poppins(
                        fontSize: 12,
                        color: AppTheme.white.withOpacity(0.85),
                      ),
                    ),
                    Text(
                      widget.motor.name,
                      style: GoogleFonts.poppins(
                        fontSize: 15,
                        fontWeight: FontWeight.w700,
                        color: AppTheme.white,
                      ),
                    ),
                    Text(
                      widget.motor.hargaLengkap,
                      style: GoogleFonts.poppins(
                        fontSize: 13,
                        color: AppTheme.white,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),

          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.symmetric(horizontal: 16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  _buildSectionTitle('Data Pribadi'),

                  const SizedBox(height: 8),

                  TextField(
                    controller: _namaController,
                    readOnly: true,
                    decoration: const InputDecoration(hintText: 'Nama User'),
                  ),

                  const SizedBox(height: 12),

                  TextField(
                    controller: _penghasilanController,
                    keyboardType: TextInputType.number,
                    inputFormatters: [FilteringTextInputFormatter.digitsOnly],
                    decoration: const InputDecoration(
                      hintText: '0',
                      prefixText: 'Rp ',
                    ),
                  ),

                  const SizedBox(height: 12),

                  _buildDropdown(
                    hint: 'Pilih pekerjaan',
                    value: _selectedPekerjaan,
                    items: _pekerjaanOptions,
                    onChanged: (v) {
                      setState(() {
                        _selectedPekerjaan = v;
                      });
                    },
                  ),

                  const SizedBox(height: 20),

                  _buildSectionTitle('Detail Kredit'),

                  const SizedBox(height: 8),

                  _buildDropdown(
                    hint: 'Pilih DP (%)',
                    value: _selectedDp,
                    items: _dpOptions,
                    onChanged: (v) {
                      setState(() {
                        _selectedDp = v;
                      });
                    },
                  ),

                  const SizedBox(height: 20),

                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text(
                        'Kelengkapan data',
                        style: GoogleFonts.poppins(
                          fontSize: 13,
                          color: AppTheme.grey,
                        ),
                      ),
                      Text(
                        '${(_kelengkapan * 100).toInt()}%',
                        style: GoogleFonts.poppins(
                          fontSize: 13,
                          fontWeight: FontWeight.w600,
                          color: AppTheme.primaryRed,
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 6),

                  LinearProgressIndicator(
                    value: _kelengkapan,
                    backgroundColor: AppTheme.lightGrey,
                    valueColor: const AlwaysStoppedAnimation(
                      AppTheme.primaryRed,
                    ),
                    minHeight: 8,
                    borderRadius: BorderRadius.circular(4),
                  ),

                  const SizedBox(height: 24),
                ],
              ),
            ),
          ),

          Padding(
            padding: const EdgeInsets.all(16),
            child: SizedBox(
              width: double.infinity,
              height: 52,
              child: ElevatedButton(
                onPressed: isLoading ? null : _proses,
                child: isLoading
                    ? const CircularProgressIndicator(color: Colors.white)
                    : Text(
                        'Proses Simulasi',
                        style: GoogleFonts.poppins(
                          fontSize: 15,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSectionTitle(String title) {
    return Text(
      title,
      style: GoogleFonts.poppins(
        fontSize: 15,
        fontWeight: FontWeight.w700,
        color: AppTheme.textDark,
      ),
    );
  }

  Widget _buildDropdown({
    required String hint,
    required String? value,
    required List<String> items,
    required void Function(String?) onChanged,
  }) {
    return Container(
      decoration: BoxDecoration(
        border: Border.all(color: AppTheme.borderColor),
        borderRadius: BorderRadius.circular(25),
      ),
      padding: const EdgeInsets.symmetric(horizontal: 20),
      child: DropdownButtonHideUnderline(
        child: DropdownButton<String>(
          value: value,
          hint: Text(
            hint,
            style: GoogleFonts.poppins(fontSize: 14, color: AppTheme.grey),
          ),
          isExpanded: true,
          icon: const Icon(Icons.keyboard_arrow_down, color: AppTheme.grey),
          items: items.map((item) {
            return DropdownMenuItem(
              value: item,
              child: Text(item, style: GoogleFonts.poppins(fontSize: 14)),
            );
          }).toList(),
          onChanged: onChanged,
        ),
      ),
    );
  }
}

Widget _buildStepIndicator({required int currentStep}) {
  return Padding(
    padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
    child: Row(
      children: [
        _StepCircle(label: 'Motor', step: 1, currentStep: currentStep),
        _StepLine(isActive: currentStep >= 1),
        _StepCircle(label: 'Data', step: 2, currentStep: currentStep),
        _StepLine(isActive: currentStep >= 2),
        _StepCircle(label: 'Hasil', step: 3, currentStep: currentStep),
      ],
    ),
  );
}

class _StepCircle extends StatelessWidget {
  final String label;
  final int step;
  final int currentStep;

  const _StepCircle({
    required this.label,
    required this.step,
    required this.currentStep,
  });

  @override
  Widget build(BuildContext context) {
    final isActive = currentStep >= step;

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
            child: Text(
              step == 1 ? 'V' : step.toString(),
              style: GoogleFonts.poppins(
                fontSize: 13,
                fontWeight: FontWeight.w700,
                color: isActive ? AppTheme.white : AppTheme.grey,
              ),
            ),
          ),
        ),
        const SizedBox(height: 2),
        Text(
          label,
          style: GoogleFonts.poppins(
            fontSize: 11,
            color: isActive ? AppTheme.primaryRed : AppTheme.grey,
            fontWeight: isActive ? FontWeight.w600 : FontWeight.normal,
          ),
        ),
      ],
    );
  }
}

class _StepLine extends StatelessWidget {
  final bool isActive;

  const _StepLine({required this.isActive});

  @override
  Widget build(BuildContext context) {
    return Expanded(
      child: Container(
        height: 2,
        margin: const EdgeInsets.only(bottom: 18),
        color: isActive ? AppTheme.primaryRed : AppTheme.lightGrey,
      ),
    );
  }
}
