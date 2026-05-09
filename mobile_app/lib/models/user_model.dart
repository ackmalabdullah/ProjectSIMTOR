class UserModel {
  final String id;
  final String nama;
  final String username;
  final String email;
  final String? noTelp;
  final String? alamat;
  final String? pekerjaan;
  final int? gajiPerBulan;
  final String? status;
  final String? role;
  final String? provider;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  UserModel({
    required this.id,
    required this.nama,
    required this.username,
    required this.email,
    this.noTelp,
    this.alamat,
    this.pekerjaan,
    this.gajiPerBulan,
    this.status,
    this.role,
    this.provider,
    this.createdAt,
    this.updatedAt,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      id: json['_id'] ?? json['id'] ?? '',
      nama: json['nama'] ?? '',
      username: json['username'] ?? '',
      email: json['email'] ?? '',
      noTelp: json['no_telp'],
      alamat: json['alamat'],
      pekerjaan: json['pekerjaan'],
      gajiPerBulan: json['gaji_per_bulan'] is int 
          ? json['gaji_per_bulan'] 
          : int.tryParse(json['gaji_per_bulan']?.toString() ?? '0'),
      status: json['status'],
      role: json['role'],
      provider: json['provider'],
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at'].toString())
          : null,
      updatedAt: json['updated_at'] != null 
          ? DateTime.parse(json['updated_at'].toString())
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      '_id': id,
      'nama': nama,
      'username': username,
      'email': email,
      'no_telp': noTelp,
      'alamat': alamat,
      'pekerjaan': pekerjaan,
      'gaji_per_bulan': gajiPerBulan,
      'status': status,
      'role': role,
      'provider': provider,
      'created_at': createdAt?.toIso8601String(),
      'updated_at': updatedAt?.toIso8601String(),
    };
  }

  // Copy method untuk update data
  UserModel copyWith({
    String? id,
    String? nama,
    String? username,
    String? email,
    String? noTelp,
    String? alamat,
    String? pekerjaan,
    int? gajiPerBulan,
    String? status,
    String? role,
    String? provider,
    DateTime? createdAt,
    DateTime? updatedAt,
  }) {
    return UserModel(
      id: id ?? this.id,
      nama: nama ?? this.nama,
      username: username ?? this.username,
      email: email ?? this.email,
      noTelp: noTelp ?? this.noTelp,
      alamat: alamat ?? this.alamat,
      pekerjaan: pekerjaan ?? this.pekerjaan,
      gajiPerBulan: gajiPerBulan ?? this.gajiPerBulan,
      status: status ?? this.status,
      role: role ?? this.role,
      provider: provider ?? this.provider,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
    );
  }
}