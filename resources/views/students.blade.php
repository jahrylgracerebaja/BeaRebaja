<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student Management</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <main class="mx-auto flex w-full max-w-7xl flex-col gap-8 px-4 py-8 sm:px-6 lg:px-8">
            <section aria-labelledby="profile-name" class="overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-950 via-slate-900 to-violet-950 px-6 py-8 text-white shadow-xl sm:px-10 sm:py-10">
                <div class="flex flex-col-reverse items-center gap-8 text-center sm:flex-row sm:justify-between sm:gap-10 sm:text-left">
                    <div class="flex max-w-2xl flex-col items-center gap-5 sm:items-start">
                        <div class="flex flex-col gap-2">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-200">Featured Work · Laravel CRUD Project</p>
                            <h1 id="profile-name" class="text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl">Jahrly Grace Y. Rebaja</h1>
                        </div>
                        <p class="max-w-xl text-base leading-7 text-slate-200 sm:text-lg">
                            The creator behind this Student Management application, built to make student records simple to manage.
                        </p>
                        <a href="#student-records" class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-indigo-950 transition hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-950">
                            Explore the project
                            <span aria-hidden="true">↓</span>
                        </a>
                    </div>
                    <img
                        src="{{ asset('images/jahrly-grace-rebaja.png') }}"
                        alt="Portrait of Jahrly Grace Y. Rebaja"
                        class="h-40 w-40 shrink-0 rounded-full border-4 border-white/90 object-cover shadow-2xl ring-4 ring-white/15 sm:h-48 sm:w-48"
                        width="192"
                        height="192"
                    >
                </div>
            </section>

            @if (session('success'))
                <div role="status" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                    Please correct the validation errors.
                </div>
            @endif

            <section aria-labelledby="student-form-heading" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-6 flex flex-col gap-1">
                    <h2 id="student-form-heading" class="text-xl font-semibold">
                        {{ $editingStudent ? 'Edit student' : 'Add a student' }}
                    </h2>
                    <p class="text-sm text-slate-500">Enter the student details below.</p>
                </div>

                <form
                    method="POST"
                    action="{{ $editingStudent ? route('students.update', $editingStudent) : route('students.store') }}"
                    class="flex flex-col gap-5"
                >
                    @csrf
                    @if ($editingStudent)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">
                        <div class="flex flex-col gap-2">
                            <label for="student_number" class="text-sm font-medium">Student Number</label>
                            <input id="student_number" name="student_number" type="text" value="{{ old('student_number', $editingStudent?->student_number) }}" required maxlength="255" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('student_number')
                                <p class="text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="first_name" class="text-sm font-medium">First Name</label>
                            <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $editingStudent?->first_name) }}" required maxlength="255" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('first_name')
                                <p class="text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="last_name" class="text-sm font-medium">Last Name</label>
                            <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $editingStudent?->last_name) }}" required maxlength="255" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('last_name')
                                <p class="text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="email" class="text-sm font-medium">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $editingStudent?->email) }}" required maxlength="255" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('email')
                                <p class="text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="course" class="text-sm font-medium">Course</label>
                            <input id="course" name="course" type="text" value="{{ old('course', $editingStudent?->course) }}" required maxlength="255" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('course')
                                <p class="text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{ $editingStudent ? 'Update Student' : 'Save Student' }}
                        </button>
                        @if ($editingStudent)
                            <a href="{{ route('students.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Cancel Edit
                            </a>
                        @endif
                    </div>
                </form>
            </section>

            <section id="student-records" aria-labelledby="student-list-heading" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-1 border-b border-slate-200 px-5 py-5 sm:px-7">
                    <h2 id="student-list-heading" class="text-xl font-semibold">Student Records</h2>
                    <p class="text-sm text-slate-500">{{ $students->count() }} {{ \Illuminate\Support\Str::plural('record', $students->count()) }}</p>
                </div>

                @if ($students->isEmpty())
                    <div class="px-5 py-12 text-center sm:px-7">
                        <p class="font-medium text-slate-700">No student records yet</p>
                        <p class="mt-1 text-sm text-slate-500">Add a student using the form above to get started.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th scope="col" class="px-5 py-3.5 sm:px-7">Student Number</th>
                                    <th scope="col" class="px-5 py-3.5">Full Name</th>
                                    <th scope="col" class="px-5 py-3.5">Email</th>
                                    <th scope="col" class="px-5 py-3.5">Course</th>
                                    <th scope="col" class="px-5 py-3.5 sm:px-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($students as $student)
                                    <tr class="align-top">
                                        <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-900 sm:px-7">{{ $student->student_number }}</td>
                                        <td class="whitespace-nowrap px-5 py-4">{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td class="whitespace-nowrap px-5 py-4">{{ $student->email }}</td>
                                        <td class="whitespace-nowrap px-5 py-4">{{ $student->course }}</td>
                                        <td class="px-5 py-4 sm:px-7">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('students.edit', $student) }}" class="font-semibold text-indigo-700 hover:text-indigo-900">Edit</a>
                                                <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this student?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-semibold text-rose-700 hover:text-rose-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>
