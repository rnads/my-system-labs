<div>
    <div class="container">

        @if($form)
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <label>Nome</label>
                        <input type="text" wire:model="user.name"
                            class="form-control @error('user.name') is-invalid @enderror">
                        @error('user.name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-5">
                        <label>Email</label>
                        <input type="text" wire:model="user.email"
                            class="form-control @error('user.email') is-invalid @enderror">
                        @error('user.email')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-2">
                        <br>
                        <button class="btn btn-success btn-sm" wire:click="store()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card  p-0">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">
                            <button class="btn btn-primary btn-sm" wire:click="createOrUpdate()">Novo</button>
                        </th>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Criado em:</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" wire:click="createOrUpdate({{ $item->id }})">Editar</button>
                            <button type="button" class="btn btn-danger btn-sm" wire:click="delete({{ $item->id }})">Deletar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>