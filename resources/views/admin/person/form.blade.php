
{!! csrf_field() !!}

<input type="hidden" name="published" id="published" value="{{ $user->published or '' }}">

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	<label for="name" class="control-label col-sm-2">Nome</label>
	<div class="col-sm-10">
		<input type="text" name="name" id="name" class="form-control" value="{{ $user->name or '' }}" placeholder="Nome...">
	    @if ($errors->has('name'))
	        <span class="help-block">
	            <strong>{{ $errors->first('name') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	<label for="email" class="control-label col-sm-2">Email</label>
	<div class="col-sm-10">
		<input type="text" name="email" id="email" class="form-control" value="{{ $user->email or '' }}" placeholder="Email...">
	    @if ($errors->has('email'))
	        <span class="help-block">
	            <strong>{{ $errors->first('email') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="password" class="control-label col-md-2">Senha</label>
    <div class="col-md-10">
        <input id="password" type="password" class="form-control" name="password" placeholder="Senha...">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    <label for="password-confirm" class="control-label col-md-2">Confirmar senha</label>
    <div class="col-md-10">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar senha...">
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<input type="submit" value="Salvar" class="btn btn-primary" />
	</div>
</div>
