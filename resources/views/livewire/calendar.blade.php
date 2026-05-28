<div>
  {{-- Header: year + month nav --}}
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:.75rem">
    <div style="display:flex;align-items:center;gap:.5rem">
      <button wire:click="prevYear" class="lf-icon-btn" title="Previous year"><i class="fa-solid fa-angles-left"></i></button>
      <button wire:click="prevMonth" class="lf-icon-btn" title="Previous month"><i class="fa-solid fa-angle-left"></i></button>
      <div style="font-family:var(--font-head);font-size:1.3rem;font-weight:800;color:var(--text-primary);min-width:200px;text-align:center">
        {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}
      </div>
      <button wire:click="nextMonth" class="lf-icon-btn" title="Next month"><i class="fa-solid fa-angle-right"></i></button>
      <button wire:click="nextYear" class="lf-icon-btn" title="Next year"><i class="fa-solid fa-angles-right"></i></button>
    </div>
    <div style="display:flex;gap:1rem;font-size:12px;color:var(--text-muted)">
      <span><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--brand);margin-right:4px"></span>Task</span>
      <span><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#8B5CF6;margin-right:4px"></span>Note</span>
    </div>
  </div>

  {{-- Day-of-week headers --}}
  <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px;margin-bottom:4px">
    @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
      <div style="text-align:center;font-size:11px;font-weight:700;color:var(--text-muted);padding:.4rem 0;text-transform:uppercase;letter-spacing:.05em">
        {{ $d }}
      </div>
    @endforeach
  </div>

  {{-- Calendar grid --}}
  <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px">
    {{-- Empty leading cells --}}
    @for($i = 0; $i < $firstDow; $i++)
      <div style="min-height:80px"></div>
    @endfor

    @for($day = 1; $day <= $daysInMonth; $day++)
      @php
        $date     = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
        $isToday  = $date === now()->format('Y-m-d');
        $isSelected = $date === $selectedDate;
        $dayTasks = $tasks[$date] ?? collect();
        $dayNotes = $notes[$date] ?? collect();
        $hasItems = $dayTasks->isNotEmpty() || $dayNotes->isNotEmpty();
      @endphp
      <div wire:click="selectDate('{{ $date }}')"
           style="min-height:80px;border-radius:var(--r-md);padding:.4rem;cursor:pointer;position:relative;
                  transition:background .15s;
                  border:2px solid {{ $isSelected ? 'var(--brand)' : ($isToday ? 'var(--brand)' : 'transparent') }};
                  background:{{ $isSelected ? 'var(--bg-surface)' : ($hasItems ? 'var(--bg-surface)' : 'transparent') }}"
           class="lf-hover-bg">
        <div style="font-size:12px;font-weight:{{ $isToday ? '800' : '600' }};
                    color:{{ $isToday ? 'var(--brand)' : 'var(--text-primary)' }};margin-bottom:4px">
          {{ $day }}
        </div>

        @foreach($dayTasks->take(2) as $task)
          <div style="font-size:10px;background:var(--brand);color:#fff;border-radius:3px;
                      padding:1px 4px;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
            {{ $task->title }}
          </div>
        @endforeach

        @foreach($dayNotes->take(2) as $note)
          <div style="font-size:10px;background:#8B5CF6;color:#fff;border-radius:3px;
                      padding:1px 4px;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
            {{ $note->title }}
          </div>
        @endforeach

        @if($dayTasks->count() + $dayNotes->count() > 4)
          <div style="font-size:9px;color:var(--text-muted);text-align:right">
            +{{ $dayTasks->count() + $dayNotes->count() - 4 }} more
          </div>
        @endif
      </div>
    @endfor
  </div>

  {{-- Selected date detail --}}
  @if($selectedDate)
  <div class="lf-card lf-card-p" style="margin-top:1.5rem">
    <div style="font-size:15px;font-weight:700;color:var(--text-primary);margin-bottom:1rem">
      {{ \Carbon\Carbon::parse($selectedDate)->format('l, d F Y') }}
    </div>

    @if($selectedTasks->isNotEmpty())
    <div style="margin-bottom:1rem">
      <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;
                  color:var(--brand);margin-bottom:.5rem">Tasks</div>
      @foreach($selectedTasks as $task)
      <div style="display:flex;align-items:center;gap:.75rem;padding:.6rem 0;border-bottom:1px solid var(--border)">
        <span class="lf-badge lf-badge-{{ $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'gray') }}">
          {{ $task->priority }}
        </span>
        <span style="font-size:13px;color:var(--text-primary);font-weight:600;flex:1">{{ $task->title }}</span>
        <span class="lf-badge lf-badge-{{ $task->status === 'completed' ? 'green' : 'gray' }}">
          {{ $task->status }}
        </span>
      </div>
      @endforeach
    </div>
    @endif

    @if($selectedNotes->isNotEmpty())
    <div>
      <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;
                  color:#8B5CF6;margin-bottom:.5rem">Notes</div>
      @foreach($selectedNotes as $note)
      <div style="display:flex;align-items:start;gap:.75rem;padding:.6rem 0;border-bottom:1px solid var(--border)">
        <span style="width:10px;height:10px;border-radius:50%;background:{{ $note->color }};flex-shrink:0;margin-top:3px"></span>
        <div>
          <div style="font-size:13px;font-weight:600;color:var(--text-primary)">{{ $note->title }}</div>
          @if($note->content)
            <div style="font-size:12px;color:var(--text-secondary);margin-top:2px">{{ Str::limit($note->content, 120) }}</div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @endif

    @if($selectedTasks->isEmpty() && $selectedNotes->isEmpty())
      <div style="color:var(--text-muted);font-size:13px">Nothing scheduled for this day.</div>
    @endif
  </div>
  @endif
</div>
