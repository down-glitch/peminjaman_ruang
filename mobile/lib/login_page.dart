import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:dio/dio.dart';
import 'register_page.dart';
import 'dashboard_page.dart';

class ApiService {
  static const String baseUrl =
      "http://127.0.0.1:8000/api"; // GANTI SESUAI SERVER

  Dio dio = Dio(
    BaseOptions(
      baseUrl: baseUrl,
      connectTimeout: const Duration(seconds: 10),
      receiveTimeout: const Duration(seconds: 10),
      headers: {"Accept": "application/json"},
    ),
  );

  // ==================== SIMPAN TOKEN ====================
  Future<void> _saveToken(String token) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setString('token', token);
    dio.options.headers['Authorization'] = 'Bearer $token';
  }

  // ==================== MUAT TOKEN ====================
  Future<void> loadToken() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');

    if (token != null) {
      dio.options.headers['Authorization'] = 'Bearer $token';
    }
  }

  // ==================== HAPUS TOKEN ====================
  Future<void> clearToken() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.remove('token');
    dio.options.headers.remove('Authorization');
  }

  // ==================== LOGIN ====================
  Future<Map<String, dynamic>> login(String username, String password) async {
    try {
      final response = await dio.post(
        '/login',
        data: {'username': username, 'password': password},
      );

      if (response.data['success'] == true) {
        await _saveToken(response.data['token']);
      }

      return response.data;
    } on DioException catch (e) {
      return {
        'success': false,
        'message':
            e.response?.data['message'] ?? 'Terjadi kesalahan saat login',
      };
    }
  }

  // ==================== REGISTER ====================
  Future<Map<String, dynamic>> register(
    String username,
    String email,
    String password,
  ) async {
    final response = await dio.post(
      '/register',
      data: {'username': username, 'email': email, 'password': password},
    );

    return response.data;
  }

  // ==================== LOGOUT ====================
  Future<Map<String, dynamic>> logout() async {
    final response = await dio.post('/logout');
    await clearToken();
    return response.data;
  }

  // ==================== GET PROFILE ====================
  Future<Map<String, dynamic>> getProfile() async {
    await loadToken();
    final response = await dio.get('/me');
    return response.data;
  }

  // ==================== ROOMS ====================
  Future<List<dynamic>> getRooms() async {
    await loadToken();
    final response = await dio.get('/rooms');
    return response.data;
  }

  // ==================== JADWAL ====================
  Future<List<dynamic>> getJadwal() async {
    await loadToken();
    final response = await dio.get('/jadwal');
    return response.data;
  }

  // ==================== LIST PEMINJAMAN USER ====================
  Future<List<dynamic>> getPeminjamanUser() async {
    await loadToken();
    final response = await dio.get('/peminjaman');
    return response.data;
  }

  // ==================== CREATE PEMINJAMAN ====================
  Future<Map<String, dynamic>> createPeminjaman(
    Map<String, dynamic> data,
  ) async {
    await loadToken();
    final response = await dio.post('/peminjaman', data: data);
    return response.data;
  }

  // ==================== JADWAL BOOKING ====================
  Future<List<dynamic>> getJadwalBooking() async {
    await loadToken();
    final response = await dio.get('/peminjaman/jadwal-booking');
    return response.data;
  }

  // ==================== CEK BENTROKAN JADWAL ====================
  Future<Map<String, dynamic>> cekJadwal(
    int roomId,
    String tanggal,
    String jamMulai,
    String jamSelesai,
  ) async {
    await loadToken();
    final response = await dio.get(
      '/cek-jadwal',
      queryParameters: {
        'room_id': roomId,
        'tanggal': tanggal,
        'jam_mulai': jamMulai,
        'jam_selesai': jamSelesai,
      },
    );
    return response.data;
  }
}

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> with TickerProviderStateMixin {
  bool _obscurePassword = true;
  bool _isLoading = false;
  final _formKey = GlobalKey<FormState>();
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();
  final ApiService _apiService = ApiService();

  List<String> _errors = [];

  late AnimationController _headerAnimationController;
  late AnimationController _formAnimationController;
  late Animation<double> _headerAnimation;
  late Animation<Offset> _formSlideAnimation;

  @override
  void initState() {
    super.initState();

    _headerAnimationController = AnimationController(
      duration: const Duration(milliseconds: 800),
      vsync: this,
    );

    _formAnimationController = AnimationController(
      duration: const Duration(milliseconds: 1200),
      vsync: this,
    );

    _headerAnimation = CurvedAnimation(
      parent: _headerAnimationController,
      curve: Curves.easeOut,
    );

    _formSlideAnimation =
        Tween<Offset>(begin: const Offset(0, 0.3), end: Offset.zero).animate(
          CurvedAnimation(
            parent: _formAnimationController,
            curve: Curves.easeOut,
          ),
        );

    _headerAnimationController.forward();
    _formAnimationController.forward();
  }

  @override
  void dispose() {
    _usernameController.dispose();
    _passwordController.dispose();
    _headerAnimationController.dispose();
    _formAnimationController.dispose();
    super.dispose();
  }

  void _togglePasswordVisibility() {
    setState(() {
      _obscurePassword = !_obscurePassword;
    });
  }

  Future<void> _login() async {
    setState(() {
      _errors = [];
    });

    if (_formKey.currentState!.validate()) {
      setState(() {
        _isLoading = true;
      });

      try {
        final result = await _apiService.login(
          _usernameController.text.trim(),
          _passwordController.text,
        );

        if (result['success'] == true) {
          // Login berhasil, navigasi ke dashboard
          if (mounted) {
            Navigator.pushReplacementNamed(context, '/dashboard');
          }
        } else {
          // Login gagal, tampilkan pesan error
          setState(() {
            if (result['errors'] != null) {
              _errors = List<String>.from(
                result['errors'].values.expand((e) => e),
              );
            } else {
              _errors = [result['message'] ?? 'Login gagal'];
            }
          });
        }
      } catch (e) {
        setState(() {
          _errors = ['Terjadi kesalahan: $e'];
        });
      } finally {
        if (mounted) {
          setState(() {
            _isLoading = false;
          });
        }
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFFAFAFA),
      body: Stack(
        children: [
          // Background pattern
          Positioned.fill(child: CustomPaint(painter: DotPatternPainter())),
          // Main content
          Center(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(24.0),
              child: FadeTransition(
                opacity: _headerAnimation,
                child: SlideTransition(
                  position: _formSlideAnimation,
                  child: Container(
                    width: double.infinity,
                    constraints: const BoxConstraints(maxWidth: 420),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(16),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.1),
                          blurRadius: 20,
                          offset: const Offset(0, 10),
                        ),
                      ],
                      border: Border.all(
                        color: const Color(0xFFE5E7EB),
                        width: 1,
                      ),
                    ),
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [_buildHeader(), _buildForm()],
                    ),
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHeader() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.symmetric(vertical: 32, horizontal: 24),
      decoration: const BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF5D4E37), Color(0xFF3E3326)],
        ),
        borderRadius: BorderRadius.only(
          topLeft: Radius.circular(16),
          topRight: Radius.circular(16),
        ),
      ),
      child: Column(
        children: [
          const Text(
            'Peminjaman Ruang',
            style: TextStyle(
              fontFamily: 'Merriweather',
              fontSize: 32,
              fontWeight: FontWeight.w700,
              color: Colors.white,
              letterSpacing: -0.5,
            ),
          ),
          const SizedBox(height: 8),
          const Text(
            'Silahkan Login Terlebih Dahulu',
            style: TextStyle(
              fontSize: 15,
              fontWeight: FontWeight.w400,
              color: Color(0xFFE0E0E0),
            ),
          ),
          const SizedBox(height: 16),
          Container(
            height: 4,
            width: double.infinity,
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                colors: [Color(0xFFD4AF37), Color(0xFFF4E4C1)],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildForm() {
    return Padding(
      padding: const EdgeInsets.all(32.0),
      child: Form(
        key: _formKey,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Error messages
            if (_errors.isNotEmpty)
              Container(
                padding: const EdgeInsets.all(14),
                margin: const EdgeInsets.only(bottom: 24),
                decoration: BoxDecoration(
                  color: const Color(0xFFFEF2F2),
                  borderRadius: BorderRadius.circular(8),
                  border: Border.all(color: const Color(0xFFDC2626), width: 1),
                ),
                child: Row(
                  children: [
                    const Icon(
                      Icons.error_outline,
                      color: Color(0xFFDC2626),
                      size: 16,
                    ),
                    const SizedBox(width: 10),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: _errors
                            .map(
                              (error) => Text(
                                error,
                                style: const TextStyle(
                                  color: Color(0xFFDC2626),
                                  fontSize: 14,
                                ),
                              ),
                            )
                            .toList(),
                      ),
                    ),
                  ],
                ),
              ),

            // Username field
            _buildFormField(
              label: 'Username',
              icon: FontAwesomeIcons.user,
              controller: _usernameController,
              hintText: 'Masukan username anda',
              validator: (value) {
                if (value == null || value.trim().isEmpty) {
                  return 'Silakan masukkan username Anda';
                }
                return null;
              },
            ),

            const SizedBox(height: 24),

            // Password field
            _buildFormField(
              label: 'Password',
              icon: FontAwesomeIcons.lock,
              controller: _passwordController,
              hintText: 'Masukan password anda',
              obscureText: _obscurePassword,
              validator: (value) {
                if (value == null || value.trim().isEmpty) {
                  return 'Silakan masukkan password Anda';
                }
                return null;
              },
              suffixIcon: IconButton(
                icon: Icon(
                  _obscurePassword
                      ? FontAwesomeIcons.eye
                      : FontAwesomeIcons.eyeSlash,
                  color: const Color(0xFF9CA3AF),
                  size: 16,
                ),
                onPressed: _togglePasswordVisibility,
              ),
            ),

            const SizedBox(height: 32),

            // Login button
            SizedBox(
              width: double.infinity,
              height: 50,
              child: ElevatedButton(
                onPressed: _isLoading ? null : _login,
                style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xFF5D4E37),
                  foregroundColor: Colors.white,
                  elevation: 0,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8),
                  ),
                  padding: const EdgeInsets.symmetric(vertical: 14),
                ),
                child: _isLoading
                    ? const Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          SizedBox(
                            width: 16,
                            height: 16,
                            child: CircularProgressIndicator(
                              color: Colors.white,
                              strokeWidth: 2,
                            ),
                          ),
                          SizedBox(width: 12),
                          Text('Mengautentikasi...'),
                        ],
                      )
                    : const Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(FontAwesomeIcons.signInAlt, size: 16),
                          SizedBox(width: 8),
                          Text(
                            'Masuk',
                            style: TextStyle(
                              fontSize: 16,
                              fontWeight: FontWeight.w600,
                            ),
                          ),
                        ],
                      ),
              ),
            ),

            const SizedBox(height: 24),

            // Footer
            Container(
              padding: const EdgeInsets.only(top: 24),
              decoration: const BoxDecoration(
                border: Border(
                  top: BorderSide(color: Color(0xFFE5E7EB), width: 1),
                ),
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  const Text(
                    'Tidak punya akun? ',
                    style: TextStyle(color: Color(0xFF6B7280), fontSize: 14),
                  ),
                  GestureDetector(
                    onTap: () {
                      Navigator.pushNamed(context, '/register');
                    },
                    child: const Text(
                      'Buat akun',
                      style: TextStyle(
                        color: Color(0xFF5D4E37),
                        fontSize: 14,
                        fontWeight: FontWeight.w600,
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

  Widget _buildFormField({
    required String label,
    required IconData icon,
    required TextEditingController controller,
    required String hintText,
    bool obscureText = false,
    String? Function(String?)? validator,
    Widget? suffixIcon,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          children: [
            Icon(icon, size: 13, color: const Color(0xFF5D4E37)),
            const SizedBox(width: 6),
            Text(
              label,
              style: const TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.w500,
                color: Color(0xFF6B7280),
              ),
            ),
          ],
        ),
        const SizedBox(height: 8),
        TextFormField(
          controller: controller,
          obscureText: obscureText,
          validator: validator,
          decoration: InputDecoration(
            hintText: hintText,
            hintStyle: const TextStyle(color: Color(0xFF9CA3AF)),
            prefixIcon: Icon(icon, color: const Color(0xFF9CA3AF), size: 15),
            suffixIcon: suffixIcon,
            filled: true,
            fillColor: const Color(0xFFF8F8F8),
            contentPadding: const EdgeInsets.symmetric(
              vertical: 12,
              horizontal: 16,
            ),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: const BorderSide(color: Color(0xFFE5E7EB), width: 1),
            ),
            enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: const BorderSide(color: Color(0xFFE5E7EB), width: 1),
            ),
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: const BorderSide(color: Color(0xFFD4AF37), width: 1),
            ),
            errorBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: const BorderSide(color: Color(0xFFDC2626), width: 1),
            ),
            focusedErrorBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: const BorderSide(color: Color(0xFFDC2626), width: 1),
            ),
            errorStyle: const TextStyle(color: Color(0xFFDC2626), fontSize: 13),
          ),
        ),
      ],
    );
  }
}

// Custom painter for background pattern
class DotPatternPainter extends CustomPainter {
  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()
      ..color = const Color(0xFFE5E7EB).withOpacity(0.3)
      ..strokeCap = StrokeCap.round
      ..strokeWidth = 1;

    const spacing = 40.0;
    const dotSize = 1.0;

    for (double x = 0; x < size.width; x += spacing) {
      for (double y = 0; y < size.height; y += spacing) {
        canvas.drawCircle(Offset(x, y), dotSize, paint);
      }
    }
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}
