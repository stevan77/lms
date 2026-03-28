<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseGrade;
use App\Models\Grade;
use App\Models\Lesson;
use App\Models\School;
use App\Models\StudentProgress;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'locale' => 'en',
        ]);

        // School 1
        $school1 = School::create([
            'name' => 'Osnovna Škola "Nikola Tesla"',
            'address' => 'Bulevar Oslobođenja 15, Novi Sad',
            'phone' => '+381 21 123 456',
            'email' => 'info@skolatesla.rs',
        ]);

        // Admin for school 1
        $admin1 = User::create([
            'name' => 'Marko Petrović',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'school_id' => $school1->id,
            'locale' => 'sr',
        ]);

        // Teachers for school 1
        $teacher1 = User::create([
            'name' => 'Ana Jovanović',
            'email' => 'teacher@lms.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'school_id' => $school1->id,
            'locale' => 'sr',
        ]);

        $teacher2 = User::create([
            'name' => 'Dragan Milić',
            'email' => 'dragan@lms.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'school_id' => $school1->id,
            'locale' => 'sr',
        ]);

        // Grades for school 1
        $grade81 = Grade::create(['school_id' => $school1->id, 'name' => '8-1', 'level' => 8, 'section' => '1']);
        $grade82 = Grade::create(['school_id' => $school1->id, 'name' => '8-2', 'level' => 8, 'section' => '2']);
        $grade71 = Grade::create(['school_id' => $school1->id, 'name' => '7-1', 'level' => 7, 'section' => '1']);

        // Courses for school 1
        $math = Course::create(['school_id' => $school1->id, 'name' => 'Matematika', 'description' => 'Osnovi matematike za osnovnu školu']);
        $physics = Course::create(['school_id' => $school1->id, 'name' => 'Fizika', 'description' => 'Osnovi fizike']);
        $serbian = Course::create(['school_id' => $school1->id, 'name' => 'Srpski jezik', 'description' => 'Srpski jezik i književnost']);

        // Course-Grade assignments
        $cg1 = CourseGrade::create(['course_id' => $math->id, 'grade_id' => $grade81->id, 'teacher_id' => $teacher1->id]);
        $cg2 = CourseGrade::create(['course_id' => $math->id, 'grade_id' => $grade82->id, 'teacher_id' => $teacher1->id]);
        $cg3 = CourseGrade::create(['course_id' => $physics->id, 'grade_id' => $grade81->id, 'teacher_id' => $teacher2->id]);
        $cg4 = CourseGrade::create(['course_id' => $serbian->id, 'grade_id' => $grade71->id, 'teacher_id' => $teacher2->id]);

        // Lessons for Math
        $lesson1 = Lesson::create(['course_id' => $math->id, 'title' => 'Uvod u algebru', 'content' => '<p>Algebra je grana matematike koja se bavi proučavanjem matematičkih simbola i pravila za manipulaciju tim simbolima.</p><p>U ovoj lekciji ćemo naučiti osnove algebarskih izraza, promenljivih i jednačina.</p>', 'order' => 1]);
        $lesson2 = Lesson::create(['course_id' => $math->id, 'title' => 'Linearne jednačine', 'content' => '<p>Linearna jednačina je jednačina u kojoj je najviši stepen nepoznate 1.</p><p>Opšti oblik: ax + b = 0, gde su a i b konstante.</p>', 'order' => 2]);
        $lesson3 = Lesson::create(['course_id' => $math->id, 'title' => 'Sistemi jednačina', 'content' => '<p>Sistem linearnih jednačina sa dve nepoznate sastoji se od dve jednačine sa dve promenljive.</p><p>Metode rešavanja: metoda zamene i metoda suprotnih koeficijenata.</p>', 'order' => 3]);
        $lesson4 = Lesson::create(['course_id' => $math->id, 'title' => 'Kvadratna funkcija', 'content' => '<p>Kvadratna funkcija je funkcija oblika f(x) = ax² + bx + c.</p><p>Grafik kvadratne funkcije je parabola.</p>', 'order' => 4]);

        // Lessons for Physics
        Lesson::create(['course_id' => $physics->id, 'title' => 'Njutnovi zakoni', 'content' => '<p>Tri Njutnova zakona kretanja čine osnovu klasične mehanike.</p>', 'order' => 1]);
        Lesson::create(['course_id' => $physics->id, 'title' => 'Sila i kretanje', 'content' => '<p>Sila je fizička veličina koja izaziva promenu stanja kretanja tela.</p>', 'order' => 2]);
        Lesson::create(['course_id' => $physics->id, 'title' => 'Energija', 'content' => '<p>Energija je sposobnost tela ili sistema da izvrši rad.</p>', 'order' => 3]);

        // Lessons for Serbian
        Lesson::create(['course_id' => $serbian->id, 'title' => 'Narodna književnost', 'content' => '<p>Narodna književnost obuhvata usmeno stvaralaštvo srpskog naroda.</p>', 'order' => 1]);
        Lesson::create(['course_id' => $serbian->id, 'title' => 'Gramatika - Vrste reči', 'content' => '<p>U srpskom jeziku razlikujemo promenljive i nepromenljive vrste reči.</p>', 'order' => 2]);

        // Students for school 1
        $students = [];
        $studentNames = [
            ['Nikola Đorđević', 'nikola@lms.com'],
            ['Milica Stanković', 'milica@lms.com'],
            ['Stefan Ilić', 'stefan@lms.com'],
            ['Jovana Marković', 'jovana@lms.com'],
            ['Lazar Nikolić', 'lazar@lms.com'],
            ['Tamara Pavlović', 'tamara@lms.com'],
        ];

        foreach ($studentNames as $i => $data) {
            $student = User::create([
                'name' => $data[0],
                'email' => $data[1],
                'password' => Hash::make('password'),
                'role' => 'student',
                'school_id' => $school1->id,
                'locale' => 'sr',
            ]);
            $students[] = $student;
        }

        // First student email is easy to remember for testing
        // student@lms.com
        $students[0]->update(['email' => 'student@lms.com']);

        // Assign students to grades
        $students[0]->grades()->attach($grade81->id); // Nikola -> 8-1
        $students[1]->grades()->attach($grade81->id); // Milica -> 8-1
        $students[2]->grades()->attach($grade81->id); // Stefan -> 8-1
        $students[3]->grades()->attach($grade82->id); // Jovana -> 8-2
        $students[4]->grades()->attach($grade82->id); // Lazar -> 8-2
        $students[5]->grades()->attach($grade71->id); // Tamara -> 7-1

        // Some progress for students
        StudentProgress::create(['student_id' => $students[0]->id, 'lesson_id' => $lesson1->id, 'course_grade_id' => $cg1->id, 'status' => 'completed', 'completed_at' => now()]);
        StudentProgress::create(['student_id' => $students[0]->id, 'lesson_id' => $lesson2->id, 'course_grade_id' => $cg1->id, 'status' => 'completed', 'completed_at' => now()]);
        StudentProgress::create(['student_id' => $students[0]->id, 'lesson_id' => $lesson3->id, 'course_grade_id' => $cg1->id, 'status' => 'in_progress']);
        StudentProgress::create(['student_id' => $students[1]->id, 'lesson_id' => $lesson1->id, 'course_grade_id' => $cg1->id, 'status' => 'completed', 'completed_at' => now()]);

        // School 2
        $school2 = School::create([
            'name' => 'Școala Generală "Mihai Eminescu"',
            'address' => 'Strada Victoriei 42, Timișoara',
            'phone' => '+40 256 123 456',
            'email' => 'info@scoalaeminescu.ro',
        ]);

        User::create([
            'name' => 'Ion Popescu',
            'email' => 'admin2@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'school_id' => $school2->id,
            'locale' => 'ro',
        ]);
    }
}
