<x-app-layout>
    <div class="container">
        <h1 class='text-2xl mb-2'>Create Test</h1>
        {{-- @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}
        <form action="{{ route('staff.tests.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select name="subject_id" class="form-control" required>
                    @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->course->name }} - {{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Test Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="duration" class="form-label">Duration (minutes)</label>
                <input type="number" name="duration" class="form-control" value="{{ old('duration') }}" required>
                @error('duration')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div id="questions">
                <div class="question mb-3">
                    <h4 class="text-lg">Question 1</h4>
                    <div class="mb-3">
                        <label class="form-label">Question Text</label>
                        <textarea name="questions[0][text]" class="form-control"
                            required>{{ old('questions.0.text') }}</textarea>
                        @error('questions.0.text')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option A</label>
                        <input type="text" name="questions[0][option_a]" class="form-control" required
                            value="{{ old('questions.0.option_a') }}">
                        @error('questions.0.option_a')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option B</label>
                        <input type="text" name="questions[0][option_b]" class="form-control" required
                            value="{{ old('questions.0.option_b') }}">
                        @error('questions.0.option_b')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option C</label>
                        <input type="text" name="questions[0][option_c]" class="form-control" required
                            value="{{ old('questions.0.option_c') }}">
                        @error('questions.0.option_c')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option D</label>
                        <input type="text" name="questions[0][option_d]" class="form-control" required
                            value="{{ old('questions.0.option_d') }}">
                        @error('questions.0.option_d')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correct Option</label>
                        <select name="questions[0][correct_option]" class="form-control" required>
                            <option value="a" {{ old('questions.0.correct_option')=='a' ? 'selected' : '' }}>A</option>
                            <option value="b" {{ old('questions.0.correct_option')=='b' ? 'selected' : '' }}>B</option>
                            <option value="c" {{ old('questions.0.correct_option')=='c' ? 'selected' : '' }}>C</option>
                            <option value="d" {{ old('questions.0.correct_option')=='d' ? 'selected' : '' }}>D</option>
                        </select>
                        @error('questions.0.correct_option')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="w-1/2 mt-4 flex justify-between">
                <button type="button" onclick="addQuestion()"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add
                    Question</button>
                <button type="submit"
                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Create
                    Test</button>
            </div>
        </form>
    </div>

    <script>
        let questionCount = 1;
        function addQuestion() {
            const container = document.getElementById('questions');
            const div = document.createElement('div');
            div.className = 'question mb-3';
            div.innerHTML = `
                <h4 class="text-lg">Question ${++questionCount}</h4>
                <div class="mb-3">
                    <label class="form-label">Question Text</label>
                    <textarea name="questions[${questionCount-1}][text]" class="form-control" required></textarea>
                    @error('questions.${questionCount-1}.text')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Option A</label>
                    <input type="text" name="questions[${questionCount-1}][option_a]" class="form-control" required>
                    @error('questions.${questionCount-1}.option_a')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Option B</label>
                    <input type="text" name="questions[${questionCount-1}][option_b]" class="form-control" required>
                    @error('questions.${questionCount-1}.option_b')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Option C</label>
                    <input type="text" name="questions[${questionCount-1}][option_c]" class="form-control" required>
                    @error('questions.${questionCount-1}.option_c')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Option D</label>
                    <input type="text" name="questions[${questionCount-1}][option_d]" class="form-control" required>
                    @error('questions.${questionCount-1}.option_d')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Correct Option</label>
                    <select name="questions[${questionCount-1}][correct_option]" class="form-control" required>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                    @error('questions.${questionCount-1}.correct_option')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</x-app-layout>