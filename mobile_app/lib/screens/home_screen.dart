import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:http/http.dart' as http;

import '../theme/app_theme.dart';
import '../models/motor_model.dart';
import 'detail_screen.dart';
import 'riwayat_screen.dart';
import '../services/auth_service.dart';
import 'profile_screen.dart';

String _searchQuery = '';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> with TickerProviderStateMixin {
  int _selectedTab = 0;
  String _selectedCategory = 'Semua';
  late AnimationController _navAnimController;

  final List<String> _categories = ['Semua', 'Matic', 'Manual', 'Adventure'];

  List<MotorModel> motorList = [];
  bool isLoading = true;

  String username = 'User';

  @override
  void initState() {
    super.initState();
    _navAnimController = AnimationController(
      duration: const Duration(milliseconds: 400),
      vsync: this,
    );
    getMotor();
    getUser();
  }

  @override
  void dispose() {
    _navAnimController.dispose();
    super.dispose();
  }

  Future<void> getMotor() async {
    setState(() {
      isLoading = true;
    });

    final url = Uri.parse("http://192.168.1.6:8080/api/motor");

    try {
      final response = await http.get(url);

      print(response.statusCode);
      print(response.body);

      if (response.statusCode == 200) {
        final jsonData = jsonDecode(response.body);

        final List data = jsonData['data'];

        setState(() {
          motorList = data.map((item) => MotorModel.fromJson(item)).toList();

          isLoading = false;
        });
      } else {
        setState(() {
          isLoading = false;
        });
      }
    } catch (e) {
      print("ERROR API: $e");

      setState(() {
        isLoading = false;
      });
    }
  }

  Future<void> getUser() async {
    final userData = await AuthService.getUserData();

    if (userData != null) {
      setState(() {
        username = userData['username'] ?? 'User';
      });
    }
  }

  List<MotorModel> get _filteredMotors {
    return motorList.where((motor) {
      final matchCategory = _selectedCategory == 'Semua'
          ? true
          : motor.tipe.toLowerCase() == _selectedCategory.toLowerCase();

      final matchSearch = motor.name.toLowerCase().contains(
        _searchQuery.toLowerCase(),
      );

      return matchCategory && matchSearch;
    }).toList();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.lightGrey,
      body: IndexedStack(
        index: _selectedTab,
        children: [
          _buildHomeTab(),
          const SimulasiListScreen(),
          const RiwayatScreen(),
          const ProfileScreen(),
        ],
      ),
      bottomNavigationBar: _buildBottomNav(),
    );
  }

  Widget _buildHomeTab() {
    return SafeArea(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          /// HEADER USER
          Padding(
            padding: const EdgeInsets.fromLTRB(16, 16, 16, 8),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Halo, $username 👋',
                  style: GoogleFonts.poppins(
                    fontSize: 22,
                    fontWeight: FontWeight.w700,
                    color: AppTheme.textDark,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  'Temukan motor impianmu',
                  style: GoogleFonts.poppins(
                    fontSize: 13,
                    color: AppTheme.grey,
                  ),
                ),
              ],
            ),
          ),

          /// SEARCH BAR
          Padding(
            padding: const EdgeInsets.all(16),
            child: TextField(
              onChanged: (value) {
                setState(() {
                  _searchQuery = value;
                });
              },
              decoration: InputDecoration(
                hintText: "Cari motor...",
                prefixIcon: const Icon(Icons.search),
                filled: true,
                fillColor: Colors.white,
                contentPadding: const EdgeInsets.symmetric(vertical: 0),
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(12),
                  borderSide: BorderSide.none,
                ),
              ),
            ),
          ),

          /// PROMO BANNER
          Padding(
            padding: const EdgeInsets.all(16),
            child: Container(
              width: double.infinity,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [AppTheme.darkRed, AppTheme.primaryRed],
                  begin: Alignment.centerLeft,
                  end: Alignment.centerRight,
                ),
                borderRadius: BorderRadius.circular(12),
              ),
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Promo Oktober',
                    style: GoogleFonts.poppins(
                      fontSize: 12,
                      color: AppTheme.white.withOpacity(0.85),
                    ),
                  ),
                  Text(
                    'DP mulai 10%',
                    style: GoogleFonts.poppins(
                      fontSize: 18,
                      fontWeight: FontWeight.w700,
                      color: AppTheme.white,
                    ),
                  ),
                  Text(
                    'Tenor hingga 36 bulan',
                    style: GoogleFonts.poppins(
                      fontSize: 12,
                      color: AppTheme.white.withOpacity(0.85),
                    ),
                  ),
                ],
              ),
            ),
          ),

          /// CATEGORY FILTER
          SizedBox(
            height: 40,
            child: ListView.builder(
              scrollDirection: Axis.horizontal,
              padding: const EdgeInsets.symmetric(horizontal: 16),
              itemCount: _categories.length,
              itemBuilder: (context, index) {
                final cat = _categories[index];
                final isSelected = _selectedCategory == cat;

                return Padding(
                  padding: const EdgeInsets.only(right: 8),
                  child: GestureDetector(
                    onTap: () {
                      setState(() {
                        _selectedCategory = cat;
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
                        cat,
                        style: GoogleFonts.poppins(
                          fontSize: 13,
                          fontWeight: FontWeight.w500,
                          color: isSelected
                              ? AppTheme.white
                              : AppTheme.darkGrey,
                        ),
                      ),
                    ),
                  ),
                );
              },
            ),
          ),

          const SizedBox(height: 12),

          /// GRID MOTOR
          Expanded(
            child: RefreshIndicator(
              color: AppTheme.primaryRed,

              onRefresh: () async {
                await getMotor();
              },

              child: isLoading
                  ? const Center(child: CircularProgressIndicator())
                  : _filteredMotors.isEmpty
                  ? ListView(
                      children: const [
                        SizedBox(height: 250),

                        Center(child: Text("Data motor tidak ada")),
                      ],
                    )
                  : GridView.builder(
                      physics: const AlwaysScrollableScrollPhysics(),

                      padding: const EdgeInsets.symmetric(horizontal: 16),

                      gridDelegate:
                          const SliverGridDelegateWithFixedCrossAxisCount(
                            crossAxisCount: 2,
                            childAspectRatio: 0.78,
                            crossAxisSpacing: 12,
                            mainAxisSpacing: 12,
                          ),

                      itemCount: _filteredMotors.length,

                      itemBuilder: (context, index) {
                        final motor = _filteredMotors[index];

                        return _buildMotorCard(motor);
                      },
                    ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildMotorCard(MotorModel motor) {
    return GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(builder: (_) => DetailScreen(motor: motor)),
        );
      },
      child: Container(
        decoration: BoxDecoration(
          color: AppTheme.white,
          borderRadius: BorderRadius.circular(12),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.06),
              blurRadius: 8,
              offset: const Offset(0, 2),
            ),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            /// IMAGE
            Expanded(
              child: Container(
                width: double.infinity,
                decoration: BoxDecoration(
                  color: AppTheme.lightGrey,
                  borderRadius: const BorderRadius.vertical(
                    top: Radius.circular(12),
                  ),
                ),
                child: ClipRRect(
                  borderRadius: const BorderRadius.vertical(
                    top: Radius.circular(12),
                  ),
                  child: Image.network(
                    "http://192.168.1.6:8080/storage/${motor.imageUrl}",
                    fit: BoxFit.cover,
                    errorBuilder: (context, error, stackTrace) {
                      return const Icon(
                        Icons.motorcycle,
                        size: 64,
                        color: Colors.grey,
                      );
                    },
                  ),
                ),
              ),
            ),

            /// TEXT
            Padding(
              padding: const EdgeInsets.all(10),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    motor.name,
                    style: GoogleFonts.poppins(
                      fontSize: 13,
                      fontWeight: FontWeight.w600,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 4),
                  Text(
                    motor.hargaFormatted,
                    style: GoogleFonts.poppins(
                      fontSize: 13,
                      fontWeight: FontWeight.w700,
                      color: AppTheme.primaryRed,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildBottomNav() {
    final items = [
      {'icon': Icons.home_rounded, 'label': 'Home'},
      {'icon': Icons.calculate_rounded, 'label': 'Simulasi'},
      {'icon': Icons.history_rounded, 'label': 'Riwayat'},
      {'icon': Icons.person_rounded, 'label': 'Profile'},
    ];

    return SafeArea(
      top: false,
      child: Padding(
        padding: const EdgeInsets.only(left: 16, right: 16, bottom: 16),
        child: Container(
          height: 78,
          decoration: BoxDecoration(
            color: AppTheme.white,
            borderRadius: BorderRadius.circular(32),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.08),
                blurRadius: 24,
                offset: const Offset(0, 8),
              ),
              BoxShadow(
                color: Colors.black.withOpacity(0.04),
                blurRadius: 12,
                offset: const Offset(0, 2),
              ),
            ],
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: List.generate(items.length, (index) {
              final isSelected = _selectedTab == index;

              return Expanded(
                child: GestureDetector(
                  onTap: () {
                    setState(() {
                      _selectedTab = index;
                    });

                    // animasi lebih aman
                    _navAnimController
                      ..reset()
                      ..forward();
                  },
                  behavior: HitTestBehavior.opaque,
                  child: Center(
                    child: AnimatedContainer(
                      duration: const Duration(milliseconds: 280),
                      curve: Curves.easeInOut, // ✅ FIX UTAMA
                      padding: EdgeInsets.symmetric(
                        horizontal: isSelected ? 14 : 10,
                        vertical: isSelected ? 10 : 6,
                      ),
                      decoration: BoxDecoration(
                        color: isSelected
                            ? AppTheme.primaryRed
                            : Colors.transparent,
                        borderRadius: BorderRadius.circular(24),
                        boxShadow: isSelected
                            ? [
                                BoxShadow(
                                  color: AppTheme.primaryRed.withOpacity(0.25),
                                  blurRadius: 12,
                                  offset: const Offset(0, 6),
                                ),
                              ]
                            : [],
                      ),
                      child: Column(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          /// ICON FLOAT EFFECT (AMAN)
                          AnimatedContainer(
                            duration: const Duration(milliseconds: 250),
                            curve: Curves.easeInOut,
                            transform: Matrix4.translationValues(
                              0,
                              isSelected ? -6 : 0,
                              0,
                            ),
                            child: ScaleTransition(
                              scale: Tween<double>(begin: 0.95, end: 1.0)
                                  .animate(
                                    CurvedAnimation(
                                      parent: _navAnimController,
                                      curve: Curves.easeInOut, // ✅ FIX
                                    ),
                                  ),
                              child: Icon(
                                items[index]['icon'] as IconData,
                                color: isSelected
                                    ? Colors.white
                                    : AppTheme.grey,
                                size: isSelected ? 26 : 24,
                              ),
                            ),
                          ),

                          const SizedBox(height: 4),

                          /// LABEL
                          AnimatedSwitcher(
                            duration: const Duration(milliseconds: 200),
                            transitionBuilder: (child, animation) {
                              return FadeTransition(
                                opacity: animation,
                                child: SlideTransition(
                                  position: Tween<Offset>(
                                    begin: const Offset(0, 0.3),
                                    end: Offset.zero,
                                  ).animate(animation),
                                  child: child,
                                ),
                              );
                            },
                            child: isSelected
                                ? Text(
                                    items[index]['label'] as String,
                                    key: ValueKey('label_$index'),
                                    style: GoogleFonts.poppins(
                                      fontSize: 10,
                                      fontWeight: FontWeight.w600,
                                      color: Colors.white,
                                    ),
                                  )
                                : const SizedBox.shrink(),
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
              );
            }),
          ),
        ),
      ),
    );
  }
}

class SimulasiListScreen extends StatefulWidget {
  const SimulasiListScreen({super.key});

  @override
  State<SimulasiListScreen> createState() => _SimulasiListScreenState();
}

class _SimulasiListScreenState extends State<SimulasiListScreen> {
  List<MotorModel> motorList = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    getMotor();
  }

  Future<void> getMotor() async {
    final url = Uri.parse("http://192.168.1.6:8080/api/motor");

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final jsonData = jsonDecode(response.body);
        final List data = jsonData['data'];

        setState(() {
          motorList = data.map((item) => MotorModel.fromJson(item)).toList();
          isLoading = false;
        });
      } else {
        setState(() {
          isLoading = false;
        });
      }
    } catch (e) {
      print("ERROR API: $e");
      setState(() {
        isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          /// HEADER
          Padding(
            padding: const EdgeInsets.fromLTRB(16, 16, 16, 8),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Simulasi Cepat 🧮',
                  style: GoogleFonts.poppins(
                    fontSize: 22,
                    fontWeight: FontWeight.w700,
                    color: AppTheme.textDark,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  'Pilih motor dan simulasikan cicilan Anda',
                  style: GoogleFonts.poppins(
                    fontSize: 13,
                    color: AppTheme.grey,
                  ),
                ),
              ],
            ),
          ),

          /// INFO CARD
          Padding(
            padding: const EdgeInsets.all(16),
            child: Container(
              width: double.infinity,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [AppTheme.darkRed, AppTheme.primaryRed],
                  begin: Alignment.centerLeft,
                  end: Alignment.centerRight,
                ),
                borderRadius: BorderRadius.circular(12),
              ),
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    '💡 Tips',
                    style: GoogleFonts.poppins(
                      fontSize: 12,
                      color: AppTheme.white.withOpacity(0.85),
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Simulasikan cicilan motor sesuai tenor dan penghasilan Anda. Pilih motor dari daftar di bawah untuk memulai!',
                    style: GoogleFonts.poppins(
                      fontSize: 13,
                      fontWeight: FontWeight.w400,
                      color: AppTheme.white,
                      height: 1.5,
                    ),
                  ),
                ],
              ),
            ),
          ),

          /// MOTOR LIST
          Expanded(
            child: isLoading
                ? const Center(child: CircularProgressIndicator())
                : motorList.isEmpty
                ? const Center(child: Text("Data motor tidak ada"))
                : ListView.builder(
                    padding: const EdgeInsets.symmetric(horizontal: 16),
                    itemCount: motorList.length,
                    itemBuilder: (context, index) {
                      final motor = motorList[index];
                      return _buildSimulasiMotorCard(motor, context);
                    },
                  ),
          ),
        ],
      ),
    );
  }

  Widget _buildSimulasiMotorCard(MotorModel motor, BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: AppTheme.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          onTap: () {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (_) => DetailScreen(motor: motor)),
            );
          },
          borderRadius: BorderRadius.circular(12),
          child: Padding(
            padding: const EdgeInsets.all(12),
            child: Row(
              children: [
                /// IMAGE
                Container(
                  width: 80,
                  height: 80,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(8),
                    color: AppTheme.lightGrey,
                  ),
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(8),
                    child: Image.network(
                      "http://192.168.1.6:8080/storage/${motor.imageUrl}",
                      fit: BoxFit.cover,
                      errorBuilder: (context, error, stackTrace) {
                        return const Icon(
                          Icons.motorcycle,
                          size: 40,
                          color: Colors.grey,
                        );
                      },
                    ),
                  ),
                ),
                const SizedBox(width: 12),

                /// INFO
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        motor.name,
                        style: GoogleFonts.poppins(
                          fontSize: 14,
                          fontWeight: FontWeight.w600,
                          color: AppTheme.textDark,
                        ),
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(height: 4),
                      Text(
                        motor.hargaFormatted,
                        style: GoogleFonts.poppins(
                          fontSize: 13,
                          fontWeight: FontWeight.w700,
                          color: AppTheme.primaryRed,
                        ),
                      ),
                      const SizedBox(height: 6),
                      Container(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 8,
                          vertical: 4,
                        ),
                        decoration: BoxDecoration(
                          color: AppTheme.primaryRed.withOpacity(0.1),
                          borderRadius: BorderRadius.circular(6),
                        ),
                        child: Text(
                          'Tipe: ${motor.tipe}',
                          style: GoogleFonts.poppins(
                            fontSize: 11,
                            fontWeight: FontWeight.w500,
                            color: AppTheme.primaryRed,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),

                /// ARROW
                const SizedBox(width: 8),
                Icon(
                  Icons.arrow_forward_rounded,
                  color: AppTheme.primaryRed,
                  size: 20,
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
