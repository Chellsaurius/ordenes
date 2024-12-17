<div class="modal fade" id="changeUserPasswordSM{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text text-uppercase" id="staticBackdropLabel">Cambiar la contraseña de: {{ $user->name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.changeUserPass')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}" required>
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <span class="fw-light text-decoration-underline">Mínimo 6 caracteres</span>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="mb-3 col-12 pt-3">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="checkBox{{ $user->id }}" required>
                            <label class="form-check-label" for="checkBox{{ $user->id }}">Los datos son correctos y quiero cambiar la contraseña.</label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Cambiar contraseña
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>