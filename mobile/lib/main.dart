import 'package:flutter/material.dart';
import 'login_page.dart';
import 'register_page.dart';
import 'dashboard_page.dart';


void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Modern App',
      theme: ThemeData(primarySwatch: Colors.brown),
      // halaman pertama
      initialRoute: '/login',
      routes: {
        '/login': (context) => const LoginPage(),
        '/register': (context) => const RegisterPage(),
        '/dashboard': (context) => const DashboardPage(),

      },
    );
  }
}
