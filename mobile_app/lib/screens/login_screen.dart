import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../theme/app_theme.dart';
import 'register_screen.dart';
import 'home_screen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();

  @override
  void dispose() {
    _usernameController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: true,

      // 🔥 pakai SafeArea + SingleChildScrollView biar tidak overflow
      body: SafeArea(
        child: SingleChildScrollView(
          child: ConstrainedBox(
            constraints: BoxConstraints(
              minHeight: MediaQuery.of(context).size.height,
            ),
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
                      /// Wave decoration
                      Positioned(
                        bottom: 0,
                        left: 0,
                        right: 0,
                        child: CustomPaint(
                          painter: WavePainter(),
                          size: const Size(double.infinity, 80),
                        ),
                      ),

                      /// Content
                      Padding(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 24,
                          vertical: 40,
                        ),
                        child: Column(
                          children: [
                            Text(
                              'SIMTOR',
                              style: GoogleFonts.poppins(
                                fontSize: 32,
                                fontWeight: FontWeight.w800,
                                color: AppTheme.white,
                                letterSpacing: 2,
                              ),
                            ),

                            const SizedBox(height: 8),

                            Text(
                              'Aplikasi Simulasi Kredit Motor',
                              style: GoogleFonts.poppins(
                                fontSize: 14,
                                color: AppTheme.white.withOpacity(0.85),
                              ),
                            ),

                            const SizedBox(height: 40),

                            /// LOGO
                            Container(
                              width: 90,
                              height: 90,
                              decoration: BoxDecoration(
                                color: AppTheme.white.withOpacity(0.2),
                                borderRadius: BorderRadius.circular(18),
                              ),
                              child: const Icon(
                                Icons.motorcycle,
                                size: 50,
                                color: Colors.white,
                              ),
                            ),

                            const SizedBox(height: 14),

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
                              'Simulasi Cicilan Motor Honda\nCerdas Berbasis AI',
                              textAlign: TextAlign.center,
                              style: GoogleFonts.poppins(
                                fontSize: 12,
                                color: AppTheme.white.withOpacity(0.85),
                              ),
                            ),

                            const SizedBox(height: 30),

                            /// BUTTON LOGIN / REGISTER
                            Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                OutlinedButton(
                                  style: OutlinedButton.styleFrom(
                                    side: const BorderSide(
                                      color: Colors.white,
                                    ),
                                    foregroundColor: Colors.white,
                                    minimumSize: const Size(120, 46),
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(25),
                                    ),
                                  ),
                                  onPressed: () {},
                                  child: Text(
                                    'Login',
                                    style: GoogleFonts.poppins(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                ),

                                const SizedBox(width: 12),

                                ElevatedButton(
                                  style: ElevatedButton.styleFrom(
                                    backgroundColor: AppTheme.white,
                                    foregroundColor: AppTheme.primaryRed,
                                    minimumSize: const Size(120, 46),
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(25),
                                    ),
                                  ),
                                  onPressed: () {
                                    Navigator.push(
                                      context,
                                      MaterialPageRoute(
                                        builder: (_) =>
                                            const RegisterScreen(),
                                      ),
                                    );
                                  },
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
                  padding: const EdgeInsets.fromLTRB(24, 30, 24, 24),
                  child: Column(
                    children: [
                      TextField(
                        controller: _usernameController,
                        decoration: InputDecoration(
                          hintText: 'Username or Email',
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          contentPadding: const EdgeInsets.symmetric(
                            horizontal: 16,
                            vertical: 14,
                          ),
                        ),
                      ),

                      const SizedBox(height: 16),

                      TextField(
                        controller: _passwordController,
                        obscureText: true,
                        decoration: InputDecoration(
                          hintText: 'Password',
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          contentPadding: const EdgeInsets.symmetric(
                            horizontal: 16,
                            vertical: 14,
                          ),
                        ),
                      ),

                      const SizedBox(height: 24),

                      SizedBox(
                        width: double.infinity,
                        child: ElevatedButton(
                          style: ElevatedButton.styleFrom(
                            padding: const EdgeInsets.symmetric(vertical: 14),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(12),
                            ),
                          ),
                          onPressed: () {
                            Navigator.pushReplacement(
                              context,
                              MaterialPageRoute(
                                builder: (_) => const HomeScreen(),
                              ),
                            );
                          },
                          child: Text(
                            'Login',
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

                      const SizedBox(height: 14),

                      /// GOOGLE BUTTON
                      GestureDetector(
                        onTap: () {},
                        child: Container(
                          width: 50,
                          height: 50,
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