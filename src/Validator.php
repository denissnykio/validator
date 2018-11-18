<?php
namespace Khalyomede;

use Khalyomede\Exception\RuleNotFoundException;
use Khalyomede\Exception\RuleAlreadyExistException;
use Khalyomede\RegExp;
use Khalyomede\Rule;
use stdClass;
use InvalidArgumentException;
use DateTime;
use OutOfBoundsException;

use function Khalyomede\array_get;

/**
 * Validate arrays, objects, strings, ...
 * 
 * @category Class
 * 
 * @package Validator
 * 
 * @author Khalyomede <khalyomede@gmail.com>
 * 
 * @license https://opensource.org/licenses/MIT MIT
 * 
 * @link https://github.com/khalyomede/validator/blob/master/src/Validator.php
 */
class Validator
{
    /**
     * Rules added by the user.
     * 
     * @var array<mixed>
     */
    protected static $extendedRules = [];

    /**
     * Contains the rules for validating an array.
     * 
     * @var array<mixed>
     */
    protected $rules;

    /**
     * Stores whether the validation failed or not.
     * 
     * @var bool
     */
    protected $failed;

    /**
     * Stores every failures caracterized by the key that caused the failure and the rule that failed to pass.
     * 
     * @var array<stdClass>
     */
    protected $failures;

    /**
     * Stores the key and their values to validate.
     * 
     * @var array<string,mixed>
     */
    protected $itemsToValidate;

    /**
     * Stores the current key being validated.
     * 
     * @var string
     */
    protected $currentKey;

    /**
     * Stores the current rule that is validating.
     * 
     * @var string
     */
    protected $currentRule;

    /**
     * Stores the current value.
     * 
     * @var mixed
     */
    protected $currentValue;

    /**
     * Stores the current index of an array. Useful for required that have to blindly check a row in an array.
     * 
     * @var int
     */
    protected $currentIndex;

    /**
     * Constructor.
     * 
     * @param array $rules The rules for validating the array.
     */
    public function __construct(array $rules) 
    {
        $this->rules = $rules;
        $this->failed = false;
        $this->failures = [];
        $this->itemsToValidate = [];
        $this->currentKey = '';
        $this->currentRule = '';
        $this->currentValue = null;
    }

    /**
     * Validate an array against some rules.
     * 
     * @param array<string,mixed> $items The array to validate.
     * 
     * @return self
     */
    public function validate(array $items): self 
    {
        $this->itemsToValidate = $items;

        $availableRules = static::_rules();

        foreach ($this->rules as $key => $rules) {
            $this->currentKey = $key;            
            
            foreach ($rules as $rule) {
                if (in_array($rule, $availableRules) === false) {
                    $exception = new RuleNotFoundException("rule \"$rule\" does not exists");
                    $exception->setRule($rule);
                    
                    throw $exception;
                }
            }

            $values = null;
            
            try {
                $values = array_get($this->itemsToValidate, $this->currentKey);
            }
            catch( OutOfBoundsException $exception ) {
                $values = null;
            }
            
            foreach ($rules as $rule) {
                $this->currentRule = $rule;

                if (is_array($values) === true && $this->_currentRuleIs(Rule::ARRAY) === false) {
                    foreach ($values as $index => $value) {
                        $this->currentValue = $value;
                        $this->currentIndex = $index;

                        $this->_performValidation();
                    }
                } else {
                    $this->currentValue = $values;

                    $this->_performValidation();
                }
            }
        }

        return $this;
    }

    /**
     * Perform validation according to a key, a rule, a value and the items.
     * 
     * @return void
     */
    private function _performValidation(): void {
        if (($this->_currentRuleIs(Rule::STRING) && $this->_stringRuleFails() === true)
            || ($this->_currentRuleIs(Rule::ARRAY) && $this->_arrayRuleFails() === true)
            || ($this->_currentRuleIs(Rule::REQUIRED) && $this->_requiredRuleFails() === true)
            || ($this->_currentRuleIs(Rule::FILLED) && $this->_filledRuleFails() === true)
            || ($this->_currentRuleIs(Rule::UPPER) && $this->_upperRuleFails() === true)
            || ($this->_currentRuleIs(Rule::EMAIL) && $this->_emailRuleFails() === true)
            || ($this->_currentRuleIs(Rule::INTEGER) && $this->_integerRuleFails() === true)
            || ($this->_currentRuleIs(Rule::LOWER) && $this->_lowerRuleFails() === true)
            || ($this->_currentRuleIs(Rule::SLUG) && $this->_slugRuleFails() === true)
            || ($this->_currentRuleIs(Rule::DATE) && $this->_dateRuleFails() === true)
            || ($this->_currentRuleIs(Rule::DATETIME) && $this->_datetimeRuleFails() === true)
            || ($this->_currentRuleIs(Rule::TIME) && $this->_timeRuleFails() === true)
            || ($this->_currentRuleIs(Rule::PRESENT) && $this->_presentRuleFails() === true)
        ) {
            $this->_addFailure();
        } else {
            foreach (static::$extendedRules as $extendedRule => $closure) {
                if ($this->_currentRuleIs($extendedRule) && call_user_func($closure, $this->currentValue, $this->currentKey, $this->itemsToValidate) !== true) {
                    $this->_addFailure();
                }
            }
        }
    }

    /**
     * Add a new rule.
     * 
     * @param string   $ruleName The name of the rule.
     * @param callable $function Closure that should return true if the test pass, else false.
     * 
     * @return void
     * 
     * @throws RuleAlreadyExistException
     * 
     * @throws InvalidArgumentException
     */
    public static function extends(string $ruleName, callable $function): void 
    {
        if (in_array($ruleName, static::_rules()) === true) {
            $exception = new RuleAlreadyExistException("rule $ruleName already exists");
            $exception->setRule($ruleName);

            throw $exception;
        }

        static::$extendedRules[$ruleName] = $function;
    }

    /**
     * Stores a failures that is caracterized by the key and the rule.
     * 
     * @return void
     */
    private function _addFailure(): void 
    {
        $failure = new stdClass;
        $failure->key = $this->currentKey;
        $failure->rule = $this->currentRule;

        $this->failures[] = $failure;
    }

    /**
     * Returns true if the validation failed.
     * 
     * @return bool
     */
    public function failed(): bool 
    {
        return count($this->failures) > 0;
    }

    /**
     * Returns true if a rule is the current rule.
     * It does not mean so much I understand, please check self::validate() to 
     * better understand.
     * 
     * @param string $rule The rule to check.
     * 
     * @return bool.
     */
    private function _currentRuleIs(string $rule): bool 
    {
        return $this->currentRule === $rule;
    }

    /**
     * Return true if the validation against string rule failed.
     * 
     * @return bool
     */
    private function _stringRuleFails(): bool 
    {
        return is_string($this->currentValue) === false;
    }

    /**
     * Returns true if the validation against array rule failed.
     * 
     * @return bool
     */
    private function _arrayRuleFails(): bool 
    {
        return is_array($this->itemsToValidate[$this->currentKey]) === false;
    }

    /**
     * Returns true if the validation against array rule failed.
     * 
     * @return bool
     */
    private function _requiredRuleFails(): bool 
    {       
        $fails = false;
        
        try {
            /**
             * @see https://regex101.com/r/ZDJl53/2
             */
            $key = preg_replace('/\*\.(\w+)$/', "{$this->currentIndex}.$1", $this->currentKey);

            $value = array_get($this->itemsToValidate, $key);

            if ((is_string($value) && strlen(trim($value)) < 1) || empty($value) === true) {
                $fails = true;
            }
        }
        catch( OutOfBoundsException $exception ) {
            $fails = true;
        }

        return $fails;
    }

    /**
     * Returns true fi the validation against filled rule failed.
     * 
     * @return bool
     */
    private function _filledRuleFails(): bool 
    {
        $fails = false;
        
        try {
            /**
             * @see https://regex101.com/r/ZDJl53/2
             */
            $key = preg_replace('/\*\.(\w+)$/', "{$this->currentIndex}.$1", $this->currentKey);

            $value = array_get($this->itemsToValidate, $key);

            if ((is_string($value) && strlen(trim($value)) < 1) || empty($value) === true) {
                $fails = true;
            }
        }
        catch( OutOfBoundsException $exception ) {
            $fails = false;
        }

        return $fails;
    }

    /**
     * Returns true if the validation against upper rule failed.
     * 
     * @return bool
     */
    private function _upperRuleFails(): bool 
    {
        return is_string($this->currentValue) === false || preg_match(RegExp::NOT_UPPER, $this->currentValue) === 1;
    }

    /**
     * Returns true if the validation against email rule failed.
     * 
     * @return bool
     */
    private function _emailRuleFails(): bool 
    {
        return is_string($this->currentValue) === false || filter_var($this->currentValue, FILTER_VALIDATE_EMAIL) === false;
    }

    /**
     * Returns true if the validation against integer rule failed.
     * 
     * @return bool
     */
    private function _integerRuleFails(): bool {
        return is_int($this->currentValue) === false;
    }

    /**
     * Returns true if the validation against lower rule failed.
     * 
     * @return bool
     */
    private function _lowerRuleFails(): bool {
        return is_string($this->currentValue) === false || preg_match(RegExp::NOT_LOWER, $this->currentValue) === 1;
    }

    /**
     * Returns true if the validation against slug rule failed.
     * 
     * @return bool
     */
    private function _slugRuleFails(): bool {
        return is_string($this->currentValue) === false || preg_match(RegExp::NOT_SLUG, $this->currentValue) === 1;
    }

    /**
     * Returns true if the validation against a date rule failed.
     * 
     * @return bool
     */
    private function _dateRuleFails(): bool {
        return is_string($this->currentValue) === false 
            || DateTime::createFromFormat('Y-m-d', $this->currentValue) === false 
            || @strtotime($this->currentValue) === false
            || (DateTime::createFromFormat('Y-m-d', $this->currentValue))->format('Y-m-d') !== $this->currentValue;
    }

    /**
     * Returns true if the validation against a datetime rule failed.
     * 
     * @return bool
     */
    private function _datetimeRuleFails(): bool {
        return is_string($this->currentValue) === false 
            || DateTime::createFromFormat('Y-m-d H:i:s', $this->currentValue) === false 
            || @strtotime($this->currentValue) === false
            || (DateTime::createFromFormat('Y-m-d H:i:s', $this->currentValue))->format('Y-m-d H:i:s') !== $this->currentValue;
    }

    /**
     * Returns true if the validation against a time rule failed.
     * 
     * @return bool
     */
    private function _timeRuleFails(): bool {
        return is_string($this->currentValue) === false 
            || DateTime::createFromFormat('H:i:s', $this->currentValue) === false 
            || @strtotime($this->currentValue) === false 
            || (DateTime::createFromFormat('H:i:s', $this->currentValue))->format('H:i:s') !== $this->currentValue;
    }

    /**
     * Returns true if the validation against a present rule failed.
     * 
     * @return bool
     */
    private function _presentRuleFails(): bool {
        $fails = false;
        
        try {
            /**
             * @see https://regex101.com/r/ZDJl53/2
             */
            $key = preg_replace('/\*\.(\w+)$/', "{$this->currentIndex}.$1", $this->currentKey);

            array_get($this->itemsToValidate, $key);
        }
        catch( OutOfBoundsException $exception ) {
            $fails = true;
        }

        return $fails;
    }

    /**
     * Returns the available rules plus the extended rules.
     * 
     * @return array<string>
     */
    private static function _rules(): array 
    {
        return array_merge(Rule::all(), array_keys(static::$extendedRules));
    }

    /**
     * Returns true if the rule exist or has been added, else returns false.
     * 
     * @param string $rule The rule to check.
     * 
     * @return bool
     */
    public static function has(string $rule): bool {
        return in_array($rule, static::_rules());
    }
}
?>