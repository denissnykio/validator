<?php
namespace Khalyomede;

use Khalyomede\Exception\UnknownRuleException;
use Khalyomede\RegExp;
use Khalyomede\Rule;
use stdClass;

/**
 * Validate arrays, objects, strings, ...
 * 
 * @example 
 * $validator = new Validator([
 *  'name' => ['string'],
 *  'hobbies' => ['array'],
 *  'hobbies.*' => ['string']     
 * ]);
 */
class Validator {
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
     * @var array<array>
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
     * @param array $rules 
     *
     * @example
     * $validator = new Validator([
     * 'name' => ['string'],
     *  'hobbies' => ['array'],
     *  'hobbies.*' => ['string']     
     * ]);
     */
    public function __construct(array $rules) {
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
     * @param array<array> $items The array to validate.
     * 
     * @return self
     * 
     * @example
     * $validator = new Validator([
     * 'name' => ['string'],
     *  'hobbies' => ['array'],
     *  'hobbies.*' => ['string']
     * ]);
     * 
     * $validator->validate(['name' => 'John', 'hobbies' => ['programming', 'TV shows', 'workout']]);
     */
    public function validate(array $items): self {
        $this->itemsToValidate = $items;

        $availableRules = Rule::all();

        foreach( $this->rules as $key => $rules ) {
            $this->currentKey = $key;
            $this->currentValue = $items[$key] ?? null;

            foreach( $rules as $rule ) {
                if( in_array($rule, $availableRules) === false ) {
                    $exception = new UnknownRuleException("rule \"$rule\" does not exists");
                    $exception->setRule($rule);

                    throw $exception;
                }
            }
            
            foreach( $rules as $rule ) {
                $this->currentRule = $rule;

                if( 
                    ($this->_currentRuleIs(Rule::STRING) && $this->_stringRuleFails() === true) ||
                    ($this->_currentRuleIs(Rule::ARRAY) && $this->_arrayRuleFails() === true) ||
                    ($this->_currentRuleIs(Rule::REQUIRED) && $this->_requiredRuleFails() === true) ||
                    ($this->_currentRuleIs(Rule::FILLED) && $this->_filledRuleFails() === true) ||
                    ($this->_currentRuleIs(Rule::UPPER) && $this->_upperRuleFails() === true) ||
                    ($this->_currentRuleIs(Rule::EMAIL) && $this->_emailRuleFails() === true)
                ) {
                    $this->_addFailure();
                }
            }
        }

        return $this;
    }

    /**
     * Stores a failures that is caracterized by the key and the rule.
     * 
     * @return void
     */
    private function _addFailure(): void {
        $failure = new stdClass;
        $failure->key = $this->currentKey;
        $failure->rule = $this->currentRule;

        $this->failures[] = $failure;
    }

    /**
     * Returns true if the validation failed.
     * 
     * @return bool
     * 
     * @example
     * $validator = new Validator([
     * 'name' => ['string'],
     *  'hobbies' => ['array'],
     *  'hobbies.*' => ['string']
     * ]);
     * 
     * $validator->validate(['name' => 'John', 'hobbies' => ['programming', 'TV shows', 'workout']]);
     * 
     * var_dump($validator->failed()); // false
     */
    public function failed(): bool {
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
    private function _currentRuleIs(string $rule): bool {
        return $this->currentRule === $rule;
    }

    private function _stringRuleFails(): bool {
        return is_string($this->currentValue) === false;
    }

    private function _arrayRuleFails(): bool {
        return is_array($this->currentValue) === false;
    }

    private function _requiredRuleFails(): bool {
        return isset($this->itemsToValidate[$this->currentKey]) === false;
    }

    private function _filledRuleFails(): bool {
        return isset($this->itemsToValidate[$this->currentKey]) === false || empty($this->currentValue) === true;
    }

    private function _upperRuleFails(): bool {
        return is_string($this->currentValue) === false || preg_match(RegExp::NOT_UPPER, $this->currentValue) === 1;
    }

    private function _emailRuleFails(): bool {
        return is_string($this->currentValue) === false || filter_var($this->currentValue, FILTER_VALIDATE_EMAIL) === false;
    }
}
?>