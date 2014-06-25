<?php
/**
 * SimpleThings FormExtraBundle
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

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
            ->addOption('target', null, InputOption::VALUE_OPTIONAL, 'The target directory', 'web/js')
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'The file name', 'javascript-validation-constraints.js')
            ->addOption('variable', null, InputOption::VALUE_OPTIONAL, 'The javscript variable name', 'jsFormExtraValidationConstraints')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $target = rtrim($input->getOption('target'), '/');

        if (!is_dir($target)) {
            throw new \InvalidArgumentException(sprintf('The target directory "%s" does not exist.', $target));
        }

        $objects = $this->getContainer()->getParameter('simple_things_form_extra.client_validation.objects');
        $generator = $this->getContainer()->get('simple_things_form_extra.js_validation_constraints_generator');
        $constraints = $generator->generate($objects);

        $file = $target . '/' . $input->getOption('name');
        $variable = $input->getOption('variable');

        file_put_contents($file, sprintf('var %s = ', $variable).$constraints);
        $output->writeln(sprintf('Generate javascript validation constraints in <comment>%s</comment>', $file));
        $output->writeln(sprintf('The javascript variable name is <comment>%s</comment>', $variable));
    }
}

