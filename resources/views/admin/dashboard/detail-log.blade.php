<div class="p-2">
    <h5 class="mb-2">{{ $activity->user->name }}</h5>

    <p>
        <strong>Aktivitas:</strong><br>
        {{ $activity->activity }}
    </p>

    <p>
        <strong>Tanggal:</strong><br>
        {{ \Carbon\Carbon::parse($activity->date)->format('d M Y') }}
    </p>

    <p>
        <strong>Status:</strong><br>
        <span class="badge bg-{{ $activity->status == 0 ? 'warning' : 'success' }}">
            {{ ucfirst($activity->status()) }}
        </span>
    </p>

    @if ($activity->photo)
        <p>
            <strong>Foto:</strong><br>
            <img src="{{ asset('storage/upload/kegiatan/' . $activity->photo) }}" alt="Foto Aktivitas"
                class="img-fluid rounded border" style="max-height: 300px;">
        </p>
    @endif
</div>
