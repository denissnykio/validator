<?php
namespace Khalyomede;

use Khalyomede\Exception\UnknownRuleException;
use Khalyomede\RegExp;
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
    const RULE_STRING = 'string';
    const RULE_ARRAY = 'array';
    const RULE_REQUIRED = 'required';
    const RULE_FILLED = 'filled';
    const RULE_UPPER = 'upper';

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
     * Stores the current value that is being validated.
     * 
     * @var string
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
        $this->currentKey = '';
        $this->currentRule = '';
        $this->currentValue = '';
    }

    /**
     * Validate an array against some rules.
     * 
     * @param array $items The array to validate.
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
        foreach( $this->rules as $key => $rules ) {
            $this->currentKey = $key;

            $value = $items[$key] ?? null;
            
            foreach( $rules as $rule ) {
                $this->currentRule = $rule;

                if( 
                    ($rule === static::RULE_STRING && is_string($value) === false) ||
                    ($rule === static::RULE_ARRAY && is_array($value) === false) ||
                    ($rule === static::RULE_REQUIRED && isset($items[$key]) === false) ||
                    ($rule === static::RULE_FILLED && isset($items[$key]) === false || empty($value) === true) ||
                    ($rule === static::RULE_UPPER && is_string($value) === false || preg_match(RegExp::NOT_UPPER, $value) === 1) ||
                    ($rule === static::RULE_EMAIL && is_string($value) === false || filter_var($value, FILTER_VALIDATE_EMAIL) === false)
                ) {
                    $this->_addFailure();
                }
                else {
                    $exception = new UnknownRuleException("rule \"$rule\" does not exists");
                    $exception->setRule($rule);

                    throw $exception;
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
}
?>