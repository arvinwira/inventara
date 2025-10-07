<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Lupa kata sandi? Masukkan email Anda, jika terdaftar kami akan mengirim tautan reset kata sandi.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" novalidate id="form-forgot">
        @csrf

        <!-- Alamat Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>Kirim Tautan Reset</x-primary-button>
        </div>
    </form>
    <script>
      (function(){
        const form = document.getElementById('form-forgot');
        const notyf = window.Notyf ? new Notyf({ duration: 3500, position:{x:'right',y:'top'} }) : null;
        form && form.addEventListener('submit', function(e){
          const email = document.getElementById('email');
          const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!email.value || !emailRe.test(email.value)) { e.preventDefault(); notyf && notyf.error('Masukkan email yang valid.'); }
        });
      })();
    </script>
</x-guest-layout>
