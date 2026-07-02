@extends('layouts.app')

@section('content')

<div class="container py-4">

<div class="row">

{{-- ================= LEFT ================= --}}
<div class="col-lg-8">

<div class="card shadow-sm border-0">

{{-- Header --}}
<div class="card-header bg-white d-flex justify-content-between align-items-center">

<div>

<h3 class="fw-bold mb-1">

{{ $event->title }}

</h3>
<div class="d-flex align-items-center gap-3 mb-4">

    <span class="badge bg-primary fs-6">
        {{ $event->participants->count() }} Joined
    </span>

    @auth

       @if($expired)

    <button class="btn btn-secondary" disabled>
        Event Ended
    </button>

@elseif(!$joined)

<form action="{{ route('event.join',$event->id) }}" method="POST">
    @csrf

    <button class="btn btn-success">
        ✅ Join Event
    </button>

</form>

@else

<form action="{{ route('event.leave',$event->id) }}" method="POST">
    @csrf
    @method('DELETE')

    <button class="btn btn-outline-danger">
        Leave Event
    </button>

</form>

@endif

    @endauth

</div>

<div class="card shadow-sm mt-4">

    <div class="card-body">

        <h5 class="fw-bold mb-3">
            Participants ({{ $event->participants->count() }})
        </h5>

        @forelse($event->participants->take(5) as $participant)

            <div class="d-flex align-items-center mb-2">

                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                     style="width:40px;height:40px;">
                    {{ strtoupper(substr($participant->name,0,1)) }}
                </div>

                <strong>{{ $participant->name }}</strong>

            </div>

        @empty

            <p class="text-muted">
                No participants yet.
            </p>

        @endforelse

         @if($event->participants->count() > 1)

            <div class="text-center mt-3">

                <a href="{{ route('event.participants',$event->id) }}"
                   class="btn btn-outline-primary">

                    View All Participants

                </a>

                   </div>

        @endif
@if(\Carbon\Carbon::parse($event->event_date)->isPast())

    <span class="badge bg-danger">
        Ended
    </span>

@endif
    </div>

</div>


   
<small class="text-muted">

{{ $event->category }}

@if($event->event_date)

・{{ $event->event_date }}

@endif

</small>

</div>

@if(Auth::id()==$event->user_id)

<div class="d-flex gap-2">

<a href="{{ route('event.edit',$event->id) }}"
class="btn btn-outline-secondary btn-sm">

Edit

</a>

<form action="{{ route('event.destroy',$event->id) }}"
method="POST"
onsubmit="return confirm('Delete this event?')">

@csrf
@method('DELETE')

<button class="btn btn-outline-danger btn-sm">

Delete

</button>

</form>

</div>

@endif

</div>

{{-- ================= BODY ================= --}}

<div class="card-body">

{{-- Main Image --}}

<div
class="border rounded bg-light d-flex justify-content-center align-items-center"
style="height:430px;">

@if($event->image1)

<img
id="previewImage"
src="{{ asset('storage/'.$event->image1) }}"
style="
max-width:100%;
max-height:100%;
object-fit:contain;
transition:.2s;
">

@else

<p class="text-muted">

No Image

</p>

@endif

</div>

{{-- Thumbnail --}}

<div class="d-flex gap-2 mt-3">

@if($event->image1)

<img

src="{{ asset('storage/'.$event->image1) }}"

class="thumb-image border rounded"

style="
width:70px;
height:70px;
object-fit:cover;
cursor:pointer;
padding:2px;
"

onclick="changeImage(this)">

@endif

@if($event->image2)

<img

src="{{ asset('storage/'.$event->image2) }}"

class="thumb-image border rounded"

style="
width:70px;
height:70px;
object-fit:cover;
cursor:pointer;
padding:2px;
"

onclick="changeImage(this)">

@endif

</div>

<hr class="my-4">

<div class="card border-0 shadow-sm">

<div class="card-body">

<h5 class="fw-bold mb-3">

Event Information

</h5>

<table class="table">

<tr>

<th width="180">

Category

</th>

<td>

{{ $event->category }}

</td>

</tr>

<tr>

<th>

Location

</th>

<td>

{{ $event->location ?? '-' }}

</td>

</tr>

<tr>

<th>

Date

</th>

<td>

{{ $event->event_date }}

</td>

</tr>

<tr>

<th>

Status

</th>

<td>

<span class="badge bg-success">

Open

</span>

</td>

</tr>

</table>

</div>

</div>

<div class="card border-0 shadow-sm mt-4">

<div class="card-body">

<h5 class="fw-bold">

Description

</h5>

<hr>

<p style="white-space:pre-line">

{{ $event->description }}

</p>

</div>

</div>

</div>

</div>

</div>
{{-- ================= RIGHT ================= --}}
<div class="col-lg-4">

    {{-- Profile --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body text-center">

            @if($event->user)

                @if($event->user->avatar)

                    <img src="{{ asset('storage/'.$event->user->avatar) }}"
                         class="rounded-circle mb-3"
                         width="90"
                         height="90"
                         style="object-fit:cover;">

                @else

                    <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:90px;height:90px;font-size:32px;">

                        {{ strtoupper(substr($event->user->name,0,1)) }}

                    </div>

                @endif

                <h5 class="fw-bold">

                    {{ $event->user->name }}

                </h5>
                 <a
                href="{{ route('chat.private',$event->user) }}"
                class="btn btn-primary">

                Message

                </a>

@if($joined)

<a href="{{ route('group.chat',$event) }}"
   class="btn btn-success w-100">
    Group Chat
</a>

@endif

            @else

                <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:90px;height:90px;font-size:32px;">

                    U

                </div>

                <h5>

                    Unknown User

                </h5>

            @endif

        </div>

    </div>



    {{-- Comments --}}
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

              <div class="d-flex justify-content-between align-items-center">

<div>

<h4 class="fw-bold mb-0">

💬 Discussion

</h4>

<small class="text-muted">

Everyone participating in this event can view and join.

</small>

</div>


</div>

                <span class="badge bg-secondary">

                    {{ isset($event->comments) ? $event->comments->count() : 0 }}

                </span>

            </div>

            <hr>
{{-- Comments --}}
<div class="card shadow-sm border-0 mt-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <h4 class="fw-bold mb-0">
                Comments
            </h4>

            <span class="badge bg-secondary">
                {{ $event->comments->count() }}
            </span>

        </div>

        <hr>

        @forelse($event->comments as $comment)

        <div class="border-bottom pb-3 mb-3">

            <div class="d-flex justify-content-between">

                <div class="d-flex">

                    @if($comment->user && $comment->user->avatar)

                        <img src="{{ asset('storage/'.$comment->user->avatar) }}"
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

                            {{ $comment->user->name ?? 'Unknown User' }}

                        </strong>

                        <br>

                        <small class="text-muted">

                            {{ $comment->created_at->diffForHumans() }}

                        </small>

                    </div>

                </div>

                @if(Auth::id()==$comment->user_id)

                <form action="{{ route('comment.destroy',$comment->id) }}"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-outline-danger btn-sm">

                        Delete

                    </button>

                </form>

                @endif

            </div>

            <div class="mt-3">

                {{ $comment->comment }}

            </div>

        </div>

        @empty

        <p class="text-muted">

            No comments yet.

        </p>

        @endforelse

    </div>

</div>

    <hr>

<form action="{{ route('comment.store', $event->id) }}" method="POST">
    @csrf

    <textarea
        name="comment"
        class="form-control"
        rows="3"
        placeholder="Write a comment..."
        required></textarea>

    <button class="btn btn-primary mt-3">
        Post Comment
    </button>
</form>
</div>
</div> {{-- row --}}

</div> {{-- container --}}

<script>

function changeImage(el){

    document.getElementById('previewImage').src = el.src;

    document.querySelectorAll('.thumb-image').forEach(img=>{

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

<style>

.thumb-image{

    transition:.2s;

}

.thumb-image:hover{

    transform:scale(1.05);

}

#previewImage{

    transition:.25s;

}

</style>

@endsection