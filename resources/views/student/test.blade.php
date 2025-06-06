<x-app-layout>

    <body>
        <div class="container">
            <h1 class="text-3xl mb-2">{{ $test->title }}</h1>
            <div id="timer" class="text-gray-800" data-duration="{{ $test->duration * 60 }}"></div>
            <form id="test-form" action="{{ route('student.test.submit', $attempt) }}" method="POST">
                @csrf
                @foreach ($test->questions as $index => $question)
                <div class="text-lg mb-1" id="question-{{ $index }}"
                    style="display: {{ $index == 0 ? 'block' : 'none' }}">
                    <p class="text-xl mb-2">{{ $index + 1 }}. {{ $question->text }}</p>
                    <label><input class="mb-1 me-2" type="radio" name="answers[{{ $question->id }}]" value="a">
                        {{
                        $question->option_a
                        }}</label><br>
                    <label><input class="mb-1 me-2" type="radio" name="answers[{{ $question->id }}]" value="b">
                        {{
                        $question->option_b
                        }}</label><br>
                    <label><input class="mb-1 me-2" type="radio" name="answers[{{ $question->id }}]" value="c">
                        {{
                        $question->option_c
                        }}</label><br>
                    <label><input class="mb-1 me-2" type="radio" name="answers[{{ $question->id }}]" value="d">
                        {{
                        $question->option_d
                        }}</label>
                </div>
                @endforeach
                @if(count($test->questions) > 1)
                <div class="mt-4 w-1/2 flex justify-between">
                    <button type="button" id="prev-btn"
                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                        onclick="prevQuestion()" style="display: none;">Prev</button>
                    <button type="button" id="next-btn"
                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        onclick="nextQuestion()">Next</button>
                    <button type="submit" id="submit-btn"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        style="display: none;">Submit</button>
                </div>
                @elseif(count($test->questions) == 1)
                <button type="submit" id="submit-btn"
                    class="focus:outline-none my-2 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Submit</button>
                @endif
            </form>
            <input type="hidden" id="course-id" value="{{ $test->subject->course->id }}">
        </div>

        <script>
            let currentQuestion = 0;
            const totalQuestions = {{ count($test->questions) }};

            function prevQuestion() {       
                if (currentQuestion > 0) {
                    document.getElementById('next-btn').style.display = 'inline-block';
                    document.getElementById('submit-btn').style.display = 'none';
                    document.getElementById('question-' + currentQuestion).style.display = 'none';
                    currentQuestion--;
                    document.getElementById('question-' + currentQuestion).style.display = 'inline-block';
                } if (currentQuestion === 0) {
                        document.getElementById('prev-btn').style.display='none' ; }                
                }

            function nextQuestion() {
                if (currentQuestion < totalQuestions - 1) {
                    document.getElementById('prev-btn').style.display = 'inline-block';
                    document.getElementById('question-' + currentQuestion).style.display = 'none';
                    currentQuestion++;
                    document.getElementById('question-' + currentQuestion).style.display = 'inline-block';
                    if (currentQuestion === totalQuestions - 1) {
                        document.getElementById('next-btn').style.display = 'none';
                        document.getElementById('submit-btn').style.display = 'inline-block';
                    }
                }
            }

            // Timer
            const duration = parseInt(document.getElementById('timer').dataset.duration);
            let timeLeft = duration;
            const timerDisplay = document.getElementById('timer');
            const timer = setInterval(() => {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerDisplay.textContent = `Time Left: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                timeLeft--;
                if (timeLeft < 0) {
                    clearInterval(timer);
                    document.getElementById('test-form').submit();
                }
            }, 1000);
        </script>
</x-app-layout>