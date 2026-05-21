<div>
  @if(!$showForm)
    <button wire:click="$set('showForm', true)"
            class="lf-btn lf-btn-primary"
            style="margin-bottom:1.5rem">
      <i class="fa-solid fa-plus"></i> Add Task
    </button>
  @else
    <div class="lf-card lf-card-p" style="margin-bottom:1.5rem">
      <div style="font-size:15px;font-weight:700;color:var(--text-primary);margin-bottom:1.25rem">
        {{ $taskId ? 'Edit Task' : 'New Task' }}
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">

        {{-- Title --}}
        <div class="lf-form-group" style="grid-column:1/-1">
          <label class="lf-label" for="tf-title">Title <span style="color:var(--error)">*</span></label>
          <input id="tf-title" type="text" wire:model.live="title"
                 class="lf-input" placeholder="Task title">
          @error('title') <div class="lf-field-error">{{ $message }}</div> @enderror
        </div>

        {{-- Subtitle --}}
        <div class="lf-form-group" style="grid-column:1/-1">
          <label class="lf-label" for="tf-subtitle">Subtitle</label>
          <input id="tf-subtitle" type="text" wire:model.live="subtitle"
                 class="lf-input" placeholder="Optional subtitle">
          @error('subtitle') <div class="lf-field-error">{{ $message }}</div> @enderror
        </div>

        {{-- Description --}}
        <div class="lf-form-group" style="grid-column:1/-1">
          <label class="lf-label" for="tf-description">Description</label>
          <textarea id="tf-description" wire:model.live="description"
                    class="lf-textarea" rows="3"
                    placeholder="Optional description"></textarea>
          @error('description') <div class="lf-field-error">{{ $message }}</div> @enderror
        </div>

        {{-- Due Date --}}
        <div class="lf-form-group">
          <label class="lf-label" for="tf-due-date">Due Date</label>
          <input id="tf-due-date" type="date" wire:model.live="due_date"
                 class="lf-input">
          @error('due_date') <div class="lf-field-error">{{ $message }}</div> @enderror
        </div>

        {{-- Priority --}}
        <div class="lf-form-group">
          <label class="lf-label" for="tf-priority">Priority</label>
          <select id="tf-priority" wire:model.live="priority" class="lf-select">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
          @error('priority') <div class="lf-field-error">{{ $message }}</div> @enderror
        </div>

        {{-- Category --}}
        <div class="lf-form-group" style="grid-column:1/-1">
          <label class="lf-label" for="tf-category">Category</label>
          <select id="tf-category" wire:model.live="category_id" class="lf-select">
            <option value="">No category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id') <div class="lf-field-error">{{ $message }}</div> @enderror
        </div>

      </div>

      {{-- Actions --}}
      <div style="display:flex;gap:.75rem;margin-top:1.25rem">
        <button wire:click="save" class="lf-btn lf-btn-primary">
          <i class="fa-solid fa-floppy-disk"></i>
          {{ $taskId ? 'Update Task' : 'Save Task' }}
        </button>
        <button wire:click="cancel" class="lf-btn lf-btn-secondary">
          Cancel
        </button>
      </div>
    </div>
  @endif
</div>
