<div class="form-row mt-3">
    <div class="form-group col-md-2">
        <label for="name">Nome</label>
    </div>
    <div class="form-group col-md-10">
        <input type="text" class="form-control" id="nome" name="name" required value="{{ old('name') ?? $user->name }}"
            placeholder="Nome do usuário">
        @if ($errors->register->has('name'))
        <span class="text-danger">
            <strong>{{ $errors->register->first('name') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-2">
        <label for="email">E-mail</label>
    </div>
    <div class="form-group col-md-10">
        <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}"
            placeholder="Email do usuário">
        @if ($errors->register->has('email'))
        <span class="text-danger">
            <strong>{{ $errors->register->first('email') }}</strong>
        </span>
        @endif
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-2">
        <label for="password">Confirme a senha </label>
    </div>
    <div class="form-group col-md-10">
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            required " placeholder=" Confirme a senha do usuário">
    </div>
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-rcsuccess">Retornar</a>
    <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Gravar</button>
</div>
