<?php namespace CatalogVideo\Domain\Notification;

class Notification
{
    private $errors = [];

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $error array[context, mensage]
     */
    public function addError(array $error): void
    {
        array_push($this->errors, $error);
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function messages(string $context = ''): string
    {
        $messages = '';

        foreach ($this->errors as $error) {
            if ($context === '' || $error['context'] == $context) {
                $messages .= "{$error['context']}: {$error['message']},";
            }
        }

        return $messages;
    }
}
