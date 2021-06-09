@extends('layouts.app')

@push('scripts')
    <script>
        /**
         * Populate state list
         */
        $('#country_id').on('change', function() {
            $.get( `/country/${this.value}/states`, function( data ) {
                let res = JSON.parse(data);
                let statesList = $('#state_id');
                statesList.find('option').remove().end();
                statesList.append(new Option('Select State', ''));
                $.each( res, function( key, value ) {
                    statesList.append(new Option(value, key));
                });

            });
        });

        /**
         * Populate city list
         */
        $('#state_id').on('change', function() {
            $.get( `/state/${this.value}}/city`, function( data ) {
                let res = JSON.parse(data);
                let citiesList = $('#city_id');
                citiesList.find('option').remove().end();
                citiesList.append(new Option('Select City', ''));
                $.each( res, function( key, value ) {
                    citiesList.append(new Option(value, key));
                });

            });
        });
    </script>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('labels.cell_phone_number') }}</label>
                            <div class="col-md-6">
                                <input id="phone_number" type="number" maxlength="10" class="form-control @error('phone_number') is-invalid @enderror " name="phone_number" value="{{ old('phone_number') }}">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num_doc_identity" class="col-md-4 col-form-label text-md-right">{{ __('labels.num_doc_identity') }}</label>
                            <div class="col-md-6">
                                <input id="num_doc_identity" type="text" maxlength="11" class="form-control @error('num_doc_identity') is-invalid @enderror " name="num_doc_identity" value="{{ old('num_doc_identity') }}" required >

                                @error('num_doc_identity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ __('labels.date_of_birth') }}</label>
                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required>

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('labels.countries') }}</label>
                            <div class="col-md-6">
                                <select id="country_id" name="country_id" class="form-control">
                                    <option>Select your country</option>
                                    @forelse($countries as $country)
                                        <option value="{!! $country->id !!}">{!! $country->name !!}</option>
                                    @empty
                                        <option>No countries found</option>
                                    @endforelse
                                </select>

                                @error('country_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state_id" class="col-md-4 col-form-label text-md-right">{{ __('labels.states') }}</label>
                            <div class="col-md-6">
                                <select id="state_id" name="state_id" class="form-control">
                                    <option>Select country first</option>
                                </select>

                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city_id" class="col-md-4 col-form-label text-md-right">{{ __('labels.cities') }}</label>
                            <div class="col-md-6">
                                <select id="city_id" name="city_id" class="form-control @error('city_id') is-invalid @enderror ">
                                    <option>Select state first</option>
                                </select>

                                @error('city_id')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="flag_admin" class="col-md-4 col-form-label text-md-right">{{ __('labels.role') }}</label>
                            <div class="col-md-6">
                                <select id="flag_admin" name="flag_admin" class="form-control @error('flag_admin') is-invalid @enderror ">
                                    <option value="1">Administrator</option>
                                    <option value="0">Staff</option>
                                </select>

                                @error('flag_admin')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
