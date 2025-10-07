<script>
  (function(){
    if (!window.Notyf) return;
    const notyf = new Notyf({ duration: 3500, position: { x: 'right', y: 'top' } });

    @if (session('status'))
      notyf.success(@json(session('status') === 'passwords.sent' ? 'Jika email terdaftar, tautan reset kata sandi telah dikirim.' : session('status')));
    @endif

    @if (session('success'))
      notyf.success(@json(session('success')));
    @endif

    @if (session('error'))
      notyf.error(@json(session('error')));
    @endif

    @if ($errors->any())
      @foreach ($errors->all() as $e)
        notyf.error(@json($e));
      @endforeach
    @endif
  })();
</script>
