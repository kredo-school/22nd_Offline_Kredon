<div class="modal fade" id="createEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Create Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger py-2" style="font-size:0.85rem;">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Please select</option>
                                <option value="questions" {{ old('category') == 'questions' ? 'selected' : '' }}>Questions</option>
                                <option value="events" {{ old('category') == 'events' ? 'selected' : '' }}>Events</option>
                                <option value="recruitment" {{ old('category') == 'recruitment' ? 'selected' : '' }}>Recruitment</option>
                                <option value="share_info" {{ old('category') == 'share_info' ? 'selected' : '' }}>Share Info</option>
                                <option value="chat" {{ old('category') == 'chat' ? 'selected' : '' }}>Chat</option>
                                <option value="others" {{ old('category') == 'others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">表示先</label>
                            <select name="display_channel" class="form-select" required>
                                <option value="event_page" {{ old('display_channel', 'event_page') == 'event_page' ? 'selected' : '' }}>
                                    Event list
                                </option>
                                <option value="share_info" {{ old('display_channel') == 'share_info' ? 'selected' : '' }}>
                                    Share Info
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Details</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Venue</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Start date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">End date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                            <div class="form-text" style="font-size:0.72rem;">If left blank, it will be treated as the same as the start date.</div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Image 1</label>
                            <input type="file" name="image1" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Image 2</label>
                            <input type="file" name="image2" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>