import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/user_model.dart';

class UserService {
  static const String baseUrl = "http://192.168.1.6:8080/api";

  /// Ambil data profile user dari backend (MongoDB)
  static Future<UserModel?> getProfile() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString("token");

      if (token == null) {
        print("Token tidak ditemukan");
        return null;
      }

      final response = await http.get(
        Uri.parse("$baseUrl/profile"),
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "Authorization": "Bearer $token",
        },
      );

      print("GET PROFILE STATUS: ${response.statusCode}");
      print("GET PROFILE BODY: ${response.body}");

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        if (data['status'] == true && data['user'] != null) {
          final user = UserModel.fromJson(data['user']);

          // Simpan user data yang terbaru ke SharedPreferences
          await prefs.setString("user", jsonEncode(data['user']));

          return user;
        }
      } else if (response.statusCode == 401) {
        print("Token expired atau tidak valid");
        // Clear token jika tidak valid
        await prefs.remove("token");
        await prefs.remove("user");
      }

      return null;
    } catch (e) {
      print("ERROR GET PROFILE: $e");
      return null;
    }
  }

  /// Ambil user data dari SharedPreferences (cache lokal)
  static Future<UserModel?> getCachedUser() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final userJson = prefs.getString("user");

      if (userJson != null) {
        final userData = jsonDecode(userJson);
        return UserModel.fromJson(userData);
      }
      return null;
    } catch (e) {
      print("ERROR GET CACHED USER: $e");
      return null;
    }
  }

  /// Logout user
  static Future<bool> logout() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString("token");

      // Kirim logout request ke backend
      if (token != null) {
        final response = await http.post(
          Uri.parse("$baseUrl/logout"),
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Bearer $token",
          },
        );

        print("LOGOUT STATUS: ${response.statusCode}");
        print("LOGOUT BODY: ${response.body}");
      }

      // Clear semua data lokal
      await prefs.clear();
      print("Logout berhasil - semua data dihapus");
      return true;
    } catch (e) {
      print("ERROR LOGOUT: $e");
      // Tetap hapus data lokal meski ada error
      final prefs = await SharedPreferences.getInstance();
      await prefs.clear();
      return true;
    }
  }

  /// Check apakah user sudah login
  static Future<bool> isLoggedIn() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString("token");
      return token != null;
    } catch (e) {
      return false;
    }
  }

  /// Update profile user di backend
  static Future<bool> updateProfile(UserModel user) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString("token");

      if (token == null) {
        print("Token tidak ditemukan");
        return false;
      }

      final response = await http.put(
        Uri.parse("$baseUrl/profile"),
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "Authorization": "Bearer $token",
        },
        body: jsonEncode({
          "nama": user.nama,
          "no_telp": user.noTelp,
          "alamat": user.alamat,
          "pekerjaan": user.pekerjaan,
          "gaji_per_bulan": user.gajiPerBulan,
        }),
      );

      print("UPDATE PROFILE STATUS: ${response.statusCode}");
      print("UPDATE PROFILE BODY: ${response.body}");

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        if (data['status'] == true && data['user'] != null) {
          // Simpan user data yang sudah diupdate
          await prefs.setString("user", jsonEncode(data['user']));
          return true;
        }
      }

      return false;
    } catch (e) {
      print("ERROR UPDATE PROFILE: $e");
      return false;
    }
  }
}
