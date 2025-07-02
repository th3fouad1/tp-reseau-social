<!-- filepath: c:\Users\Fouad\Desktop\TP 2CI\BENLAHMAR\mon-projet2\resources\views\auth\forgot-password.blade.php -->
<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Login -->
        <div>
            <x-input-label for="login" :value="__('Login')" />
            <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>