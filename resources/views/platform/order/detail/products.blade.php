
<fieldset class="py-3">
    <div class="col p-0 px-3">
        <legend class="text-black">Состав заказа</legend>
    </div>
    <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
        <table class="table">
            <thead>
            <tr>
                <th width="250" class="text-left" data-column="name">
                    <div>Название</div>
                </th>
                <th class="text-left" data-column="price">
                    <div>Цена</div>
                </th>
                <th class="text-left" data-column="quantity">
                    <div>Кол-во</div>
                </th>
                <th class="text-left" data-column="total">
                    <div>Итого</div>
                </th>
            </tr>
            </thead>
            <tbody>
                @foreach ($item['items'] as $item)
                    <tr>
                        <td class="text-left " data-column="name" colspan="1">
                            <div style="width:250px">
                                {{ $item['name'] }}
                            </div>
                        </td>
                        <td class="text-left text-truncate" data-column="price" colspan="1">
                            <div>{{ $item['unit_price'] }} руб</div>
                        </td>
                        <td class="text-left text-truncate" data-column="quantity" colspan="1">
                            <div>{{ $item['quantity'] }}</div>
                        </td>
                        <td class="text-left  text-truncate" data-column="total" colspan="1">
                            <div>{{ $item['total'] }} руб</div>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</fieldset>