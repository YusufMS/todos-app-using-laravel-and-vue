@extends('layouts.app')

@section('content')

<h3>Add Todo</h3><br><br>
<list-todos v-bind:todos_db="{{$todos}}"></list-todos>
<br><br>
<h3>Edit and Delete</h3><br><br>
    
@endsection