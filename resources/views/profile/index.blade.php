@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid rounded-circle" style="width: 20%;"
                    src="{{ $profile->profile_foto_url ?? asset('storage/img/default-profile.jpg')}}"
                    alt="User profile picture">
        </div>
            <br>
            <h3 class="profile-username text-center text-bold">{{ $user->nama }}</h3>
        </div>

        <div class="card-header">
            <h3 class="card-title">Edit Profile</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ url('/profile/'.$profile->profile_id.'/updateProfile') }}" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Image Field -->
                <div class="form-group row">
                  <label class="col-2 control-label col-form-label">Foto Profile</label>
                  <div class="col-10">
                      <input type="file" class="form-control-file" name="profile_foto_url">
                  </div>
              </div>

                <!-- Email Field -->
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Email</label>
                    <div class="col-10">
                        <input type="email" class="form-control" name="profile_email" value="{{ old('profile_email', $profile->profile_email) }}" required>
                        @error('profile_email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 control-label col-form-label">Telepon</label>
                  <div class="col-10">
                      <input type="number" class="form-control" name="profile_telepon" value="{{ old('profile_telepon', $profile->profile_telepon) }}" required>
                      @error('profile_telepon')
                          <small class="form-text text-danger">{{ $message }}</small>
                      @enderror
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 control-label col-form-label">Alamat</label>
                  <div class="col-10">
                      <input type="profile_alamat" class="form-control" name="profile_alamat" value="{{ old('profile_alamat', $profile->profile_alamat) }}" required>
                      @error('profile_alamat')
                          <small class="form-text text-danger">{{ $message }}</small>
                      @enderror
                  </div>
                </div>

                <!-- Save Button -->
                <div class="form-group row">
                    <div class="col-10 offset-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ url('/') }}" class="btn btn-default">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
    <!-- Tambahkan style tambahan jika diperlukan -->
@endpush

@push('js')
    <!-- Tambahkan script tambahan jika diperlukan -->
@endpush
