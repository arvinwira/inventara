<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama -->
        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Alamat Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Kata Sandi -->
        <div class="mt-4">
            <x-input-label for="password" value="Kata Sandi" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Password Checker -->
            <div class="mt-3">
                <div class="h-2 w-full bg-neutral-200 rounded-full overflow-hidden">
                    <div id="pwd-meter" class="h-2 w-0 bg-brand transition-all duration-300"></div>
                </div>
                <ul class="mt-2 text-xs text-neutral-600 space-y-1" id="pwd-rules">
                    <li data-rule="len">Minimal 8 karakter</li>
                    <li data-rule="letter">Mengandung huruf</li>
                    <li data-rule="digit">Mengandung angka</li>
                </ul>
            </div>
        </div>

        <!-- Konfirmasi Kata Sandi -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button class="ms-4">
                Daftar
            </x-primary-button>
        </div>
    </form>
    <script>
      (function(){
        const pwd = document.getElementById('password');
        if(!pwd) return;
        const bar = document.getElementById('pwd-meter');
        const rules = document.getElementById('pwd-rules');
        const ruleItems = {
          len: rules.querySelector('[data-rule=len]'),
          letter: rules.querySelector('[data-rule=letter]'),
          digit: rules.querySelector('[data-rule=digit]'),
        };
        const update = () => {
          const v = pwd.value || '';
          const okLen = v.length >= 8;
          const okLetter = /[A-Za-z]/.test(v);
          const okDigit = /\d/.test(v);
          let score = (okLen?1:0)+(okLetter?1:0)+(okDigit?1:0);
          bar.style.width = (score/3*100)+'%';
          bar.className = 'h-2 transition-all duration-300 ' + (score<2? 'bg-red-500':'bg-brand');
          [ ['len',okLen], ['letter',okLetter], ['digit',okDigit] ].forEach(([k,ok])=>{
            ruleItems[k].className = 'transition-colors ' + (ok? 'text-green-600':'text-neutral-600');
          });
        };
        pwd.addEventListener('input', update);
        update();
      })();
    </script>
</x-guest-layout>
