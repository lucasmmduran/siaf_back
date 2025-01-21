<?php

namespace App\Command;

use OpenApi\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SwaggerGenerateCommand extends Command
{
	//protected static $defaultName = 'swagger:generate';

	public function __construct()
	{
		parent::__construct('swagger:generate');
	}

	protected function configure(): void
	{
		$this
			->setDescription('Generates the OpenAPI documentation.')
			->setHelp('This command generates the OpenAPI documentation and saves it to public/openapi.json.');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$openapi = Generator::scan([__DIR__.'/../Controller', __DIR__.'/../Entity']);
		file_put_contents('public/openapi.json', $openapi->toJson());
		$output->writeln('OpenAPI documentation generated successfully.');
		return Command::SUCCESS;
	}
}
