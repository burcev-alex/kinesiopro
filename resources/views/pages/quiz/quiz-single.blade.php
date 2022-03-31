@extends('layouts.app')


@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => $quiz_item->meta_title,
    "description" => $quiz_item->meta_description
    ])
@stop

@section('content')
    @include('includes.partials.breadcrumbs')
    <h1 class="width titleH1">{{ $quiz_item->title }}</h1>

    <div class="testIn width flex">
        <img src="{{ $quiz_item->banner != null ? $quiz_item->banner->url() : '' }}" alt="">

        <div>{!! $quiz_item->description !!}</div>
    </div>

    <section class="teachers intensive">
        <div class="teachersIn width">
            <h2 class="teachersH2">Интенсивность болевых ощущений</h2>

            <form action="" class="formIntensive flex">
                <div class="formIntensiveRadio">
                    <label class="blockCheckbox">
                        <span>Я могу переносить боль без применения болеутоляющих средств</span>
                        <input type="radio" checked="checked" name="radio"><span class="checkmark"></span>
                    </label>
                </div>

                <div class="formIntensiveRadio">
                    <label class="blockCheckbox">
                        <span>Я испытываю сильную боль, но могу переносить её без применения болеутоляющих средств</span>
                        <input type="radio" name="radio"><span class="checkmark"></span>
                    </label>
                </div>

                <div class="formIntensiveRadio">
                    <label class="blockCheckbox">
                        <span>Болеутоляющие средства целиком избавляют меня от боли</span>
                        <input type="radio" name="radio"><span class="checkmark"></span>
                    </label>
                </div>

                <div class="formIntensiveRadio mb">
                    <label class="blockCheckbox">
                        <span>Болеутоляющие средства частично избавляют меня от боли</span>
                        <input type="radio" name="radio"><span class="checkmark"></span>
                    </label>
                </div>

                <div class="formIntensiveRadio mb">
                    <label class="blockCheckbox">
                        <span>Болеутоляющие средства незначительно облегчают мою боль</span>
                        <input type="radio" name="radio"><span class="checkmark"></span>
                    </label>
                </div>

                <div class="formIntensiveRadio mb">
                    <label class="blockCheckbox">
                        <span>Болеутоляющие средства не избавляют меня от боли</span>
                        <input type="radio" name="radio"><span class="checkmark"></span>
                    </label>
                </div>
            </form>
        </div>
    </section>

@stop
