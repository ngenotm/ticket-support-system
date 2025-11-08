<div class="row g-3">
    {{-- Category --}}
    <div class="col-md-4">
        <label class="form-label">Category</label>
        <select name="cat_id" id="cat_id" class="form-select" required>
            <option value="">Select Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('cat_id', $ticket->cat_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Subcategory --}}
    <div class="col-md-4">
        <label class="form-label">Subcategory</label>
        <select name="subcat_id" id="subcat_id" class="form-select" data-selected="{{ old('subcat_id', $ticket->subcat_id ?? '') }}">
            <option value="">Select Subcategory</option>
        </select>
    </div>

    {{-- Service --}}
    <div class="col-md-4">
        <label class="form-label">Service</label>
        <select name="service_id" id="service_id" class="form-select" data-selected="{{ old('service_id', $ticket->service_id ?? '') }}">
            <option value="">Select Service</option>
        </select>
    </div>

    {{-- Title --}}
    <div class="col-md-12">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $ticket->title ?? '') }}" required>
    </div>

    {{-- Description --}}
    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="ticket_body" class="form-control" rows="4" required>{{ old('ticket_body', $ticket->ticket_body ?? '') }}</textarea>
    </div>

    {{-- Assign --}}
    <div class="col-md-6">
        <label class="form-label">Assign To</label>
        <select name="assigned_to" class="form-select">
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('assigned_to', $ticket->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->username }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Priority --}}
    <div class="col-md-6">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-select">
            @foreach(['Low','Medium','High','Urgent'] as $p)
                <option value="{{ $p }}" {{ old('priority', $ticket->priority ?? 'Medium') == $p ? 'selected' : '' }}>
                    {{ $p }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Buttons --}}
    <div class="col-12 text-end mt-3">
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const catSelect = document.getElementById('cat_id');
    const subSelect = document.getElementById('subcat_id');
    const serviceSelect = document.getElementById('service_id');

    const preSelectedSub = subSelect.dataset.selected || '';
    const preSelectedService = serviceSelect.dataset.selected || '';

    const clearSelect = (el, placeholder = 'Select') => {
        el.innerHTML = `<option value="">${placeholder}</option>`;
    };

    const fetchJson = async (url) => {
        try {
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return [];
            return await res.json();
        } catch (err) {
            console.error('Fetch error', err);
            return [];
        }
    };

    const loadSubcategories = async (catId, selectedSub = '') => {
        clearSelect(subSelect, 'Select Subcategory');
        clearSelect(serviceSelect, 'Select Service');
        if (!catId) return;

        const data = await fetchJson(`/admin/subcategories/${catId}`);
        data.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.id;
            opt.textContent = sub.name;
            if (String(sub.id) === String(selectedSub)) opt.selected = true;
            subSelect.appendChild(opt);
        });

        if (selectedSub) await loadServices(selectedSub, preSelectedService);
    };

    const loadServices = async (subId, selectedService = '') => {
        clearSelect(serviceSelect, 'Select Service');
        if (!subId) return;

        const data = await fetchJson(`/admin/services/${subId}`);
        data.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.textContent = s.name;
            if (String(s.id) === String(selectedService)) opt.selected = true;
            serviceSelect.appendChild(opt);
        });
    };

    catSelect.addEventListener('change', () => loadSubcategories(catSelect.value));
    subSelect.addEventListener('change', () => loadServices(subSelect.value));

    const existingCat = "{{ old('cat_id', $ticket->cat_id ?? '') }}";
    if (existingCat) loadSubcategories(existingCat, preSelectedSub);
});
</script>
