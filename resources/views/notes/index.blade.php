<x-app-layout pageTitle="My Notes">

  <div class="lf-fade-up" style="background:linear-gradient(135deg,#8B5CF6,#6366F1);
              border-radius:var(--r-xl);padding:2rem 2rem 2rem 2.25rem;
              margin-bottom:2rem;box-shadow:var(--shadow-md)">
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                color:rgba(255,255,255,.7);margin-bottom:.4rem">
      <i class="fa-regular fa-note-sticky" style="margin-right:5px"></i> Notes
    </div>
    <div style="font-family:var(--font-head);font-size:1.6rem;font-weight:800;color:#fff;
                letter-spacing:-.03em;margin-bottom:.35rem">My Notes</div>
    <div style="font-size:13px;color:rgba(255,255,255,.75)">
      Capture ideas, reminders, and anything worth remembering.
    </div>
  </div>

  <livewire:notes-list />

</x-app-layout>
