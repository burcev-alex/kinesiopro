<?php

if (!function_exists('seo_parse')) {


  /**
   * Парсинг SEO текста
   *
   * @param string $string Строка с шаблонными вставками
   * @param array $data Массив с ключами - соответствующими частям шаблонных строк до
   * разделителя (точки) и значениями - соответствующими частям после разделителя (точки)
   *
   * Пример:
   * для правильной подстановки шаблонной строки вида {{product.name}} необходимо передать
   * следующий массив - ["product" => ["name" => "some name"]];
   *
   * @return string
   */
    function seo_parse(string $string, array $data)
    {
        $template_bracket_start = "{{";
        $template_bracket_end = "}}";
        $template_bracket_separator = ".";

        if (str_contains($string, $template_bracket_start) &&
        str_contains($string, $template_bracket_end)
        ) {
            $replaces = [];

            $one = explode($template_bracket_start, $string);

            foreach ($one as $value) {
                if (str_contains($value, $template_bracket_end)) {
                    $replaces[] = explode($template_bracket_end, $value)[0];
                }
            }


            foreach ($replaces as $value) {
                $data_value = explode($template_bracket_separator, $value);

                if (isset($data[$data_value[0]][$data_value[1]])) {
                    $string = str_replace(
                        $template_bracket_start . $value . $template_bracket_end,
                        $data[$data_value[0]][$data_value[1]],
                        $string
                    );
                }
            }
        }


        return $string;
    }
}
