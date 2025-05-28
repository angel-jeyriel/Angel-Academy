<x-app-layout>
    <div class="lg-container">
        <h1 class='text-2xl'>Tests</h1>
        {{-- Alert --}}
        @if (session()->has('success'))
        <div id="alert" class="flex items-center mb-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" role="alert">
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
        <a href="{{ route('staff.tests.create') }}">
            <x-primary-button class="my-3">
                Create New Test
            </x-primary-button>
        </a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Course</th>
                        <th scope="col" class="px-6 py-3">Subject</th>
                        <th scope="col" class="px-6 py-3">Title</th>
                        <th scope="col" class="px-6 py-3">Questions</th>
                        <th scope="col" class="px-6 py-3">Duration (min)</th>
                        <th scope="col" class="px-6 py-3">Attempts</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tests as $test)
                    <tr>
                        <td class="px-6 py-4">{{ $test->subject->course->name }}</td>
                        <td class="px-6 py-4">{{ $test->subject->name }}</td>
                        <td class="px-6 py-4">{{ $test->title }}</td>
                        <td class="px-6 py-4">{{ count($test->questions) }}</td>
                        <td class="px-6 py-4">{{ $test->duration }}</td>
                        <td class="px-6 py-4 hover:font-bold"><a href="{{ route('staff.tests.results', $test) }}">{{
                                count($test->testAttempts) }} <i
                                    class="fas fa-eye p-1 text-gray-500 hover:text-gray-600"></a></td>
                        <td class="px-6 py-4">
                            <a href="{{ route('staff.tests.edit', $test) }}">
                                <i class="fas fa-edit p-2 text-lg text-green-500 hover:text-green-600"></i></a>
                            <form action="{{ route('staff.tests.destroy', $test) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <i class="fas fa-trash p-2 text-lg text-red-500 hover:text-red-600 delete"></i>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <input type="hidden" id="course-id" value="{{ $tests->first()->subject->course->id ?? '' }}">
    </div>

    <script>
        const alert = document.getElementById('alert');
    
            function deleteAlert() {
                alert.style.display = 'none';
            }
    
            setTimeout(() => {  
                alert.style.display = 'none';        
            }, 60000);

            document.addEventListener('DOMContentLoaded', function () {
                const deleteButtons = document.querySelectorAll('.delete');
                
                deleteButtons.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
-                        const form = button.closest('form');
                        
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You want to delete this Test?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
    </script>
</x-app-layout>