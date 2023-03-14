@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <v-app>
                <six-fournine
                    :sixfournine = "{{ $sixfournine }}"
                />
            </v-app>
        </div>
    </div>
</div>
@endsection

