<?php
namespace Khalyomede;

use Khalyomede\Exception\RuleNotFoundException;
use Khalyomede\Exception\RuleAlreadyExistException;
use Khalyomede\RegExp;
use Khalyomede\Rule;
use stdClass;
use InvalidArgumentException;

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
            $this->currentValue = $items[$key] ?? null;

            foreach ($rules as $rule) {
                if (in_array($rule, $availableRules) === false) {
                    $exception = new RuleNotFoundException("rule \"$rule\" does not exists");
                    $exception->setRule($rule);

                    throw $exception;
                }
            }
            
            foreach ($rules as $rule) {
                $this->currentRule = $rule;

                if (($this->_currentRuleIs(Rule::STRING) && $this->_stringRuleFails() === true)
                    || ($this->_currentRuleIs(Rule::ARRAY) && $this->_arrayRuleFails() === true)
                    || ($this->_currentRuleIs(Rule::REQUIRED) && $this->_requiredRuleFails() === true)
                    || ($this->_currentRuleIs(Rule::FILLED) && $this->_filledRuleFails() === true)
                    || ($this->_currentRuleIs(Rule::UPPER) && $this->_upperRuleFails() === true)
                    || ($this->_currentRuleIs(Rule::EMAIL) && $this->_emailRuleFails() === true)
                ) {
                    $this->_addFailure();
                }
                else {
                    foreach (static::$extendedRules as $extendedRule => $closure) {
                        if ($this->_currentRuleIs($extendedRule) && call_user_func($closure, $this->currentValue, $this->currentKey, $this->itemsToValidate) !== true) {
                            $this->_addFailure();
                        }
                    }
                }
            }
        }

        return $this;
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
        return is_array($this->currentValue) === false;
    }

    /**
     * Returns true if the validation against array rule failed.
     * 
     * @return bool
     */
    private function _requiredRuleFails(): bool 
    {
        return isset($this->itemsToValidate[$this->currentKey]) === false;
    }

    /**
     * Returns true fi the validation against filled rule failed.
     * 
     * @return bool
     */
    private function _filledRuleFails(): bool 
    {
        return isset($this->itemsToValidate[$this->currentKey]) === false || empty($this->currentValue) === true;
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
     * Returns the available rules plus the extended rules.
     * 
     * @return array<string>
     */
    private static function _rules(): array 
    {
        return array_merge(Rule::all(), array_keys(static::$extendedRules));
    }
}
?>