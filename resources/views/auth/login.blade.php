<x-guest-layout>
    <!-- Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" novalidate id="form-login">
        @csrf

        <!-- Alamat Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Kata Sandi -->
        <div class="mt-4">
            <x-input-label for="password" value="Kata Sandi" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <button type="button" aria-label="Tampilkan kata sandi" data-toggle-password="password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-500 hover:text-neutral-700">
                    <span class="material-icons text-base">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Ingat Saya -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand shadow-sm focus:ring-brand" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif

            <x-primary-button class="ms-3">
                Masuk
            </x-primary-button>
        </div>
    </form>
    <script>
      (function(){
        const form = document.getElementById('form-login');
        if (!form) return;
        const notyf = window.Notyf ? new Notyf({ duration: 3500, position:{x:'right',y:'top'} }) : null;
        const email = document.getElementById('email');
        const pwd = document.getElementById('password');
        const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        form.addEventListener('submit', function(e){
          let ok = true;
          if (!email.value || !emailRe.test(email.value)) { ok = false; notyf && notyf.error('Masukkan email yang valid.'); }
          if (!pwd.value) { ok = false; notyf && notyf.error('Kata sandi wajib diisi.'); }
          if (!ok) e.preventDefault();
        });
        // Toggle password visibility
        document.querySelectorAll('[data-toggle-password]').forEach(btn=>{
          btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-toggle-password');
            const input = document.getElementById(id);
            if (!input) return;
            const isPwd = input.type === 'password';
            input.type = isPwd ? 'text' : 'password';
            btn.querySelector('.material-icons').textContent = isPwd ? 'visibility_off' : 'visibility';
          });
        });
      })();
    </script>
</x-guest-layout>
