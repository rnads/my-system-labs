<div>
    @if($filter['status'])
    <div class="card mb-2">
        <div class="card-header">Filtros</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <label>Data</label>
                    <input type="date" wire:model="filter.date" class="form-control">
                </div>
                <div class="col-4">
                    <label>Início</label>
                    <input type="time" wire:model="filter.start_time" class="form-control">
                </div>
                <div class="col-4">
                    <label>Fim</label>
                    <input type="time" wire:model="filter.end_time" class="form-control">
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($filter['form'] && $admin)
    <div class="card mb-2">
        <div class="card-header">Aula</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <label>Nome</label>
                    <input type="text" wire:model="class.name"
                        class="form-control @error('class.name') is-invalid @enderror">
                    @error('class.name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-2">
                    <label>Data</label>
                    <input type="date" wire:model="class.date"
                        class="form-control @error('class.date') is-invalid @enderror">
                    @error('class.date')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-2">
                    <label>Início</label>
                    <input type="time" wire:model="class.start_time"
                        class="form-control @error('class.start_time') is-invalid @enderror">
                    @error('class.start_time')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-2">
                    <label>Fim</label>
                    <input type="time" wire:model="class.end_time"
                        class="form-control @error('class.end_time') is-invalid @enderror">
                    @error('class.end_time')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-2">
                    <label>Capacidade</label>
                    <input type="number" wire:model="class.capacity"
                        class="form-control @error('class.capacity') is-invalid @enderror">
                    @error('class.capacity')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-4">
                    <label>Professor</label>
                    <select wire:model="teacher" class="form-control @error('teacher') is-invalid @enderror">
                        <option value="">Selecione</option>
                        @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('teacher')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-4">
                    <br>
                    <button type="button" class="btn btn-success" wire:click="store()">Salvar</button>
                </div>

            </div>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-9">Aulas Disponíveis</div>
                <div class="col text-right">
                    @if($admin)
                    <button type="button" class="btn btn-primary btn-sm" wire:click="createOrUpdate()">Nova
                        Aula</button>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm" wire:click="showForm()">Filtros</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Dia</th>
                        <th scope="col">Horário</th>
                        <th scope="col">Aula</th>
                        <th scope="col">Professor</th>
                        <th scope="col">Capacidade</th>
                        <th scope="col">Incritos</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->start_time . ' - '. $item->end_time }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->teachers->first()->name }}</td>
                        <td>{{ $item->capacity }}</td>
                        <td class="{{ $item->capacity >= $item->students->count() ? 'text-success' : 'text-danger' }}">
                            {{ $item->students->count() }}</td>
                        <td>

                            <a href="{{ route('show', ['classes' => $item->id]) }}"
                                class="btn btn-primary btn-sm">Detalhes</a>
                            @if($admin)
                            <button type="button" class="btn btn-warning btn-sm"
                                wire:click="createOrUpdate({{ $item->id }})">Editar</button>
                            <button type="button" class="btn btn-danger btn-sm"
                                wire:click="delete({{ $item->id }})">Deletar</button>
                            @else

                            @if ($item->capacity >= $item->students->count())
                            @if($item->students->where('id', $user->id)->first())
                            <button type="button" class="btn btn-danger btn-sm"
                                wire:click="cancelCheckIn({{ $item->id }})">
                                Cancelar Check In
                            </button>
                            @else
                            <button type="button" class="btn btn-primary btn-sm" wire:click="checkIn({{ $item->id }})">
                                Check In
                            </button>
                            @endif
                            @else
                            <p class="text-danger">Sem Vagas</p>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center text-danger">
                        <td colspan="7">Nenhuma aula cadastrada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>