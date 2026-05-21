<?php

namespace App\Livewire;

use Livewire\Component;

class CategoryManager extends Component
{
    public string $name = '';
    public string $colour = '#3B82F6';
    public bool $showForm = false;

    protected $rules = [
        'name'   => 'required|string|max:50',
        'colour' => 'required|string|max:7',
    ];

    public function getCategories()
    {
        return \App\Models\Category::where('user_id', auth()->id())
            ->withCount('tasks')
            ->get();
    }

    public function save()
    {
        $this->validate();

        \App\Models\Category::create([
            'user_id' => auth()->id(),
            'name'    => $this->name,
            'colour'  => $this->colour,
        ]);

        $this->reset(['name', 'colour', 'showForm']);
        $this->dispatch('categorySaved');
    }

    public function delete(int $id)
    {
        $cat = \App\Models\Category::where('user_id', auth()->id())->findOrFail($id);
        $cat->delete();
    }

    public function render()
    {
        return view('livewire.category-manager', [
            'categories' => $this->getCategories(),
        ]);
    }
}
