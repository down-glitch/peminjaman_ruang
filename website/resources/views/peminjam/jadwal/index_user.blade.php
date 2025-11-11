    @extends('layouts.peminjam')

    @section('title', 'Jadwal Ruangan')

    @section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="page-title"><i class="fas fa-calendar-alt"></i> Jadwal Ruangan</h3>

        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Days Navigation -->
        <div class="days-navigation mb-4">
            <div class="days-list">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                <button class="day-btn {{ $loop->first ? 'active' : '' }}" data-day="{{ $day }}">
                    {{ $day }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Schedule Cards -->
        <div class="schedule-cards">
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
            <div class="day-schedule {{ $loop->first ? 'active' : '' }}" id="schedule-{{ $day }}">
                <div class="day-header">
                    <h4 class="day-title">{{ $day }}</h4>
                    <span class="schedule-count">
                        {{ $jadwal->where('hari', $day)->count() }} jadwal
                    </span>
                </div>
                
                <div class="schedule-list">
                    @forelse($jadwal->where('hari', $day) as $j)
                    <div class="schedule-card">
                        <div class="schedule-info">
                            <div class="room-badge">
                                <i class="fas fa-door-open"></i>
                                {{ $j->room->nama_room ?? 'Ruangan' }}
                            </div>
                            <div class="time-slot">
                                <i class="fas fa-clock"></i>
                                {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                            </div>
                            @if($j->deskripsi)
                            <div class="schedule-desc">
                                {{ $j->deskripsi }}
                            </div>
                            @endif
                        </div>
                        <div class="schedule-actions">
                            
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="empty-day">
                        <i class="fas fa-calendar-plus"></i>
                        <p>Tidak ada jadwal</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <style>
        .page-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            font-family: 'Montserrat', sans-serif;
            background: var(--primary);
            color: var(--text);
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--text);
            border: 1px solid rgba(40, 167, 69, 0.2);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Days Navigation */
        .days-navigation {
            border-bottom: 2px solid var(--primary);
        }

        .days-list {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }

        .day-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px 8px 0 0;
            background: transparent;
            color: var(--text);
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
            font-family: 'Montserrat', sans-serif;
        }

        .day-btn:hover {
            background: rgba(156, 124, 94, 0.1);
        }

        .day-btn.active {
            background: var(--primary);
            color: var(--text);
            font-weight: 600;
        }

        /* Schedule Cards */
        .schedule-cards {
            margin-top: 1rem;
        }

        .day-schedule {
            display: none;
        }

        .day-schedule.active {
            display: block;
        }

        .day-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(156, 124, 94, 0.2);
        }

        .day-title {
            font-family: 'Playfair Display', serif;
            color: var(--accent);
            margin: 0;
            font-size: 1.5rem;
        }

        .schedule-count {
            background: var(--primary);
            color: var(--text);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .schedule-list {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .schedule-card {
            background: var(--card-bg);
            border: 1px solid rgba(156, 124, 94, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: all 0.3s ease;
        }

        .schedule-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .schedule-info {
            flex: 1;
        }

        .room-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(156, 124, 94, 0.1);
            color: var(--accent);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .time-slot {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .time-slot i {
            color: var(--accent);
        }

        .schedule-desc {
            color: var(--text);
            opacity: 0.8;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(156, 124, 94, 0.1);
        }

        .schedule-actions {
            display: flex;
            gap: 0.5rem;
            margin-left: 1rem;
        }

        .btn-edit, .btn-delete {
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-edit {
            background: rgba(255, 193, 7, 0.1);
            color: var(--text);
        }

        .btn-edit:hover {
            background: rgba(255, 193, 7, 0.2);
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: var(--text);
        }

        .btn-delete:hover {
            background: rgba(220, 53, 69, 0.2);
        }

        /* Empty State */
        .empty-day {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text);
            opacity: 0.6;
            grid-column: 1 / -1;
        }

        .empty-day i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .empty-day p {
            margin: 0;
            font-style: italic;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .schedule-list {
                grid-template-columns: 1fr;
            }

            .schedule-card {
                flex-direction: column;
                gap: 1rem;
            }

            .schedule-actions {
                margin-left: 0;
                align-self: flex-end;
            }

            .days-list {
                gap: 0.25rem;
            }

            .day-btn {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding: 1rem;
            }

            .schedule-card {
                padding: 1.25rem;
            }

            .day-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Day navigation functionality
            const dayButtons = document.querySelectorAll('.day-btn');
            const daySchedules = document.querySelectorAll('.day-schedule');

            dayButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const day = this.getAttribute('data-day');
                    
                    // Update active button
                    dayButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show corresponding schedule
                    daySchedules.forEach(schedule => {
                        schedule.classList.remove('active');
                        if (schedule.id === `schedule-${day}`) {
                            schedule.classList.add('active');
                        }
                    });
                });
            });

            // Auto-scroll to current day
            const today = new Date().toLocaleString('id-ID', { weekday: 'long' });
            const todayButton = document.querySelector(`.day-btn[data-day="${today}"]`);
            if (todayButton) {
                todayButton.click();
            }
        });
    </script>
    @endsection 