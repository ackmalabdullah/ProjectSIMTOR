import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';
import '../services/auth_service.dart';
import 'home_screen.dart';
import 'login_screen.dart';

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _namaController = TextEditingController();
  final _usernameController = TextEditingController();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  final _confirmPasswordController = TextEditingController();
  bool _isLoading = false;
  bool _passwordVisible = false;
  bool _confirmPasswordVisible = false;

  @override
  void dispose() {
    _namaController.dispose();
    _usernameController.dispose();
    _emailController.dispose();
    _passwordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
  }

  // 🔥 VALIDASI FORM
  bool _validateForm() {
    if (_namaController.text.isEmpty) {
      _showSnackBar("Nama harus diisi!");
      return false;
    }
    if (_usernameController.text.isEmpty) {
      _showSnackBar("Username harus diisi!");
      return false;
    }
    if (_emailController.text.isEmpty) {
      _showSnackBar("Email harus diisi!");
      return false;
    }
    if (!_emailController.text.contains('@')) {
      _showSnackBar("Email tidak valid!");
      return false;
    }
    if (_passwordController.text.isEmpty) {
      _showSnackBar("Password harus diisi!");
      return false;
    }
    if (_passwordController.text.length < 6) {
      _showSnackBar("Password minimal 6 karakter!");
      return false;
    }
    if (_passwordController.text != _confirmPasswordController.text) {
      _showSnackBar("Password tidak sama!");
      return false;
    }
    return true;
  }

  // 🔥 REGISTER
  void _register() async {
    if (!_validateForm()) return;

    setState(() => _isLoading = true);

    bool success = await AuthService.register(
      nama: _namaController.text,
      username: _usernameController.text,
      email: _emailController.text,
      password: _passwordController.text,
    );

    setState(() => _isLoading = false);

    if (success) {
      _showSnackBar("Register berhasil! Silakan login");
      Future.delayed(const Duration(seconds: 1), () {
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (_) => const LoginScreen()),
        );
      });
    } else {
      _showSnackBar("Register gagal! Email mungkin sudah digunakan");
    }
  }

  void _showSnackBar(String message) {
    ScaffoldMessenger.of(
      context,
    ).showSnackBar(SnackBar(content: Text(message)));
  }

  void _registerGoogle() async {
    setState(() => _isLoading = true);

    bool success = await AuthService.loginWithGoogle();

    setState(() => _isLoading = false);

    if (success) {
      _showSnackBar("Register Google berhasil!");
      Future.delayed(const Duration(seconds: 1), () {
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (_) => const HomeScreen()),
        );
      });
    } else {
      _showSnackBar("Register Google gagal");
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: true,
      body: SingleChildScrollView(
        child: Column(
          children: [
            /// =========================
            /// TOP RED SECTION
            /// =========================
            Container(
              width: double.infinity,
              color: AppTheme.primaryRed,
              child: Stack(
                children: [
                  /// Wave putih bawah
                  Positioned(
                    bottom: 0,
                    left: 0,
                    right: 0,
                    child: CustomPaint(
                      painter: WavePainter(),
                      size: const Size(double.infinity, 80),
                    ),
                  ),

                  /// Content atas
                  Padding(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 24,
                      vertical: 40,
                    ),
                    child: Column(
                      children: [
                        const SizedBox(height: 30),

                        /// Title
                        Text(
                          'SIMTOR',
                          style: GoogleFonts.poppins(
                            fontSize: 32,
                            fontWeight: FontWeight.w800,
                            color: AppTheme.white,
                            letterSpacing: 2,
                          ),
                        ),

                        const SizedBox(height: 6),

                        Text(
                          'Simulasi Cicilan Motor Honda',
                          style: GoogleFonts.poppins(
                            fontSize: 14,
                            color: AppTheme.white.withOpacity(0.85),
                          ),
                        ),

                        const SizedBox(height: 40),

                        /// Logo Placeholder
                        Container(
                          width: 80,
                          height: 80,
                          decoration: BoxDecoration(
                            color: AppTheme.white.withOpacity(0.2),
                            borderRadius: BorderRadius.circular(16),
                          ),
                          child: const Icon(
                            Icons.motorcycle,
                            size: 48,
                            color: AppTheme.white,
                          ),
                        ),

                        const SizedBox(height: 12),

                        Text(
                          'LOGO',
                          style: GoogleFonts.poppins(
                            fontSize: 18,
                            fontWeight: FontWeight.w700,
                            color: AppTheme.white,
                          ),
                        ),

                        const SizedBox(height: 6),

                        Text(
                          'Simulasi Cicilan Motor Honda\nCerdas berbasis AI',
                          textAlign: TextAlign.center,
                          style: GoogleFonts.poppins(
                            fontSize: 12,
                            color: AppTheme.white.withOpacity(0.85),
                          ),
                        ),

                        const SizedBox(height: 30),

                        /// =========================
                        /// LOGIN / REGISTER TOGGLE
                        /// =========================
                        Row(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            /// LOGIN
                            OutlinedButton(
                              style: OutlinedButton.styleFrom(
                                side: BorderSide(color: AppTheme.white),
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(25),
                                ),
                                minimumSize: const Size(120, 46),
                              ),
                              onPressed: () {
                                Navigator.pushReplacement(
                                  context,
                                  MaterialPageRoute(
                                    builder: (_) => const LoginScreen(),
                                  ),
                                );
                              },
                              child: Text(
                                'Login',
                                style: GoogleFonts.poppins(
                                  fontWeight: FontWeight.w600,
                                  color: AppTheme.white,
                                ),
                              ),
                            ),

                            const SizedBox(width: 12),

                            /// REGISTER (aktif)
                            ElevatedButton(
                              style: ElevatedButton.styleFrom(
                                backgroundColor: AppTheme.white,
                                foregroundColor: AppTheme.primaryRed,
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(25),
                                ),
                                minimumSize: const Size(120, 46),
                              ),
                              onPressed: () {},
                              child: Text(
                                'Register',
                                style: GoogleFonts.poppins(
                                  fontWeight: FontWeight.w600,
                                ),
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),

            /// =========================
            /// BOTTOM WHITE SECTION
            /// =========================
            Container(
              width: double.infinity,
              color: AppTheme.white,
              padding: const EdgeInsets.fromLTRB(24, 24, 24, 30),
              child: Column(
                children: [
                  /// Nama Lengkap
                  TextField(
                    controller: _namaController,
                    enabled: !_isLoading,
                    decoration: InputDecoration(
                      hintText: 'Nama Lengkap',
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      contentPadding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 14,
                      ),
                      prefixIcon: const Icon(Icons.person),
                    ),
                  ),

                  const SizedBox(height: 12),

                  /// Username
                  TextField(
                    controller: _usernameController,
                    enabled: !_isLoading,
                    decoration: InputDecoration(
                      hintText: 'Username',
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      contentPadding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 14,
                      ),
                      prefixIcon: const Icon(Icons.account_circle),
                    ),
                  ),

                  const SizedBox(height: 12),

                  /// Email
                  TextField(
                    controller: _emailController,
                    enabled: !_isLoading,
                    keyboardType: TextInputType.emailAddress,
                    decoration: InputDecoration(
                      hintText: 'Email',
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      contentPadding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 14,
                      ),
                      prefixIcon: const Icon(Icons.email),
                    ),
                  ),

                  const SizedBox(height: 12),

                  /// Password
                  TextField(
                    controller: _passwordController,
                    enabled: !_isLoading,
                    obscureText: !_passwordVisible,
                    decoration: InputDecoration(
                      hintText: 'Password',
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      contentPadding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 14,
                      ),
                      prefixIcon: const Icon(Icons.lock),
                      suffixIcon: IconButton(
                        icon: Icon(
                          _passwordVisible
                              ? Icons.visibility
                              : Icons.visibility_off,
                        ),
                        onPressed: () {
                          setState(() {
                            _passwordVisible = !_passwordVisible;
                          });
                        },
                      ),
                    ),
                  ),

                  const SizedBox(height: 12),

                  /// Confirm Password
                  TextField(
                    controller: _confirmPasswordController,
                    enabled: !_isLoading,
                    obscureText: !_confirmPasswordVisible,
                    decoration: InputDecoration(
                      hintText: 'Konfirmasi Password',
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      contentPadding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 14,
                      ),
                      prefixIcon: const Icon(Icons.lock),
                      suffixIcon: IconButton(
                        icon: Icon(
                          _confirmPasswordVisible
                              ? Icons.visibility
                              : Icons.visibility_off,
                        ),
                        onPressed: () {
                          setState(() {
                            _confirmPasswordVisible = !_confirmPasswordVisible;
                          });
                        },
                      ),
                    ),
                  ),

                  const SizedBox(height: 24),

                  /// Button Register
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        padding: const EdgeInsets.symmetric(vertical: 14),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                      ),
                      onPressed: _isLoading ? null : _register,
                      child: _isLoading
                          ? const SizedBox(
                              height: 20,
                              width: 20,
                              child: CircularProgressIndicator(strokeWidth: 2),
                            )
                          : Text(
                              'Register',
                              style: GoogleFonts.poppins(
                                fontSize: 16,
                                fontWeight: FontWeight.w600,
                              ),
                            ),
                    ),
                  ),

                  const SizedBox(height: 14),

                  Text(
                    'or',
                    style: GoogleFonts.poppins(
                      fontSize: 13,
                      color: AppTheme.grey,
                    ),
                  ),

                  const SizedBox(height: 12),

                  /// Google Button
                  GestureDetector(
                    onTap: _isLoading ? null : _registerGoogle,
                    child: Container(
                      width: 48,
                      height: 48,
                      decoration: BoxDecoration(
                        border: Border.all(color: AppTheme.borderColor),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: const Center(
                        child: Text(
                          'G',
                          style: TextStyle(
                            fontSize: 24,
                            fontWeight: FontWeight.bold,
                            color: Colors.red,
                          ),
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(height: 14),

                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        'Sudah punya akun? ',
                        style: GoogleFonts.poppins(fontSize: 13),
                      ),
                      GestureDetector(
                        onTap: () {
                          Navigator.pushReplacement(
                            context,
                            MaterialPageRoute(
                              builder: (_) => const LoginScreen(),
                            ),
                          );
                        },
                        child: Text(
                          'Login di sini',
                          style: GoogleFonts.poppins(
                            fontSize: 13,
                            fontWeight: FontWeight.w600,
                            color: AppTheme.primaryRed,
                          ),
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class WavePainter extends CustomPainter {
  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()
      ..color = AppTheme.white
      ..style = PaintingStyle.fill;

    final path = Path();
    path.moveTo(0, size.height);
    path.quadraticBezierTo(
      size.width * 0.25,
      size.height * 0.3,
      size.width * 0.5,
      size.height * 0.6,
    );
    path.quadraticBezierTo(
      size.width * 0.75,
      size.height * 0.9,
      size.width,
      size.height * 0.4,
    );
    path.lineTo(size.width, size.height);
    path.close();

    canvas.drawPath(path, paint);
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}
