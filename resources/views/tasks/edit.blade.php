{{-- FILE: resources/views/tasks/edit.blade.php --}}
<x-app-layout pageTitle="Edit Task">
  <div class="lf-wrap-sm">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
      <a href="{{ route('dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
      </a>
      <div>
        <div class="lf-page-title">Edit Task</div>
        <div style="font-size:13px;color:var(--text-secondary)">Update the task details below</div>
      </div>
    </div>

    <div class="lf-card lf-card-p">
      <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf @method('PUT')

        <div style="display:flex;flex-direction:column;gap:1.25rem">

          <div class="lf-form-group">
            <label class="lf-label">Task Title <span style="color:var(--error)">*</span></label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}"
                   placeholder="Task title"
                   class="lf-input {{ $errors->has('title') ? 'lf-input-error' : '' }}">
            @error('title')
              <div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>
            @enderror
          </div>

          <div class="lf-form-group">
            <label class="lf-label">Subtitle</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $task->subtitle) }}"
                   placeholder="Brief description" class="lf-input">
          </div>

          <div class="lf-form-group">
            <label class="lf-label">Description</label>
            <textarea name="description" class="lf-textarea"
                      placeholder="Additional details…">{{ old('description', $task->description) }}</textarea>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="lf-form-group">
              <label class="lf-label">Due Date</label>
              <input type="date" name="due_date"
                     value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                     class="lf-input">
            </div>
            <div class="lf-form-group">
              <label class="lf-label">Priority <span style="color:var(--error)">*</span></label>
              <select name="priority" class="lf-select">
                <option value="low"    {{ old('priority',$task->priority)==='low'    ? 'selected':'' }}>🟢 Low</option>
                <option value="medium" {{ old('priority',$task->priority)==='medium' ? 'selected':'' }}>🟡 Medium</option>
                <option value="high"   {{ old('priority',$task->priority)==='high'   ? 'selected':'' }}>🔴 High</option>
              </select>
            </div>
          </div>

        </div>

        <hr class="lf-divider">

        <div style="display:flex;justify-content:space-between">
          <a href="{{ route('dashboard') }}" class="lf-btn lf-btn-secondary">Cancel</a>
          <button type="submit" class="lf-btn lf-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Save Changes
          </button>
        </div>

      </form>
    </div>
  </div>
</x-app-layout>
