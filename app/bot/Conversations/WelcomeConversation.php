namespace App\Bot\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class WelcomeConversation extends Conversation
{
public function run()
{
$this->say('Hello, welcome to our shop!');
$this->askOptions();
}

public function askOptions()
{
$this->ask('Please select one of our services:', function (Answer $answer) {
$selectedService = $answer->getText();
$this->say("You selected: $selectedService. Here are some related links.");
// You can add more logic here based on the selected service

$this->askContactOption();
});
}

public function askContactOption()
{
$this->ask('Would you like to contact us?', function (Answer $answer) {
if ($answer->isPositive()) {
$this->say('Great! Here is our contact link: [Contact Us](https://yourwebsite.com/contact)');
} else {
$this->say('Thank you for visiting. If you have any questions, feel free to ask.');
}
});
}
}