import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';
import '../models/motor_model.dart';
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
  String? _selectedTenor;
  double _kelengkapan = 0.6;

  final List<String> _pekerjaanOptions = [
    'Karyawan Swasta',
    'PNS',
    'Wiraswasta',
    'Freelancer',
    'Lainnya',
  ];

  final List<String> _tenorOptions = ['12 bulan', '18 bulan', '24 bulan', '36 bulan'];

  @override
  void dispose() {
    _namaController.dispose();
    _penghasilanController.dispose();
    super.dispose();
  }

  void _proses() {
    final penghasilan =
        double.tryParse(_penghasilanController.text.replaceAll('.', '')) ??
            3400000;
    final tenor = int.tryParse(
            (_selectedTenor ?? '24 bulan').replaceAll(RegExp(r'[^0-9]'), '')) ??
        24;

    final hasil = HasilSimulasi(
      motorName: 'Honda ${widget.motor.name}',
      hargaMotor: widget.motor.harga,
      dpPersen: 0.1,
      tenorRekomendasi: 24,
      cicilanPerBulan: 954000,
      rasioGaji: 0.28,
      alasanRekomendasi:
          'Berdasarkan penghasilanmu Rp ${(penghasilan / 1000000).toStringAsFixed(1)} jt/bln, tenor 24 bulan menjaga cicilan di bawah 30% gaji — batas sehat menurut standar OJK. Tenor lebih pendek berisiko memberatkan, tenor lebih panjang menambah bunga total.',
      tanggal: DateTime.now(),
    );

    Navigator.push(
      context,
      MaterialPageRoute(builder: (_) => HasilScreen(hasil: hasil)),
    );
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
              color: AppTheme.textDark),
        ),
      ),
      body: Column(
        children: [
          // Step indicator
          _buildStepIndicator(currentStep: 1),

          // Motor selected banner
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
                          color: AppTheme.white.withOpacity(0.85)),
                    ),
                    Text(
                      'Honda ${widget.motor.name}',
                      style: GoogleFonts.poppins(
                          fontSize: 15,
                          fontWeight: FontWeight.w700,
                          color: AppTheme.white),
                    ),
                    Text(
                      widget.motor.hargaLengkap,
                      style: GoogleFonts.poppins(
                          fontSize: 13, color: AppTheme.white),
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
                    decoration: const InputDecoration(hintText: 'Masukan nama'),
                  ),
                  const SizedBox(height: 12),
                  TextField(
                    controller: _penghasilanController,
                    keyboardType: TextInputType.number,
                    inputFormatters: [FilteringTextInputFormatter.digitsOnly],
                    decoration:
                        const InputDecoration(hintText: 'Rp 0', prefixText: 'Rp '),
                  ),
                  const SizedBox(height: 12),
                  _buildDropdown(
                    hint: 'Pilih pekerjaan',
                    value: _selectedPekerjaan,
                    items: _pekerjaanOptions,
                    onChanged: (v) =>
                        setState(() => _selectedPekerjaan = v),
                  ),

                  const SizedBox(height: 20),
                  _buildSectionTitle('Detail Kredit'),
                  const SizedBox(height: 8),
                  _buildDropdown(
                    hint: 'Pilih Tenor',
                    value: _selectedTenor,
                    items: _tenorOptions,
                    onChanged: (v) => setState(() => _selectedTenor = v),
                  ),

                  const SizedBox(height: 20),
                  // Progress kelengkapan
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text('Kelengkapan data',
                          style: GoogleFonts.poppins(
                              fontSize: 13, color: AppTheme.grey)),
                      Text(
                        '${(_kelengkapan * 100).toInt()} %',
                        style: GoogleFonts.poppins(
                            fontSize: 13,
                            fontWeight: FontWeight.w600,
                            color: AppTheme.primaryRed),
                      ),
                    ],
                  ),
                  const SizedBox(height: 6),
                  LinearProgressIndicator(
                    value: _kelengkapan,
                    backgroundColor: AppTheme.lightGrey,
                    valueColor: const AlwaysStoppedAnimation(AppTheme.primaryRed),
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
            child: ElevatedButton(
              onPressed: _proses,
              child: Text('Proses Simulasi',
                  style: GoogleFonts.poppins(
                      fontSize: 15, fontWeight: FontWeight.w600)),
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
          fontSize: 15, fontWeight: FontWeight.w700, color: AppTheme.textDark),
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
          hint: Text(hint,
              style: GoogleFonts.poppins(fontSize: 14, color: AppTheme.grey)),
          isExpanded: true,
          icon: const Icon(Icons.keyboard_arrow_down, color: AppTheme.grey),
          items: items
              .map((item) => DropdownMenuItem(
                    value: item,
                    child: Text(item,
                        style: GoogleFonts.poppins(fontSize: 14)),
                  ))
              .toList(),
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

  const _StepCircle(
      {required this.label, required this.step, required this.currentStep});

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
              step == 1
                  ? 'V'
                  : step.toString(),
              style: GoogleFonts.poppins(
                fontSize: 13,
                fontWeight: FontWeight.w700,
                color: isActive ? AppTheme.white : AppTheme.grey,
              ),
            ),
          ),
        ),
        const SizedBox(height: 2),
        Text(label,
            style: GoogleFonts.poppins(
                fontSize: 11,
                color: isActive ? AppTheme.primaryRed : AppTheme.grey,
                fontWeight: isActive ? FontWeight.w600 : FontWeight.normal)),
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
