import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Honda Credit App',
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
  final TextEditingController nama = TextEditingController();
  final TextEditingController umur = TextEditingController();
  final TextEditingController gaji = TextEditingController();
  final TextEditingController hargaMotor = TextEditingController();
  final TextEditingController dp = TextEditingController();
  final TextEditingController tanggungan = TextEditingController();

  String pekerjaan = "Karyawan";
  String hasil = "";

  void hitungDummy() {
    setState(() {
      hasil = "Tenor disarankan: 3 Tahun\nCicilan: Rp 1.200.000 / bulan";
    });
  }

  Widget inputField(String label, TextEditingController controller) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: TextField(
        controller: controller,
        keyboardType: TextInputType.number,
        decoration: InputDecoration(
          labelText: label,
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(10),
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Hanya Coba"),
        centerTitle: true,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            // FORM CARD
            Card(
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(15),
              ),
              elevation: 4,
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Column(
                  children: [
                    inputField("Nama", nama),
                    inputField("Umur", umur),
                    inputField("Gaji / bulan", gaji),
                    inputField("Harga Motor", hargaMotor),
                    inputField("DP", dp),
                    inputField("Jumlah Tanggungan", tanggungan),

                    const SizedBox(height: 10),

                    // DROPDOWN
                    DropdownButtonFormField(
                      value: pekerjaan,
                      items: const [
                        DropdownMenuItem(
                            value: "Karyawan", child: Text("Karyawan")),
                        DropdownMenuItem(
                            value: "Wiraswasta", child: Text("Wiraswasta")),
                        DropdownMenuItem(
                            value: "Mahasiswa", child: Text("Mahasiswa")),
                      ],
                      onChanged: (value) {
                        setState(() {
                          pekerjaan = value.toString();
                        });
                      },
                      decoration: InputDecoration(
                        labelText: "Pekerjaan",
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(10),
                        ),
                      ),
                    ),

                    const SizedBox(height: 20),

                    // BUTTON
                    SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        onPressed: hitungDummy,
                        style: ElevatedButton.styleFrom(
                          padding: const EdgeInsets.symmetric(vertical: 14),
                        ),
                        child: const Text(
                          "Hitung Tenor",
                          style: TextStyle(fontSize: 16),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),

            const SizedBox(height: 20),

            // HASIL
            if (hasil.isNotEmpty)
              Card(
                color: Colors.red.shade50,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(15),
                ),
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Column(
                    children: [
                      const Text(
                        "Hasil Prediksi",
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const SizedBox(height: 10),
                      Text(
                        hasil,
                        textAlign: TextAlign.center,
                        style: const TextStyle(fontSize: 16),
                      ),
                    ],
                  ),
                ),
              )
          ],
        ),
      ),
    );
  }
}
