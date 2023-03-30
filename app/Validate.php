<?php

namespace Projekt\Dziennik;

class Formularz
{
    private $value;
    private $minLength; //0 brak ograniczen
    private $maxLength; //0 brak ograniczen
    private $required; //true,false, DEFAULT: TRUE

    public function __construct($value, $required = "true", $maxLength = 0, $minLength = 0)
    {
        $this->value = $value;
        $this->required = $required;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    public function validate()
    {
        if ($this->maxLength != 0) {
            if (strlen($this->value) > $this->maxLength) {
                return false;
            }
        }

        if ($this->minLength != 0) {
            if (strlen($this->value) < $this->minLength) {
                return false;
            }
        }

        if (empty($this->value) && $this->required == "true") return false;

        return true;
    }

    public function validate_name()
    {
        $this->validate();
        $condition = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        if (preg_match($condition, $this->value)) return true;
        else return false;
    }

    public function validate_surname()
    {
        $this->validate();
        $condition = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        if (preg_match($condition, $this->value)) return true;
        else return false;
    }

    public function validate_email()
    {
        $this->validate();
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else return true;
    }

    public function validate_string()
    {
        $this->validate();
        if (!is_string($this->value)) return false;
        return true;
    }

    public function validate_number()
    {
        $this->validate();
        if (!is_int($this->value)) return false;
        return true;
    }

    ///HASŁA
    ///Usage: $password, $password2
    /// First password - we use only $password -> validate()
    /// Second password - we use only password2 -> validate_passwords($password)
    public function validate_passwords($pass)
    {
        $this->validate();
        if ($this->value === $pass->value) return true;
        else return false;
    }

    public function get_safe_value()
    {
        return htmlspecialchars($this->value);
    }

    public function get_value()
    {
        return $this->value;
    }
};
