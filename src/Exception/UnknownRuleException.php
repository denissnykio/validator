<?php
    namespace Khalyomede\Exception;

    use InvalidArgumentException;

    class UnknownRuleException extends InvalidArgumentException {
        protected $rule;

        public function setRule(string $rule): self {
            $this->rule = $rule;

            return $this;
        }

        public function getRule(): string {
            return $this->rule;
        }
    }
?>