@if($logged_in_user->unreadNotifications->count() > 0) 
    <div class="notifications">
        <div class="notifications__title">
            <h3>Уведомления <span>{{ $logged_in_user->unreadNotifications->count() }}</span></h3>
        </div>

        <ul class="notificationsList">
            @foreach($logged_in_user->unreadNotifications as $notify)
                @php
                    $today = date('d.m.Y', time());
                    $yesterday = date('d.m.Y', time() - 86400);
                    $dbDate = date('d.m.Y', strtotime($notify->created_at->format('Y-m-d H:i:s')));
                    $dbTime = date('H:i', strtotime($notify->created_at->format('Y-m-d H:i:s')));

                    switch ($dbDate)
                    {
                        case $today : $created_at_format = 'Сегодня в '. $dbTime; break;
                        case $yesterday : $created_at_format = 'Вчера в '. $dbTime; break;
                        default : $created_at_format = $dbDate;
                    }
                    
                @endphp
                <li>
                    <div class="notificationsList__day">{{ $created_at_format }}</div>
                    <div class="notificationsList__desc">{{ $notify->data['title'] }}</div>
                    @if($notify->data['type'] == 'online')
                        <div class="notificationsList__name">
                            {{ $notify->data['online']['title'] }}
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
