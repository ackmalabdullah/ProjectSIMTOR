import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';
import '../models/motor_model.dart';
import 'simulasi_screen.dart';

class DetailScreen extends StatelessWidget {
  final MotorModel motor;
  const DetailScreen({super.key, required this.motor});

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
          'Detail Motor',
          style: GoogleFonts.poppins(
            fontSize: 16,
            fontWeight: FontWeight.w600,
            color: AppTheme.textDark,
          ),
        ),
      ),
      body: Column(
        children: [
          // 🔥 GAMBAR MOTOR (API)
          Container(
            width: double.infinity,
            height: 220,
            color: AppTheme.lightGrey,
            child: Image.network(
              "http://192.168.0.22:8080/storage/${motor.imageUrl}",
              fit: BoxFit.contain,
              errorBuilder: (context, error, stackTrace) {
                return Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: const [
                    Icon(Icons.broken_image, size: 80, color: Colors.grey),
                    SizedBox(height: 8),
                    Text("Gambar tidak tersedia"),
                  ],
                );
              },
            ),
          ),

          // 🔥 INFO MOTOR
          Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  motor.name,
                  style: GoogleFonts.poppins(
                    fontSize: 20,
                    fontWeight: FontWeight.w700,
                  ),
                ),
                const SizedBox(height: 4),

                Text(
                  motor.hargaLengkap,
                  style: GoogleFonts.poppins(
                    fontSize: 16,
                    fontWeight: FontWeight.w700,
                    color: AppTheme.primaryRed,
                  ),
                ),

                const SizedBox(height: 8),

                Text(
                  motor.deskripsi,
                  style: GoogleFonts.poppins(
                    fontSize: 13,
                    color: AppTheme.grey,
                  ),
                ),

                const SizedBox(height: 10),

                // STATUS
                Container(
                  padding:
                      const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                  decoration: BoxDecoration(
                    color: motor.status == 'tersedia'
                        ? Colors.green.withOpacity(0.1)
                        : Colors.red.withOpacity(0.1),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Text(
                    motor.status.toUpperCase(),
                    style: GoogleFonts.poppins(
                      fontSize: 11,
                      fontWeight: FontWeight.w600,
                      color: motor.status == 'tersedia'
                          ? Colors.green
                          : Colors.red,
                    ),
                  ),
                ),
              ],
            ),
          ),

          const Divider(),

          // 🔥 DETAIL TAMBAHAN
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Column(
              children: [
                _buildItem("Merk", motor.merk),
                _buildItem("Tipe", motor.tipe),
              ],
            ),
          ),

          const Spacer(),

          // 🔥 BUTTON
          Padding(
            padding: const EdgeInsets.all(16),
            child: ElevatedButton(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (_) => SimulasiScreen(motor: motor),
                  ),
                );
              },
              child: Text(
                'Simulasi Kredit',
                style: GoogleFonts.poppins(fontWeight: FontWeight.w600),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildItem(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(label,
              style: GoogleFonts.poppins(color: AppTheme.grey, fontSize: 14)),
          Text(value,
              style: GoogleFonts.poppins(
                  fontWeight: FontWeight.w600, fontSize: 14)),
        ],
      ),
    );
  }
}