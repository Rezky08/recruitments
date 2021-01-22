@extends('template')
@section('title',$title)
@push('main')
<div class="hero is-fullheight is-primary">
    <div class="hero-body">
        <div class="container">
            <div class="box">
                <div class="block has-text-centered">
                    <span class="is-size-3 has-text-weight-bold">{{$title}}</span>
                </div>
                <form action="" method="POST">
                    @csrf
                    {{-- name field --}}
                    <div class="field">
                        <label class="label">name</label>
                        <div class="control">
                            <input class="input" type="text" name="name" placeholder="Place your name">
                            @error('name')
                                <span class="help is-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- email field --}}
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email" name="email" placeholder="Place your email">
                            @error('email')
                                <span class="help is-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- password field --}}
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" type="password" name="password">
                            @error('password')
                                <span class="help is-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- password field --}}
                    <div class="field">
                        <label class="label">Password Confirmation</label>
                        <div class="control">
                            <input class="input" type="password" name="password_confirmation">
                        </div>
                    </div>

                    <div class="field">
                        <button class="button is-primary is-fullwidth">Register</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endpush
