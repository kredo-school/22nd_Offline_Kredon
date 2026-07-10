@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-header bg-white">

                    <h3 class="fw-bold mb-0">
                        ✏ Edit Item
                    </h3>

                </div>

                <div class="card-body">

                    <form action="{{ route('marketplace.update',$item) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                value="{{ old('title',$item->title) }}"
                                required>

                        </div>

                        {{-- Description --}}
                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Description
                            </label>

                            <textarea
                                name="description"
                                rows="5"
                                class="form-control"
                                required>{{ old('description',$item->description) }}</textarea>

                        </div>

                        {{-- Category & Place --}}
                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">
                                    Category
                                </label>

                                <select
                                    name="category"
                                    class="form-select">

                                    @php

                                        $categories=[
                                            'Clothes',
                                            'Towel',
                                            'Medicine',
                                            'Skin Care',
                                            'Daily Goods',
                                            'Stationery',
                                            'Other'
                                        ];

                                    @endphp

                                    @foreach($categories as $category)

                                    <option
                                        value="{{ $category }}"
                                        {{ $item->category==$category ? 'selected':'' }}>

                                        {{ $category }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">
                                    Place
                                </label>

                                <select
                                    name="location_name"
                                    class="form-select">

                                    @php

                                        $places=[
                                            'Dormitory',
                                            'School',
                                            'IT Park',
                                            'Ayala',
                                            'SM Mall',
                                            'Other'
                                        ];

                                    @endphp

                                    @foreach($places as $place)

                                    <option
                                        value="{{ $place }}"
                                        {{ $item->location_name==$place ? 'selected':'' }}>

                                        {{ $place }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                        {{-- Condition --}}
                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Condition
                            </label>

                            <select
                                name="status"
                                class="form-select">

                                @php

                                    $conditions=[
                                        'New/Unused',
                                        'Used',
                                        'Needs Repair'
                                    ];

                                @endphp

                                @foreach($conditions as $condition)

                                <option
                                    value="{{ $condition }}"
                                    {{ $item->status==$condition ? 'selected':'' }}>

                                    {{ $condition }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Images --}}
                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Change Images
                            </label>

                            <input
                                type="file"
                                name="images[]"
                                class="form-control"
                                multiple>

                            <small class="text-muted">
                                Leave blank if you don't want to change images.
                            </small>

                        </div>

                        {{-- Current Images --}}
                        @if($item->images->count())

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Current Images

                            </label>

                            <div class="d-flex gap-3 flex-wrap">

                                @foreach($item->images as $image)

                                <img
                                    src="{{ asset('storage/'.$image->path) }}"
                                    style="
                                        width:120px;
                                        height:120px;
                                        object-fit:cover;
                                        border-radius:10px;
                                    ">

                                @endforeach

                            </div>

                        </div>

                        @endif

                       
                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Save Changes

                    </button>

                    <a
                        href="{{ route('marketplace.show',$item->id) }}"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection