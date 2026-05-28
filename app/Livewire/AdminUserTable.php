<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

/**
 * Livewire component: AdminUserTable — paginated user table for admins.
 */
class AdminUserTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function getUsers()
    {
        return \App\Models\User::withCount('tasks')
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
            )
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);
    }

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    public function toggleRole(int $id): void
    {
        if ($id === Auth::id()) {
            return;
        }
        $user = \App\Models\User::findOrFail($id);
        $user->update(['role' => $user->role === 'admin' ? 'user' : 'admin']);
    }

    public function deleteUser(int $id): void
    {
        if ($id === Auth::id()) {
            return;
        }
        \App\Models\User::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin-user-table', [
            'users' => $this->getUsers(),
        ]);
    }
}
