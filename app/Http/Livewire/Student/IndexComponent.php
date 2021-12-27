<?php

namespace App\Http\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class IndexComponent extends Component
{
    public $items = [];
    public $user;
    public $form = false;

    public function render()
    {
        $this->getStudents();
        return view('livewire.student.index-component');
    }

    private function getStudents()
    {
        try {
            $this->items = User::whereHas('groups', function ($query) {
                $query->where('id', 2);
            })
                ->get();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required|email',
    ];

    public function createOrUpdate(User $user = null)
    {
        $this->form ?
            $this->form = false
            : $this->form = true;

        $this->user = $user;
    }

    public function store()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $groups = $this->user->groups->pluck('id')->toArray() ?? '';

            if (!$this->user->id) {
                $this->user->password = bcrypt('123456');
            }

            $this->user->save();

            if (!$groups) {
                $this->user->groups()->sync(['group_id' => 2]);
            }

            DB::commit();

            $this->form = false;

            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'success',
                'title' => 'Salvo',
                'message' => ''
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->form = false;

            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'error',
                'title' => 'Erro',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(User $user)
    {
        try {
            DB::beginTransaction();

            $user->groups()->detach();
            $user->checkins()->detach();
            $user->delete();

            DB::commit();

            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'success',
                'title' => 'Sucesso',
                'message' => ''
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'error',
                'title' => 'Erro',
                'message' => $e->getMessage()
            ]);
        }
    }
}
