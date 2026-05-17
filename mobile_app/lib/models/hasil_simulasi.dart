class HasilSimulasi {
  final String motorId;

  final String motorName;

  final double hargaMotor;

  final double penghasilan;

  final double dpPersen;

  final double dpNominal;

  final int tenorRekomendasi;

  final double cicilanPerBulan;

  final double rasioGaji;

  final String alasanRekomendasi;

  final DateTime tanggal;

  final String statusKelayakan;

  final String imageUrl;

  HasilSimulasi({
    required this.motorId,
    required this.motorName,
    required this.hargaMotor,
    required this.penghasilan,
    required this.dpPersen,
    required this.dpNominal,
    required this.tenorRekomendasi,
    required this.cicilanPerBulan,
    required this.rasioGaji,
    required this.alasanRekomendasi,
    required this.tanggal,
    required this.statusKelayakan,
    required this.imageUrl,
  });

  double get totalHarga => hargaMotor;

  double get dpDibayar => dpNominal;

  double get sisaKredit => hargaMotor - dpNominal;
}