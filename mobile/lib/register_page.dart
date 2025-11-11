import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:dio/dio.dart';
import 'login_page.dart';

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
    String passwordConfirmation,
  ) async {
    try {
      final response = await dio.post(
        '/register',
        data: {
          'username': username,
          'email': email,
          'password': password,
          'password_confirmation': passwordConfirmation,
        },
      );

      return response.data;
    } on DioException catch (e) {
      return {
        'success': false,
        'message':
            e.response?.data['message'] ?? 'Terjadi kesalahan saat registrasi',
        'errors': e.response?.data['errors'] ?? {},
      };
    }
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

class RegisterPage extends StatefulWidget {
  const RegisterPage({super.key});

  @override
  State<RegisterPage> createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage>
    with TickerProviderStateMixin {
  bool _obscurePassword = true;
  bool _obscureConfirmPassword = true;
  bool _isLoading = false;
  final _formKey = GlobalKey<FormState>();
  final _usernameController = TextEditingController();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  final _confirmPasswordController = TextEditingController();
  final ApiService _apiService = ApiService();

  List<String> _errors = [];

  // Password strength indicators
  bool _hasMinLength = false;
  bool _hasNumber = false;
  bool _hasUpperCase = false;
  bool _passwordsMatch = false;

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

    // Add listeners to password fields to update validation
    _passwordController.addListener(_checkPasswordStrength);
    _confirmPasswordController.addListener(_checkPasswordMatch);
  }

  @override
  void dispose() {
    _usernameController.dispose();
    _emailController.dispose();
    _passwordController.dispose();
    _confirmPasswordController.dispose();
    _headerAnimationController.dispose();
    _formAnimationController.dispose();
    super.dispose();
  }

  void _togglePasswordVisibility() {
    setState(() {
      _obscurePassword = !_obscurePassword;
    });
  }

  void _toggleConfirmPasswordVisibility() {
    setState(() {
      _obscureConfirmPassword = !_obscureConfirmPassword;
    });
  }

  void _checkPasswordStrength() {
    final password = _passwordController.text;

    setState(() {
      _hasMinLength = password.length >= 8;
      _hasNumber = password.contains(RegExp(r'[0-9]'));
      _hasUpperCase = password.contains(RegExp(r'[A-Z]'));
    });

    // Also check if passwords match
    _checkPasswordMatch();
  }

  void _checkPasswordMatch() {
    final password = _passwordController.text;
    final confirmPassword = _confirmPasswordController.text;

    setState(() {
      _passwordsMatch = password.isNotEmpty && password == confirmPassword;
    });
  }

  Future<void> _register() async {
    setState(() {
      _errors = [];
    });

    if (_formKey.currentState!.validate()) {
      setState(() {
        _isLoading = true;
      });

      try {
        final result = await _apiService.register(
          _usernameController.text.trim(),
          _emailController.text.trim(),
          _passwordController.text,
          _confirmPasswordController.text,
        );

        if (result['success'] == true) {
          // Registration successful, navigate to login
          if (mounted) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(
                content: Text('Registrasi berhasil! Silakan login.'),
                backgroundColor: Colors.green,
              ),
            );
            Navigator.pushReplacementNamed(context, '/login');
          }
        } else {
          // Registration failed, display errors
          setState(() {
            if (result['errors'] != null) {
              _errors = List<String>.from(
                result['errors'].values.expand((e) => e),
              );
            } else {
              _errors = [result['message'] ?? 'Registrasi gagal'];
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

  double get _passwordStrength {
    int strength = 0;
    if (_hasMinLength) strength += 33;
    if (_hasNumber) strength += 33;
    if (_hasUpperCase) strength += 34;
    return strength.toDouble();
  }

  Color get _passwordStrengthColor {
    if (_passwordStrength < 40) return const Color(0xFFDC2626);
    if (_passwordStrength < 80) return const Color(0xFFD4AF37);
    return const Color(0xFF059669);
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
            'Silahkan buat akun',
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
              hintText: 'Masukan username',
              validator: (value) {
                if (value == null || value.trim().isEmpty) {
                  return 'Silakan masukkan username Anda';
                }
                return null;
              },
            ),

            const SizedBox(height: 24),

            // Email field
            _buildFormField(
              label: 'Email',
              icon: FontAwesomeIcons.envelope,
              controller: _emailController,
              hintText: 'Masukan email',
              validator: (value) {
                if (value == null || value.trim().isEmpty) {
                  return 'Silakan masukkan email Anda';
                }
                if (!value.contains('@')) {
                  return 'Silakan masukkan email yang valid';
                }
                return null;
              },
            ),

            const SizedBox(height: 24),

            // Password field
            _buildPasswordField(),

            const SizedBox(height: 24),

            // Confirm password field
            _buildConfirmPasswordField(),

            const SizedBox(height: 32),

            // Register button
            SizedBox(
              width: double.infinity,
              height: 50,
              child: ElevatedButton(
                onPressed: _isLoading ? null : _register,
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
                          Text('Membuat Akun...'),
                        ],
                      )
                    : const Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(FontAwesomeIcons.userPlus, size: 16),
                          SizedBox(width: 8),
                          Text(
                            'Buat akun',
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
                    'Sudah punya akun? ',
                    style: TextStyle(color: Color(0xFF6B7280), fontSize: 14),
                  ),
                  GestureDetector(
                    onTap: () {
                      Navigator.pushReplacementNamed(context, '/login');
                    },
                    child: const Text(
                      'Masuk',
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
    String? Function(String?)? validator,
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
          validator: validator,
          decoration: InputDecoration(
            hintText: hintText,
            hintStyle: const TextStyle(color: Color(0xFF9CA3AF)),
            prefixIcon: Icon(icon, color: const Color(0xFF9CA3AF), size: 15),
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

  Widget _buildPasswordField() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          children: [
            const Icon(
              FontAwesomeIcons.lock,
              size: 13,
              color: Color(0xFF5D4E37),
            ),
            const SizedBox(width: 6),
            const Text(
              'Password',
              style: TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.w500,
                color: Color(0xFF6B7280),
              ),
            ),
          ],
        ),
        const SizedBox(height: 8),
        TextFormField(
          controller: _passwordController,
          obscureText: _obscurePassword,
          validator: (value) {
            if (value == null || value.trim().isEmpty) {
              return 'Silakan masukkan password Anda';
            }
            if (value.length < 8) {
              return 'Password minimal 8 karakter';
            }
            if (!value.contains(RegExp(r'[0-9]'))) {
              return 'Password harus mengandung angka';
            }
            if (!value.contains(RegExp(r'[A-Z]'))) {
              return 'Password harus mengandung huruf besar';
            }
            return null;
          },
          decoration: InputDecoration(
            hintText: 'Masukan password',
            hintStyle: const TextStyle(color: Color(0xFF9CA3AF)),
            prefixIcon: const Icon(
              FontAwesomeIcons.lock,
              color: Color(0xFF9CA3AF),
              size: 15,
            ),
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

        // Password strength indicator
        Container(
          height: 5,
          margin: const EdgeInsets.only(top: 8),
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(5),
            color: const Color(0xFFE5E7EB),
          ),
          child: FractionallySizedBox(
            alignment: Alignment.centerLeft,
            widthFactor: _passwordStrength / 100,
            child: Container(
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(5),
                color: _passwordStrengthColor,
              ),
            ),
          ),
        ),

        // Password requirements
        Container(
          margin: const EdgeInsets.only(top: 8),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildRequirement('Minimal 8 karakter', _hasMinLength),
              _buildRequirement('Sertakan nomor', _hasNumber),
              _buildRequirement('Sertakan Huruf besar', _hasUpperCase),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildConfirmPasswordField() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          children: [
            const Icon(
              FontAwesomeIcons.lock,
              size: 13,
              color: Color(0xFF5D4E37),
            ),
            const SizedBox(width: 6),
            const Text(
              'Confirm Password',
              style: TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.w500,
                color: Color(0xFF6B7280),
              ),
            ),
          ],
        ),
        const SizedBox(height: 8),
        TextFormField(
          controller: _confirmPasswordController,
          obscureText: _obscureConfirmPassword,
          validator: (value) {
            if (value == null || value.trim().isEmpty) {
              return 'Silakan konfirmasi password Anda';
            }
            if (value != _passwordController.text) {
              return 'Password tidak sama';
            }
            return null;
          },
          decoration: InputDecoration(
            hintText: 'Konfirmasi password',
            hintStyle: const TextStyle(color: Color(0xFF9CA3AF)),
            prefixIcon: const Icon(
              FontAwesomeIcons.lock,
              color: Color(0xFF9CA3AF),
              size: 15,
            ),
            suffixIcon: IconButton(
              icon: Icon(
                _obscureConfirmPassword
                    ? FontAwesomeIcons.eye
                    : FontAwesomeIcons.eyeSlash,
                color: const Color(0xFF9CA3AF),
                size: 16,
              ),
              onPressed: _toggleConfirmPasswordVisibility,
            ),
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

        // Password match requirement
        Container(
          margin: const EdgeInsets.only(top: 8),
          child: _buildRequirement('Passwords match', _passwordsMatch),
        ),
      ],
    );
  }

  Widget _buildRequirement(String text, bool isMet) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 4),
      child: Row(
        children: [
          Icon(
            isMet ? FontAwesomeIcons.checkCircle : FontAwesomeIcons.timesCircle,
            size: 12,
            color: isMet ? const Color(0xFF059669) : const Color(0xFFDC2626),
          ),
          const SizedBox(width: 6),
          Text(
            text,
            style: TextStyle(fontSize: 12, color: const Color(0xFF6B7280)),
          ),
        ],
      ),
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
