<?php

namespace App\Http\Livewire\Classes;

use App\Jobs\CanceledClass;
use App\Models\Classes;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

/**
 * @permissionResource('Classes')
 */
class IndexComponent extends Component
{
    public $filter = [
        'date' => null,
        'start_time' => null,
        'end_time' => null,
        'status' => false,
        'form' => false,
    ];

    public $items = [];
    public $teachers = [];
    public $class;
    public $teacher;
    public $admin;
    public $user;

    public function mount()
    {
        $this->admin = Auth::user()->groups->where('id', 1)->first() ? true : false;
        $this->user = Auth::user();
        $this->filter['date'] = now()->format('Y-m-d');
    }

    /**
     * @permissionName('Permissions')
     */
    public function render()
    {
        $this->admin = Auth::user()->groups->where('id', 1)->first() ? true : false;
        $this->user = Auth::user();
        $this->getClasses();
        return view('livewire.classes.index-component');
    }

    private function getClasses()
    {
        try {
            $this->items = Classes::when($this->filter['date'], function ($query) {
                $query->where('date', '=', $this->filter['date']);
            })
                ->when($this->filter['start_time'], function ($query) {
                    $query->where('start_time', '>=', $this->filter['start_time']);
                })
                ->when($this->filter['end_time'], function ($query) {
                    $query->where('end_time', '>=', $this->filter['end_time']);
                })
                ->with('students', 'teachers')
                ->get();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function showForm()
    {
        $this->filter['status'] ?
            $this->filter['status'] = false
            : $this->filter['status'] = true;
    }

    private function getTeachers()
    {
        try {
            $this->teachers = User::whereHas('groups', function ($query) {
                $query->where('id', 3);
            })
                ->get();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }


    protected $rules = [
        'class.name' => 'required',
        'class.date' => 'required|date|after:yesterday',
        'class.start_time' => 'required',
        'class.end_time' => 'required|after:class.start_time',
        'class.capacity' => 'required|numeric|min:1',
        'teacher' => 'required',
    ];


    public function createOrUpdate(Classes $class = null)
    {
        $this->class = $class;
        $this->getTeachers();

        $this->filter['form'] ?
            $this->filter['form'] = false
            : $this->filter['form'] = true;
    }

    public function store()
    {
        $this->validate();

        try {
            $classes = Classes::where('date', $this->class->date)->get();

            $classes->each(function ($class) {
                if (($this->class->start_time >= $class->start_time && $this->class->start_time < $class->end_time) || ($this->class->end_time >= $class->start_time && $this->class->end_time <= $class->end_time)) {
                    throw new Exception("Existe aula nesse horário.", 1);
                }
            });

            DB::beginTransaction();
            $this->class->save();
            $this->class->teachers()->attach($this->teacher);
            DB::commit();

            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'success',
                'title' => 'Salvo',
                'message' => ''
            ]);
            $this->filter['form'] = false;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'error',
                'title' => 'Erro',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Classes $class)
    {
        try {
            $studants = $class->students->pluck('id')->toArray();
            CanceledClass::dispatch($studants, ['date' => $class->date]);

            DB::beginTransaction();
            $class->students()->detach();
            $class->teachers()->detach();
            $class->delete();
            DB::commit();
            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'success',
                'title' => 'Sucesso',
                'message' => 'Aula apagada com sucesso'
            ]);
            $this->getClasses();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'error',
                'title' => 'Erro',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function checkIn(Classes $class)
    {
        try {
            if(Carbon::parse($class->date.' '.$class->start_time)->subDay() >= now() || Carbon::parse($class->date.' '.$class->start_time)->subMinutes(30) < now()){
                throw new Exception('O check In só pode ser feito com 24 horas ou 30 minutos de antecedência.');
            }

            DB::beginTransaction();

            $class->students()->attach(Auth::user()->id);

            DB::commit();

            $this->getClasses();
            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'success',
                'title' => 'Sucesso',
                'message' => 'Check In Realizado.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'error',
                'title' => 'Erro',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function cancelCheckIn(Classes $class)
    {
        try {
            if(Carbon::parse($class->date.' '.$class->start_time)->subMinutes(30) <= now()){
                throw new Exception('O check In só pode ser cancelado 30 minutos de antecedência.');
            }

            DB::beginTransaction();
            $class->students()->detach(Auth::user()->id);
            DB::commit();
            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'success',
                'title' => 'Sucesso',
                'message' => 'Check In Cancelado.'
            ]);
            $this->getClasses();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent('Sweetalert2', [
                'type' => 'error',
                'title' => 'Erro',
                'message' => $e->getMessage()
            ]);
        }
    }
}
