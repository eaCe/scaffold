<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class module extends rex_console_command
{
    /**
     * Available input types.
     */
    private array $inputTypes = [
        'empty',
        'text',
        'textarea',
        'select',
    ];

    protected function configure(): void
    {
        $this
            ->setName('scaffold:module')
            ->setDescription('Create a new module')
            ->setHelp('This command allows you to create a new module');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        /**
         * Ask for the module name.
         */
        $moduleNameQuestion = new Question('Please enter a module name: ', '');
        $moduleNameQuestion->setValidator(static function ($answer) {
            if (!is_string($answer) || '' === $answer) {
                throw new RuntimeException('You must enter a module name.');
            }

            return $answer;
        });

        $moduleName = $helper->ask($input, $output, $moduleNameQuestion);

        /**
         * Ask for the module key, default the module name.
         */
        $moduleKey = rex_string::normalize($moduleName);
        $moduleKeyQuestion = new Question('Please enter a module key (default: ' . $moduleKey . '): ', $moduleName);
        $moduleKeyQuestion->setValidator(static function ($answer) {
            if (!is_string($answer) || '' === $answer) {
                throw new RuntimeException('You must enter a module key.');
            }

            return $answer;
        });

        $moduleKey = $helper->ask($input, $output, $moduleKeyQuestion);

        /**
         * Ask for the module input as long as the user wants to add more.
         */
        $moduleInput = [];

        while (true) {
            $moduleInputQuestion = new ChoiceQuestion(
                'Please select the module input type (default empty)
                Press enter without selecting an option to finish',
                $this->inputTypes,
                '0',
            );
            $moduleInputQuestion->setErrorMessage('Module input %s is invalid.');

            $inputType = $helper->ask($input, $output, $moduleInputQuestion);

            if ('empty' === $inputType) {
                break;
            }

            /**
             * Ask for the input Label, Name and Value.
             */
            $inputLabelQuestion = new Question('Please enter the input label: ', '');
            $inputLabelQuestion->setValidator(static function ($answer) {
                if (!is_string($answer) || '' === $answer) {
                    throw new RuntimeException('You must enter a input label.');
                }

                return $answer;
            });

            $inputLabel = $helper->ask($input, $output, $inputLabelQuestion);

            $inputNameQuestion = new Question('Please enter the input name: ', '');

            $inputNameQuestion->setValidator(static function ($answer) {
                if (!is_string($answer) || '' === $answer) {
                    throw new RuntimeException('You must enter a input name.');
                }

                return $answer;
            });

            $inputName = $helper->ask($input, $output, $inputNameQuestion);

            $inputValueQuestion = new Question('Please enter the input value: ', '');

            $inputValueQuestion->setValidator(static function ($answer) {
                if (!is_string($answer) || '' === $answer) {
                    throw new RuntimeException('You must enter a input value.');
                }

                return $answer;
            });

            $inputValue = $helper->ask($input, $output, $inputValueQuestion);

            $moduleInput[] = [
                'type' => $inputType,
                'label' => $inputLabel,
                'name' => $inputName,
                'value' => $inputValue,
            ];
        }

        // TODO: Generate the module :)
        $output->writeln('<info>Generated module "' . $moduleName . '" with key "' . $moduleKey . '"</info>');
        $output->writeln('<error>Actually, nothing was generated. This is just a dummy command. The module generation is not implemented yet. ¯\_(ツ)_/¯</error>');

        return Command::SUCCESS;
    }
}
