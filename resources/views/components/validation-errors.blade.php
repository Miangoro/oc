@if ($errors->any())
  <div {!! $attributes->merge(['class' => 'alert alert-danger']) !!} role="alert">
    <div class="alert-body">
      <div class="fw-bold">{{ __('¡Vaya! Algo salió mal.') }}</div>

      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
