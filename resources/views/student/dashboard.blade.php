<x-app-layout>
    <div class="container">
        <p class="text-2xl mb-4">Welcome, {{ auth()->user()->name }}! Select a test to begin.</p>

        @if ($courses->isEmpty())
        <p>No tests are available at this time.</p>
        @else
        @foreach ($courses as $course)
        <div class="mb-4">
            <div class="card-header">
                <h3 class="text-xl">{{ $course->name }}</h3>
                {{-- <p>{{ $course->description ?? 'No description available.' }}</p> --}}
            </div>
            <div class="mb-4 card-body">
                @foreach ($course->subjects as $subject)
                <h4 class="text-lg mb-1">{{ $subject->name }}</h4>
                @if ($subject->tests->isEmpty())
                <p class="text-sm text-gray-700">No tests available for this subject.</p>
                @else
                <div class="list-group">
                    @foreach ($subject->tests as $test)
                    <div class="mb-2 list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>{{ $test->title }}</h5>
                                <p class="text-sm text-gray-700">{{ $test->duration }} minutes | {{
                                    $test->questions->count() }} Questions
                                </p>
                            </div>
                            <a href="{{ route('student.test.start', $test) }}">
                                <x-primary-button class="ms-3">
                                    Start Test
                                </x-primary-button>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endforeach
        @endif
    </div>
</x-app-layout>