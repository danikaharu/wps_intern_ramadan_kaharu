@extends('layouts.admin.index')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card mb-3">
            <div class="card-header">
                <h5>Selamat Datang, {{ auth()->user()->name }}</h5>
            </div>
        </div>

        @if (auth()->user()->hasRole('Direktur') ||
                auth()->user()->hasRole('Manager Keuangan') ||
                auth()->user()->hasRole('Manager Operasional'))
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Filter Bawahan</h5>
                </div>
                <div class="card-body">
                    <form id="filterForm">
                        <label for="user_id">Pilih Bawahan:</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">Semua</option>
                            @if (auth()->user()->hasRole('Direktur'))
                                @foreach ($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                @endforeach
                            @endif
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h5>Kalender Log Harian Bawahan</h5>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="logDetailModal" tabindex="-1" aria-labelledby="logDetailModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logDetailModalLabel">Detail Kegiatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="log-detail-body">Memuat...</div>
                    </div>
                </div>
            </div>
        @endif
    </div>



@endsection

@push('style')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
@endpush

@push('script')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(info, successCallback, failureCallback) {
                    var userId = document.getElementById('user_id').value;
                    fetch(`/admin/dashboard/logs/calendar?user_id=${userId}`)
                        .then(response => response.json())
                        .then(data => successCallback(data));
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    fetch(info.event.url)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('log-detail-body').innerHTML = html;
                            new bootstrap.Modal(document.getElementById('logDetailModal')).show();
                        });
                }
            });

            calendar.render();

            // Event listener untuk filter
            document.getElementById('user_id').addEventListener('change', function() {
                calendar.refetchEvents();
            });
        });
    </script>
@endpush
