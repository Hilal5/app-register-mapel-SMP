<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@smp.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'gender' => 'L',
        ]);

        // Siswa Kelas 7A
        // $students7A = [
        //     ['nis' => '2024070001', 'name' => 'Ahmad Rizki', 'email' => 'ahmad.rizki@student.smp.sch.id', 'class_id' => 1, 'gender' => 'L', 'birth_date' => '2011-01-15'],
        //     ['nis' => '2024070002', 'name' => 'Siti Nurhaliza', 'email' => 'siti.nur@student.smp.sch.id', 'class_id' => 1, 'gender' => 'P', 'birth_date' => '2011-02-20'],
        //     ['nis' => '2024070003', 'name' => 'Budi Santoso', 'email' => 'budi.santoso@student.smp.sch.id', 'class_id' => 1, 'gender' => 'L', 'birth_date' => '2011-03-10'],
        //     ['nis' => '2024070004', 'name' => 'Dewi Lestari', 'email' => 'dewi.lestari@student.smp.sch.id', 'class_id' => 1, 'gender' => 'P', 'birth_date' => '2011-04-05'],
        //     ['nis' => '2024070005', 'name' => 'Eko Prasetyo', 'email' => 'eko.prasetyo@student.smp.sch.id', 'class_id' => 1, 'gender' => 'L', 'birth_date' => '2011-05-12'],
        // ];

        // Siswa Kelas 7B
        // $students7B = [
        //     ['nis' => '2024070011', 'name' => 'Fitri Handayani', 'email' => 'fitri.handayani@student.smp.sch.id', 'class_id' => 2, 'gender' => 'P', 'birth_date' => '2011-06-18'],
        //     ['nis' => '2024070012', 'name' => 'Galih Pratama', 'email' => 'galih.pratama@student.smp.sch.id', 'class_id' => 2, 'gender' => 'L', 'birth_date' => '2011-07-22'],
        //     ['nis' => '2024070013', 'name' => 'Hani Safitri', 'email' => 'hani.safitri@student.smp.sch.id', 'class_id' => 2, 'gender' => 'P', 'birth_date' => '2011-08-30'],
        //     ['nis' => '2024070014', 'name' => 'Irfan Maulana', 'email' => 'irfan.maulana@student.smp.sch.id', 'class_id' => 2, 'gender' => 'L', 'birth_date' => '2011-09-14'],
        //     ['nis' => '2024070015', 'name' => 'Jihan Kamila', 'email' => 'jihan.kamila@student.smp.sch.id', 'class_id' => 2, 'gender' => 'P', 'birth_date' => '2011-10-08'],
        // ];

        // Siswa Kelas 8A
        // $students8A = [
        //     ['nis' => '2023080001', 'name' => 'Kartika Sari', 'email' => 'kartika.sari@student.smp.sch.id', 'class_id' => 3, 'gender' => 'P', 'birth_date' => '2010-01-20'],
        //     ['nis' => '2023080002', 'name' => 'Lukman Hakim', 'email' => 'lukman.hakim@student.smp.sch.id', 'class_id' => 3, 'gender' => 'L', 'birth_date' => '2010-02-15'],
        //     ['nis' => '2023080003', 'name' => 'Maya Anggraini', 'email' => 'maya.anggraini@student.smp.sch.id', 'class_id' => 3, 'gender' => 'P', 'birth_date' => '2010-03-25'],
        //     ['nis' => '2023080004', 'name' => 'Nanda Pratama', 'email' => 'nanda.pratama@student.smp.sch.id', 'class_id' => 3, 'gender' => 'L', 'birth_date' => '2010-04-18'],
        //     ['nis' => '2023080005', 'name' => 'Olivia Putri', 'email' => 'olivia.putri@student.smp.sch.id', 'class_id' => 3, 'gender' => 'P', 'birth_date' => '2010-05-22'],
        // ];

        // Siswa Kelas 8B
        // $students8B = [
        //     ['nis' => '2023080011', 'name' => 'Putra Wijaya', 'email' => 'putra.wijaya@student.smp.sch.id', 'class_id' => 4, 'gender' => 'L', 'birth_date' => '2010-06-12'],
        //     ['nis' => '2023080012', 'name' => 'Qori Azzahra', 'email' => 'qori.azzahra@student.smp.sch.id', 'class_id' => 4, 'gender' => 'P', 'birth_date' => '2010-07-08'],
        //     ['nis' => '2023080013', 'name' => 'Rafi Ahmad', 'email' => 'rafi.ahmad@student.smp.sch.id', 'class_id' => 4, 'gender' => 'L', 'birth_date' => '2010-08-16'],
        //     ['nis' => '2023080014', 'name' => 'Salma Nurhaliza', 'email' => 'salma.nurhaliza@student.smp.sch.id', 'class_id' => 4, 'gender' => 'P', 'birth_date' => '2010-09-20'],
        //     ['nis' => '2023080015', 'name' => 'Teguh Santoso', 'email' => 'teguh.santoso@student.smp.sch.id', 'class_id' => 4, 'gender' => 'L', 'birth_date' => '2010-10-25'],
        // ];

        // Siswa Kelas 9A
        // $students9A = [
        //     ['nis' => '2022090001', 'name' => 'Umi Kalsum', 'email' => 'umi.kalsum@student.smp.sch.id', 'class_id' => 5, 'gender' => 'P', 'birth_date' => '2009-01-10'],
        //     ['nis' => '2022090002', 'name' => 'Vino Bastian', 'email' => 'vino.bastian@student.smp.sch.id', 'class_id' => 5, 'gender' => 'L', 'birth_date' => '2009-02-14'],
        //     ['nis' => '2022090003', 'name' => 'Wulan Guritno', 'email' => 'wulan.guritno@student.smp.sch.id', 'class_id' => 5, 'gender' => 'P', 'birth_date' => '2009-03-20'],
        //     ['nis' => '2022090004', 'name' => 'Xavier Nugraha', 'email' => 'xavier.nugraha@student.smp.sch.id', 'class_id' => 5, 'gender' => 'L', 'birth_date' => '2009-04-15'],
        //     ['nis' => '2022090005', 'name' => 'Yuni Shara', 'email' => 'yuni.shara@student.smp.sch.id', 'class_id' => 5, 'gender' => 'P', 'birth_date' => '2009-05-18'],
        // ];

        // Siswa Kelas 9B
        // $students9B = [
        //     ['nis' => '2022090011', 'name' => 'Zaki Firmansyah', 'email' => 'zaki.firmansyah@student.smp.sch.id', 'class_id' => 6, 'gender' => 'L', 'birth_date' => '2009-06-22'],
        //     ['nis' => '2022090012', 'name' => 'Aisha Rahman', 'email' => 'aisha.rahman@student.smp.sch.id', 'class_id' => 6, 'gender' => 'P', 'birth_date' => '2009-07-28'],
        //     ['nis' => '2022090013', 'name' => 'Bagas Pratama', 'email' => 'bagas.pratama@student.smp.sch.id', 'class_id' => 6, 'gender' => 'L', 'birth_date' => '2009-08-12'],
        //     ['nis' => '2022090014', 'name' => 'Citra Dewi', 'email' => 'citra.dewi@student.smp.sch.id', 'class_id' => 6, 'gender' => 'P', 'birth_date' => '2009-09-05'],
        //     ['nis' => '2022090015', 'name' => 'Danu Wijaya', 'email' => 'danu.wijaya@student.smp.sch.id', 'class_id' => 6, 'gender' => 'L', 'birth_date' => '2009-10-11'],
        // ];

        // $allStudents = array_merge($students7A, $students7B, $students8A, $students8B, $students9A, $students9B);

        // foreach ($allStudents as $student) {
        //     User::create([
        //         'nis' => $student['nis'],
        //         'name' => $student['name'],
        //         'email' => $student['email'],
        //         'password' => Hash::make('password'), // Default password: password
        //         'role' => 'student',
        //         'class_id' => $student['class_id'],
        //         'gender' => $student['gender'],
        //         'birth_date' => $student['birth_date'],
        //         'phone' => '0812' . rand(10000000, 99999999),
        //         'address' => 'Medan, Sumatera Utara',
        //     ]);
        // }
    }
}