<?php

namespace helpers;
/**
 * Класс FormValidator предоставляет методы для проверки и обработки данных форм.
 */
class FormValidator {
    /**
     * Проверяет, находится ли длина строки в заданных пределах.
     *
     * @param int $minLength Минимальная длина строки.
     * @param int $maxLength Максимальная длина строки.
     * @param string $data Строка для проверки.
     * @return bool Возвращает true, если длина строки находится в пределах, иначе false.
     */
    public static function validateForm(int $minLength, int $maxLength, string $data): bool {
        $len = mb_strlen($data);
        return $len >= $minLength && $len <= $maxLength;
    }

    /**
     * Проверяет, является ли поле обязательным (не пустым).
     *
     * @param mixed $data Данные для проверки.
     * @return bool Возвращает true, если поле не пустое, иначе false.
     */
    public static function requiredField($data): bool
    {
        return !empty($data);
    }

    /**
     * Очищает данные, удаляя пробелы и преобразуя специальные символы.
     *
     * @param mixed $data Данные для очистки.
     * @return string Очищенные данные.
     */
    public static function sanitizeData($data): string
    {
        $data = trim($data);
        return htmlspecialchars($data);
    }
}