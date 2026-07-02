@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')

<div class="container">

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <h2 class="fw-bold mb-4">
                Edit Event
            </h2>

            <form action="{{ route('event.update',$event->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="mb-3">

                    <label class="form-label">
                        Title
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        value="{{ old('title',$event->title) }}">

                </div>

                {{-- Category --}}
                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <select
                        name="category"
                        class="form-select">

                        <option value="Questions"
                            {{ $event->category=='Questions' ? 'selected' : '' }}>
                            Questions
                        </option>

                        <option value="Events"
                            {{ $event->category=='Events' ? 'selected' : '' }}>
                            Events
                        </option>

                        <option value="Recruitment"
                            {{ $event->category=='Recruitment' ? 'selected' : '' }}>
                            Recruitment
                        </option>

                        <option value="Share Info"
                            {{ $event->category=='Share Info' ? 'selected' : '' }}>
                            Share Info
                        </option>

                        <option value="Chat"
                            {{ $event->category=='Chat' ? 'selected' : '' }}>
                            Chat
                        </option>

                        <option value="Others"
                            {{ $event->category=='Others' ? 'selected' : '' }}>
                            Others
                        </option>

                    </select>

                </div>

                {{-- Description --}}
                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        class="form-control"
                        rows="6"
                        name="description">{{ old('description',$event->description) }}</textarea>

                </div>

                {{-- Location --}}
                <div class="mb-3">

                    <label class="form-label">
                        Location
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="location"
                        value="{{ old('location',$event->location) }}">

                </div>

                {{-- Date --}}
                <div class="mb-3">

                    <label class="form-label">
                        Event Date
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        name="event_date"
                        value="{{ old('event_date',$event->event_date) }}">

                </div>

                {{-- Current Image --}}
                @if($event->image)

                <div class="mb-3">

                    <label class="form-label">
                        Current Image
                    </label>

                    <br>

                    <img
                        src="{{ asset('storage/'.$event->image) }}"
                        class="img-fluid rounded shadow"
                        style="max-height:250px;">

                </div>

                @endif

                {{-- New Image --}}
          {{-- 現在の画像１ --}}
@if($event->image1)

<div class="mb-3">

    <label class="form-label">
        Current Image 1
    </label>

    <br>

    <img
        src="{{ asset('storage/'.$event->image1) }}"
        class="img-fluid rounded shadow"
        style="max-height:220px;">

</div>

@endif

<div class="mb-3">

    <label class="form-label">

        Change Image 1

    </label>

    <input
        type="file"
        class="form-control"
        name="image1">

</div>



@if($event->image2)

<div class="mb-3">

    <label class="form-label">

        Current Image 2

    </label>

    <br>

    <img
        src="{{ asset('storage/'.$event->image2) }}"
        class="img-fluid rounded shadow"
        style="max-height:220px;">

</div>

@endif

<div class="mb-4">

    <label class="form-label">

        Change Image 2

    </label>

    <input
        type="file"
        class="form-control"
        name="image2">

</div>

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Save Changes

                    </button>

                    <a
                        href="{{ route('event.show',$event->id) }}"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection