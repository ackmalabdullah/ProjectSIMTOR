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
      final profileUser = await UserService.getProfile();

      if (profileUser != null) {
        setState(() {
          user = profileUser;
          isLoading = false;

          _initializeControllers(profileUser);
        });
      } else {
        final cachedUser = await UserService.getCachedUser();

        setState(() {
          user = cachedUser;
          isLoading = false;

          _initializeControllers(cachedUser);
        });
      }
    } catch (e) {
      print(e);

      setState(() {
        isLoading = false;
      });
    }
  }

  void _initializeControllers(UserModel? userData) {
    namaController = TextEditingController(text: userData?.nama ?? '');

    noTelpController = TextEditingController(text: userData?.noTelp ?? '');

    alamatController = TextEditingController(text: userData?.alamat ?? '');

    pekerjaanController = TextEditingController(
      text: userData?.pekerjaan ?? '',
    );

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
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(const SnackBar(content: Text('Nama tidak boleh kosong')));

      return;
    }

    setState(() {
      isSaving = true;
    });

    try {
      final updatedUser = user!.copyWith(
        nama: namaController.text,

        noTelp: noTelpController.text.isEmpty ? null : noTelpController.text,

        alamat: alamatController.text.isEmpty ? null : alamatController.text,

        pekerjaan: pekerjaanController.text.isEmpty
            ? null
            : pekerjaanController.text,

        gajiPerBulan: gajiController.text.isEmpty
            ? null
            : int.tryParse(gajiController.text),
      );

      final success = await UserService.updateProfile(updatedUser);

      if (success) {
        await _loadUserData();

        setState(() {
          isEditing = false;
          isSaving = false;
        });

        if (mounted) {
          showDialog(
            context: context,
            barrierDismissible: false,
            builder: (_) {
              return AlertDialog(
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(20),
                ),

                content: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Container(
                      width: 80,
                      height: 80,
                      decoration: BoxDecoration(
                        color: Colors.green.withOpacity(0.15),

                        shape: BoxShape.circle,
                      ),

                      child: const Icon(
                        Icons.check_circle,
                        color: Colors.green,
                        size: 50,
                      ),
                    ),

                    const SizedBox(height: 20),

                    Text(
                      "Berhasil!",
                      style: GoogleFonts.poppins(
                        fontSize: 20,
                        fontWeight: FontWeight.w700,
                      ),
                    ),

                    const SizedBox(height: 8),

                    Text(
                      "Profile berhasil diperbarui",
                      textAlign: TextAlign.center,
                      style: GoogleFonts.poppins(
                        fontSize: 13,
                        color: AppTheme.grey,
                      ),
                    ),
                  ],
                ),
              );
            },
          );

          await Future.delayed(const Duration(seconds: 2));

          if (mounted) {
            Navigator.pop(context);
          }
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
      print(e);

      setState(() {
        isSaving = false;
      });

      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error: $e'), backgroundColor: Colors.red),
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
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(24),
          ),

          contentPadding: const EdgeInsets.all(24),

          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                width: 80,
                height: 80,

                decoration: BoxDecoration(
                  color: Colors.red.withOpacity(0.12),

                  shape: BoxShape.circle,
                ),

                child: const Icon(
                  Icons.logout_rounded,
                  size: 42,
                  color: Colors.red,
                ),
              ),

              const SizedBox(height: 20),

              Text(
                'Logout?',
                style: GoogleFonts.poppins(
                  fontSize: 20,
                  fontWeight: FontWeight.w700,
                ),
              ),

              const SizedBox(height: 10),

              Text(
                'Anda yakin ingin keluar dari akun SIMTOR?',
                textAlign: TextAlign.center,
                style: GoogleFonts.poppins(
                  fontSize: 13,
                  color: AppTheme.grey,
                  height: 1.5,
                ),
              ),

              const SizedBox(height: 24),

              Row(
                children: [
                  Expanded(
                    child: OutlinedButton(
                      onPressed: () {
                        Navigator.pop(context);
                      },

                      style: OutlinedButton.styleFrom(
                        padding: const EdgeInsets.symmetric(vertical: 12),

                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(14),
                        ),
                      ),

                      child: Text(
                        'Batal',
                        style: GoogleFonts.poppins(
                          fontWeight: FontWeight.w600,
                          color: AppTheme.darkGrey,
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(width: 12),

                  Expanded(
                    child: ElevatedButton(
                      onPressed: () {
                        Navigator.pop(context);

                        _performLogout();
                      },

                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppTheme.primaryRed,

                        padding: const EdgeInsets.symmetric(vertical: 12),

                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(14),
                        ),
                      ),

                      child: Text(
                        'Logout',
                        style: GoogleFonts.poppins(
                          fontWeight: FontWeight.w600,
                          color: AppTheme.white,
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ],
          ),
        );
      },
    );
  }

  Future<void> _performLogout() async {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) => const Center(child: CircularProgressIndicator()),
    );

    await UserService.logout();

    if (mounted) {
      Navigator.pop(context);

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
          ? const Center(child: Text("User tidak ditemukan"))
          : isEditing
          ? _buildEditProfileUI()
          : _buildViewProfileUI(),
    );
  }

  Widget _buildViewProfileUI() {
    return SafeArea(
      child: SingleChildScrollView(
        child: Column(
          children: [
            Container(
              width: double.infinity,

              padding: const EdgeInsets.fromLTRB(24, 50, 24, 30),

              decoration: const BoxDecoration(
                gradient: LinearGradient(
                  colors: [AppTheme.primaryRed, AppTheme.darkRed],

                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),

                borderRadius: BorderRadius.only(
                  bottomLeft: Radius.circular(30),
                  bottomRight: Radius.circular(30),
                ),
              ),

              child: Column(
                children: [
                  Container(
                    width: 110,
                    height: 110,

                    decoration: BoxDecoration(
                      shape: BoxShape.circle,
                      color: AppTheme.white,

                      border: Border.all(color: AppTheme.white, width: 4),

                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.15),

                          blurRadius: 12,

                          offset: const Offset(0, 5),
                        ),
                      ],
                    ),

                    child: const Icon(
                      Icons.person,
                      size: 50,
                      color: AppTheme.grey,
                    ),
                  ),

                  const SizedBox(height: 18),

                  Text(
                    user!.nama,
                    style: GoogleFonts.poppins(
                      fontSize: 22,
                      fontWeight: FontWeight.w700,
                      color: AppTheme.white,
                    ),
                  ),

                  const SizedBox(height: 4),

                  Text(
                    '@${user!.username}',
                    style: GoogleFonts.poppins(
                      fontSize: 13,
                      color: AppTheme.white.withOpacity(0.8),
                    ),
                  ),
                ],
              ),
            ),

            Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  _buildInfoCard(
                    icon: Icons.email_outlined,
                    label: 'Email',
                    value: user!.email,
                  ),

                  const SizedBox(height: 12),

                  _buildInfoCard(
                    icon: Icons.phone_outlined,
                    label: 'Nomor HP',
                    value: user!.noTelp ?? 'Belum diisi',
                    isEmpty: user!.noTelp == null,
                  ),

                  const SizedBox(height: 12),

                  _buildInfoCard(
                    icon: Icons.location_on_outlined,
                    label: 'Alamat',
                    value: user!.alamat ?? 'Belum diisi',
                    isEmpty: user!.alamat == null,
                  ),

                  const SizedBox(height: 12),

                  _buildInfoCard(
                    icon: Icons.work_outline,
                    label: 'Pekerjaan',
                    value: user!.pekerjaan ?? 'Belum diisi',
                    isEmpty: user!.pekerjaan == null,
                  ),

                  const SizedBox(height: 12),

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

            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 24),

              child: Column(
                children: [
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

                        padding: const EdgeInsets.symmetric(vertical: 14),

                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(14),
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(height: 12),

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

                        padding: const EdgeInsets.symmetric(vertical: 14),

                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(14),
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

  Widget _buildEditProfileUI() {
    return SafeArea(
      child: SingleChildScrollView(
        child: Column(
          children: [
            Container(
              width: double.infinity,

              padding: const EdgeInsets.fromLTRB(24, 50, 24, 30),

              decoration: const BoxDecoration(
                gradient: LinearGradient(
                  colors: [AppTheme.primaryRed, AppTheme.darkRed],

                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),

                borderRadius: BorderRadius.only(
                  bottomLeft: Radius.circular(30),
                  bottomRight: Radius.circular(30),
                ),
              ),

              child: Column(
                children: [
                  Container(
                    width: 100,
                    height: 100,

                    decoration: BoxDecoration(
                      color: AppTheme.white,
                      shape: BoxShape.circle,

                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.15),

                          blurRadius: 12,

                          offset: const Offset(0, 5),
                        ),
                      ],
                    ),

                    child: const Icon(
                      Icons.edit,
                      size: 45,
                      color: AppTheme.primaryRed,
                    ),
                  ),

                  const SizedBox(height: 18),

                  Text(
                    "Edit Profile",
                    style: GoogleFonts.poppins(
                      fontSize: 22,
                      fontWeight: FontWeight.w700,
                      color: AppTheme.white,
                    ),
                  ),

                  const SizedBox(height: 6),

                  Text(
                    "Lengkapi informasi profile akun Anda",
                    textAlign: TextAlign.center,
                    style: GoogleFonts.poppins(
                      fontSize: 13,
                      color: AppTheme.white.withOpacity(0.85),
                      height: 1.5,
                    ),
                  ),
                ],
              ),
            ),

            Padding(
              padding: const EdgeInsets.all(16),

              child: Column(
                children: [
                  _buildModernTextField(
                    controller: namaController,
                    label: "Nama Lengkap",
                    hint: "Masukkan nama lengkap",
                    icon: Icons.person_outline,
                  ),

                  const SizedBox(height: 18),

                  _buildModernTextField(
                    controller: noTelpController,
                    label: "Nomor Telepon",
                    hint: "08xxxxxxxxxx",
                    icon: Icons.phone_outlined,
                    keyboardType: TextInputType.phone,
                  ),

                  const SizedBox(height: 18),

                  _buildModernTextField(
                    controller: alamatController,
                    label: "Alamat",
                    hint: "Masukkan alamat lengkap",
                    icon: Icons.location_on_outlined,
                    maxLines: 3,
                  ),

                  const SizedBox(height: 18),

                  _buildModernTextField(
                    controller: pekerjaanController,
                    label: "Pekerjaan",
                    hint: "Masukkan pekerjaan",
                    icon: Icons.work_outline,
                  ),

                  const SizedBox(height: 18),

                  _buildModernTextField(
                    controller: gajiController,
                    label: "Gaji Per Bulan",
                    hint: "Masukkan gaji bulanan",
                    icon: Icons.attach_money_outlined,
                    keyboardType: TextInputType.number,
                  ),

                  const SizedBox(height: 32),

                  Row(
                    children: [
                      Expanded(
                        child: OutlinedButton(
                          onPressed: isSaving ? null : _cancelEdit,

                          style: OutlinedButton.styleFrom(
                            padding: const EdgeInsets.symmetric(vertical: 14),

                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(16),
                            ),
                          ),

                          child: Text(
                            "Batal",
                            style: GoogleFonts.poppins(
                              fontSize: 14,
                              fontWeight: FontWeight.w600,
                              color: AppTheme.darkGrey,
                            ),
                          ),
                        ),
                      ),

                      const SizedBox(width: 14),

                      Expanded(
                        child: ElevatedButton(
                          onPressed: isSaving ? null : _saveProfile,

                          style: ElevatedButton.styleFrom(
                            backgroundColor: AppTheme.primaryRed,

                            padding: const EdgeInsets.symmetric(vertical: 14),

                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(16),
                            ),
                          ),

                          child: isSaving
                              ? SizedBox(
                                  width: 20,
                                  height: 20,
                                  child: CircularProgressIndicator(
                                    strokeWidth: 2,
                                    valueColor: AlwaysStoppedAnimation<Color>(
                                      AppTheme.white,
                                    ),
                                  ),
                                )
                              : Text(
                                  "Simpan",
                                  style: GoogleFonts.poppins(
                                    fontSize: 14,
                                    fontWeight: FontWeight.w600,
                                    color: AppTheme.white,
                                  ),
                                ),
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 30),
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

        borderRadius: BorderRadius.circular(18),

        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.06),

            blurRadius: 14,

            offset: const Offset(0, 5),
          ),
        ],
      ),

      padding: const EdgeInsets.all(16),

      child: Row(
        children: [
          Container(
            width: 50,
            height: 50,

            decoration: BoxDecoration(
              color: AppTheme.lightGrey,

              borderRadius: BorderRadius.circular(14),
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
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildModernTextField({
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

        Container(
          decoration: BoxDecoration(
            color: AppTheme.white,

            borderRadius: BorderRadius.circular(18),

            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.05),

                blurRadius: 10,

                offset: const Offset(0, 4),
              ),
            ],
          ),

          child: TextField(
            controller: controller,
            keyboardType: keyboardType,
            maxLines: maxLines,

            style: GoogleFonts.poppins(
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),

            decoration: InputDecoration(
              hintText: hint,

              hintStyle: GoogleFonts.poppins(
                fontSize: 13,
                color: AppTheme.grey,
              ),

              prefixIcon: Icon(icon, color: AppTheme.primaryRed),

              filled: true,
              fillColor: AppTheme.white,

              contentPadding: const EdgeInsets.symmetric(
                horizontal: 16,
                vertical: 16,
              ),

              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(18),

                borderSide: BorderSide.none,
              ),

              enabledBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(18),

                borderSide: BorderSide(color: AppTheme.borderColor),
              ),

              focusedBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(18),

                borderSide: const BorderSide(
                  color: AppTheme.primaryRed,
                  width: 2,
                ),
              ),
            ),
          ),
        ),
      ],
    );
  }
}
