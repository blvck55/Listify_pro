<div>
  {{-- Search + Add --}}
  <div style="display:flex;gap:1rem;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap">
    <div style="flex:1;min-width:200px;position:relative">
      <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:13px"></i>
      <input wire:model.live="search" type="text" placeholder="Search notes…"
             class="lf-input" style="padding-left:36px">
    </div>
    @if(!$showForm)
      <button wire:click="openCreate" class="lf-btn lf-btn-primary">
        <i class="fa-solid fa-plus"></i> New Note
      </button>
    @endif
  </div>

  {{-- Form --}}
  @if($showForm)
  <div class="lf-card lf-card-p lf-form-slide" style="margin-bottom:1.5rem;border-left:4px solid {{ $color }}">
    <div style="font-size:15px;font-weight:700;color:var(--text-primary);margin-bottom:1.25rem">
      {{ $editingId ? 'Edit Note' : 'New Note' }}
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
      <div class="lf-form-group" style="grid-column:1/-1">
        <label class="lf-label">Title <span style="color:var(--error)">*</span></label>
        <input wire:model.live="title" type="text" class="lf-input" placeholder="Note title">
        @error('title') <div class="lf-field-error">{{ $message }}</div> @enderror
      </div>
      <div class="lf-form-group" style="grid-column:1/-1">
        <label class="lf-label">Content</label>
        <textarea wire:model.live="content" class="lf-textarea" rows="4" placeholder="Write your note…"></textarea>
      </div>
      <div class="lf-form-group">
        <label class="lf-label">Date (optional)</label>
        <input wire:model.live="note_date" type="date" class="lf-input">
      </div>
      <div class="lf-form-group">
        <label class="lf-label">Colour</label>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;margin-top:4px">
          @foreach(['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#6B7280'] as $c)
            <button wire:click="$set('color','{{ $c }}')" type="button"
                    style="width:28px;height:28px;border-radius:50%;background:{{ $c }};border:3px solid {{ $color === $c ? 'var(--text-primary)' : 'transparent' }};cursor:pointer"></button>
          @endforeach
        </div>
      </div>
    </div>
    <div style="display:flex;gap:.75rem;margin-top:1.25rem">
      <button wire:click="save" class="lf-btn lf-btn-primary">
        <i class="fa-solid fa-floppy-disk"></i> {{ $editingId ? 'Update' : 'Save' }}
      </button>
      <button wire:click="cancel" class="lf-btn lf-btn-secondary">Cancel</button>
    </div>
  </div>
  @endif

  {{-- Notes Grid --}}
  @if($notes->isEmpty())
    <div style="text-align:center;padding:3rem 1rem;color:var(--text-muted)">
      <i class="fa-regular fa-note-sticky" style="font-size:2.5rem;margin-bottom:1rem;display:block"></i>
      <div style="font-size:15px;font-weight:600">No notes yet</div>
      <div style="font-size:13px;margin-top:.25rem">Click "New Note" to get started</div>
    </div>
  @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem">
      @foreach($notes as $note)
      <div class="lf-card" style="border-left:4px solid {{ $note->color }};padding:1.25rem;position:relative">
        {{-- Pin badge --}}
        @if($note->is_pinned)
          <span style="position:absolute;top:10px;right:10px;font-size:11px;color:{{ $note->color }}">
            <i class="fa-solid fa-thumbtack"></i>
          </span>
        @endif

        <div style="font-size:15px;font-weight:700;color:var(--text-primary);margin-bottom:.5rem;padding-right:20px">
          {{ $note->title }}
        </div>

        @if($note->content)
          <div style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:.75rem;
                      display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;overflow:hidden">
            {{ $note->content }}
          </div>
        @endif

        @if($note->note_date)
          <div style="font-size:11px;color:var(--text-muted);margin-bottom:.75rem">
            <i class="fa-regular fa-calendar" style="margin-right:4px"></i>
            {{ $note->note_date->format('d M Y') }}
          </div>
        @endif

        <div style="display:flex;gap:.5rem;border-top:1px solid var(--border);padding-top:.75rem;margin-top:auto">
          <button wire:click="togglePin({{ $note->id }})" class="lf-btn lf-btn-ghost lf-btn-sm"
                  title="{{ $note->is_pinned ? 'Unpin' : 'Pin' }}">
            <i class="fa-solid fa-thumbtack" style="{{ $note->is_pinned ? 'color:'.e($note->color) : 'opacity:.4' }}"></i>
          </button>
          <button wire:click="edit({{ $note->id }})" class="lf-btn lf-btn-ghost lf-btn-sm">
            <i class="fa-solid fa-pen"></i> Edit
          </button>
          <button wire:click="delete({{ $note->id }})" class="lf-btn lf-btn-ghost lf-btn-sm"
                  style="color:var(--error);margin-left:auto"
                  onclick="return confirm('Delete this note?')">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      </div>
      @endforeach
    </div>
  @endif
</div>
