<x-app-layout>
    <div class="container">
        @if (session()->has('success'))
        <div id="alert" class="flex items-center p-4 mb-4 rounded-lg bg-gray-50 dark:bg-gray-800" role="alert">
            <svg class="shrink-0 w-4 h-4 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium text-gray-800 dark:text-gray-300">
                {{ session('success') }}
            </div>
            <button type="button" onclick="deleteAlert()"
                class="ms-auto -mx-1.5 -my-1.5 bg-gray-50 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                data-dismiss-target="#alert-5" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        @endif
        <h1 class="text-2xl mb-1">Test Results</h1>
        <h3 class="text-lg">{{ $attempt->test->title }}</h3>
        <p>Score: {{ $attempt->score }} / {{ $attempt->test->questions->count() }}</p>
        <p>Percentage: {{ round(($attempt->score)/($attempt->test->questions->count()) * 100, 1) }}%</p>
        <p>Completed: {{ $attempt->completed_at->format('H:i d-m-Y') }}</p>
        <a href="{{ route('home') }}">
            <x-primary-button class="mt-3">
                Back to Home
            </x-primary-button>
        </a>
        <input type="hidden" id="course-id" value="{{ $attempt->test->subject->course->id }}">
    </div>

    <script>
        const alert = document.getElementById('alert');
        
        function deleteAlert() {
            alert.style.display = 'none';
        }

        setTimeout(() => {  
            alert.style.display = 'none';        
        }, 60000);
    </script>
</x-app-layout>