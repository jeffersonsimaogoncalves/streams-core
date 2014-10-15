<?php namespace Streams\Platform\Field\Command;

use Streams\Platform\Field\FieldModel;
use Streams\Platform\Traits\DispatchableTrait;
use Streams\Platform\Contract\HandlerInterface;

class AddFieldHandlerHandler implements HandlerInterface
{
    use DispatchableTrait;

    /**
     * The field model.
     *
     * @var \Streams\Platform\Field\FieldModel
     */
    protected $field;

    /**
     * Create a new InstallFieldCommandHandler instance.
     *
     * @param FieldModel $field
     */
    function __construct(FieldModel $field)
    {
        $this->field = $field;
    }

    /**
     * Handle the command.
     *
     * @param $command
     * @return $this|mixed
     */
    public function handle($command)
    {
        $field = $this->field->add(
            $command->getNamespace(),
            $command->getSlug(),
            $command->getName(),
            $command->getType(),
            $command->getRules(),
            $command->getSettings(),
            $command->getIsLocked()
        );

        $this->dispatchEventsFor($field);

        return $field;
    }
}
 