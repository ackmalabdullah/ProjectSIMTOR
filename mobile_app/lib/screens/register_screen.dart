import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';
import 'home_screen.dart';
import 'login_screen.dart';

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();
  final _confirmPasswordController = TextEditingController();

  @override
  void dispose() {
    _usernameController.dispose();
    _passwordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
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
                            /// LOGIN (tidak aktif)
                            OutlinedButton(
                              style: OutlinedButton.styleFrom(
                                side: BorderSide(
                                  color: AppTheme.white,
                                ),
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
                  /// Username
                  TextField(
                    controller: _usernameController,
                    decoration: const InputDecoration(
                      hintText: 'Username or Email',
                    ),
                  ),

                  const SizedBox(height: 12),

                  /// Password
                  TextField(
                    controller: _passwordController,
                    obscureText: true,
                    decoration: const InputDecoration(
                      hintText: 'Password',
                    ),
                  ),

                  const SizedBox(height: 12),

                  /// Confirm Password
                  TextField(
                    controller: _confirmPasswordController,
                    obscureText: true,
                    decoration: const InputDecoration(
                      hintText: 'Confirm Password',
                    ),
                  ),

                  const SizedBox(height: 24),

                  /// Button Register
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      onPressed: () {
                        Navigator.pushReplacement(
                          context,
                          MaterialPageRoute(
                            builder: (_) => const HomeScreen(),
                          ),
                        );
                      },
                      child: Text(
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
                    onTap: () {},
                    child: Container(
                      width: 48,
                      height: 48,
                      decoration: BoxDecoration(
                        border: Border.all(
                          color: AppTheme.borderColor,
                        ),
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
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}