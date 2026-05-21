<div>
  {{-- Existing category chips --}}
  @if($categories->isNotEmpty())
    <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem">
      @foreach($categories as $cat)
        <div style="display:inline-flex;align-items:center;gap:6px;
                    background:var(--bg-card);border:1px solid var(--border);
                    border-radius:var(--r-xl);padding:5px 10px 5px 8px;font-size:13px">
          <div style="width:10px;height:10px;border-radius:50%;background:{{ $cat->colour }};flex-shrink:0"></div>
          <span style="font-weight:600;color:var(--text-primary)">{{ $cat->name }}</span>
          <span style="color:var(--text-muted);font-size:11px">({{ $cat->tasks_count }})</span>
          <button wire:click="delete({{ $cat->id }})"
                  wire:confirm="Delete category '{{ addslashes($cat->name) }}'? This cannot be undone."
                  style="background:none;border:none;cursor:pointer;color:var(--text-muted);
                         padding:0;margin-left:2px;line-height:1;font-size:12px"
                  title="Delete category">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      @endforeach
    </div>
  @endif

  {{-- Add category button / form --}}
  @if(!$showForm)
    <button wire:click="$set('showForm', true)"
            class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-plus"></i> Add category
    </button>
  @else
    <div style="display:flex;align-items:flex-end;gap:.75rem;flex-wrap:wrap;
                background:var(--bg-card);border:1px solid var(--border);
                border-radius:var(--r-md);padding:1rem;margin-top:.5rem">

      <div class="lf-form-group" style="flex:1;min-width:160px;margin-bottom:0">
        <label class="lf-label">Category Name</label>
        <input type="text" wire:model.live="name"
               class="lf-input" placeholder="e.g. Work"
               style="height:38px">
        @error('name') <div class="lf-field-error">{{ $message }}</div> @enderror
      </div>

      <div class="lf-form-group" style="margin-bottom:0">
        <label class="lf-label">Colour</label>
        <input type="color" wire:model.live="colour"
               style="height:38px;width:48px;padding:2px;border:1px solid var(--border);
                      border-radius:var(--r-sm);cursor:pointer;background:var(--bg-input)">
        @error('colour') <div class="lf-field-error">{{ $message }}</div> @enderror
      </div>

      <div style="display:flex;gap:.5rem;margin-bottom:0">
        <button wire:click="save" class="lf-btn lf-btn-primary lf-btn-sm">
          Save
        </button>
        <button wire:click="$set('showForm', false)" class="lf-btn lf-btn-secondary lf-btn-sm">
          Cancel
        </button>
      </div>

    </div>
  @endif
</div>
