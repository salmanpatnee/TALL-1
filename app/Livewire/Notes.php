<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use App\Models\Notes as ModelsNotes;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Notes extends Component
{
    use WithPagination;

    #[Url(except: false)]
    public $isActive = false;

    #[Url(except: '')]
    public $s = '';

    #[Url(except: '')]
    public $column = 'id';

    #[Url(except: 'ASC')]
    public $sortOrder = 'ASC';

    #[Validate('required')]
    public $body = '';

    #[Validate('required')]
    public $priority = 'low';

    public $confirmingNoteDeletion = 0;
    public $confirmingNoteAdd = 0;
    public $editMode = false;
    public $note;

    public function render()
    {
        $notes = ModelsNotes::where('user_id', auth()->user()->id)
            ->when($this->s, function ($query) {
                return $query->where('body', 'like', '%' . $this->s . '%');
            })
            ->when($this->isActive, function ($query) {
                return $query->active();
            })
            ->orderBy($this->column, $this->sortOrder)
            ->paginate(10);

        return view('livewire.notes', [
            'notes' => $notes
        ]);
    }

    public function sort($column)
    {
        $this->sortOrder = $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
        $this->column = $column;
    }

    public function confirmNoteDeletion(int $id)
    {
        $this->confirmingNoteDeletion = $id;
    }

    public function confirmNoteSave()
    {
        $this->editMode = false;
        $this->confirmingNoteAdd = true;
    }

    public function deleteNote(ModelsNotes $note)
    {
        $note->delete();
        $this->confirmingNoteDeletion = false;

        session()->flash('message', 'Note deleted.');
    }

    public function saveNote()
    {
        $this->validate();
       
        if ($this->editMode) {

            $this->note->update([
                'body' => $this->body,
                'priority' => $this->priority,
            ]);

            session()->flash('message', 'Note updated.');

        } else {
            auth()->user()->notes()->create(
                [
                    'body' => $this->body,
                    'priority' => $this->priority,
                ]
                );
                session()->flash('message', 'Note added.');
        }


        $this->confirmingNoteAdd = false;
    }

    public function edit(ModelsNotes $note)
    {
        $this->editMode = true;
        $this->note = $note;

        $this->body = $this->note->body;
        $this->priority = strtolower($this->note->priority);

        $this->confirmingNoteAdd = true;
    }
}
