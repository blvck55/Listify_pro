{{-- FILE: resources/views/tasks/create.blade.php --}}
<x-app-layout pageTitle="Add Task">

  <div class="lf-wrap-sm">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
      <a href="{{ route('dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
      </a>
      <div>
        <div class="lf-page-title">Add New Task</div>
        <div style="font-size:13px;color:var(--text-secondary)">Fill in the details below</div>
      </div>
    </div>

    <div class="lf-card lf-card-p">

      <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div style="display:flex;flex-direction:column;gap:1.25rem">

          {{-- Title --}}
          <div class="lf-form-group">
            <label class="lf-label">Task Title <span style="color:var(--error)">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}"
                   placeholder="e.g. Review project proposal"
                   class="lf-input {{ $errors->has('title') ? 'lf-input-error' : '' }}">
            @error('title')
              <div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>
            @enderror
          </div>

          {{-- Subtitle --}}
          <div class="lf-form-group">
            <label class="lf-label">Subtitle <span style="color:var(--text-muted);font-weight:400;text-transform:none">(optional)</span></label>
            <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                   placeholder="A brief description" class="lf-input">
          </div>

          {{-- Description --}}
          <div class="lf-form-group">
            <label class="lf-label">Description <span style="color:var(--text-muted);font-weight:400;text-transform:none">(optional)</span></label>
            <textarea name="description" class="lf-textarea"
                      placeholder="Add any additional details…">{{ old('description') }}</textarea>
          </div>

          {{-- Due date + Priority (side by side) --}}
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="lf-form-group">
              <label class="lf-label">Due Date</label>
              <input type="date" name="due_date" value="{{ old('due_date') }}" class="lf-input">
            </div>
            <div class="lf-form-group">
              <label class="lf-label">Priority <span style="color:var(--error)">*</span></label>
              <select name="priority" class="lf-select {{ $errors->has('priority') ? 'lf-input-error' : '' }}">
                <option value="">Select priority</option>
                <option value="low"    {{ old('priority')==='low'    ? 'selected' : '' }}>🟢 Low</option>
                <option value="medium" {{ old('priority')==='medium' ? 'selected' : '' }}>🟡 Medium</option>
                <option value="high"   {{ old('priority')==='high'   ? 'selected' : '' }}>🔴 High</option>
              </select>
              @error('priority')
                <div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>
              @enderror
            </div>
          </div>

        </div>

        <hr class="lf-divider">

        {{-- Actions --}}
        <div style="display:flex;justify-content:space-between;align-items:center">
          <a href="{{ route('dashboard') }}" class="lf-btn lf-btn-secondary">Cancel</a>
          <button type="submit" class="lf-btn lf-btn-primary">
            <i class="fa-solid fa-check"></i> Save Task
          </button>
        </div>

      </form>
    </div>
  </div>

</x-app-layout>
