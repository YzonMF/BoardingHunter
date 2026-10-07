@php
    $a = $accommodation ?? null;
    $systemManaged = $a && in_array($a->status, ['reserved', 'booked'], true);
@endphp

<style>
    .listing-form label { display: block; margin-top: 12px; font-weight: bold; }
    .listing-form input[type=text], .listing-form input[type=number], .listing-form select, .listing-form textarea { width: 100%; padding: 8px; box-sizing: border-box; }
    .listing-form .err { color: #b00; font-size: 14px; }
    .listing-form .row2 { display: flex; gap: 16px; }
    .listing-form .row2 > div { flex: 1; }
    .listing-form .hint { color: #666; font-size: 13px; font-weight: normal; }
</style>

<div class="listing-form">
    <label for="Name">Name</label>
    <input type="text" id="Name" name="Name" maxlength="100" value="{{ old('Name', $a->Name ?? '') }}" required>
    @error('Name') <div class="err">{{ $message }}</div> @enderror

    <div class="row2">
        <div>
            <label for="Type">Type</label>
            <select id="Type" name="Type" required>
                @foreach(\App\Models\Accommodation::TYPES as $type)
                    <option value="{{ $type }}" {{ old('Type', $a->Type ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
            @error('Type') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="status">Status</label>
            @if($systemManaged)
                <input type="text" value="{{ ucfirst($a->status) }}" disabled>
                <span class="hint">Managed automatically while a reservation or booking is active.</span>
            @else
                <select id="status" name="status" required>
                    @foreach(['active' => 'Active', 'available' => 'Available', 'inactive' => 'Inactive (hidden from booking)'] as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $a->status ?? 'active') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            @endif
            @error('status') <div class="err">{{ $message }}</div> @enderror
        </div>
    </div>

    <label for="Location">Location</label>
    <input type="text" id="Location" name="Location" maxlength="255" value="{{ old('Location', $a->Location ?? '') }}" required>
    @error('Location') <div class="err">{{ $message }}</div> @enderror

    <div class="row2">
        <div>
            <label for="PricePerNight">Price per night</label>
            <input type="number" id="PricePerNight" name="PricePerNight" min="0" step="0.01" value="{{ old('PricePerNight', $a->PricePerNight ?? '') }}" required>
            @error('PricePerNight') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="PricePerMonth">Price per month</label>
            <input type="number" id="PricePerMonth" name="PricePerMonth" min="0" step="0.01" value="{{ old('PricePerMonth', $a->PricePerMonth ?? '') }}" required>
            @error('PricePerMonth') <div class="err">{{ $message }}</div> @enderror
        </div>
    </div>

    <label for="Description">Description</label>
    <textarea id="Description" name="Description" rows="5" maxlength="5000" required>{{ old('Description', $a->Description ?? '') }}</textarea>
    @error('Description') <div class="err">{{ $message }}</div> @enderror

    @unless($a)
        <label for="amenities">Amenities <span class="hint">(comma separated, e.g. Wi-Fi, Air conditioning, Parking)</span></label>
        <input type="text" id="amenities" name="amenities" maxlength="1000" value="{{ old('amenities') }}">
        @error('amenities') <div class="err">{{ $message }}</div> @enderror
    @endunless

    <label for="photos">Add photos <span class="hint">(up to 10 images, JPG/PNG/WebP, 4 MB each)</span></label>
    <input type="file" id="photos" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple>
    @error('photos') <div class="err">{{ $message }}</div> @enderror
    @foreach($errors->get('photos.*') as $messages)
        @foreach($messages as $message) <div class="err">{{ $message }}</div> @endforeach
    @endforeach
</div>
