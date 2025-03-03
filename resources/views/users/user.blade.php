@extends('layout')


@section('title', 'Listado de usuarios')

@section('content')
<div class="table-responsive">
    <table  class="table">
        <tr>
            <td>#</td>
            <td>name</td>
            <td>surname</td>
            <td>username</td> 
            <td>email</td> 
            <td>sex</td> 
            <td>date_of_birth</td> 
            <td>phone_number</td> 
            <td>password</td> 
            <td>tokens</td> 
        </tr>

    
    @foreach ($users as $user)
        

    <tr>
            <td>
                <div>
                    <a href="/user/{{ $user->id }}" class="btn btn-primary"><i class="bi bi-search"></i></a>
                    <a href="/user/actualizar/{{ $user->id }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                    <a href="/user/eliminar/{{ $user->id }}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                </div>

            </td>
            <td style="">{{ $user->name }}</td>
            <td>{{ $user->surname }}</td> 
            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $user->surname }}</td> 
            <td>{{ $user->username }}</td> 
    </tr>

    @endforeach

    </table>
    {{ $users->links() }}
</div>
    <a href="/users/nuevo" class="btn btn-success"><i class="bi bi-plus"></i> Nuevo user</a>


@endsection