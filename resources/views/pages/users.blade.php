@extends('adminlte::page')


@section('content_header')
    <h1 class="m-0 text-dark">Gerenciar Usuários</h1>
@stop


@section('content')
<users :groups="{{$usersGroup}}"></users>
@stop
