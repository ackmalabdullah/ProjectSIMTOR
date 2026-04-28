import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';

class RiwayatScreen extends StatefulWidget {
  const RiwayatScreen({super.key});

  @override
  State<RiwayatScreen> createState() => _RiwayatScreenState();
}

class _RiwayatScreenState extends State<RiwayatScreen> {
  String _selectedFilter = 'Semua';
  final List<String> _filters = ['Semua', 'Bulan Ini', '3 Bulan'];

  final List<Map<String, dynamic>> _riwayatData = [
    {
      'motor': 'Honda Vario 125',
      'tenor': '24 bulan',
      'cicilan': 'Rp 954.000/bln',
      'tanggal': 'Hari ini',
      'harga': 'Rp 22.000.000',
    },
    {
      'motor': 'Honda Beat Street',
      'tenor': '18 bulan',
      'cicilan': 'Rp 920.000/bln',
      'tanggal': 'Kemarin',
      'harga': 'Rp 15.500.000',
    },
  ];

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Padding(
            padding: const EdgeInsets.fromLTRB(20, 16, 20, 0),
            child: Text(
              'Riwayat',
              style: GoogleFonts.poppins(
                  fontSize: 22, fontWeight: FontWeight.w800),
            ),
          ),

          // Filter chips
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
            child: Row(
              children: _filters.map((f) {
                final isSelected = _selectedFilter == f;
                return Padding(
                  padding: const EdgeInsets.only(right: 8),
                  child: GestureDetector(
                    onTap: () => setState(() => _selectedFilter = f),
                    child: Container(
                      padding: const EdgeInsets.symmetric(
                          horizontal: 16, vertical: 6),
                      decoration: BoxDecoration(
                        color: isSelected
                            ? AppTheme.primaryRed
                            : AppTheme.white,
                        borderRadius: BorderRadius.circular(20),
                        border: Border.all(
                            color: isSelected
                                ? AppTheme.primaryRed
                                : AppTheme.borderColor),
                      ),
                      child: Text(
                        f,
                        style: GoogleFonts.poppins(
                          fontSize: 13,
                          fontWeight: FontWeight.w500,
                          color: isSelected ? AppTheme.white : AppTheme.darkGrey,
                        ),
                      ),
                    ),
                  ),
                );
              }).toList(),
            ),
          ),

          Expanded(
            child: _riwayatData.isEmpty
                ? Center(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(Icons.history,
                            size: 64, color: AppTheme.grey.withOpacity(0.5)),
                        const SizedBox(height: 12),
                        Text(
                          'Belum ada riwayat simulasi',
                          style: GoogleFonts.poppins(
                              fontSize: 14, color: AppTheme.grey),
                        ),
                      ],
                    ),
                  )
                : ListView.builder(
                    padding: const EdgeInsets.symmetric(horizontal: 16),
                    itemCount: _riwayatData.length + 1,
                    itemBuilder: (context, index) {
                      if (index == 0) {
                        return _buildDateHeader('Hari ini');
                      }
                      final item = _riwayatData[index - 1];
                      return _buildRiwayatCard(item);
                    },
                  ),
          ),
        ],
      ),
    );
  }

  Widget _buildDateHeader(String date) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8, top: 4),
      child: Text(
        date,
        style: GoogleFonts.poppins(
            fontSize: 13,
            fontWeight: FontWeight.w600,
            color: AppTheme.grey),
      ),
    );
  }

  Widget _buildRiwayatCard(Map<String, dynamic> item) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: AppTheme.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: AppTheme.borderColor),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
            blurRadius: 6,
            offset: const Offset(0, 2),
          )
        ],
      ),
      child: Padding(
        padding: const EdgeInsets.all(14),
        child: Row(
          children: [
            Container(
              width: 50,
              height: 50,
              decoration: BoxDecoration(
                color: AppTheme.lightGrey,
                borderRadius: BorderRadius.circular(10),
              ),
              child: const Icon(Icons.motorcycle,
                  color: AppTheme.grey, size: 28),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    item['motor'],
                    style: GoogleFonts.poppins(
                        fontSize: 14, fontWeight: FontWeight.w600),
                  ),
                  Text(
                    '${item['tenor']} • ${item['cicilan']}',
                    style: GoogleFonts.poppins(
                        fontSize: 12, color: AppTheme.grey),
                  ),
                ],
              ),
            ),
            Column(
              crossAxisAlignment: CrossAxisAlignment.end,
              children: [
                Text(
                  item['harga'],
                  style: GoogleFonts.poppins(
                      fontSize: 13,
                      fontWeight: FontWeight.w700,
                      color: AppTheme.primaryRed),
                ),
                Text(
                  item['tanggal'],
                  style:
                      GoogleFonts.poppins(fontSize: 11, color: AppTheme.grey),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
