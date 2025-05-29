<x-app-layout>
    <div class="container">
        <h1 class="text-2xl mb-4">Edit Test: {{ $test->title }}</h1>
        <form action="{{ route('staff.tests.update', $test) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-control" required>
                    @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $test->subject_id == $subject->id ? 'selected' : '' }}>
                        {{ $subject->course->name }} - {{ $subject->name }}
                    </option>
                    @endforeach
                </select>
                @error('subject_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Test Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $test->title) }}"
                    required>
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="duration" class="form-label">Duration (minutes)</label>
                <input type="number" name="duration" id="duration" class="form-control"
                    value="{{ old('duration', $test->duration) }}" required>
                @error('duration')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div id="questions">
                @foreach ($test->questions as $index => $question)
                <div class="question mb-3" id="question-{{ $index }}">
                    <h4 class="text-lg mb-2">Question {{ $index + 1 }}</h4>
                    <div class="mb-3">
                        <label class="form-label">Question Text</label>
                        <textarea name="questions[{{ $index }}][text]" class="form-control"
                            required>{{ old('questions.' . $index . '.text', $question->text) }}</textarea>
                        @error('questions.' . $index . '.text')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option A</label>
                        <input type="text" name="questions[{{ $index }}][option_a]" class="form-control" required
                            value="{{ old('questions.' . $index . '.option_a', $question->option_a) }}">
                        @error('questions.' . $index . '.option_a')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option B</label>
                        <input type="text" name="questions[{{ $index }}][option_b]" class="form-control" required
                            value="{{ old('questions.' . $index . '.option_b', $question->option_b) }}">
                        @error('questions.' . $index . '.option_b')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option C</label>
                        <input type="text" name="questions[{{ $index }}][option_c]" class="form-control" required
                            value="{{ old('questions.' . $index . '.option_c', $question->option_c) }}">
                        @error('questions.' . $index . '.option_c')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option D</label>
                        <input type="text" name="questions[{{ $index }}][option_d]" class="form-control" required
                            value="{{ old('questions.' . $index . '.option_d', $question->option_d) }}">
                        @error('questions.' . $index . '.option_d')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correct Option</label>
                        <select name="questions[{{ $index }}][correct_option]" class="form-control" required>
                            <option value="a" {{ old('questions.' . $index . '.correct_option' , $question->
                                correct_option) == 'a' ? 'selected' : '' }}>A</option>
                            <option value="b" {{ old('questions.' . $index . '.correct_option' , $question->
                                correct_option) == 'b' ? 'selected' : '' }}>B</option>
                            <option value="c" {{ old('questions.' . $index . '.correct_option' , $question->
                                correct_option) == 'c' ? 'selected' : '' }}>C</option>
                            <option value="d" {{ old('questions.' . $index . '.correct_option' , $question->
                                correct_option) == 'd' ? 'selected' : '' }}>D</option>
                        </select>
                        @error('questions.' . $index . '.correct_option')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button"
                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                        onclick="removeQuestion({{ $index }})">Remove
                        Question</button>
                </div>
                @endforeach
            </div>
            <div class="flex justify-between">
                <div>
                    <button type="button" onclick="addQuestion()"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add
                        Question</button>
                    <a href="{{ route('staff.tests.index') }}"
                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Cancel</a>
                </div>

                <button type="submit"
                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-7 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Update
                    Test</button>
            </div>
        </form>
    </div>

    <script>
        let questionCount = {{ count($test->questions) }};
            function addQuestion() {
                const container = document.getElementById('questions');
                const div = document.createElement('div');
                div.className = 'question mb-3';
                div.id = `question-${questionCount}`;
                div.innerHTML = `
                    <h4>Question ${questionCount + 1}</h4>
                    <div class="mb-3">
                        <label class="form-label">Question Text</label>
                        <textarea name="questions[${questionCount}][text]" class="form-control" required></textarea>
                        @error('questions.${questionCount}.text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option A</label>
                        <input type="text" name="questions[${questionCount}][option_a]" class="form-control" required>
                        @error('questions.${questionCount}.option_a')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option B</label>
                        <input type="text" name="questions[${questionCount}][option_b]" class="form-control" required>
                        @error('questions.${questionCount}.option_b')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option C</label>
                        <input type="text" name="questions[${questionCount}][option_c]" class="form-control" required>
                        @error('questions.${questionCount}.option_c')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Option D</label>
                        <input type="text" name="questions[${questionCount}][option_d]" class="form-control" required>
                        @error('questions.${questionCount}.option_d')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correct Option</label>
                        <select name="questions[${questionCount}][correct_option]" class="form-control" required>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                        @error('questions.${questionCount}.correct_option')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="removeQuestion(${questionCount})">Remove Question</button>
                `;
                container.appendChild(div);
                questionCount++;
            }

            function removeQuestion(index) {
                const questionDiv = document.getElementById(`question-${index}`);
                if (questionDiv) {
                    questionDiv.remove();
                }
            }
    </script>
</x-app-layout>