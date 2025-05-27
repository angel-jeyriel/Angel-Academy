<x-app-layout>
    <div class="container">
        <h1 class="text-2xl">Test Results: {{ $test->title }}</h1>
        <p class="text-xl mb-2">Subject: {{ $test->subject->name }} (Course: {{ $test->subject->course->name }})</p>
        <a href="{{ route('staff.tests.pdf', $test) }}"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Download
            PDF<i class="fas fa-download p-2 text-lg text-white"></i></a>
        <div id="notifications" class="relative overflow-x-auto my-4 shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Student</th>
                        <th scope="col" class="px-6 py-3">Score</th>
                        <th scope="col" class="px-6 py-3">Completed At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attempts as $attempt)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td class="px-6 py-4">{{ $attempt->user->name }}</td>
                        <td class="px-6 py-4">{{ $attempt->score }} / {{ $test->questions->count() }}</td>
                        <td class="px-6 py-4">{{ $attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i:s')
                            :
                            'Not completed' }}
                        </td>
                    </tr>
                    @endforeach
                    @if ($attempts->isEmpty())
                    <tr>
                        <td colspan="3">No attempts found for this test.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <a href="{{ route('staff.tests.index') }}"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fas fa-arrow-left mt-1 p-2 text-lg text-white"></i>Back to Tests</a>
        <input type="hidden" id="course-id" value="{{ $test->subject->course->id }}">
    </div>
</x-app-layout>