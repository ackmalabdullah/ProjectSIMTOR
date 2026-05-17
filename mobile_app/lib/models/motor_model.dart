class MotorModel {
  final String id;
  final String name;
  final String merk;
  final String tipe;
  final double harga;
  final String imageUrl;
  final String deskripsi;
  final String status;

  MotorModel({
    required this.id,
    required this.name,
    required this.merk,
    required this.tipe,
    required this.harga,
    required this.imageUrl,
    required this.deskripsi,
    required this.status,
  });

  factory MotorModel.fromJson(Map<String, dynamic> json) {
    return MotorModel(
      id: json['_id'] ?? json['id'],
      name: json['nama_motor'] ?? '',
      merk: json['merk'] ?? '',
      tipe: json['tipe'] ?? '',
      harga: (json['harga'] as num).toDouble(),
      imageUrl: json['gambar'] ?? '',
      deskripsi: json['deskripsi'] ?? '',
      status: json['status'] ?? '',
    );
  }

  String get hargaFormatted {
    final jutaan = harga / 1000000;
    return 'Rp ${jutaan.toStringAsFixed(1)} Jt';
  }

  String get hargaLengkap {
    final formatted = harga.toStringAsFixed(0).replaceAllMapped(
      RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
      (m) => '${m[1]}.',
    );
    return 'Rp $formatted';
  }
}

// class HasilSimulasi {
//   final String motorName;
//   final double hargaMotor;
//   final double dpPersen;
//   final int tenorRekomendasi;
//   final double cicilanPerBulan;
//   final double rasioGaji;
//   final String alasanRekomendasi;
//   final DateTime tanggal;

//   HasilSimulasi({
//     required this.motorName,
//     required this.hargaMotor,
//     required this.dpPersen,
//     required this.tenorRekomendasi,
//     required this.cicilanPerBulan,
//     required this.rasioGaji,
//     required this.alasanRekomendasi,
//     required this.tanggal,
//   });

//   double get totalHarga => hargaMotor * 1.04;
//   double get dpDibayar => hargaMotor * dpPersen;
//   double get sisaKredit => totalHarga - dpDibayar;
// }