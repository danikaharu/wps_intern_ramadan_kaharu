<div class="row">
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Kegiatan</label>
        <input type="text" name="activity" class="form-control @error('activity')
      invalid
  @enderror"
            value="{{ isset($activity) ? $activity->activity : old('activity') }}">
        @error('activity')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>


    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Tanggal Pelaksanaan</label>
        <input type="date" name="date" class="form-control @error('date')
      invalid
  @enderror"
            value="{{ isset($activity) ? $activity->date : old('date') }}">
        @error('date')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>

    @isset($activity)
        <div class="mb-3 col-md-12">
            <div class="row">
                <div class="col-md-3">
                    @if ($activity->photo == null)
                        <label for="photo" class="form-label">Gambar Lama</label>
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="photo"
                            class="rounded mb-2 mt-2" alt="photo" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <label for="photo" class="form-label">Gambar Lama</label>
                        <img src="{{ asset('storage/upload/kegiatan/' . $activity->photo) }}" alt="photo"
                            class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="form-group ms-3">
                        <label for="photo" class="form-label">Bukti Pekerjaan</label>
                        <input class="form-control  @error('photo') is-invalid @enderror" type="file" name="photo" />
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 mb-6">
            <label class="form-label" for="basic-default-fullname">Bukti Pekerjaan</label>
            <input type="file" name="photo" class="form-control @error('photo')
      invalid
  @enderror">
            @error('photo')
                <div class="small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    @endisset
</div>
