{{-- FILE: resources/views/tasks/history.blade.php --}}
<x-app-layout pageTitle="Task History">

  {{-- Header --}}
  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">Task History</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        Your full task activity feed
      </div>
    </div>
    <a href="{{ route('dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
  </div>

  {{-- Livewire activity feed --}}
  <livewire:task-history-feed />

</x-app-layout>
