@extends('layouts.app')

@section('title', 'Create Event')

@section('content')

<div class="container">

<div class="card shadow-sm border-0">

    <div class="card-body">

        <h2 class="fw-bold mb-4">
            Create Event
        </h2>

        <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Title
                </label>

                <input type="text"
                    class="form-control"
                    name="title">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Category
                </label>

                <select name="category" class="form-select">

                    <option value="Questions">Questions</option>
                    <option value="Events">Events</option>
                    <option value="Recruitment">Recruitment</option>
                    <option value="Share Info">Share Info</option>
                    <option value="Chat">Chat</option>
                    <option value="Others">Others</option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Description
                </label>

                <textarea
                    class="form-control"
                    rows="5"
                    name="description"></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Event Date
                </label>

                <input type="date"
                    class="form-control"
                    name="event_date">

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Event Image
                </label>

                <input type="file"
                    class="form-control"
                    name="image">

            </div>

            <button type="submit"
                class="btn btn-primary">

                Create Event

            </button>

        </form>

    </div>

</div>

</div>

@endsection
