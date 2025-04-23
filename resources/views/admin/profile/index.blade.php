@extends('layouts.admin.index')

@section('title', 'Profil')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-8 order-md-1 order-last">
                        <h3>{{ __('Profile') }}</h3>
                        <p class="text-subtitle text-muted">
                            {{ __('Ubah password anda dibawah ini') }}
                        </p>
                    </div>
                </div>
            </div>

            <section class="section mt-4">

                {{-- Password --}}
                <div class="row">
                    <div class="col-md-12">
                        <hr class="mb-5">
                    </div>

                    <div class="col-md-3">
                        <h4>{{ __('Ubah Password') }}</h4>
                    </div>

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('user-password.update') }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group mb-2">
                                        <label for="password">{{ __('Password Saat Ini') }}</label>
                                        <input type="password" name="current_password"
                                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                            id="password" placeholder="Password Saat Ini">
                                        @error('current_password', 'updatePassword')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="password">{{ __('Password Baru') }}</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                            id="password" placeholder="Password Baru">
                                        @error('password', 'updatePassword')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="password_confirmation">{{ __('Konfirmasi Password Baru') }}</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Konfirmasi Password Baru">
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">{{ __('Ubah Password') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')
    @if (session('password_updated'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Password berhasil diperbarui.',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@endpush
