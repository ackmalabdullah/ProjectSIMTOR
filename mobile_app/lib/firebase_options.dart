import 'package:firebase_core/firebase_core.dart' show FirebaseOptions;
import 'package:flutter/foundation.dart'
    show defaultTargetPlatform, kIsWeb, TargetPlatform;

class DefaultFirebaseOptions {
  static FirebaseOptions get currentPlatform {
    if (kIsWeb) {
      return web;
    }
    switch (defaultTargetPlatform) {
      case TargetPlatform.android:
        return android;
      case TargetPlatform.iOS:
        return ios;
      case TargetPlatform.macOS:
        return macos;
      case TargetPlatform.windows:
      case TargetPlatform.linux:
        throw UnsupportedError(
          'DefaultFirebaseOptions are not supported for this platform.',
        );
    }
  }

  // Data dari google-services.json yang Anda berikan
  static const FirebaseOptions android = FirebaseOptions(
    apiKey: 'AIzaSyA7Q3rYWBcnpjfiBEvPic267MYE7BMCl1Y',
    appId: '1:971512712348:android:0fb35d0b488c0a0204f159',
    messagingSenderId: '971512712348',
    projectId: 'projectsimtor-25121',
    storageBucket: 'projectsimtor-25121.firebasestorage.app',
  );

  // Untuk iOS, sesuaikan nanti jika perlu
  static const FirebaseOptions ios = FirebaseOptions(
    apiKey: 'AIzaSyDummyKeyForIOS',
    appId: '1:971512712348:ios:someid',
    messagingSenderId: '971512712348',
    projectId: 'projectsimtor-25121',
    storageBucket: 'projectsimtor-25121.firebasestorage.app',
    iosBundleId: 'com.example.mobile_app',
  );

  static const FirebaseOptions macos = FirebaseOptions(
    apiKey: 'AIzaSyDummyKeyForMacOS',
    appId: '1:971512712348:ios:someid',
    messagingSenderId: '971512712348',
    projectId: 'projectsimtor-25121',
    storageBucket: 'projectsimtor-25121.firebasestorage.app',
    iosBundleId: 'com.example.mobile_app',
  );

  static const FirebaseOptions web = FirebaseOptions(
    apiKey: 'AIzaSyDummyKeyForWeb',
    appId: '1:971512712348:web:somewebid',
    messagingSenderId: '971512712348',
    projectId: 'projectsimtor-25121',
    authDomain: 'projectsimtor-25121.firebaseapp.com',
    storageBucket: 'projectsimtor-25121.firebasestorage.app',
  );
}
