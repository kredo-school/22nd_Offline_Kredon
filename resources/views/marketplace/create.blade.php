@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<div class="container"
     style="max-width: 650px;">
     <hr>
 <a href="{{ route('marketplace.index') }}"
       class="btn btn-outline-secondary mb-4">
        ← Back to Marketplace
    </a>
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <form action="{{ route('marketplace.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- IMAGE --}}
                <div class="mb-4">

                    <div class="d-flex gap-3">

                        {{-- IMAGE 1 --}}
                        <label class="image-box border rounded-4 d-flex align-items-center justify-content-center overflow-hidden"
                               style="
                               width:120px;
                               height:120px;
                               cursor:pointer;
                               background:#f8f9fa;">

                            <img id="preview1"
                                 src=""
                                 class="w-100 h-100 object-fit-cover d-none">

                            <i id="icon1"
                               class="fa-regular fa-image text-secondary fs-2"></i>

                            <input type="file"
                                   name="images[]"
                                   accept="image/*"
                                   hidden
                                   onchange="previewImage(event, 1)">

                        </label>

                        {{-- IMAGE 2 --}}
                        <label class="image-box border rounded-4 d-flex align-items-center justify-content-center overflow-hidden"
                               style="
                               width:120px;
                               height:120px;
                               cursor:pointer;
                               background:#f8f9fa;">

                            <img id="preview2"
                                 src=""
                                 class="w-100 h-100 object-fit-cover d-none">

                            <i id="icon2"
                               class="fa-regular fa-image text-secondary fs-2"></i>

                            <input type="file"
                                   name="images[]"
                                   accept="image/*"
                                   hidden
                                   onchange="previewImage(event, 2)">

                        </label>

                    </div>

                </div>

                {{-- ITEM NAME --}}
                <div class="mb-4">

                    <label class="fw-bold mb-2">
                        Item Name
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control rounded-3"
                           placeholder="Item name (e.g., skincare set, T-shirt, etc.)"
                           required>

                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-4">

                    <label class="fw-bold mb-2">
                        Description
                    </label>

                    <textarea name="description"
                              rows="4"
                              class="form-control rounded-3"
                              placeholder="Description"
                              required></textarea>

                </div>

                {{-- CATEGORY --}}
                <div class="mb-4">

                    <label class="fw-bold mb-2">
                        Category & Place
                    </label>

                    <div class="row g-2">

                        {{-- CATEGORY --}}
                        <div class="col-md-6">

                            <select name="category"
                                    class="form-select rounded-3"
                                    required>

                                <option value="">
                                    Select Category
                                </option>

                                <option value="Fashion">
                                    Fashion
                                </option>

                                <option value="Skincare">
                                    Skincare
                                </option>

                                <option value="Household Items">
                                    Household Items
                                </option>

                                <option value="Stationery">
                                    Stationery
                                </option>

                                <option value="Medicine">
                                    Medicine
                                </option>

                                <option value="Other">
                                    Other
                                </option>

                            </select>

                        </div>

                        {{-- PLACE --}}
                        <div class="col-md-6">

                            <select name="location_name"
                                    id="placeSelect"
                                    class="form-select rounded-3"
                                    onchange="toggleOtherPlace()"
                                    required>

                                <option value="">
                                    Select Place
                                </option>

                                <option value="Dormitory">
                                    Dormitory
                                </option>

                                <option value="Cafeteria">
                                    Cafeteria
                                </option>

                                <option value="Other">
                                    Other
                                </option>

                            </select>

                        </div>

                    </div>

                    {{-- OTHER PLACE --}}
                    <div class="mt-3 d-none"
                         id="otherPlaceBox">

                        <input type="text"
                               name="other_location"
                               class="form-control rounded-3"
                               placeholder="Other Place">

                    </div>

                </div>

                {{-- CONDITION --}}
                <div class="mb-4">

                    <label class="fw-bold mb-2">
                        Condition
                    </label>

                    <select name="status"
                            class="form-select rounded-3"
                            required>

                        <option value="New/Unused">
                            New/Unused
                        </option>

                        <option value="Used">
                            Used
                        </option>

                    </select>

                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        class="btn btn-success w-100 py-3 rounded-4 fw-bold">

                    List on KREDON

                </button>

            </form>

        </div>

    </div>

</div>

{{-- SCRIPT --}}
<script>

    function previewImage(event, number)
    {
        const file = event.target.files[0];

        if(file)
        {
            const reader = new FileReader();

            reader.onload = function(e)
            {
                document.getElementById('preview' + number).src = e.target.result;

                document.getElementById('preview' + number)
                    .classList.remove('d-none');

                document.getElementById('icon' + number)
                    .classList.add('d-none');
            }

            reader.readAsDataURL(file);
        }
    }

    function toggleOtherPlace()
    {
        const select = document.getElementById('placeSelect');
        const box = document.getElementById('otherPlaceBox');

        if(select.value === 'Other')
        {
            box.classList.remove('d-none');
        }
        else
        {
            box.classList.add('d-none');
        }
    }

</script>

@endsection
