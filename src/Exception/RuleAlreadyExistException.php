<?php
namespace Khalyomede\Exception;

use InvalidArgumentException;

/**
 * After attempting to add a rule that already exist, this exception is thrown.
 * 
 * @category Exception
 * 
 * @package Validator
 * 
 * @author Khalyomede <khalyomede@gmail.com>
 * 
 * @license https://opensource.org/licenses/MIT MIT
 * 
 * @link https://github.com/khalyomede/validator/blob/master/src/Exception/RuleAlreadyExistException.php
 */
class RuleAlreadyExistException extends InvalidArgumentException
{
    /**
     * Stores the rule name that already exist.
     * 
     * @var string
     */
    protected $rule;

    /**
     * Set the rule name.
     * 
     * @param string $rule The rule name.
     * 
     * @return self
     */
    public function setRule(string $rule): self 
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Return the rule.
     * 
     * @return string
     */
    public function getRule(): string 
    {
        return $this->rule;
    }
}
?>