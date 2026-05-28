<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Livewire component: NotesList — list and edit quick user notes.
 */
class NotesList extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;
    public string $title = '';
    public string $content = '';
    public string $color = '#3B82F6';
    public string $note_date = '';

    public string $search = '';

    protected function rules(): array
    {
        return [
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string',
            'color'     => 'required|string|size:7',
            'note_date' => 'nullable|date',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'title', 'content', 'note_date']);
        $this->color = '#3B82F6';
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $this->editingId  = $note->id;
        $this->title      = $note->title;
        $this->content    = $note->content ?? '';
        $this->color      = $note->color;
        $this->note_date  = $note->note_date?->format('Y-m-d') ?? '';
        $this->showForm   = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'user_id'   => Auth::id(),
            'title'     => $this->title,
            'content'   => $this->content ?: null,
            'color'     => $this->color,
            'note_date' => $this->note_date ?: null,
        ];

        if ($this->editingId) {
            Note::where('user_id', Auth::id())->findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Note updated.');
        } else {
            Note::create($data);
            session()->flash('success', 'Note created.');
        }

        $this->cancel();
    }

    public function togglePin(int $id): void
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->update(['is_pinned' => ! $note->is_pinned]);
    }

    public function delete(int $id): void
    {
        Note::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('success', 'Note deleted.');
    }

    public function cancel(): void
    {
        $this->reset(['showForm', 'editingId', 'title', 'content', 'note_date']);
        $this->color = '#3B82F6';
    }

    public function render()
    {
        $notes = Auth::user()->notes()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('content', 'like', "%{$this->search}%"))
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();

        return view('livewire.notes-list', compact('notes'));
    }
}
