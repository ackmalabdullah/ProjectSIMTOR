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
  });

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

  static List<MotorModel> get sampleData => [
        MotorModel(
          id: '1',
          name: 'Beat Street',
          category: 'Matic',
          harga: 15500000,
          imageUrl: '',
          mesin: '108,2 cc',
          transmisi: 'Otomatis',
          berat: 93,
          tangki: '3,7 Liter',
          konsumsibbm: '60 km/l',
        ),
        MotorModel(
          id: '2',
          name: 'Vario 125',
          category: 'Matic',
          harga: 22000000,
          imageUrl: '',
          mesin: '124,9 cc',
          transmisi: 'Otomatis',
          berat: 110,
          tangki: '5,5 Liter',
          konsumsibbm: '52 km/l',
        ),
        MotorModel(
          id: '3',
          name: 'Beat Street',
          category: 'Sport',
          harga: 15500000,
          imageUrl: '',
          mesin: '108,2 cc',
          transmisi: 'Otomatis',
          berat: 93,
          tangki: '3,7 Liter',
          konsumsibbm: '60 km/l',
        ),
        MotorModel(
          id: '4',
          name: 'Beat Street',
          category: 'Adventure',
          harga: 15500000,
          imageUrl: '',
          mesin: '108,2 cc',
          transmisi: 'Otomatis',
          berat: 93,
          tangki: '3,7 Liter',
          konsumsibbm: '60 km/l',
        ),
      ];
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
