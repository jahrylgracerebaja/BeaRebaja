<?php

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function studentAttributes(array $overrides = []): array
{
    return array_merge([
        'student_number' => 'STU-1001',
        'first_name' => 'Jordan',
        'last_name' => 'Lee',
        'email' => 'jordan@example.test',
        'course' => 'Computer Science',
    ], $overrides);
}

test('the home page shows an empty state and student records', function () {
    $response = $this->get('/');

    $response->assertOk()->assertSee('No student records yet');

    Student::create(studentAttributes());

    $this->get('/')
        ->assertOk()
        ->assertSee('STU-1001')
        ->assertSee('Jordan Lee')
        ->assertSee('jordan@example.test')
        ->assertSee('Computer Science');
});

test('student details are escaped in the records table', function () {
    Student::create(studentAttributes(['first_name' => '<script>alert(1)</script>']));

    $this->get('/')
        ->assertOk()
        ->assertSee('<script>alert(1)</script>')
        ->assertDontSee('<script>alert(1)</script>', escape: false);
});

test('a valid student can be created', function () {
    $response = $this->post('/students', studentAttributes());

    $response->assertRedirect(route('students.index'))
        ->assertSessionHas('success', 'Student created successfully.');
    $this->assertDatabaseHas('students', studentAttributes());
});

test('required student fields are validated', function () {
    $response = $this->from('/')->post('/students', []);

    $response->assertRedirect('/')
        ->assertSessionHasErrors(['student_number', 'first_name', 'last_name', 'email', 'course']);
    $this->assertDatabaseCount('students', 0);
});

test('student number must be unique', function () {
    Student::create(studentAttributes());

    $response = $this->from('/')->post('/students', studentAttributes([
        'email' => 'another@example.test',
    ]));

    $response->assertRedirect('/')
        ->assertSessionHasErrors('student_number');
    $this->assertDatabaseCount('students', 1);
});

test('email must be valid and unique', function () {
    Student::create(studentAttributes());

    $duplicateEmailResponse = $this->from('/')->post('/students', studentAttributes([
        'student_number' => 'STU-1002',
    ]));

    $duplicateEmailResponse->assertRedirect('/')
        ->assertSessionHasErrors('email');

    $invalidEmailResponse = $this->from('/')->post('/students', studentAttributes([
        'student_number' => 'STU-1003',
        'email' => 'not-an-email',
    ]));

    $invalidEmailResponse->assertRedirect('/')
        ->assertSessionHasErrors('email');
    $this->assertDatabaseCount('students', 1);
});

test('a student can be edited without changing its own unique values', function () {
    $student = Student::create(studentAttributes());

    $this->get(route('students.edit', $student))
        ->assertRedirect(route('students.index', ['edit' => $student->id]));

    $this->get(route('students.index', ['edit' => $student->id]))
        ->assertOk()
        ->assertSee('Update Student')
        ->assertSee('Cancel Edit')
        ->assertSee('value="STU-1001"', escape: false)
        ->assertSee('value="jordan@example.test"', escape: false);

    $response = $this->put(route('students.update', $student), studentAttributes([
        'first_name' => 'Taylor',
        'course' => 'Information Systems',
    ]));

    $response->assertRedirect(route('students.index'))
        ->assertSessionHas('success', 'Student updated successfully.');
    $this->assertDatabaseHas('students', studentAttributes([
        'first_name' => 'Taylor',
        'course' => 'Information Systems',
    ]));
    $this->assertDatabaseCount('students', 1);
});

test('student number and email cannot be changed to values used by another student', function () {
    Student::create(studentAttributes());
    $student = Student::create(studentAttributes([
        'student_number' => 'STU-1002',
        'email' => 'another@example.test',
    ]));

    $response = $this->from(route('students.index', ['edit' => $student->id]))
        ->put(route('students.update', $student), studentAttributes([
            'student_number' => 'STU-1001',
            'email' => 'jordan@example.test',
        ]));

    $response->assertRedirect(route('students.index', ['edit' => $student->id]))
        ->assertSessionHasErrors(['student_number', 'email']);
    $this->assertDatabaseHas('students', [
        'id' => $student->id,
        'student_number' => 'STU-1002',
        'email' => 'another@example.test',
    ]);
});

test('a student can be deleted', function () {
    $student = Student::create(studentAttributes());

    $response = $this->delete(route('students.destroy', $student));

    $response->assertRedirect(route('students.index'))
        ->assertSessionHas('success', 'Student deleted successfully.');
    $this->assertDatabaseMissing('students', ['id' => $student->id]);
});

test('unknown student IDs return not found for edit update and delete', function () {
    $this->get('/students/999/edit')->assertNotFound();
    $this->put('/students/999', studentAttributes())->assertNotFound();
    $this->delete('/students/999')->assertNotFound();
});
