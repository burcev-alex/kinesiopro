@extends('layouts.app')

@section('metaLabels')
    @parent
    @includeIf('meta::manager', [
        'title' => __('main.meta.privacy_policy_title'),
        'description' => __('main.meta.privacy_policy_description'),
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')

    <h1 class="width titleH1 titleH12">{{ __('main.meta.privacy_policy_h1') }}</h1>

    <div class="width flex">
        <div class="paragraf">

            <p> В соответствии с требованиями Федерального закона от 27.07.2006 г. № 152-ФЗ«О персональных данных» я выражаю
                согласие на обработку своих персональных данных администрацией ресурса kinesiopro.ru без оговорок и
                ограничений, совершение с моими персональными данными действий, предусмотренных п.3 ч.1 ст.3 Федерального
                закона от 27.07.2006 г. № 152-ФЗ«О персональных данных», и подтверждаю, что, давая такое согласие, действую
                свободно, по своей воле и в своих интересах.<br>Согласие на обработку персональных данных дается мной в
                целях получения услуг, оказываемых ресурсом kinesiopro.ru.<br>Перечень персональных данных, на обработку
                которых предоставляется согласие:<br>• Фамилия<br>• Имя<br>• Отчество<br>• Место пребывания (город,
                область)<br>• Номера телефонов<br>• Адреса электронной почты (E-mail)<br>• Иные полученные от меня
                персональные данные.<br>Я выражаю свое согласие на осуществление со всеми указанными персональными данными
                следующих действий:<br>• cбор<br>• систематизация<br>• накопление хранение<br>• уточнение (обновление или
                изменение)<br>• использование<br>• обезличивание<br>• блокировка<br>• уничтожение, а также осуществление
                любых иных действий с персональными данными в соответствии с действующим законодательством.<br>Обработка
                данных может осуществляться как с использованием средств автоматизации, так и без их использования (при
                неавтоматической обработке). При обработке персональных данных администрация ресурса kinesiopro.ruне
                ограничено в применении способов их обработки.<br>Настоящим я признаю и подтверждаю, что в случае
                необходимости администрация ресурса kinesiopro.ru является правообладателем всех фото и видеоматериалов
                полученных в процессе проведения мероприятия и вправе предоставлять мои персональные данные третьим лицам
                исключительно в целях оказания услуг технической поддержки, а также (в обезличенном виде) в статистических,
                маркетинговых и иных научных целях. Такие третьи лица имеют право на обработку персональных данных на
                основании настоящего согласия.<br>Данное согласие действует до даты его отзыва путем направления,
                подписанного мною соответствующего письменного заявления, которое может быть направлено мной в адрес
                администрации ресурса kinesiopro.ru по почте заказным письмом с уведомлением о вручении, либо вручено лично
                под расписку надлежащему уполномоченному представителю ресурса kinesiopro.ru.<br>В случае получения моего
                письменного заявления об отзыве настоящего согласия на обработку персональных данных, администрация ресурса
                kinesiopro.ru обязана прекратить их обработку и исключить персональные данные из базы данных, в том числе
                электронной, за исключением сведений о фамилии, имени, отчества.<br>Я осознаю, что проставление отметки «V»
                в поле слева от фразы « Нажимая на кнопку «Зарегистрироваться», я принимаю условия Согласие на обработку
                персональных данных » на сайте kinesiopro.ru означает мое согласие с условиями, описанными в нём. </p>
        </div>
    </div>
@endsection