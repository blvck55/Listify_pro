<x-app-layout pageTitle="Calendar">

  <div class="lf-fade-up" style="background:linear-gradient(135deg,#10B981,#3B82F6);
              border-radius:var(--r-xl);padding:2rem 2rem 2rem 2.25rem;
              margin-bottom:2rem;box-shadow:var(--shadow-md)">
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                color:rgba(255,255,255,.7);margin-bottom:.4rem">
      <i class="fa-regular fa-calendar" style="margin-right:5px"></i> Calendar
    </div>
    <div style="font-family:var(--font-head);font-size:1.6rem;font-weight:800;color:#fff;
                letter-spacing:-.03em;margin-bottom:.35rem">My Calendar</div>
    <div style="font-size:13px;color:rgba(255,255,255,.75)">
      View your tasks and notes across the year. Click any day to see details.
    </div>
  </div>

  <livewire:calendar />

</x-app-layout>
