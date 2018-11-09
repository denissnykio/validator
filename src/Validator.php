<?php
namespace Khalyomede;

use Khalyomede\Exception\UnknownRuleException;

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
     * @var array<array>
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

                if( $rule === static::RULE_STRING ) {
                    if( is_string($value) === false ) {
                        $this->_addFailure();
                    }
                }
                else if( $rule === static::RULE_ARRAY ) {
                    if( is_array($value) === false ) {
                        $this->_addFailure();
                    }
                }
                else if( $rule === static::RULE_REQUIRED ) {
                    if( isset($items[$key]) === false ) {
                        $this->_addFailure();
                    }
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
     * @param array<string> $options The key and the rule.
     */
    private function _addFailure(): void {
        $failure = new StdClass;
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