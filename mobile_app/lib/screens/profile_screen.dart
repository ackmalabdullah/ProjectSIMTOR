import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../models/user_model.dart';
import '../services/user_service.dart';
import '../theme/app_theme.dart';
import 'login_screen.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  UserModel? user;
  bool isLoading = true;
  bool isEditing = false;
  bool isSaving = false;

  // TextEditingControllers untuk form
  late TextEditingController namaController;
  late TextEditingController noTelpController;
  late TextEditingController alamatController;
  late TextEditingController pekerjaanController;
  late TextEditingController gajiController;

  @override
  void initState() {
    super.initState();
    _loadUserData();
  }

  Future<void> _loadUserData() async {
    try {
      // Coba ambil dari backend terlebih dahulu
      final profileUser = await UserService.getProfile();

      if (profileUser != null) {
        setState(() {
          user = profileUser;
          isLoading = false;
          _initializeControllers(profileUser);
        });
      } else {
        // Jika gagal, ambil dari cache lokal
        final cachedUser = await UserService.getCachedUser();
        setState(() {
          user = cachedUser;
          isLoading = false;
          _initializeControllers(cachedUser);
        });
      }
    } catch (e) {
      print("Error loading user data: $e");
      setState(() {
        isLoading = false;
      });
    }
  }

  void _initializeControllers(UserModel? userData) {
    namaController = TextEditingController(text: userData?.nama ?? '');
    noTelpController = TextEditingController(text: userData?.noTelp ?? '');
    alamatController = TextEditingController(text: userData?.alamat ?? '');
    pekerjaanController = TextEditingController(text: userData?.pekerjaan ?? '');
    gajiController = TextEditingController(
      text: userData?.gajiPerBulan?.toString() ?? '',
    );
  }

  @override
  void dispose() {
    namaController.dispose();
    noTelpController.dispose();
    alamatController.dispose();
    pekerjaanController.dispose();
    gajiController.dispose();
    super.dispose();
  }

  Future<void> _saveProfile() async {
    if (namaController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Nama tidak boleh kosong')),
      );
      return;
    }

    setState(() {
      isSaving = true;
    });

    try {
      // Update user data dari form
      final updatedUser = user!.copyWith(
        nama: namaController.text,
        noTelp: noTelpController.text.isEmpty ? null : noTelpController.text,
        alamat: alamatController.text.isEmpty ? null : alamatController.text,
        pekerjaan: pekerjaanController.text.isEmpty ? null : pekerjaanController.text,
        gajiPerBulan: gajiController.text.isEmpty ? null : int.tryParse(gajiController.text),
      );

      // Send ke backend
      final success = await UserService.updateProfile(updatedUser);

      if (success) {
        // Reload data terbaru
        await _loadUserData();
        
        setState(() {
          isEditing = false;
          isSaving = false;
        });

        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text('Profile berhasil disimpan!'),
              backgroundColor: Colors.green,
            ),
          );
        }
      } else {
        setState(() {
          isSaving = false;
        });

        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text('Gagal menyimpan profile'),
              backgroundColor: Colors.red,
            ),
          );
        }
      }
    } catch (e) {
      print("Error saving profile: $e");
      setState(() {
        isSaving = false;
      });

      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Error: $e'),
            backgroundColor: Colors.red,
          ),
        );
      }
    }
  }

  void _cancelEdit() {
    setState(() {
      isEditing = false;
    });
    _initializeControllers(user);
  }

  Future<void> _handleLogout() async {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text(
            'Logout',
            style: GoogleFonts.poppins(
              fontSize: 16,
              fontWeight: FontWeight.w600,
            ),
          ),
          content: Text(
            'Apakah Anda yakin ingin logout?',
            style: GoogleFonts.poppins(fontSize: 14),
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text(
                'Batal',
                style: GoogleFonts.poppins(color: AppTheme.grey),
              ),
            ),
            ElevatedButton(
              onPressed: () {
                Navigator.pop(context);
                _performLogout();
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: AppTheme.primaryRed,
              ),
              child: Text(
                'Logout',
                style: GoogleFonts.poppins(
                  color: AppTheme.white,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ],
        );
      },
    );
  }

  Future<void> _performLogout() async {
    // Tampilkan loading dialog
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) => const Center(child: CircularProgressIndicator()),
    );

    await UserService.logout();

    if (mounted) {
      // Tutup loading dialog
      Navigator.pop(context);

      // Redirect ke Login Screen
      Navigator.of(context).pushAndRemoveUntil(
        MaterialPageRoute(builder: (_) => const LoginScreen()),
        (route) => false,
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.lightGrey,
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : user == null
              ? _buildUserNotFoundUI()
              : isEditing
                  ? _buildEditProfileUI()
                  : _buildViewProfileUI(),
    );
  }

  Widget _buildUserNotFoundUI() {
    return SafeArea(
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(Icons.person_off, size: 64, color: AppTheme.grey),
            const SizedBox(height: 16),
            Text(
              'Data user tidak ditemukan',
              style: GoogleFonts.poppins(
                fontSize: 16,
                fontWeight: FontWeight.w600,
              ),
            ),
            const SizedBox(height: 32),
            ElevatedButton(
              onPressed: _loadUserData,
              style: ElevatedButton.styleFrom(
                backgroundColor: AppTheme.primaryRed,
                foregroundColor: AppTheme.white,
                padding: const EdgeInsets.symmetric(
                  horizontal: 32,
                  vertical: 12,
                ),
              ),
              child: Text(
                'Refresh',
                style: GoogleFonts.poppins(
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildViewProfileUI() {
    return SafeArea(
      child: SingleChildScrollView(
        child: Column(
          children: [
            // Header dengan avatar dan basic info
            Container(
              width: double.infinity,
              decoration: const BoxDecoration(
                gradient: LinearGradient(
                  colors: [AppTheme.primaryRed, AppTheme.darkRed],
                  begin: Alignment.topCenter,
                  end: Alignment.bottomCenter,
                ),
              ),
              padding: const EdgeInsets.all(24),
              child: Column(
                children: [
                  // Avatar
                  Container(
                    width: 100,
                    height: 100,
                    decoration: BoxDecoration(
                      shape: BoxShape.circle,
                      color: AppTheme.white,
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.1),
                          blurRadius: 8,
                          offset: const Offset(0, 2),
                        ),
                      ],
                    ),
                    child: const Icon(
                      Icons.person,
                      size: 48,
                      color: AppTheme.grey,
                    ),
                  ),
                  const SizedBox(height: 16),
                  // Nama
                  Text(
                    user!.nama,
                    style: GoogleFonts.poppins(
                      fontSize: 20,
                      fontWeight: FontWeight.w700,
                      color: AppTheme.white,
                    ),
                  ),
                  const SizedBox(height: 4),
                  // Username
                  Text(
                    '@${user!.username}',
                    style: GoogleFonts.poppins(
                      fontSize: 12,
                      color: AppTheme.white.withOpacity(0.8),
                    ),
                  ),
                ],
              ),
            ),

            // Detail Information Section
            Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  // Email Card
                  _buildInfoCard(
                    icon: Icons.email_outlined,
                    label: 'Email',
                    value: user!.email,
                  ),
                  const SizedBox(height: 12),
                  // Nomor HP Card
                  _buildInfoCard(
                    icon: Icons.phone_outlined,
                    label: 'Nomor HP',
                    value: user!.noTelp ?? 'Belum diisi',
                    isEmpty: user!.noTelp == null,
                  ),
                  const SizedBox(height: 12),
                  // Alamat Card
                  _buildInfoCard(
                    icon: Icons.location_on_outlined,
                    label: 'Alamat',
                    value: user!.alamat ?? 'Belum diisi',
                    isEmpty: user!.alamat == null,
                  ),
                  const SizedBox(height: 12),
                  // Pekerjaan Card
                  _buildInfoCard(
                    icon: Icons.work_outline,
                    label: 'Pekerjaan',
                    value: user!.pekerjaan ?? 'Belum diisi',
                    isEmpty: user!.pekerjaan == null,
                  ),
                  const SizedBox(height: 12),
                  // Gaji Per Bulan Card
                  _buildInfoCard(
                    icon: Icons.attach_money,
                    label: 'Gaji Per Bulan',
                    value: user!.gajiPerBulan != null
                        ? 'Rp ${user!.gajiPerBulan.toString().replaceAllMapped(RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'), (m) => '${m[1]}.')}'
                        : 'Belum diisi',
                    isEmpty: user!.gajiPerBulan == null,
                  ),
                ],
              ),
            ),

            // Button Section
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 24),
              child: Column(
                children: [
                  // Edit Button
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton.icon(
                      onPressed: () {
                        setState(() {
                          isEditing = true;
                        });
                      },
                      icon: const Icon(Icons.edit),
                      label: Text(
                        'Edit Profile',
                        style: GoogleFonts.poppins(
                          fontSize: 14,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppTheme.primaryRed,
                        foregroundColor: AppTheme.white,
                        padding: const EdgeInsets.symmetric(vertical: 12),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(8),
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(height: 12),
                  // Logout Button
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton.icon(
                      onPressed: _handleLogout,
                      icon: const Icon(Icons.logout),
                      label: Text(
                        'Logout',
                        style: GoogleFonts.poppins(
                          fontSize: 14,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.red.shade600,
                        foregroundColor: AppTheme.white,
                        padding: const EdgeInsets.symmetric(vertical: 12),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(8),
                        ),
                      ),
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

  /// EDIT MODE - Form untuk edit profile
  Widget _buildEditProfileUI() {
    return SafeArea(
      child: SingleChildScrollView(
        child: Column(
          children: [
            // Header
            Container(
              width: double.infinity,
              decoration: const BoxDecoration(
                gradient: LinearGradient(
                  colors: [AppTheme.primaryRed, AppTheme.darkRed],
                  begin: Alignment.topCenter,
                  end: Alignment.bottomCenter,
                ),
              ),
              padding: const EdgeInsets.all(24),
              child: Column(
                children: [
                  const Icon(Icons.edit, size: 48, color: AppTheme.white),
                  const SizedBox(height: 12),
                  Text(
                    'Edit Profile',
                    style: GoogleFonts.poppins(
                      fontSize: 20,
                      fontWeight: FontWeight.w700,
                      color: AppTheme.white,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    'Lengkapi dan update data profil Anda',
                    style: GoogleFonts.poppins(
                      fontSize: 12,
                      color: AppTheme.white.withOpacity(0.8),
                    ),
                  ),
                ],
              ),
            ),

            // Form Section
            Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  // Nama Field
                  _buildTextFormField(
                    controller: namaController,
                    label: 'Nama Lengkap',
                    hint: 'Masukkan nama Anda',
                    icon: Icons.person,
                  ),
                  const SizedBox(height: 16),

                  // Nomor HP Field
                  _buildTextFormField(
                    controller: noTelpController,
                    label: 'Nomor Telepon',
                    hint: '08123456789',
                    icon: Icons.phone,
                    keyboardType: TextInputType.phone,
                  ),
                  const SizedBox(height: 16),

                  // Alamat Field
                  _buildTextFormField(
                    controller: alamatController,
                    label: 'Alamat',
                    hint: 'Masukkan alamat Anda',
                    icon: Icons.location_on,
                    maxLines: 3,
                  ),
                  const SizedBox(height: 16),

                  // Pekerjaan Field
                  _buildTextFormField(
                    controller: pekerjaanController,
                    label: 'Pekerjaan',
                    hint: 'Masukkan pekerjaan Anda',
                    icon: Icons.work,
                  ),
                  const SizedBox(height: 16),

                  // Gaji Per Bulan Field
                  _buildTextFormField(
                    controller: gajiController,
                    label: 'Gaji Per Bulan',
                    hint: 'Masukkan gaji bulanan',
                    icon: Icons.attach_money,
                    keyboardType: TextInputType.number,
                  ),
                ],
              ),
            ),

            // Action Buttons
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 24),
              child: Row(
                children: [
                  // Cancel Button
                  Expanded(
                    child: ElevatedButton(
                      onPressed: isSaving ? null : _cancelEdit,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.grey.shade300,
                        foregroundColor: AppTheme.darkGrey,
                        padding: const EdgeInsets.symmetric(vertical: 12),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(8),
                        ),
                      ),
                      child: Text(
                        'Batal',
                        style: GoogleFonts.poppins(
                          fontSize: 14,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(width: 12),
                  // Save Button
                  Expanded(
                    child: ElevatedButton.icon(
                      onPressed: isSaving ? null : _saveProfile,
                      icon: isSaving
                          ? SizedBox(
                              width: 16,
                              height: 16,
                              child: CircularProgressIndicator(
                                strokeWidth: 2,
                                valueColor: AlwaysStoppedAnimation<Color>(
                                  AppTheme.white,
                                ),
                              ),
                            )
                          : const Icon(Icons.check),
                      label: Text(
                        isSaving ? 'Menyimpan...' : 'Simpan',
                        style: GoogleFonts.poppins(
                          fontSize: 14,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppTheme.primaryRed,
                        foregroundColor: AppTheme.white,
                        disabledBackgroundColor: Colors.grey,
                        padding: const EdgeInsets.symmetric(vertical: 12),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(8),
                        ),
                      ),
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

  Widget _buildInfoCard({
    required IconData icon,
    required String label,
    required String value,
    bool isEmpty = false,
  }) {
    return Container(
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
      padding: const EdgeInsets.all(16),
      child: Row(
        children: [
          Container(
            width: 48,
            height: 48,
            decoration: BoxDecoration(
              color: AppTheme.lightGrey,
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: AppTheme.primaryRed, size: 24),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: GoogleFonts.poppins(
                    fontSize: 12,
                    color: AppTheme.grey,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  value,
                  style: GoogleFonts.poppins(
                    fontSize: 14,
                    fontWeight: FontWeight.w600,
                    color: isEmpty ? AppTheme.grey : AppTheme.darkGrey,
                  ),
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTextFormField({
    required TextEditingController controller,
    required String label,
    required String hint,
    required IconData icon,
    TextInputType keyboardType = TextInputType.text,
    int maxLines = 1,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: GoogleFonts.poppins(
            fontSize: 13,
            fontWeight: FontWeight.w600,
            color: AppTheme.darkGrey,
          ),
        ),
        const SizedBox(height: 8),
        TextField(
          controller: controller,
          keyboardType: keyboardType,
          maxLines: maxLines,
          decoration: InputDecoration(
            hintText: hint,
            prefixIcon: Icon(icon, color: AppTheme.primaryRed),
            filled: true,
            fillColor: AppTheme.white,
            contentPadding: const EdgeInsets.symmetric(
              horizontal: 16,
              vertical: 12,
            ),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide: BorderSide(color: AppTheme.borderColor),
            ),
            enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide: BorderSide(color: AppTheme.borderColor),
            ),
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide: const BorderSide(
                color: AppTheme.primaryRed,
                width: 2,
              ),
            ),
          ),
        ),
      ],
    );
  }

  String _formatDate(DateTime date) {
    final months = [
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember',
    ];
    return '${date.day} ${months[date.month - 1]} ${date.year}';
  }
}
