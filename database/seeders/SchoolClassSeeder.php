<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'VII 1', 'grade' => 7, 'room' => 'R-101', 'homeroom_teacher_id' => 1, 'capacity' => 30],
            ['name' => 'VII 2', 'grade' => 7, 'room' => 'R-102', 'homeroom_teacher_id' => 2, 'capacity' => 30],
            ['name' => 'VII 3', 'grade' => 7, 'room' => 'R-103', 'homeroom_teacher_id' => 3, 'capacity' => 30],
            ['name' => 'VII 4', 'grade' => 7, 'room' => 'R-104', 'homeroom_teacher_id' => 4, 'capacity' => 30],
            ['name' => 'VII 5', 'grade' => 7, 'room' => 'R-105', 'homeroom_teacher_id' => 5, 'capacity' => 30],
            ['name' => 'VII 6', 'grade' => 7, 'room' => 'R-106', 'homeroom_teacher_id' => 6, 'capacity' => 30],
            ['name' => 'VIII 1', 'grade' => 8, 'room' => 'R-201', 'homeroom_teacher_id' => 7, 'capacity' => 30],
            ['name' => 'VIII 2', 'grade' => 8, 'room' => 'R-202', 'homeroom_teacher_id' => 8, 'capacity' => 30],
            ['name' => 'VIII 3', 'grade' => 8, 'room' => 'R-203', 'homeroom_teacher_id' => 9, 'capacity' => 30],
            ['name' => 'VIII 4', 'grade' => 8, 'room' => 'R-204', 'homeroom_teacher_id' => 10, 'capacity' => 30],
            ['name' => 'VIII 5', 'grade' => 8, 'room' => 'R-205', 'homeroom_teacher_id' => 11, 'capacity' => 30],
            ['name' => 'VIII 6', 'grade' => 8, 'room' => 'R-206', 'homeroom_teacher_id' => 12, 'capacity' => 30],
            ['name' => 'IX 1', 'grade' => 9, 'room' => 'R-301', 'homeroom_teacher_id' => 13, 'capacity' => 30],
            ['name' => 'IX 2', 'grade' => 9, 'room' => 'R-302', 'homeroom_teacher_id' => 14, 'capacity' => 30],
            ['name' => 'IX 3', 'grade' => 9, 'room' => 'R-303', 'homeroom_teacher_id' => 15, 'capacity' => 30],
            ['name' => 'IX 4', 'grade' => 9, 'room' => 'R-304', 'homeroom_teacher_id' => 16, 'capacity' => 30],
            ['name' => 'IX 5', 'grade' => 9, 'room' => 'R-305', 'homeroom_teacher_id' => 17, 'capacity' => 30],
            ['name' => 'IX 6', 'grade' => 9, 'room' => 'R-306', 'homeroom_teacher_id' => 18, 'capacity' => 30],
        ];

        foreach ($classes as $class) {
            SchoolClass::create($class);
        }
    }
}