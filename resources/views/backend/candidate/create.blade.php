@extends('backend.layouts.app')
@section('title')
    {{ __('create_candidate') }}
@endsection
@section('content')
    @if (userCan('candidate.create'))
        <div class="container-fluid">
            <form action="{{ route('candidate.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title line-height-36">{{ __('create') }}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                {{ __('account_details') }}
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="name" />
                                        <x-forms.input type="text" name="name" placeholder="name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="father_name" />
                                        <x-forms.input type="text" name="father_name" placeholder="father_name" value="{{ old('father_name') }}" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <x-forms.label name="contact_number" :required="false"/>
                                        <x-forms.input type="tel" name="contact_number" placeholder="contact_number" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="email" />
                                        <x-forms.input value="{{ old('email') }}" type="email" name="email"
                                            placeholder="email" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <x-forms.label name="password" :required="false" />
                                            <x-forms.input type="password" name="password" placeholder="password" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            @if (config('templatecookie.map_show'))
                                <div class="card-header">
                                    {{ __('location') }}
                                    <span class="text-red font-weight-bold">*</span>
                                    <small class="h6">
                                        ({{ __('click_to_add_a_pointer') }})
                                    </small>
                                </div>
                                <div class="card-body">
                                    <x-website.map.map-warning />

                                    @php
                                        $map = $setting->default_map;
                                    @endphp
                                    <div id="google-map-div" class="{{ $map == 'google-map' ? '' : 'd-none' }}">
                                        <input id="searchInput" class="mapClass" type="text"
                                            placeholder="Enter a location">
                                        <div class="map mymap" id="google-map"></div>
                                    </div>
                                    <div class="{{ $map == 'leaflet' ? '' : 'd-none' }}">
                                        <input type="text" autocomplete="off" id="leaflet_search"
                                            placeholder="{{ __('enter_city_name') }}" class="form-control" /> <br>
                                        <div id="leaflet-map"></div>
                                    </div>
                                    @error('location')
                                        <span class="ml-3 text-md text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                @php
                                    $location = session()->get('location');

                                @endphp
                                <div class="card-footer location_footer d-none">
                                    <span>
                                        <img src="{{ asset('frontend/assets/images/loader.gif') }}" alt="loading"
                                            width="50px" height="50px" class="loader_position d-none">
                                    </span>
                                    <div class="location_secion">
                                        {{ __('country') }}: <span
                                            class="location_country">{{ $location && array_key_exists('country', $location) ? $location['country'] : '-' }}</span>
                                        <br>
                                        {{ __('full_address') }}: <span
                                            class="location_full_address">{{ $location && array_key_exists('exact_location', $location) ? $location['exact_location'] : '-' }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="card-header border-0">
                                    {{ __('location') }}
                                </div>
                                <div class="card-body pt-0 row">
                                    <div class="col-12">
                                        @livewire('country-state-city')
                                        @error('location')
                                            <span class="ml-3 text-md text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                {{ __('image') }}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-forms.label name="image" :required="false" />
                                        <input name="image" type="file" data-show-errors="true" data-width="100%"
                                            data-default-file="" class="dropify">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
    <div class="card-header">
        {{ __('files') }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
            <div class="form-group">
    <!-- Label for the file input -->
    <x-forms.label name="cv" :required="false" />

    <!-- File input field -->
    <div class="custom-file">
        <input name="cv" type="file" class="custom-file-input @error('cv') is-invalid @enderror" id="cvInputFile">
        <label class="custom-file-label" for="cvInputFile">{{ __('choose_cv') }}</label>

        <!-- Error message for validation errors -->
        @error('cv')
            <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Display selected file name -->
<p id="selectedFileName" style="display: none;"></p>

            </div>
        </div>
    </div>
</div>

                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('profile_details') }}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="profession" :required="false" />
                                            <select name="profession_id" id="profession"
                                                class="select2bs4 form-control @error('profession_id') is-invalid @enderror">
                                                @foreach ($professions as $profession)
                                                    <option {{ $profession->id == old('profession_id') ? 'selected' : '' }}
                                                        value="{{ $profession->id }}">
                                                        {{ $profession->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('profession_id')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="experience" :required="false" />
                                            <select name="experience" id="experience"
                                                class="form-control select2bs4 @error('experience') is-invalid @enderror">
                                                @foreach ($experiences as $experience)
                                                    <option {{ old('experience') == $experience->id ? 'selected' : '' }}
                                                        value="{{ $experience->id }}">{{ $experience->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('experience')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="job_role" :required="false" />
                                            <select name="role_id"
                                                class="form-control select2bs4 @error('role_id') is-invalid @enderror"
                                                id="role_id">
                                                @foreach ($job_roles as $role)
                                                    <option value="{{ $role->id }}"> {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="education" :required="false" />
                                            <select name="education" id="education"
                                                class="form-control select2bs4 @error('education') is-invalid @enderror">
                                                @foreach ($educations as $education)
                                                    <option {{ $education->id == old('education_id') ? 'selected' : '' }}
                                                        value="{{ $education->id }}"> {{ $education->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('education')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="gender" :required="false" />
                                            <select name="gender" id="gender"
                                                class="form-control select2bs4 @error('gender') is-invalid @enderror">
                                                <option value="male">{{ __('male') }}</option>
                                                <option value="female">{{ __('female') }}</option>
                                                <option value="other">{{ __('other') }}</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="place_of_birth" :required="false" />
                                            <input type="text" id="place_of_birth" name="place_of_birth"
                                                value="{{ old('place_of_birth') }}"
                                                class="form-control @error('place_of_birth') is-invalid @enderror"
                                                placeholder="{{ __('place_of_birth') }}">
                                            @error('place_of_birth')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="nationality" :required="false" />
                                            <input type="text" id="nationality" name="nationality"
                                                value="{{ old('nationality') }}"
                                                class="form-control @error('nationality') is-invalid @enderror"
                                                placeholder="{{ __('nationality') }}">
                                            @error('nationality')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="religion" :required="false" />
                                            <input type="text" id="religion" name="religion"
                                                value="{{ old('religion') }}"
                                                class="form-control @error('religion') is-invalid @enderror"
                                                placeholder="{{ __('religion') }}">
                                            @error('religion')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="birth_date" :required="false" />
                                            <input type="text"
                                                class="form-control @error('birth_date') is-invalid @enderror"
                                                name="birth_date" id="birth_date" placeholder="{{ __('birth_date') }}">
                                            @error('birth_date')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="age" :required="false" />
                                            <input type="number" id="age" name="age"
                                                value="{{ old('age') }}"
                                                class="form-control @error('age') is-invalid @enderror"
                                                placeholder="{{ __('age') }}">
                                            @error('age')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="passport_number" :required="false" />
                                            <input type="text" id="passport_number" name="passport_number"
                                                value="{{ old('passport_number') }}"
                                                class="form-control @error('passport_number') is-invalid @enderror"
                                                placeholder="{{ __('passport_number') }}">
                                            @error('passport_number')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                                        <x-forms.label :required="true" name="passport_issue_date"
                                                            class="body-font-4 d-block text-gray-900 rt-mb-8" />
                                                        <div class="fromGroup">
                                                            <div
                                                                class="d-flex align-items-center form-control-icon date datepicker">
                                                                <input type="text" name="passport_issue_date"
                                                                    value="{{old('passport_issue_date') }}"
                                                                    id="issuedate" placeholder="dd/mm/yyyy"
                                                                    class="form-control border-cutom @error('passport_issue_date') is-invalid @enderror" />
                                                                <!-- <span class="input-group-addon input-group-text-custom">
                                                                    <x-svg.calendar-icon />
                                                                </span> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <x-forms.label :required="true" name="passport_expiry_date"
                                                            class="body-font-4 d-block text-gray-900 rt-mb-8" />
                                                        <div class="fromGroup">
                                                            <div
                                                                class="d-flex align-items-center form-control-icon date datepicker">
                                                                <input type="text" name="passport_expiry_date"
                                                                    value="{{old('passport_expiry_date') }}"
                                                                    id="expirydate" placeholder="dd/mm/yyyy"
                                                                    class="form-control border-cutom @error('passport_expiry_date') is-invalid @enderror" />
                                                                <!-- <span class="input-group-addon input-group-text-custom">
                                                                    <x-svg.calendar-icon />
                                                                </span> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                    

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="cnic" :required="false" />
                                            <input type="text" id="cnic" name="cnic"
                                                value="{{ old('cnic') }}"
                                                class="form-control @error('cnic') is-invalid @enderror"
                                                placeholder="{{ __('cnic') }}">
                                            @error('cnic')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="cnic_issue_date" :required="false" />
                                            <input type="date" id="cnic_issue_date" name="cnic_issue_date"
                                                value="{{ old('cnic_issue_date') }}"
                                                class="form-control @error('cnic_issue_date') is-invalid @enderror"
                                                placeholder="{{ __('cnic_issue_date') }}">
                                            @error('cnic_issue_date')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="cnic_expiry_date" :required="false" />
                                            <input type="date" id="cnic_expiry_date" name="cnic_expiry_date"
                                                value="{{ old('cnic_expiry_date') }}"
                                                class="form-control @error('cnic_expiry_date') is-invalid @enderror"
                                                placeholder="{{ __('cnic_expiry_date') }}">
                                            @error('cnic_expiry_date')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                                  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="declaration_statement" :required="false" />
                                            <input type="text" id="declaration_statement" name="declaration_statement"
                                                value="{{ old('declaration_statement') }}"
                                                class="form-control @error('declaration_statement') is-invalid @enderror"
                                                placeholder="{{ __('declaration_statement') }}">
                                            @error('declaration_statement')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="website" :required="false" />
                                            <input type="text" id="website" name="website"
                                                value="{{ old('website') }}"
                                                class="form-control @error('website') is-invalid @enderror"
                                                placeholder="{{ __('website') }}">
                                            @error('website')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    
                                   
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-forms.label name="marital_status" :required="false" />
                                            <select id="marital_status" name="marital_status"
                                                class="form-control select2bs4 @error('marital_status') is-invalid @enderror">
                                                <option value="married">{{ __('married') }}</option>
                                                <option value="single">{{ __('single') }}</option>
                                            </select>
                                            @error('marital_status')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-forms.label name="skills" :required="false" />
                                            <select id="skills" name="skills[]"
                                                class="select2-taggable form-control @error('skills') is-invalid @enderror"
                                                multiple>
                                                @foreach ($skills as $skill)
                                                    <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('skills')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-forms.label name="languages" :required="false" />
                                            <select id="languages" name="languages[]" multiple
                                                class="select2bs4 form-control @error('languages') is-invalid @enderror">
                                                @foreach ($candidate_languages as $language)
                                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('languages')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-forms.label name="bio" :required="false" />
                                            <textarea name="bio" id="image_ckeditor" placeholder="{{ __('bio') }}" value="{{ old('bio') }}"
                                                class="form-control @error('bio') is-invalid @enderror" id="bio" cols="1" rows="4"></textarea>
                                            @error('bio')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-block bg-success">
                            <i class="fas fa-plus mr-1"></i>
                            {{ __('save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap-datepicker.min.css">
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }

        .select2-results__option[aria-selected=true] {
            display: none;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            color: #fff;
            border: 1px solid #fff;
            background: #007bff;
            border-radius: 30px;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }
    </style>
    <!-- >=>Leaflet Map<=< -->
    <x-map.leaflet.map_links />
    <x-map.leaflet.autocomplete_links />

    @include('map::links')
@endsection
@section('frontend_links')
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap-datepicker.min.css">
    <!-- >=>Leaflet Map<=< -->
    <x-map.leaflet.map_links />
    <x-map.leaflet.autocomplete_links />
    @include('map::links')
    <style>
    

        .input-group-text-custom {
            max-height: 48px;
            padding: 12px;
            background-color: #e9ecef;
            border-radius: 0 5px 5px 0;
        }

  
    </style>


@section('script')
    @livewireScripts
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="{{ asset('frontend/assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select21').select2();
        });
        window.addEventListener('render-select2', event => {
            console.log('fired');
            $('.select21').select2();
        })
    </script>

    @stack('js')
    <script src="{{ asset('backend') }}/plugins/dropify/js/dropify.min.js"></script>
    @if (app()->getLocale() == 'ar')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ar.min.js
                                                    "></script>
    @endif
    <script>
        $('#customFile').on('change', function(event) {
            $('#defaulthide').addClass('d-block')
            $('#defaulthide').removeClass('d-none')
        });
        //init datepicker
    $("#issuedate").attr("autocomplete", "off");
    //init datepicker
    $('#issuedate').datepicker({
    format: 'dd-mm-yyyy',
    isRTL: "{{ app()->getLocale() == 'ar' ? true : false }}",
    language: "{{ app()->getLocale() }}",
    endDate: new Date() // Restrict selectable dates up to today
});

      // Listen for the change event on the file input
      document.getElementById('cvInputFile').addEventListener('change', function(event) {
        // Get the selected file
        const selectedFile = event.target.files[0];

        // Display the file name
        const selectedFileNameElement = document.getElementById('selectedFileName');
        selectedFileNameElement.style.display = 'block';
        selectedFileNameElement.textContent = selectedFile ? selectedFile.name : '';
    });
    $("#expirydate").attr("autocomplete", "off");
    //init datepicker
    $('#expirydate').datepicker({
    format: 'dd-mm-yyyy',
    isRTL: "{{ app()->getLocale() == 'ar' ? true : false }}",
    language: "{{ app()->getLocale() }}",
    startDate: new Date() // Restrict selectable dates starting from today
});

        // dropify image
        $('.dropify').dropify();
        //init datepicker
        $(document).ready(function() {
            $('#birth_date').datepicker({
                format: 'dd-mm-yyyy',
                isRTL: "{{ app()->getLocale() == 'ar' ? true : false }}",
                language: "{{ app()->getLocale() }}",
            });
        });
    </script>
    {{-- Leaflet  --}}
    @include('map::set-leafletmap')
    @include('map::set-googlemap')
@endsection
