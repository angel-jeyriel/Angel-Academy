<x-app-layout>
    <div class="container">
        <h1 class='text-2xl mb-2'>Create New Subject</h1>
        <form action="{{ route('staff.add.subject') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Subject name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="course_id" class="form-label">Course</label>
                <select name="course_id" class="form-control" required>
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Create
                Subject</button>
        </form>
    </div>
</x-app-layout>