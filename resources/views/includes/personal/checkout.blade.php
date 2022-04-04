<form action="{{ route('checkout.save') }}" data-action="async" id="createOrder" method="POST" class="registerPay">
    @csrf
    <input type="hidden" name="order[type]" value="{{ $type }}">

    <input type="hidden" name="order[user_id]" value="{{ $logged_in_user ? $logged_in_user->id : 0 }}">

    <input type="hidden" name="product[id]" value="{{ $entity->id }}">
    <input type="hidden" name="product[type]" value="{{ $entity->type ? $entity->type : 'course' }}">
    <input type="hidden" name="product[name]" value="{{ $entity->title ? $entity->title : $entity->name }}">
    <input type="hidden" name="product[price]" value="{{ $entity->price }}">
    <input type="hidden" name="product[qty]" value="1">

    <div class="registerBtnTop flex">
        <div class="registerBtnTop__block">
            <label for="name">Имя <span>*</span></label>
            <input type="text" id="name" required name="order[name]">
        </div>

        <div class="registerBtnTop__block">
            <label for="surname">Фамилия <span>*</span></label>
            <input type="text" id="surname" required name="order[surname]">
        </div>

        <div class="registerBtnTop__block">
            <label for="phone">Телефон <span>*</span></label>
            <input type="text" id="phone" required name="order[phone]">
        </div>
    </div>

    <div class="registerBtnBottom flex">
        <div class="registerBtnTop__block">
            <label for="email">E-mail <span>*</span></label>
            <input type="text" id="email" required name="order[user_email]">
        </div>

        <div class="registerBtnTop__block">
            <label for="promo">Промокод</label>
            <input type="text" id="promo" name="order[promocode]">
        </div>
    </div>

    <h3 class="registerPay__title">Платежный шлюз:</h3>
    <div class="registerPayBlock flex">
        <div class="formIntensiveRadio">
            <label class="blockCheckbox">
                <span>Сбербанк (подходит для большинства платежей)</span>
                <input type="radio" value="sberbank" checked="checked" name="order[payment]"><span class="checkmark"></span>
            </label>
            <img src="/images/icon41.svg" alt="">
        </div>

        <div class="formIntensiveRadio">
            <label class="blockCheckbox">
                <span>Robokassa (подходит для жителей Украины)</span>
                <input type="radio" value="robokassa" name="order[payment]"><span class="checkmark"></span>
            </label>

            <img src="/images/icon41.svg" alt="">
        </div>

        <div class="formIntensiveRadio formIntensiveCheckbox">
            <label class="blockCheckbox">
                <span>Нажимая на кнопку «Зарегистрироваться», я принимаю условия <a href="{{ route('privacy_policy') }}" target="_blank">Согласие на
                    обработку персональных данных</a></span>
                <input type="checkbox" required checked="checked" name="privacy_policy"><span class="checkmark"></span>
            </label>
        </div>


        <div class="formIntensiveRadio formIntensiveCheckbox">
            <label class="blockCheckbox">
                <span>Нажимая на кнопку «Зарегистрироваться», я принимаю условия <a href="{{ route('public_offer') }}" target="_blank">Договора-оферты</a></span>
                <input type="checkbox" required name="public_offer"><span class="checkmark"></span>
            </label>
        </div>
    </div>

    <button type="submit" class="flex registerPaySend">
        <span>Зарегистрироваться</span>
    </button>

    <div class="errors"></div>

    <div class="payText">После покупки с Вами свяжется наш менеджер</div>
</form>