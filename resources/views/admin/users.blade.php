{{-- FILE: resources/views/admin/users.blade.php --}}
<x-app-layout pageTitle="User Management">

  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">User Management</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        Manage all registered users
      </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
  </div>

  <livewire:admin-user-table />

</x-app-layout>
