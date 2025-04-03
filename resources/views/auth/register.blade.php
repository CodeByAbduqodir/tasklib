<x-guest-layout>
    <div class="flex items-center justify-center bg-gray-100 py-8">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm border border-blue-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4">SIGN UP</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="block text-gray-600 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required autofocus />
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="block text-gray-600 mb-1">Password</label>
                    <input id="password" type="password" name="password"
                           class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required />
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="block text-gray-600 mb-1">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required />
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit"
                            class="w-full bg-pink-500 text-white p-2 rounded-lg hover:bg-pink-600 transition">
                        SIGN UP
                    </button>
                </div>
            </form>

            <div class="flex items-center mb-4">
                <hr class="flex-grow border-gray-300">
                <span class="mx-2 text-gray-500 text-sm">OR</span>
                <hr class="flex-grow border-gray-300">
            </div>

            <div class="flex justify-center space-x-3 mb-4">
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100">
                    <span class="text-red-500 font-bold">G</span>
                </a>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100">
                    <span class="text-blue-600 font-bold">f</span>
                </a>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100">
                    <span class="text-blue-500 font-bold">in</span>
                </a>
            </div>

            <p class="text-center text-gray-600 text-sm">
                Already a user? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">LOGIN</a>
            </p>
        </div>
    </div>
</x-guest-layout>
