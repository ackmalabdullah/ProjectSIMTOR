import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:google_sign_in/google_sign_in.dart';
import 'package:shared_preferences/shared_preferences.dart';

class AuthService {
  // ✅ GANTI KE IP LOKAL KAMU (SAMA DENGAN API MOTOR)
  static const String baseUrl = "http://192.168.0.11:8080/api";

  static final GoogleSignIn _googleSignIn = GoogleSignIn(
    scopes: ['email'],
  );

  // 🔥 REGISTER
  static Future<bool> register({
    required String nama,
    required String username,
    required String email,
    required String password,
  }) async {
    try {
      final response = await http.post(
        Uri.parse("$baseUrl/register"),
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "nama": nama,
          "username": username,
          "email": email,
          "password": password,
        }),
      );

      print("REGISTER STATUS: ${response.statusCode}");
      print("REGISTER BODY: ${response.body}");

      if (response.statusCode == 200 || response.statusCode == 201) {
        final data = jsonDecode(response.body);

        if (data['status'] == true) {
          final prefs = await SharedPreferences.getInstance();
          await prefs.setString("token", data['token']);
          await prefs.setString("user", jsonEncode(data['user']));
          return true;
        }
      }

      return false;
    } catch (e) {
      print("ERROR REGISTER: $e");
      return false;
    }
  }

  // 🔥 LOGIN EMAIL
  static Future<bool> loginWithEmail(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse("$baseUrl/login"),
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "email": email,
          "password": password,
        }),
      );

      print("LOGIN STATUS: ${response.statusCode}");
      print("LOGIN BODY: ${response.body}");

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        if (data['status'] == true) {
          final prefs = await SharedPreferences.getInstance();

          await prefs.setString("token", data['token']);
          await prefs.setString("user", jsonEncode(data['user']));

          return true;
        }
      }

      return false;
    } catch (e) {
      print("ERROR EMAIL LOGIN: $e");
      return false;
    }
  }

  // 🔥 LOGIN GOOGLE
  static Future<bool> loginWithGoogle() async {
    try {
      final account = await _googleSignIn.signIn();

      if (account == null) {
        print("User cancel login");
        return false;
      }

      final response = await http.post(
        Uri.parse("$baseUrl/social-login"),
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "nama": account.displayName ?? "User",
          "email": account.email,
          "firebase_uid": account.id,
        }),
      );

      print("GOOGLE LOGIN STATUS: ${response.statusCode}");
      print("GOOGLE LOGIN BODY: ${response.body}");

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        if (data['status'] == true) {
          final prefs = await SharedPreferences.getInstance();

          await prefs.setString("token", data['token']);
          await prefs.setString("user", jsonEncode(data['user']));

          return true;
        }
      }

      return false;
    } catch (e) {
      print("ERROR GOOGLE LOGIN: $e");
      return false;
    }
  }

  // 🔥 GET USER
  static Future<Map<String, dynamic>?> getUserData() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final userJson = prefs.getString("user");

      if (userJson != null) {
        return jsonDecode(userJson);
      }
      return null;
    } catch (e) {
      print("ERROR GET USER: $e");
      return null;
    }
  }

  // 🔥 GET TOKEN
  static Future<String?> getToken() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      return prefs.getString("token");
    } catch (e) {
      print("ERROR GET TOKEN: $e");
      return null;
    }
  }

  // 🔥 LOGOUT
  static Future<void> logout() async {
    try {
      await _googleSignIn.signOut();
      final prefs = await SharedPreferences.getInstance();
      await prefs.clear();
      print("Logout berhasil");
    } catch (e) {
      print("ERROR LOGOUT: $e");
    }
  }

  // 🔥 CEK LOGIN
  static Future<bool> isLoggedIn() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString("token");
      return token != null;
    } catch (e) {
      return false;
    }
  }
}