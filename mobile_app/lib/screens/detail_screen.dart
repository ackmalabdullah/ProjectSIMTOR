import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';
import '../models/motor_model.dart';
import 'simulasi_screen.dart';

class DetailScreen extends StatefulWidget {
  final MotorModel motor;
  const DetailScreen({super.key, required this.motor});

  @override
  State<DetailScreen> createState() => _DetailScreenState();
}

class _DetailScreenState extends State<DetailScreen>
    with SingleTickerProviderStateMixin {
  late TabController _tabController;

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 3, vsync: this);
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final motor = widget.motor;
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
          '< Detail',
          style: GoogleFonts.poppins(
              fontSize: 16,
              fontWeight: FontWeight.w600,
              color: AppTheme.textDark),
        ),
      ),
      body: Column(
        children: [
          // Motor Image
          Container(
            width: double.infinity,
            height: 200,
            color: AppTheme.lightGrey,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                const Icon(Icons.motorcycle, size: 100, color: Color(0xFFCCCCCC)),
                Text('foto motor',
                    style: GoogleFonts.poppins(
                        fontSize: 14, color: AppTheme.grey)),
              ],
            ),
          ),

          // Motor Info
          Padding(
            padding: const EdgeInsets.all(16),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'Honda ${motor.name}',
                      style: GoogleFonts.poppins(
                          fontSize: 18, fontWeight: FontWeight.w700),
                    ),
                    Text(
                      motor.hargaLengkap,
                      style: GoogleFonts.poppins(
                          fontSize: 16,
                          fontWeight: FontWeight.w700,
                          color: AppTheme.textDark),
                    ),
                  ],
                ),
                Container(
                  padding:
                      const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                  decoration: BoxDecoration(
                    color: AppTheme.lightGrey,
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: AppTheme.borderColor),
                  ),
                  child: Text(
                    'Cash',
                    style: GoogleFonts.poppins(
                        fontSize: 13,
                        fontWeight: FontWeight.w500,
                        color: AppTheme.darkGrey),
                  ),
                ),
              ],
            ),
          ),

          // Tabs
          TabBar(
            controller: _tabController,
            labelColor: AppTheme.primaryRed,
            unselectedLabelColor: AppTheme.grey,
            indicatorColor: AppTheme.primaryRed,
            indicatorWeight: 3,
            labelStyle: GoogleFonts.poppins(
                fontSize: 14, fontWeight: FontWeight.w600),
            tabs: const [
              Tab(text: 'Spesifikasi'),
              Tab(text: 'Warna'),
              Tab(text: 'Ulasan'),
            ],
          ),

          Expanded(
            child: TabBarView(
              controller: _tabController,
              children: [
                _buildSpesifikasi(motor),
                _buildWarna(),
                _buildUlasan(),
              ],
            ),
          ),

          // Action Buttons
          Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              children: [
                ElevatedButton(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                          builder: (_) => SimulasiScreen(motor: motor)),
                    );
                  },
                  child: Text('Simulasi Kredit',
                      style: GoogleFonts.poppins(
                          fontSize: 15, fontWeight: FontWeight.w600)),
                ),
                const SizedBox(height: 10),
                OutlinedButton(
                  style: OutlinedButton.styleFrom(
                    foregroundColor: AppTheme.primaryRed,
                    side: const BorderSide(color: AppTheme.primaryRed),
                    minimumSize: const Size(double.infinity, 50),
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(25)),
                  ),
                  onPressed: () {},
                  child: Text('Bandingkan Motor',
                      style: GoogleFonts.poppins(
                          fontSize: 15, fontWeight: FontWeight.w600)),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSpesifikasi(MotorModel motor) {
    final specs = [
      {'label': 'Mesin', 'value': motor.mesin},
      {'label': 'Transmisi', 'value': motor.transmisi},
      {'label': 'Berat', 'value': '${motor.berat} kg'},
      {'label': 'Tangki', 'value': motor.tangki},
      {'label': 'Komsumsi BBM', 'value': motor.konsumsibbm},
    ];

    return ListView.separated(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      itemCount: specs.length,
      separatorBuilder: (_, __) =>
          const Divider(color: AppTheme.borderColor, height: 1),
      itemBuilder: (context, index) {
        final spec = specs[index];
        return Padding(
          padding: const EdgeInsets.symmetric(vertical: 12),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(spec['label']!,
                  style: GoogleFonts.poppins(
                      fontSize: 14, color: AppTheme.grey)),
              Text(spec['value']!,
                  style: GoogleFonts.poppins(
                      fontSize: 14,
                      fontWeight: FontWeight.w500,
                      color: AppTheme.textDark)),
            ],
          ),
        );
      },
    );
  }

  Widget _buildWarna() {
    final colors = [Colors.red, Colors.black, Colors.white, Colors.blue];
    return Padding(
      padding: const EdgeInsets.all(16),
      child: Wrap(
        spacing: 12,
        children: colors
            .map((c) => Container(
                  width: 40,
                  height: 40,
                  decoration: BoxDecoration(
                    color: c,
                    shape: BoxShape.circle,
                    border: Border.all(color: AppTheme.borderColor),
                  ),
                ))
            .toList(),
      ),
    );
  }

  Widget _buildUlasan() {
    return Center(
      child: Text('Belum ada ulasan.',
          style: GoogleFonts.poppins(fontSize: 14, color: AppTheme.grey)),
    );
  }
}
