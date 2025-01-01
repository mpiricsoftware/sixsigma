<x-form-section submit="updateProfileInformation">
  <x-slot name="title">
    {{ __('Profile Information') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Update your account\'s profile information and email address.') }}
  </x-slot>

  <x-slot name="form">
    <x-action-message on="saved">
      {{ __('Saved.') }}
    </x-action-message>

    <!-- Profile Photo -->
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
      <div class="mb-6" x-data="{photoName: null, photoPreview: null}">
        <!-- Profile Photo File Input -->
        <input type="file" hidden wire:model.live="photo" x-ref="photo"
          x-on:change=" photoName = $refs.photo.files[0].name; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result;}; reader.readAsDataURL($refs.photo.files[0]);" />

        <!-- Current Profile Photo -->
        <div class="mt-2" x-show="! photoPreview">
          <img src="{{ $this->user->profile_photo_url }}" class="rounded-circle" height="80px" width="80px">
        </div>

        <!-- New Profile Photo Preview -->
        <div class="mt-2" x-show="photoPreview">
          <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
        </div>

        <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
          {{ __('Select A New Photo') }}
        </x-secondary-button>

        @if ($this->user->profile_photo_path)
          <button type="button" class="btn btn-danger mt-2" wire:click="deleteProfilePhoto">
            {{ __('Remove Photo') }}
          </button>
        @endif

        <x-input-error for="photo" class="mt-2" />
      </div>
    @endif

    <!-- Profile Form Fields -->
    <div class="row">
      <div class="col-md-6 mb-5">
        <x-label class="form-label" for="name" value="{{ __('Name') }}" />
        <x-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
          wire:model="state.name" autocomplete="name" />
        <x-input-error for="name" />
      </div>

      <div class="col-md-6 mb-5">
        <x-label class="form-label" for="email" value="{{ __('Email') }}" />
        <x-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
          wire:model="state.email" />
        <x-input-error for="email" />
      </div>
    </div>

    <div class="mb-5">
      <x-label class="form-label" for="address" value="{{ __('Address') }}" />
      <x-input id="address" type="text" class="{{ $errors->has('address') ? 'is-invalid' : '' }}"
        wire:model="state.address" />
      <x-input-error for="address" />
    </div>

    <!-- Country, State, and City Dropdowns -->
    <div class="row">
      <div class="col-md-4 mb-5">
        <x-label class="form-label" for="Country" value="{{ __('Country') }}" />
        <select id="country" class="form-select" onchange="updateStates()"  wire:model="state.Country">
          <option value="">Select Country</option>
          @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->name }}</option>
          @endforeach
        </select>
        <x-input-error for="country" />
      </div>

      <div class="col-md-4 mb-5">
        <x-label class="form-label" for="state" value="{{ __('State') }}" />
        <select id="state" class="form-select" name="state" onchange="updateCities()"  wire:model="state.state">
          <option value="">Select State</option>
        </select>
        <x-input-error for="state" />
      </div>

      <div class="col-md-4 mb-5">
        <x-label class="form-label" for="city" value="{{ __('City') }}" />
        <select id="city" class="form-select" name="city"   wire:model="state.city">
          <option value="">Select City</option>
        </select>
        <x-input-error for="city" />
      </div>
    </div>
  </x-slot>

  <x-slot name="actions">
    <div class="d-flex align-items-baseline">
      <x-button>
        {{ __('Save') }}
      </x-button>
    </div>
  </x-slot>
</x-form-section>

<script>
  function updateStates() {
    const countryId = document.getElementById('country').value;
    const stateDropdown = document.getElementById('state');
    const cityDropdown = document.getElementById('city');

    // Clear existing state and city options
    stateDropdown.innerHTML = '<option value="">Select State</option>';
    cityDropdown.innerHTML = '<option value="">Select City</option>';

    if (countryId) {
        fetch(`/states/${countryId}`)
            .then(response => response.json())
            .then(states => {
                if (states.length > 0) {
                    states.forEach(state => {
                        const option = document.createElement('option');
                        option.value = state.id;
                        option.textContent = state.name;
                        stateDropdown.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.textContent = "No states found";
                    option.disabled = true;
                    stateDropdown.appendChild(option);
                }
            })
            .catch(error => console.error('Error fetching states:', error));
    }
}

function updateCities() {
    const stateId = document.getElementById('state').value;
    const cityDropdown = document.getElementById('city');

    // Clear existing city options
    cityDropdown.innerHTML = '<option value="">Select City</option>';

    if (stateId) {
        fetch(`/cities/${stateId}`)
            .then(response => response.json())
            .then(cities => {
                if (cities.length > 0) {
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        cityDropdown.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.textContent = "No cities found";
                    option.disabled = true;
                    cityDropdown.appendChild(option);
                }
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
}

</script>
