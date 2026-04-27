import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Motor API App',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: Colors.red,
      ),
      home: const HomePage(),
    );
  }
}

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  List dataMotor = [];
  bool isLoading = true;

  // 🔥 FUNCTION AMBIL API
  Future<void> getMotor() async {
    final url = Uri.parse("http://127.0.0.1:8000/api/motor");

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);

        setState(() {
          dataMotor = data['data'];
          isLoading = false;
        });
      } else {
        setState(() {
          isLoading = false;
        });
      }
    } catch (e) {
      setState(() {
        isLoading = false;
      });
    }
  }

  // 🔥 AUTO LOAD SAAT HALAMAN DIBUKA
  @override
  void initState() {
    super.initState();
    getMotor();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Data Motor (API Laravel)"),
        centerTitle: true,
      ),

      // 🔥 BODY
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : dataMotor.isEmpty
              ? const Center(child: Text("Data tidak ada"))
              : ListView.builder(
                  itemCount: dataMotor.length,
                  itemBuilder: (context, index) {
                    final motor = dataMotor[index];

                    return Card(
                      margin: const EdgeInsets.symmetric(
                          horizontal: 12, vertical: 6),
                      elevation: 3,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: ListTile(
                        leading:
                            const Icon(Icons.motorcycle, color: Colors.red),
                        title: Text(
                          motor['nama_motor'] ?? '-',
                          style: const TextStyle(fontWeight: FontWeight.bold),
                        ),
                        subtitle: Text(
                          "Harga: Rp ${motor['harga']}",
                        ),
                      ),
                    );
                  },
                ),
    );
  }
}
