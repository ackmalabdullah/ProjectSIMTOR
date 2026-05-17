import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

import '../theme/app_theme.dart';

class RiwayatScreen extends StatefulWidget {
  const RiwayatScreen({super.key});

  @override
  State<RiwayatScreen> createState() => _RiwayatScreenState();
}

class _RiwayatScreenState extends State<RiwayatScreen> {
  bool isLoading = true;

  List<dynamic> riwayatData = [];

  String _selectedFilter = 'Semua';

  final List<String> _filters = ['Semua', 'Bulan Ini', '3 Bulan'];

  @override
  void initState() {
    super.initState();

    getRiwayat();
  }

  Future<void> getRiwayat() async {
    try {
      setState(() {
        isLoading = true;
      });

      final prefs = await SharedPreferences.getInstance();

      final token = prefs.getString('token');

      final response = await http.get(
        Uri.parse("http://192.168.1.6:8080/api/simulasi/riwayat"),
        headers: {
          "Authorization": "Bearer $token",
          "Accept": "application/json",
        },
      );

      print("STATUS RIWAYAT : ${response.statusCode}");
      print("BODY RIWAYAT : ${response.body}");

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        setState(() {
          riwayatData = data['data'] ?? [];
          isLoading = false;
        });
      } else {
        setState(() {
          isLoading = false;
        });

        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text("Gagal mengambil data riwayat")),
        );
      }
    } catch (e) {
      print("ERROR RIWAYAT : $e");

      setState(() {
        isLoading = false;
      });

      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Error: $e")));
    }
  }

  List<dynamic> get filteredRiwayat {
    if (_selectedFilter == 'Semua') {
      return riwayatData;
    }

    final now = DateTime.now();

    if (_selectedFilter == 'Bulan Ini') {
      return riwayatData.where((item) {
        final tanggal = DateTime.parse(item['created_at']);

        return tanggal.month == now.month && tanggal.year == now.year;
      }).toList();
    }

    if (_selectedFilter == '3 Bulan') {
      return riwayatData.where((item) {
        final tanggal = DateTime.parse(item['created_at']);

        return now.difference(tanggal).inDays <= 90;
      }).toList();
    }

    return riwayatData;
  }

  String formatRupiah(dynamic value) {
    final number = double.tryParse(value.toString()) ?? 0;

    final formatted = number
        .toStringAsFixed(0)
        .replaceAllMapped(
          RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
          (match) => '${match[1]}.',
        );

    return 'Rp $formatted';
  }

  String formatTanggal(String date) {
    final tanggal = DateTime.parse(date);

    return "${tanggal.day}/${tanggal.month}/${tanggal.year}";
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.white,

      appBar: AppBar(
        backgroundColor: AppTheme.white,
        elevation: 0,
        centerTitle: false,
        title: Text(
          'Riwayat Simulasi',
          style: GoogleFonts.poppins(
            fontSize: 20,
            fontWeight: FontWeight.w700,
            color: AppTheme.textDark,
          ),
        ),
      ),

      body: Column(
        children: [
          // FILTER
          SingleChildScrollView(
            scrollDirection: Axis.horizontal,
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
            child: Row(
              children: _filters.map((filter) {
                final isSelected = _selectedFilter == filter;

                return Padding(
                  padding: const EdgeInsets.only(right: 8),
                  child: GestureDetector(
                    onTap: () {
                      setState(() {
                        _selectedFilter = filter;
                      });
                    },
                    child: Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 8,
                      ),
                      decoration: BoxDecoration(
                        color: isSelected
                            ? AppTheme.primaryRed
                            : AppTheme.white,
                        borderRadius: BorderRadius.circular(20),
                        border: Border.all(
                          color: isSelected
                              ? AppTheme.primaryRed
                              : AppTheme.borderColor,
                        ),
                      ),
                      child: Text(
                        filter,
                        style: GoogleFonts.poppins(
                          fontSize: 12,
                          fontWeight: FontWeight.w600,
                          color: isSelected ? Colors.white : AppTheme.textDark,
                        ),
                      ),
                    ),
                  ),
                );
              }).toList(),
            ),
          ),

          // CONTENT
          Expanded(
            child: isLoading
                ? const Center(child: CircularProgressIndicator())
                : filteredRiwayat.isEmpty
                ? _buildEmpty()
                : RefreshIndicator(
                    onRefresh: getRiwayat,
                    child: ListView.builder(
                      padding: const EdgeInsets.all(16),
                      itemCount: filteredRiwayat.length,
                      itemBuilder: (context, index) {
                        final item = filteredRiwayat[index];

                        return _buildRiwayatCard(item);
                      },
                    ),
                  ),
          ),
        ],
      ),
    );
  }

  Widget _buildEmpty() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.history, size: 70, color: AppTheme.grey.withOpacity(0.4)),

          const SizedBox(height: 14),

          Text(
            'Belum ada riwayat simulasi',
            style: GoogleFonts.poppins(fontSize: 14, color: AppTheme.grey),
          ),
        ],
      ),
    );
  }

  Widget _buildRiwayatCard(dynamic item) {
    final isLayak =
        item['status_kelayakan'].toString().toUpperCase().trim() == "LAYAK";

    return Container(
      margin: const EdgeInsets.only(bottom: 14),

      padding: const EdgeInsets.all(14),

      decoration: BoxDecoration(
        color: AppTheme.white,

        borderRadius: BorderRadius.circular(16),

        border: Border.all(color: AppTheme.borderColor),

        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
            blurRadius: 8,
            offset: const Offset(0, 3),
          ),
        ],
      ),

      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                width: 55,
                height: 55,
                decoration: BoxDecoration(
                  color: AppTheme.lightGrey,
                  borderRadius: BorderRadius.circular(12),
                ),

                clipBehavior: Clip.antiAlias,

                child: Image.network(
                  item['gambar'] ?? '',
                  fit: BoxFit.cover,

                  errorBuilder: (context, error, stackTrace) {
                    return const Icon(
                      Icons.motorcycle,
                      size: 30,
                      color: AppTheme.primaryRed,
                    );
                  },
                ),
              ),

              const SizedBox(width: 12),

              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      item['nama_motor'] ?? '-',
                      style: GoogleFonts.poppins(
                        fontSize: 15,
                        fontWeight: FontWeight.w700,
                      ),
                    ),

                    const SizedBox(height: 4),

                    Text(
                      '${item['tenor']} bulan',
                      style: GoogleFonts.poppins(
                        fontSize: 12,
                        color: AppTheme.grey,
                      ),
                    ),

                    const SizedBox(height: 3),

                    Text(
                      formatTanggal(item['created_at']),
                      style: GoogleFonts.poppins(
                        fontSize: 11,
                        color: AppTheme.grey,
                      ),
                    ),
                  ],
                ),
              ),

              Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 10,
                  vertical: 6,
                ),
                decoration: BoxDecoration(
                  color: isLayak
                      ? Colors.green.withOpacity(0.15)
                      : Colors.red.withOpacity(0.15),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Row(
                  children: [
                    Icon(
                      isLayak ? Icons.check_circle : Icons.cancel,
                      size: 14,
                      color: isLayak ? Colors.green : Colors.red,
                    ),

                    const SizedBox(width: 4),

                    Text(
                      item['status_kelayakan'],
                      style: GoogleFonts.poppins(
                        fontSize: 11,
                        fontWeight: FontWeight.w700,
                        color: isLayak ? Colors.green : Colors.red,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),

          const SizedBox(height: 14),

          Divider(color: AppTheme.borderColor),

          const SizedBox(height: 10),

          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              _buildInfo("Harga", formatRupiah(item['harga_motor'])),

              _buildInfo("DP", formatRupiah(item['dp_nominal'])),

              _buildInfo("Cicilan", formatRupiah(item['cicilan_per_bulan'])),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildInfo(String title, String value) {
    return Column(
      children: [
        Text(
          title,
          style: GoogleFonts.poppins(fontSize: 11, color: AppTheme.grey),
        ),

        const SizedBox(height: 4),

        Text(
          value,
          style: GoogleFonts.poppins(fontSize: 12, fontWeight: FontWeight.w700),
        ),
      ],
    );
  }
}
