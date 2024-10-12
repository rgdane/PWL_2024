<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Registrasi Pengguna</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- icheck bootstrap -->
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
		<!-- SweetAlert2 -->
		<link rel="stylesheet" href="{{ asset('adminlte\plugins\sweetalert2-theme-bootstrap-4\bootstrap-4.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
	</head>
	<body class="hold-transition login-page">
<div class="card card-outline card-primary">
	<div class="card-header">
		<h2 align= "center">Registrasi User</h2>
		<div class="card-tools"></div>
	</div>
	<div class="card-body">
		<form method="POST" action="{{ url('store') }}" class="form-horizontal"> @csrf <div class="form-group row">
				{{-- <label class="col-1 control-label col-form-label">Level</label>
				<div class="col-11">
					<select class="form-control" id="level_id" name="level_id" required>
						<option value="">- Pilih Level -</option> @foreach($level as $item) <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option> @endforeach
					</select> @error('level_id') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div> --}}
			</div>
			<div class="form-group row">
				<label class="col-10 control-label col-form-label">Username</label>
				<div class="col-11">
					<input type="text" class="form-control" id="username" name="username" value="{{
old('username') }}" required> @error('username') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div>
			</div>
			<div class="form-group row">
				<label class="col-10 control-label col-form-label">Nama</label>
				<div class="col-11">
					<input type="text" class="form-control" id="nama" name="nama" value="{{
old('nama') }}" required> @error('nama') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div>
			</div>
			<div class="form-group row">
				<label class="col-10 control-label col-form-label">Password</label>
				<div class="col-11">
					<input type="password" class="form-control" id="password" name="password" required> @error('password') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div>
			</div>
			<div class="form-group row">
				<label class="col-1 control-label col-form-label"></label>
				<div class="col-10" align="center">
					<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
					<a class="btn btn-sm btn-default ml-1" href="{{ url('login') }}">Kembali</a>
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>