@extends('layouts.admin')
@section('page_title', 'Edit Canned Message')

@section('content')
<div class="container mt-4">
    <h4 class="fw-semibold text-primary mb-3">✏️ Edit Canned Message - {{ $cannedMessage->title }}</h4>

    <form action="{{ route('admin.canned_messages.update', $cannedMessage->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm rounded-3 p-4">
            <div class="row g-3">
                {{-- Title --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Title</label>
                    <input type="text" name="title" value="{{ $cannedMessage->title }}" class="form-control flat-input" required>
                </div>

                {{-- Subject --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Subject</label>
                    <input type="text" name="subject" value="{{ $cannedMessage->subject }}" class="form-control flat-input">
                </div>

                {{-- Type --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Type</label>
                    <select name="type" class="form-select flat-input" required>
                        @foreach(['text', 'html', 'markdown'] as $type)
                            <option value="{{ $type }}" {{ $cannedMessage->type === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Category --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Category</label>
                    <select name="category_id" class="form-select flat-input">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $cannedMessage->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategory --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Subcategory</label>
                    <select name="subcategory_id" class="form-select flat-input">
                        <option value="">Select Subcategory</option>
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}" {{ $cannedMessage->subcategory_id == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Service --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Service</label>
                    <select name="service_id" class="form-select flat-input">
                        <option value="">Select Service</option>
                        @foreach($services as $srv)
                            <option value="{{ $srv->id }}" {{ $cannedMessage->service_id == $srv->id ? 'selected' : '' }}>
                                {{ $srv->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Body --}}
                <div class="col-12">
                    <label class="form-label small fw-semibold text-secondary">Body</label>
                    <textarea name="body" rows="5" class="form-control flat-input" required>{{ $cannedMessage->body }}</textarea>
                </div>

                {{-- Global Checkbox --}}
                <div class="col-md-4 form-check mt-3">
                    <input type="checkbox" name="is_global" id="is_global" class="form-check-input"
                           {{ $cannedMessage->is_global ? 'checked' : '' }}>
                    <label for="is_global" class="form-check-label small fw-semibold text-secondary">Make Global</label>
                </div>

                {{-- Status --}}
                <div class="col-md-4 mt-3">
                    <label class="form-label small fw-semibold text-secondary">Status</label>
                    <select name="status" class="form-select flat-input">
                        <option value="active" {{ $cannedMessage->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $cannedMessage->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('admin.canned_messages.index') }}" class="btn btn-light border shadow-sm px-4">Back</a>
                <button type="submit" class="btn btn-success px-4">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection

<style>
/* === Minimal Flat Admin Form Styling === */
.card {
    border-radius: 10px;
    background-color: #fff;
}

.flat-input {
    border: 1px solid #d9d9d9;
    border-radius: 6px;
    font-size: 0.9rem;
    transition: all 0.2s ease-in-out;
}

.flat-input:focus {
    border-color: #2d5be3;
    box-shadow: 0 0 0 2px rgba(45,91,227,0.15);
}

.flat-input:hover {
    border-color: #b8b8b8;
}

.btn-success {
    background-color: #00b386;
    border: none;
    font-weight: 500;
}

.btn-success:hover {
    background-color: #009e75;
}

.btn-light {
    color: #333;
    background-color: #f8f9fa;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-light:hover {
    background-color: #ebedef;
}

label.form-label {
    margin-bottom: 0.3rem;
}

textarea {
    resize: vertical;
}
</style>
