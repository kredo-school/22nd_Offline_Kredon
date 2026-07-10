@extends('layouts.app')

@section('content')

<div class="container py-4">

    <a href="{{ route('marketplace.index') }}"
       class="btn btn-outline-secondary mb-4">
        ← Back to Marketplace
    </a>

    <div class="row">

        {{-- ================= LEFT ================= --}}
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                {{-- Header --}}
                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <div>

                        <h3 class="fw-bold mb-2">
                            {{ $item->title }}
                        </h3>

                        <div class="d-flex gap-2 mb-3">

                            <span class="badge bg-primary">
                                {{ $item->category }}
                            </span>

                            <span class="badge bg-success">
                                {{ $item->status }}
                            </span>

                        </div>

                        <small class="text-muted">
                            📍 {{ $item->location_name }}
                        </small>

                    </div>

                    @if(Auth::id() == $item->user_id)

                    <div class="d-flex gap-2">

                        <a href="{{ route('marketplace.edit', $item->id) }}"
                           class="btn btn-outline-secondary btn-sm">
                            Edit
                        </a>

                        <form action="#"
                              method="POST"
                              onsubmit="return confirm('Delete this item?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-outline-danger btn-sm">
                                Delete
                            </button>

                        </form>

                    </div>
<hr>

@if(Auth::id()==$item->user_id)

<hr>

@if($item->market_status=="available")

<form action="{{ route('market.sold',$item) }}"
      method="POST">

    @csrf

    <button class="btn btn-dark w-100">

        ✅ Mark as Sold

    </button>

</form>

@else

<span class="badge bg-dark w-100 py-2 mb-2">

    ✅ SOLD

</span>

<form action="{{ route('market.available',$item) }}"
      method="POST">

    @csrf

    <button class="btn btn-outline-success w-100">

        🔄 Reopen Item

    </button>

</form>


@endif

@endif
                    @endif

                </div>

                <div class="card-body">

                    {{-- Main Image --}}
                    <div class="border rounded bg-light d-flex justify-content-center align-items-center"
                         style="height:430px;">

                        @if($item->images->count())

                            <img id="previewImage"
                                 src="{{ asset('storage/'.$item->images->first()->path) }}"
                                 style="max-width:100%;
                                        max-height:100%;
                                        object-fit:contain;">

                        @else

                            <p class="text-muted">
                                No Image
                            </p>

                        @endif

                    </div>

                    {{-- Thumbnail --}}
                    <div class="d-flex gap-2 mt-3">

                        @foreach($item->images as $image)

                            <img src="{{ asset('storage/'.$image->path) }}"
                                 class="thumb-image border rounded"
                                 style="width:70px;
                                        height:70px;
                                        object-fit:cover;
                                        cursor:pointer;
                                        padding:2px;"
                                 onclick="changeImage(this)">

                        @endforeach

                    </div>

                    <hr class="my-4">

                                        {{-- Item Information --}}
                    <div class="card border-0 shadow-sm">

                        <div class="card-body">

                            <h5 class="fw-bold mb-3">
                                Item Information
                            </h5>

                            <table class="table">

                                <tr>
                                    <th width="180">
                                        Category
                                    </th>
                                    <td>
                                        {{ $item->category }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Condition
                                    </th>
                                    <td>
                                        {{ $item->status }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Pickup Location
                                    </th>
                                    <td>
                                        {{ $item->location_name }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Posted
                                    </th>
                                    <td>
                                        {{ $item->created_at->format('M d, Y') }}
                                    </td>
                                </tr>

                            </table>

                        </div>

                    </div>

                    {{-- Description --}}
                    <div class="card border-0 shadow-sm mt-4">

                        <div class="card-body">

                            <h5 class="fw-bold">
                                Description
                            </h5>

                            <hr>

                            <p style="white-space:pre-line">
                                {{ $item->description }}
                            </p>

                        </div>

                    </div>

                </div> {{-- card-body --}}
            </div> {{-- card --}}
        </div> {{-- col-lg-8 --}}

        {{-- ================= RIGHT ================= --}}
        <div class="col-lg-4">
                        {{-- Seller --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-body text-center">

                    @if($item->user)

                        @if($item->user->avatar)

                            <img src="{{ asset('storage/'.$item->user->avatar) }}"
                                 class="rounded-circle mb-3"
                                 width="90"
                                 height="90"
                                 style="object-fit:cover;">

                        @else

                            <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width:90px;height:90px;font-size:32px;">

                                {{ strtoupper(substr($item->user->name,0,1)) }}

                            </div>

                        @endif

                        <h5 class="fw-bold">
                            {{ $item->user->name }}
                        </h5>

                        <small class="text-muted d-block mb-3">
                            Seller
                        </small>
                        <form action="{{ route('report.market.item',$item) }}"
      method="POST">

    @csrf

    <button class="btn btn-link text-danger">

        🚨 Report Item

    </button>

</form>
@auth

<form action="{{ route('market.interested',$item) }}"
      method="POST"
      class="mb-2">

    @csrf

    <button class="btn {{ $isInterested ? 'btn-danger' : 'btn-outline-danger' }} w-100">

        @if($isInterested)

            ❤️ Interested

        @else

            🤍 Interested

        @endif

        ({{ $item->interestedUsers->count() }})

    </button>

</form>

@endauth
                        @auth
                            @if($item->user->id != auth()->id())

                                <a href="{{ route('chat.private', $item->user) }}"
                                class="btn btn-primary w-100 mb-2">
                                    💬 Chat
                                </a>

                            @endif
                        @endauth

                        @else

                            <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:90px;height:90px;font-size:32px;">
                                U
                            </div>

                            <h5>Unknown Seller</h5>

                        @endif

                </div>

            </div>

            {{-- Reviews --}}
            <div class="card shadow-sm border-0 mt-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <h4 class="fw-bold mb-0">
                💬 Comments
            </h4>

            <span class="badge bg-secondary">
                {{ $item->comments->count() }}
            </span>

        </div>

        <hr>

        @forelse($item->comments as $comment)

            <div class="border-bottom pb-3 mb-3">

                <div class="d-flex">

                    @if($comment->user && $comment->user->avatar)

                        <img
                            src="{{ asset('storage/'.$comment->user->avatar) }}"
                            class="rounded-circle me-3"
                            width="45"
                            height="45"
                            style="object-fit:cover;">

                    @else

                        <div
                            class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                            style="width:45px;height:45px;">

                            {{ strtoupper(substr($comment->user->name ?? 'U',0,1)) }}

                        </div>

                    @endif

                    <div>

                        <strong>

                            {{ $comment->user->name }}

                        </strong>

                        <br>

                        <small class="text-muted">

                            {{ $comment->created_at->diffForHumans() }}

                        </small>

                    </div>

                </div>

                <div class="mt-3">

                    {{ $comment->comment }}

                </div>

                @if(Auth::id()==$comment->user_id)

                    <form
                        action="{{ route('market.comment.destroy',$comment) }}"
                        method="POST"
                        class="mt-2">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-danger btn-sm">

                            Delete

                        </button>
                        

                    </form>

                @endif
@if(Auth::id() != $comment->user_id)

<form action="{{ route('report.market.comment',$comment) }}"
      method="POST"
      class="mt-1">

    @csrf

    <button class="btn btn-link text-danger p-0"
            style="font-size:12px">

        🚨 Report

    </button>

</form>

@endif
            </div>

        @empty

            <p class="text-muted">

                No comments yet.

            </p>

        @endforelse

    </div>

</div>

       <div class="card shadow-sm border-0 mt-4">

    <div class="card-body">

        <h5 class="fw-bold">

            Leave a Comment

        </h5>

        <form
            action="{{ route('market.comment.store',$item) }}"
            method="POST">

            @csrf

            <textarea
                name="comment"
                class="form-control"
                rows="3"
                placeholder="Write your comment..."
                required></textarea>

            <button class="btn btn-primary mt-3">

                Post Comment

            </button>

        </form>

    </div>

</div>
</div> {{-- col-lg-4 --}}

</div> {{-- row --}}

</div> {{-- container --}}
<script>

function changeImage(el){

    document.getElementById('previewImage').src = el.src;

    document.querySelectorAll('.thumb-image').forEach(function(img){

        img.classList.remove('border-primary');

    });

    el.classList.add('border-primary');

}

window.onload = function(){

    const first = document.querySelector('.thumb-image');

    if(first){

        first.classList.add('border-primary');

    }

}

</script>

@endsection
                    