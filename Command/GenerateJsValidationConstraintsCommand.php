<?php

namespace SimpleThings\FormExtraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author david badura <badura@simplethings.de>
 */
class GenerateJsValidationConstraintsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('formextra:jsvalidation:generate')
            ->setDescription('Generates javascript validation constraints')
            ->addOption('target', null, InputOption::VALUE_OPTIONAL, 'The target directory', 'web')
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'The file name', 'javascript-validation-constraints.js')
            ->addOption('variable', null, InputOption::VALUE_OPTIONAL, 'The javscript variable name', 'simpleThingsFormExtraValidationConstraints')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $target = rtrim($input->getOption('target'), '/');

        if (!is_dir($target)) {
            throw new \InvalidArgumentException(sprintf('The target directory "%s" does not exist.', $target));
        }
        
        $generator = $this->getContainer()->get('simple_things_form_extra.js_validation_constraints_generator');
        $constraints = $generator->generate();
        
        $file = $target . '/' . $input->getOption('name');
        $variable = $input->getOption('variable');
        
        file_put_contents($file, sprintf('var %s = ', $variable).$constraints);
        $output->writeln(sprintf('Generate javascript validation constraints in <comment>%s</comment>', $file));
        $output->writeln(sprintf('The javascript variable name is <comment>%s</comment>', $variable));
    }
}