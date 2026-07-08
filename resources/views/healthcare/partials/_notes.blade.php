@php
    $notesDate = \Carbon\Carbon::now()->format('F Y');
@endphp

<div class="card border-0 shadow-sm mt-4 hs-notes">

    <div class="card-body p-4">

        <h6 class="hs-notes__title">
            {{ __('healthcare.notes.title') }}
        </h6>

        <ul class="hs-notes__list">

            <li class="hs-notes__item">
                {{ __('healthcare.notes.item1') }}
            </li>

            <li class="hs-notes__item">
                {{ __('healthcare.notes.item2') }}
            </li>

            <li class="hs-notes__item">
                {{ __('healthcare.notes.item3', ['date' => $notesDate]) }}
            </li>

        </ul>

    </div>

</div>
