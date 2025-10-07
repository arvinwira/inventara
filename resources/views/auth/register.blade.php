<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" novalidate id="form-register">
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
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <button type="button" aria-label="Tampilkan kata sandi" data-toggle-password="password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-500 hover:text-neutral-700">
                    <span class="material-icons text-base">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Password Checker (lebih lengkap) -->
            <div class="mt-3">
                <div class="h-2 w-full bg-neutral-200 rounded-full overflow-hidden">
                    <div id="pwd-meter" class="h-2 w-0 bg-red-500 transition-all duration-300"></div>
                </div>
                <ul class="mt-2 text-xs text-neutral-600 space-y-1" id="pwd-rules">
                    <li data-rule="len">Minimal 8 karakter</li>
                    <li data-rule="letter">Mengandung huruf</li>
                    <li data-rule="digit">Mengandung angka</li>
                    <li data-rule="upper" class="opacity-80">Disarankan huruf besar</li>
                    <li data-rule="symbol" class="opacity-80">Disarankan simbol</li>
                </ul>
            </div>
        </div>

        <!-- Konfirmasi Kata Sandi -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <button type="button" aria-label="Tampilkan kata sandi" data-toggle-password="password_confirmation" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-500 hover:text-neutral-700">
                    <span class="material-icons text-base">visibility</span>
                </button>
            </div>
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
        const form = document.getElementById('form-register');
        const notyf = window.Notyf ? new Notyf({ duration: 3500, position:{x:'right',y:'top'} }) : null;
        function toggleBind(){
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
        }
        toggleBind();

        const pwd = document.getElementById('password');
        if(!pwd) return;
        const bar = document.getElementById('pwd-meter');
        const rules = document.getElementById('pwd-rules');
        const ruleItems = {
          len: rules.querySelector('[data-rule=len]'),
          letter: rules.querySelector('[data-rule=letter]'),
          digit: rules.querySelector('[data-rule=digit]'),
          upper: rules.querySelector('[data-rule=upper]'),
          symbol: rules.querySelector('[data-rule=symbol]'),
        };
        const update = () => {
          const v = pwd.value || '';
          const okLen = v.length >= 8;
          const okLetter = /[A-Za-z]/.test(v);
          const okDigit = /\d/.test(v);
          const okUpper = /[A-Z]/.test(v);
          const okSymbol = /[^A-Za-z0-9]/.test(v);
          // Required rules
          const requiredScore = (okLen?1:0) + (okLetter?1:0) + (okDigit?1:0);
          // Score with recommendations
          let score = requiredScore + (okUpper?1:0) + (okSymbol?1:0); // 0..5
          const pct = (score/5*100);
          bar.style.width = pct+'%';
          bar.className = 'h-2 transition-all duration-300 ' + (score<=2? 'bg-red-500' : score<=4 ? 'bg-yellow-500' : 'bg-green-600');
          [['len',okLen],['letter',okLetter],['digit',okDigit],['upper',okUpper],['symbol',okSymbol]].forEach(([k,ok])=>{
            ruleItems[k].className = 'transition-colors ' + (ok? 'text-green-600':'text-neutral-600');
          });
        };
        pwd.addEventListener('input', update); update();

        // Client-side validation to avoid browser native bubble
        form && form.addEventListener('submit', function(e){
          const email = document.getElementById('email');
          const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          let ok = true;
          if (!email.value || !emailRe.test(email.value)) { ok = false; notyf && notyf.error('Masukkan email yang valid.'); }
          const v = pwd.value || '';
          const okLen = v.length >= 8, okLetter = /[A-Za-z]/.test(v), okDigit = /\d/.test(v);
          if (!(okLen && okLetter && okDigit)) { ok = false; notyf && notyf.error('Kata sandi minimal 8 karakter dan mengandung huruf serta angka.'); }
          const c = document.getElementById('password_confirmation');
          if (c && v !== c.value) { ok = false; notyf && notyf.error('Konfirmasi kata sandi tidak cocok.'); }
          if (!ok) e.preventDefault();
        });
      })();
    </script>
</x-guest-layout>
