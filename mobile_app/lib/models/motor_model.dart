class MotorModel {
  final String id;
  final String name;
  final String category;
  final double harga;
  final String imageUrl;

  final String mesin;
  final String transmisi;
  final double berat;
  final String tangki;
  final String konsumsibbm;

  final String merk;
  final String tipe;
  final String deskripsi;
  final String status;

  MotorModel({
    required this.id,
    required this.name,
    required this.category,
    required this.harga,
    required this.imageUrl,
    required this.mesin,
    required this.transmisi,
    required this.berat,
    required this.tangki,
    required this.konsumsibbm,
    required this.merk,
    required this.tipe,
    required this.deskripsi,
    required this.status,
  });

  factory MotorModel.fromJson(Map<String, dynamic> json) {
    return MotorModel(
      id: json['_id'] ?? '',
      name: json['nama_motor'] ?? '',
      category: json['tipe'] ?? '',
      harga: (json['harga'] ?? 0).toDouble(),
      imageUrl: json['gambar'] ?? '',

      // sementara default dulu
      mesin: json['mesin'] ?? '-',
      transmisi: json['transmisi'] ?? '-',
      berat: (json['berat'] ?? 0).toDouble(),
      tangki: json['tangki'] ?? '-',
      konsumsibbm: json['konsumsibbm'] ?? '-',

      merk: json['merk'] ?? '',
      tipe: json['tipe'] ?? '',
      deskripsi: json['deskripsi'] ?? '',
      status: json['status'] ?? '',
    );
  }

  String get hargaFormatted {
    final jutaan = harga / 1000000;

    if (jutaan == jutaan.truncate()) {
      return 'Rp ${jutaan.truncate()} Jt';
    }

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

class HasilSimulasi {
  final String motorName;
  final double hargaMotor;
  final double dpPersen;
  final int tenorRekomendasi;
  final double cicilanPerBulan;
  final double rasioGaji;
  final String alasanRekomendasi;
  final DateTime tanggal;

  HasilSimulasi({
    required this.motorName,
    required this.hargaMotor,
    required this.dpPersen,
    required this.tenorRekomendasi,
    required this.cicilanPerBulan,
    required this.rasioGaji,
    required this.alasanRekomendasi,
    required this.tanggal,
  });

  double get totalHarga => hargaMotor * 1.04;
  double get dpDibayar => hargaMotor * dpPersen;
  double get sisaKredit => totalHarga - dpDibayar;
}