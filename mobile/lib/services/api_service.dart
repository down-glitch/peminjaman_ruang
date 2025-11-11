import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';

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
    final response = await dio.post(
      '/login',
      data: {'username': username, 'password': password},
    );

    if (response.data['success'] == true) {
      await _saveToken(response.data['token']);
    }

    return response.data;
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
