@foreach ($podcasts as $podcast)
<li>
    <div class="listPodcast__date flex">
        <span>{{ $podcast->publish_date_day }}</span>
        <span>{{ $podcast->publish_date_month }}</span>
    </div>

    <a href="{{ route('podcast.single', ['slug' => $podcast->slug]) }}">{{ $podcast->title }}</a>
</li>
@endforeach
