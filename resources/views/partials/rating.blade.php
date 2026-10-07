{{-- Average rating for a room loaded with Accommodation::card() (reviews_avg_rating / reviews_count). --}}
@if(($room->reviews_count ?? 0) > 0)
    <span title="{{ number_format($room->reviews_avg_rating, 1) }} out of 5 from {{ $room->reviews_count }} review(s)">
        &#9733; {{ number_format($room->reviews_avg_rating, 1) }} ({{ $room->reviews_count }})
    </span>
@else
    <span class="text-muted">No reviews yet</span>
@endif
