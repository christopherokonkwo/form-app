@component('mail::message')

# {{ trans('app.your_weekly_writer_summary_for', [], $data['locale']) }} {{ $data['endDate'] }}

{{ trans('app.from', [], $data['locale']) }} {{ $data['startDate'] }} {{ trans('app.to', [], $data['locale']) }} {{ $data['endDate'] }} {{ trans('app.your_posts_received', [], $data['locale']) }}

# {{ trans('app.views', [], $data['locale']) }}
## +{{ $data['totals']['views']  }}

# {{ trans('app.visits', [], $data['locale']) }}
## +{{ $data['totals']['visits']  }}

@component('mail::table')
| | {{ trans('app.visits', [], $data['locale']) }} | {{ trans('app.views', [], $data['locale']) }} |
| ----------------------------------------------------------------- | --------------------------------------------------------: | --------------------------------------------------:|
@foreach($data['posts'] as $post)
| *{{ \Illuminate\Support\Str::limit($post['title'], 40, '...') }}* | **+{{ number_format($post['visits_count']) }}** | **+{{ number_format($post['views_count']) }}** |
@endforeach
@endcomponent

@component('mail::button', ['url' => url(config('dashboard.path'))])
{{ trans('app.see_all_stats', [], $data['locale']) }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
