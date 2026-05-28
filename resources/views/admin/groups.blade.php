<x-app-layout pageTitle="Manage Groups">

  <div class="lf-fade-up" style="background:linear-gradient(135deg,#F59E0B,#EF4444);
              border-radius:var(--r-xl);padding:2rem 2rem 2rem 2.25rem;
              margin-bottom:2rem;box-shadow:var(--shadow-md)">
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                color:rgba(255,255,255,.7);margin-bottom:.4rem">
      <i class="fa-solid fa-users-gear" style="margin-right:5px"></i> Admin
    </div>
    <div style="font-family:var(--font-head);font-size:1.6rem;font-weight:800;color:#fff;
                letter-spacing:-.03em;margin-bottom:.35rem">Group Management</div>
    <div style="font-size:13px;color:rgba(255,255,255,.75)">
      Create groups, add members, and assign tasks to everyone at once.
    </div>
  </div>

  <livewire:admin-group-manager />

</x-app-layout>
