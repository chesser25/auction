green=`tput setaf 2`
reset=`tput sgr0`

echo "${green}Tests started!${reset}"
composer install
php "${PWD}/src/Commands/TestsRunnerCommand.php";
echo "${green}Tests finished!${reset}"