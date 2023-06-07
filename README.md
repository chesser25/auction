Requirements:
- installed php

To validate that it works, you may follow 2 ways.
First way:
- clone the project
- open bash terminal inside the project root
- execute command `bash tests-runner.sh`
- as a result there should be list of successfull tests

Second way:
- clone the project
- execute composer install inside project's root
- execute command `php src/Commands/TestsRunnerCommand.php`
- as a result there should be list of successfull tests