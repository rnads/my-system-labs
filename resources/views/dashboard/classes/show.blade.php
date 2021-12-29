@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card mb-2">
    <div class="card-header">
     <div class="row">
       <div class="col-11">
        <h5>{{ $classes->name }}</h5>
       </div>
       <div class="col-1">
         <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Voltar</a>
       </div>
     </div>
    </div>
      <div class="card-body">
          <div class="row text-center">
              <div class="col-2">
                  <label>Dia</label> <br>
                 <p>{{ $classes->date }}</p>
              </div>

              <div class="col-2">
                <label>Início</label><br>
                {{ $classes->start_time }}
              </div>

              <div class="col-2">
                <label>Fim</label><br>
                {{ $classes->end_time }}
              </div>

              <div class="col-2">
                <label>Capacidade</label><br>
                {{ $classes->capacity }}
              </div>

              <div class="col-2">
                <label>Professor</label><br>
                {{ $classes->teachers->first()->name }}
              </div>

              <div class="col-2">
                <label>Inscritos</label><br>
                {{ $classes->students->count() }}
              </div>
          </div>
      </div>
  </div>

  <div class="card  p-0">
    <div class="card-header">
      Alunos Inscritos
    </div>
    <div class="card-body text-center">
      <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th scope="col">Aluno</th>
                <th scope="col">E-mail</th>
                <th scope="col">Inscrito e:</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes->students as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->pivot->created_at->format('d/m/Y H:i') }}</td>
            @endforeach
        </tbody>
    </table>
    </div>
  </div>
</div>
@endsection
