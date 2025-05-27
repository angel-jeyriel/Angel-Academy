<x-app-layout>
    <div class="container">
        <h1 class="text-4xl my-3">Welcome to {{ str_replace('_', ' ', config('app.name', 'Laravel')) }}</h1>
        @auth
        @if (auth()->user()->isStaff())
        <p class="text-lg">Manage tests from the <a class="text-gray-600 hover:underline"
                href="{{ route('staff.tests.index') }}">Tests</a> page.</p>
        @else
        <p class="text-lg">Access available tests from your <a class="text-gray-600 hover:underline"
                href="{{ route('student.dashboard') }}">Dashboard</a>.
        </p>
        @endif
        @else
        <p class="text-lg">Please <a class="text-gray-600 hover:underline" href="{{ route('login') }}">login</a> or <a
                class="text-gray-600 hover:underline" href="{{ route('register') }}">register</a> to access
            tests.</p>
        @endauth
    </div>
</x-app-layout>