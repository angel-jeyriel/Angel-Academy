<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Test;
use App\Models\Question;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $staff = User::create([
        //     'name' => 'Staff User',
        //     'email' => 'staff@example.com',
        //     'password' => bcrypt('password'),
        //     'role' => 'staff',
        // ]);

        // $student = User::create([
        //     'name' => 'Student User',
        //     'email' => 'student@example.com',
        //     'password' => bcrypt('password'),
        //     'role' => 'student',
        // ]);

        // $course = Course::create(['name' => 'General Knowledge', 'description' => 'General Knowledge']);
        $subject = Subject::create(['course_id' => 7, 'name' => 'Electronics']);
        // $test = Test::create(['subject_id' => $subject->id, 'title' => 'Intro to Matter', 'duration' => 30]);
        // Question::create([
        //     'test_id' => $test->id,
        //     'text' => 'All these are states of matter except?',
        //     'option_a' => 'solid',
        //     'option_b' => 'gas',
        //     'option_c' => 'plasma',
        //     'option_d' => 'breeze',
        //     'correct_option' => 'd',
        // ]);
    }
}
