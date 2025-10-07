<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Ini area aman aplikasi. Konfirmasikan kata sandi Anda sebelum melanjutkan.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" novalidate id="form-confirm">
        @csrf

        <!-- Kata Sandi -->
        <div>
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

        <div class="flex justify-end mt-4">
            <x-primary-button>
                Konfirmasi
            </x-primary-button>
        </div>
    </form>
    <script>
      (function(){
        const form = document.getElementById('form-confirm');
        const notyf = window.Notyf ? new Notyf({ duration: 3500, position:{x:'right',y:'top'} }) : null;
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
        form && form.addEventListener('submit', function(e){
          const pwd = document.getElementById('password');
          if (!pwd.value) { e.preventDefault(); notyf && notyf.error('Kata sandi wajib diisi.'); }
        });
      })();
    </script>
</x-guest-layout>
