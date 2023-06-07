echo 'Tests started!'
composer install
php "${PWD}/src/Commands/TestsRunnerCommand.php";
echo 'Tests finished'