<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" novalidate id="form-reset">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Alamat Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Kata Sandi Baru -->
        <div class="mt-4">
            <x-input-label for="password" value="Kata Sandi Baru" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" />
                <button type="button" aria-label="Tampilkan kata sandi" data-toggle-password="password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-500 hover:text-neutral-700">
                    <span class="material-icons text-base">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Password Checker -->
            <div class="mt-3">
                <div class="h-2 w-full bg-neutral-200 rounded-full overflow-hidden">
                    <div id="pwd-meter-r" class="h-2 w-0 bg-brand transition-all duration-300"></div>
                </div>
                <ul class="mt-2 text-xs text-neutral-600 space-y-1" id="pwd-rules-r">
                    <li data-rule="len">Minimal 8 karakter</li>
                    <li data-rule="letter">Mengandung huruf</li>
                    <li data-rule="digit">Mengandung angka</li>
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
            <x-primary-button>Reset Kata Sandi</x-primary-button>
        </div>
    </form>
    <script>
      (function(){
        const form = document.getElementById('form-reset');
        const notyf = window.Notyf ? new Notyf({ duration: 3500, position:{x:'right',y:'top'} }) : null;
        const pwd = document.getElementById('password');
        if(!pwd) return;
        const bar = document.getElementById('pwd-meter-r');
        const rules = document.getElementById('pwd-rules-r');
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
        // Toggle visibility
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
        // Basic client validate
        form && form.addEventListener('submit', function(e){
          let ok = true;
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
